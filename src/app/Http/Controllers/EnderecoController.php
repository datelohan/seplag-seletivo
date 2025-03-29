<?php
namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $enderecos = Endereco::paginate($perPage);

        // Adiciona a URL de cada objeto
        $enderecos->getCollection()->transform(function ($endereco) {
            $endereco->url = route('enderecos.show', ['endereco' => $endereco->end_id]);
            return $endereco;
        });

        return $enderecos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'end_tipo_logradouro' => 'required|string|max:255',
            'end_logradouro' => 'required|string|max:255',
            'end_numero' => 'required|string|max:50',
            'cid_id' => 'required|exists:cidades,cid_id', // Corrigido para usar 'cid_id'
        ]);

        return Endereco::create($validated);
    }

    public function show(Endereco $endereco)
    {
        // Adiciona a URL ao objeto retornado
        $endereco->url = route('enderecos.show', ['endereco' => $endereco->end_id]);
        return $endereco->only([
            'end_tipo_logradouro',
            'end_logradouro',
            'end_numero',
            'cid_id',
            'created_at',
            'updated_at',
            'url',
        ]);
    }

    public function update(Request $request, Endereco $endereco)
    {
        $validated = $request->validate([
            'end_tipo_logradouro' => 'string|max:255',
            'end_logradouro' => 'string|max:255',
            'end_numero' => 'string|max:50',
            'cid_id' => 'exists:cidades,cid_id', // Corrigido para usar 'cid_id'
        ]);

        $endereco->update($validated);
        $endereco->url = route('enderecos.show', ['endereco' => $endereco->end_id]);
        return $endereco->only([
            'end_tipo_logradouro',
            'end_logradouro',
            'end_numero',
            'cid_id',
            'created_at',
            'updated_at',
            'url',
        ]);
    }

    public function destroy(Endereco $endereco)
    {
        $endereco->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso']);
    }
}
