<?php

namespace App\Http\Controllers;

use App\Models\ServidorTemporario;
use Illuminate\Http\Request;

class ServidorTemporarioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $servidoresTemporarios = ServidorTemporario::with('pessoa')->paginate($perPage); // Inclui os dados das pessoas relacionadas

        // Adiciona a URL de cada objeto
        $servidoresTemporarios->getCollection()->transform(function ($servidorTemporario) {
            $servidorTemporario->url = route('servidores_temporarios.show', ['servidor_temporario' => $servidorTemporario->ser_id]); // Use 'id' como chave primária
            return $servidorTemporario;
        });

        return $servidoresTemporarios;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pes_id' => 'required|exists:pessoas,pes_id', // Valida se a pessoa existe
            'ser_data_admissao' => 'required|date',
            'ser_data_demissao' => 'required|date',
        ]);

        return ServidorTemporario::create($validated);
    }

    public function show(ServidorTemporario $servidorTemporario)
    {
        return $servidorTemporario;
    }

    public function update(Request $request, ServidorTemporario $servidorTemporario)
    {
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'contrato' => 'string|max:255',
            'lotacao_id' => 'exists:lotacaos,id',
        ]);

        $servidorTemporario->update($validated);
        return $servidorTemporario;
    }

    public function destroy(ServidorTemporario $servidorTemporario)
    {
        $servidorTemporario->delete();
        return response()->json(['message' => 'Servidor Temporário deletado com sucesso']);
    }
}
