<?php
namespace App\Http\Controllers;

use App\Models\Lotacao;
use Illuminate\Http\Request;

class LotacaoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10); // Número de itens por página (padrão: 10)
        $lotacoes = Lotacao::paginate($perPage);

        // Adiciona a URL de cada objeto
        $lotacoes->getCollection()->transform(function ($lotacao) {
            $lotacao->url = route('lotacoes.show', ['lotacao' => $lotacao->lot_id]); // Certifique-se de usar 'lotacao'
            return $lotacao;
        });

        return $lotacoes;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pes_id' => 'required|exists:pessoas,pes_id', 
            'unid_id' => 'required|exists:unidades,uni_id',
            'lot_data_lotacao' => 'required|date',
            'lot_data_remocao' => 'required|date|after_or_equal:lot_data_lotacao',
            'lot_portaria' => 'required|string|max:255',
        ]);

        return Lotacao::create($validated);
    }

    public function show(Lotacao $lotacao)
    {
        // Adiciona a URL ao objeto retornado
        $lotacao->url = route('lotacoes.show', ['lotacao' => $lotacao->lot_id]);
        return $lotacao->only([
            'pes_id',
            'unid_id',
            'lot_data_lotacao',
            'lot_data_remocao',
            'lot_portaria',
            'created_at',
            'updated_at',
            'url',
        ]);
    }

    public function update(Request $request, Lotacao $lotacao)
    {
        $validated = $request->validate([
            'pes_id' => 'exists:pessoas,pes_id', 
            'unid_id' => 'exists:unidades,uni_id',
            'lot_data_lotacao' => 'date',
            'lot_data_remocao' => 'required|date|after_or_equal:lot_data_lotacao',
            'lot_portaria' => 'string|max:255',
        ]);

        $lotacao->update($validated);
        $lotacao->url = route('lotacoes.show', ['lotacao' => $lotacao->lot_id]);
        return $lotacao;
    }

    public function destroy(Lotacao $lotacao)
    {
        $lotacao->delete();
        return response()->json(['message' => 'Lotação deletada com sucesso']);
    }
}
