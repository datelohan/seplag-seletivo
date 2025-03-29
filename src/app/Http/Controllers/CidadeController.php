<?php
namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $cidades = Cidade::paginate($perPage);

        // Adiciona a URL de cada objeto
        $cidades->getCollection()->transform(function ($cidade) {
            $cidade->url = route('cidades.show', ['cidade' => $cidade->cid_id]);
            return $cidade;
        });

        return $cidades;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cid_nome' => 'required|string|max:255',
            'cid_uf' => 'required|string|max:255',
        ]);

        return Cidade::create($validated);
    }

    public function show(Cidade $cidade)
    {
        // Adiciona a URL ao objeto retornado
        $cidade->url = route('cidades.show', ['cidade' => $cidade->cid_id]);
        return $cidade;
    }

    public function update(Request $request, Cidade $cidade)
    {
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'estado' => 'string|max:255',
        ]);

        $cidade->update($validated);
        return $cidade;
    }

    public function destroy(Cidade $cidade)
    {
        $cidade->delete();
        return response()->json(['message' => 'Cidade deletada com sucesso']);
    }
}
