<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\UnidadeEnderecoController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\PessoaEnderecoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\PessoaController;

// Inicializar proteção CSRF
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

// Login e logout para SPA (baseado em sessão)
Route::post('/login_session', [AuthController::class, 'login_session'])->middleware('web');
Route::post('/logout_session', [AuthController::class, 'logout_session'])->middleware('web');

// Login via API token
Route::post('/login', [AuthController::class, 'login']); // Login via API token
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logout via API token

// Rota para registro de usuários
Route::post('/register', [AuthController::class, 'register']);

// Rotas protegidas por token
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/foto-pessoa', [FotoPessoaController::class, 'store'])->name('foto-pessoa.store');

    // Rotas protegidas para CRUD
    Route::apiResource('enderecos', EnderecoController::class);
    Route::apiResource('cidades', CidadeController::class);
    Route::apiResource('unidade_endereco', UnidadeEnderecoController::class);
    Route::apiResource('lotacoes', LotacaoController::class)->parameters([
        'lotacoes' => 'lotacao', 
    ]);
    Route::apiResource('servidores_efetivos', ServidorEfetivoController::class)->parameters([
        'servidores_efetivos' => 'servidor_efetivo', // Certifique-se de que o parâmetro é 'servidor_efetivo'
    ]);
    Route::get('/servidores_efetivos/unidade/{unid_id}', [ServidorEfetivoController::class, 'getByUnidade']);
    Route::get('/servidores_efetivos/endereco_funcional/{nome}', [ServidorEfetivoController::class, 'getEnderecoFuncional']);
    Route::apiResource('servidores_temporarios', ServidorTemporarioController::class)->parameters([
        'servidores_temporarios' => 'servidor_temporario',
    ]);
    Route::apiResource('pessoa_enderecos', PessoaEnderecoController::class)->parameters([
        'pessoa_enderecos' => 'pessoa_endereco', 
    ]);
    Route::apiResource('fotos_pessoas', FotoPessoaController::class);
    Route::apiResource('unidades', UnidadeController::class)->parameters([
        'unidades' => 'unidade', 
    ]);
    Route::apiResource('pessoas', PessoaController::class)->names([
        'show' => 'pessoa.show', 
    ]);

    // Rota explícita para criar registros (opcional)
    Route::post('/enderecos', [EnderecoController::class, 'store']);
});

// Rota para testar conexão com MinIO

Route::post('/upload-image', function (Request $request) {
    try {
        // Valida se o arquivo foi enviado
        if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
            return response()->json(['message' => 'No valid image file provided.'], 400);
        }

        $file = $request->file('image');
        $filePath = 'images/' . $file->getClientOriginalName();

        // Envia a imagem para o MinIO
        $stored = Storage::disk('s3')->put($filePath, file_get_contents($file));

        if ($stored) {
            return response()->json(['message' => 'Image uploaded successfully!', 'path' => $filePath]);
        }

        return response()->json(['message' => 'Failed to upload image.'], 500);
    } catch (\Exception $e) {
        \Log::error('Failed to upload image to MinIO', [
            'error' => $e->getMessage(),
        ]);

        return response()->json(['message' => 'Failed to upload image.', 'error' => $e->getMessage()], 500);
    }
});

Route::get('/download', function () {
    try {
        $filePath = 'image.jpg';

        // Verifica se o arquivo existe no MinIO
        if (Storage::disk('s3')->exists($filePath)) {
            return Storage::disk('s3')->download($filePath);
        }

        return response()->json(['message' => 'File not found in MinIO!'], 404);
    } catch (\Exception $e) {
        \Log::error('Failed to download file from MinIO', [
            'error' => $e->getMessage(),
            'filePath' => $filePath,
        ]);

        return response()->json(['message' => 'Failed to download file.', 'error' => $e->getMessage()], 500);
    }
});

Route::get('/upload-test-file', function () {
    $filePath = 'test/file.txt';
    $fileContent = 'This is a test file for MinIO storage.';

    Storage::disk('s3')->put($filePath, $fileContent);

    return 'Test file uploaded to MinIO!';
});

Route::get('/test-upload', function () {
    try {
        // Envia um arquivo de teste para o MinIO
        $filePath = 'test/file.txt';
        $fileContent = 'This is a test file for MinIO storage.';

        Storage::disk('s3')->put($filePath, $fileContent);

        return response()->json(['message' => 'File uploaded successfully!', 'path' => $filePath]);
    } catch (\Exception $e) {
        \Log::error('Failed to upload file to MinIO', [
            'error' => $e->getMessage(),
        ]);

        return response()->json(['message' => 'Failed to upload file.', 'error' => $e->getMessage()], 500);
    }
});

Route::get('/test-minio-connection', function () {
    try {
        $disk = Storage::disk('s3');
        $exists = $disk->exists('test'); // Verifica se o arquivo ou diretório "test" existe

        return response()->json(['message' => 'Connection successful!', 'exists' => $exists]);
    } catch (\Exception $e) {
        \Log::error('Failed to connect to MinIO', [
            'error' => $e->getMessage(),
        ]);

        return response()->json(['message' => 'Connection failed!', 'error' => $e->getMessage()], 500);
    }
});

Route::get('/list-images', function () {
    try {
        $directory = 'dados/';
        $files = Storage::disk('s3')->files($directory);

        // Gera URLs manualmente
        $fileUrls = array_map(function ($file) {
            return config('filesystems.disks.s3.endpoint') . '/' . config('filesystems.disks.s3.bucket') . '/' . $file;
        }, $files);

        return response()->json([
            'message' => 'Images retrieved successfully!',
            'files' => $fileUrls,
        ]);
    } catch (\Exception $e) {
        \Log::error('Failed to list images from MinIO', [
            'error' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Failed to retrieve images.',
            'error' => $e->getMessage(),
        ], 500);
    }
});
