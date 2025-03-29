<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServidorEfetivoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $servidoresEfetivos = ServidorEfetivo::paginate($perPage);

        // Adiciona a URL de cada objeto
        $servidoresEfetivos->getCollection()->transform(function ($servidorEfetivo) {
            $servidorEfetivo->url = route('servidores_efetivos.show', ['servidor_efetivo' => $servidorEfetivo->ser_id]); // Use 'ser_id' como chave primária
            return $servidorEfetivo;
        });

        return $servidoresEfetivos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pes_id' => 'required|exists:pessoas,pes_id', // Valida se a pessoa existe
            'se_matricula' => 'required|string|max:50', // Valida a matrícula
        ]);

        return ServidorEfetivo::create($validated);
    }

    public function show(ServidorEfetivo $servidor_efetivo)
    {
        return $servidor_efetivo;
    }

    public function update(Request $request, ServidorEfetivo $servidorEfetivo)
    {
        $validated = $request->validate([
            'pes_id' => 'exists:pessoas,pes_id', // Valida se a pessoa existe
            'se_matricula' => 'string|max:50', // Valida a matrícula
        ]);

        $servidorEfetivo->update($validated);
        return $servidorEfetivo;
    }

    public function destroy(ServidorEfetivo $servidorEfetivo)
    {
        $servidorEfetivo->delete();
        return response()->json(['message' => 'Servidor Efetivo deletado com sucesso']);
    }

    public function getByUnidade($unid_id)
    {
        $servidores = DB::table('lotacaos as a')
            ->join('servidor_efetivos as b', 'b.pes_id', '=', 'a.pes_id')
            ->join('unidades as c', 'a.unid_id', '=', 'c.uni_id')
            ->join('pessoas as d', 'd.pes_id', '=', 'a.pes_id')
            ->where('c.uni_id', $unid_id)
            ->select(
                'd.pes_nome as nome',
                'd.pes_data_nascimento as data_nascimento',
                'c.uni_nome as unidade_lotacao'
            )
            ->get()
            ->map(function ($servidor) {
                return [
                    'nome' => $servidor->nome,
                    'idade' => \Carbon\Carbon::parse($servidor->data_nascimento)->age ?? null,
                    'unidade_lotacao' => $servidor->unidade_lotacao,
                ];
            });

        return response()->json($servidores);
    }

    public function getEnderecoFuncional($nome)
    {
        if (!$nome) {
            return response()->json(['message' => 'O parâmetro "nome" é obrigatório.'], 400);
        }

        $enderecos = DB::table('servidor_efetivos as se')
            ->join('pessoas as p', 'se.pes_id', '=', 'p.pes_id')
            ->join('lotacaos as l', 'se.pes_id', '=', 'l.pes_id')
            ->join('unidades as u', 'l.unid_id', '=', 'u.uni_id')
            ->join('unidade_endereco as ue', 'u.uni_id', '=', 'ue.unid_id')
            ->join('enderecos as e', 'ue.end_id', '=', 'e.end_id')
            ->where('p.pes_nome', 'like', '%' . $nome . '%') // Filtra pelo nome do servidor
            ->select(
                'p.pes_nome as nome_servidor',
                'u.uni_nome as unidade',
                'e.end_tipo_logradouro as tipo_logradouro',
                'e.end_logradouro as logradouro',
                'e.end_numero as numero'
            )
            ->get();

        if ($enderecos->isEmpty()) {
            return response()->json(['message' => 'Nenhum endereço funcional encontrado para o nome fornecido.'], 404);
        }

        return response()->json($enderecos);
    }
}
