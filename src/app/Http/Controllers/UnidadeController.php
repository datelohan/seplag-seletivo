<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $unidades = Unidade::paginate($perPage);

        // Adiciona a URL de cada objeto
        $unidades->getCollection()->transform(function ($unidade) {
            $unidade->url = route('unidades.show', ['unidade' => $unidade->uni_id]); // Use 'uni_id' como chave primária
            return $unidade;
        });

        return $unidades;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'cid_nome' => 'required|string|max:255',
        'cid_uf' => 'required|string|max:2',
        ]); // Corrigido para usar 'cid_nome' e
        

        return Unidade::create($validated);
    }

    public function show(Unidade $unidade)
    {
        // Adiciona a URL ao objeto retornado
        $unidade->url = route('unidades.show', ['unidade' => $unidade->uni_id]);
        return $unidade;
    }

    public function update(Request $request, Unidade $unidade)
    {
        $validated = $request->validate([
            'uni_sigla' => 'string|max:10',
            'uni_nome' => 'string|max:255',
        ]);

        $unidade->update($validated);
        return $unidade;
    }

    public function destroy(Unidade $unidade)
    {
        $unidade->delete();
        return response()->json(['message' => 'Unidade deletada com sucesso']);
    }
}
