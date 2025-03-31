<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoPessoaController extends Controller
{
    public function index()
    {
        return FotoPessoa::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'fp_pes_id' => 'required|integer',
            'fp_data' => 'required|date',
            'fp_bucket' => 'required|string',
            'fp_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bucket = $request->input('fp_bucket');
        $file = $request->file('fp_path');
        $filePath = $bucket . '/' . $file->getClientOriginalName();

        try {
            // Armazena o arquivo no MinIO
            $stored = Storage::disk('s3')->put($filePath, file_get_contents($file));

            if ($stored) {
                return response()->json([
                    'message' => 'Image uploaded successfully!',
                    'path' => $filePath,
                ]);
            }
        } catch (\Exception $e) {
            // Log detalhado do erro
            \Log::error('Failed to upload image to MinIO', [
                'error' => $e->getMessage(),
                'bucket' => $bucket,
                'filePath' => $filePath,
            ]);

            return response()->json([
                'message' => 'Failed to upload image.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Failed to upload image.',
            'path' => false,
        ], 500);
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

    public function testMinio()
    {
        try {
            $disk = Storage::disk('s3');
            $disk->exists('/'); // Testa a conexão com o MinIO

            return response()->json(['message' => 'Conexão com o MinIO bem-sucedida!']);
        } catch (\Exception $e) {
            \Log::error('Failed to connect to MinIO', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Falha na conexão com o MinIO.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
