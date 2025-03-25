<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use Illuminate\Http\Request;

class ServidorEfetivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servidores = ServidorEfetivo::all();
        return response()->json([
            'message' => 'Servidores listados com sucesso',
            'data' => $servidores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|unique:servidores_efetivos,matricula',
            'cargo' => 'required|string|max:255',
            'lotacao' => 'required|string|max:255',
        ], [
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'O nome não pode ter mais que 255 caracteres',
            'matricula.required' => 'O campo matrícula é obrigatório',
            'matricula.unique' => 'Esta matrícula já está cadastrada',
            'cargo.required' => 'O campo cargo é obrigatório',
            'cargo.max' => 'O cargo não pode ter mais que 255 caracteres',
            'lotacao.required' => 'O campo lotação é obrigatório',
            'lotacao.max' => 'A lotação não pode ter mais que 255 caracteres'
        ]);

        $servidor = ServidorEfetivo::create($validated);

        return response()->json([
            'message' => 'Servidor cadastrado com sucesso',
            'data' => $servidor
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServidorEfetivo $servidorEfetivo)
    {
        return response()->json([
            'message' => 'Servidor encontrado com sucesso',
            'data' => $servidorEfetivo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServidorEfetivo $servidorEfetivo)
    {
        $validated = $request->validate([
            'nome' => 'string|max:255',
            'matricula' => 'string|unique:servidores_efetivos,matricula,' . $servidorEfetivo->id,
            'cargo' => 'string|max:255',
            'lotacao' => 'string|max:255',
        ], [
            'nome.max' => 'O nome não pode ter mais que 255 caracteres',
            'matricula.unique' => 'Esta matrícula já está cadastrada',
            'cargo.max' => 'O cargo não pode ter mais que 255 caracteres',
            'lotacao.max' => 'A lotação não pode ter mais que 255 caracteres'
        ]);

        $servidorEfetivo->update($validated);

        return response()->json([
            'message' => 'Servidor atualizado com sucesso',
            'data' => $servidorEfetivo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServidorEfetivo $servidorEfetivo)
    {
        $servidorEfetivo->delete();
        return response()->json([
            'message' => 'Servidor removido com sucesso'
        ]);
    }
} 