<?php
namespace App\Http\Controllers;

use App\Models\UnidadeEndereco;
use Illuminate\Http\Request;

class UnidadeEnderecoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $unidadeEnderecos = UnidadeEndereco::with(['unidade', 'endereco'])->paginate($perPage); // Inclui os relacionamentos

        // Adiciona a URL de cada objeto
        $unidadeEnderecos->getCollection()->transform(function ($unidadeEndereco) {
            $unidadeEndereco->url = route('unidade_endereco.show', ['unidade_endereco' => $unidadeEndereco->id]); // Use 'id' como chave primária
            return $unidadeEndereco;
        });

        return $unidadeEnderecos;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unid_id' => 'required|exists:unidades,uni_id', // Agora é obrigatório
            'end_id' => 'required|exists:enderecos,end_id', // Agora é obrigatório
        ]);

        return UnidadeEndereco::create($validated);
    }

    public function show(UnidadeEndereco $unidadeEndereco)
    {
        // Adiciona a URL ao objeto retornado
        $unidadeEndereco->url = route('unidade_endereco.show', ['unidade_endereco' => $unidadeEndereco->id]);
        return $unidadeEndereco->load(['unidade', 'endereco']);
    }

    public function update(Request $request, UnidadeEndereco $unidadeEndereco)
    {
        $validated = $request->validate([
            'unid_id' => 'exists:unidades,uni_id', // Valida a chave estrangeira 'unid_id'
            'end_id' => 'exists:enderecos,end_id', // Valida a chave estrangeira 'end_id'
        ]);

        $unidadeEndereco->update($validated);
        return $unidadeEndereco->load(['unidade', 'endereco']);
    }

    public function destroy(UnidadeEndereco $unidadeEndereco)
    {
        $unidadeEndereco->delete();
        return response()->json(['message' => 'Unidade Endereço deletado com sucesso']);
    }
}
