<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $pessoas = Pessoa::paginate($perPage);

        // Adiciona a URL de cada objeto
        $pessoas->getCollection()->transform(function ($pessoa) {
            $pessoa->url = route('pessoa.show', ['pessoa' => $pessoa->pes_id]);
            return $pessoa;
        });

        return $pessoas;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pes_nome' => 'required|string|max:255',
            'pes_data_nascimento' => 'required|date',
            'pes_sexo' => 'required|string|max:12',  
            'pes_mae' => 'required|string|max:255',
            'pes_pai' => 'required|string|max:255',
        ]);

        return Pessoa::create($validated);
    }

    public function show(Pessoa $pessoa)
    {
        return $pessoa;
    }

    public function update(Request $request, Pessoa $pessoa)
    {
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'cpf' => 'string|max:14|unique:pessoas,cpf,' . $pessoa->id,
            'data_nascimento' => 'date',
        ]);

        $pessoa->update($validated);
        return $pessoa;
    }

    public function destroy(Pessoa $pessoa)
    {
        $pessoa->delete();
        return response()->json(['message' => 'Pessoa deletada com sucesso']);
    }
}
