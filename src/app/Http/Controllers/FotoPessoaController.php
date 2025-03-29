<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;

class FotoPessoaController extends Controller
{
    public function index()
    {
        return FotoPessoa::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pessoa_id' => 'required|exists:pessoas,id',
            'caminho' => 'required|string|max:255',
        ]);

        return FotoPessoa::create($validated);
    }

    public function show(FotoPessoa $fotoPessoa)
    {
        return $fotoPessoa;
    }

    public function update(Request $request, FotoPessoa $fotoPessoa)
    {
        $validated = $request->validate([
            'pessoa_id' => 'exists:pessoas,id',
            'caminho' => 'string|max:255',
        ]);

        $fotoPessoa->update($validated);
        return $fotoPessoa;
    }

    public function destroy(FotoPessoa $fotoPessoa)
    {
        $fotoPessoa->delete();
        return response()->json(['message' => 'Foto Pessoa deletada com sucesso']);
    }
}
