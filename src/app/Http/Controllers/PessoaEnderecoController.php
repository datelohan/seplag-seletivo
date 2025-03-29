<?php

namespace App\Http\Controllers;

use App\Models\PessoaEndereco;
use Illuminate\Http\Request;

class PessoaEnderecoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $pessoaEnderecos = PessoaEndereco::with(['pessoa', 'endereco'])->paginate($perPage);

        // Adiciona a URL de cada objeto
        $pessoaEnderecos->getCollection()->transform(function ($pessoaEndereco) {
            $pessoaEndereco->url = route('pessoa_enderecos.show', ['pessoa_endereco' => $pessoaEndereco->id]);
            return $pessoaEndereco;
        });

        return $pessoaEnderecos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pes_id' => 'required|exists:pessoas,pes_id', // Valida se a pessoa existe
            'end_id' => 'required|exists:enderecos,end_id', // Valida se o endereço existe
        ]);

        return PessoaEndereco::create($validated);
    }

    public function show(PessoaEndereco $pessoa_endereco)
    {
        // Adiciona a URL ao objeto retornado
        $pessoa_endereco->url = route('pessoa_enderecos.show', ['pessoa_endereco' => $pessoa_endereco->id]);
        return $pessoa_endereco->only([
            'pes_id',
            'end_id',
            'created_at',
            'updated_at',
            'url',
        ]);
    }

    public function update(Request $request, PessoaEndereco $pessoaEndereco)
    {
        $validated = $request->validate([
            'pes_id' => 'exists:pessoas,pes_id', // Valida se a pessoa existe
            'end_id' => 'exists:enderecos,end_id', // Valida se o endereço existe
        ]);

        $pessoaEndereco->update($validated);
        return $pessoaEndereco->load(['pessoa', 'endereco']);
    }

    public function destroy(PessoaEndereco $pessoaEndereco)
    {
        $pessoaEndereco->delete();
        return response()->json(['message' => 'Pessoa Endereço deletado com sucesso']);
    }
}
