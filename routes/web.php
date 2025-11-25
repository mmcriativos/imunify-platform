<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\VacinaController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CarteiraVacinacaoController;
use App\Http\Controllers\LembreteController;
use App\Http\Controllers\WhatsAppConfigController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterTenantController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing Page e Registro
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/landing-teste', [LandingController::class, 'teste'])->name('landing.teste');

Route::get('/registrar', [RegisterTenantController::class, 'showForm'])->name('register.form');
Route::post('/registrar', [RegisterTenantController::class, 'register'])->name('register.submit');
Route::post('/check-subdomain', [RegisterTenantController::class, 'checkSubdomain'])->name('check.subdomain');

// Páginas Legais
Route::get('/termos-de-uso', function () {
    return view('legal.terms');
})->name('legal.terms');

Route::get('/politica-de-privacidade', function () {
    return view('legal.privacy');
})->name('legal.privacy');

// Rota de teste WhatsApp CENTRAL (TEMPORÁRIA - REMOVER EM PRODUÇÃO)
Route::get('/test-whatsapp/{phone}', function ($phone) {
    $apiUrl = config('services.evolution.url');
    $apiKey = config('services.evolution.api_key');
    $instance = config('services.evolution.instance_name');
    
    $phoneFormatted = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phoneFormatted) === 11 || strlen($phoneFormatted) === 10) {
        $phoneFormatted = '55' . $phoneFormatted;
    }
    
    $url = "{$apiUrl}/instances/{$instance}/token/{$apiKey}/send-text";
    
    $message = '🧪 Teste Imunify Central' . PHP_EOL . 
               '✅ Sistema Central ativo!' . PHP_EOL .
               now()->format('d/m/Y H:i:s');
    
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(30)->post($url, [
            'phone' => $phoneFormatted,
            'message' => $message
        ]);
        
        return response()->json([
            'config' => [
                'url' => $apiUrl,
                'instance' => $instance,
                'api_key_length' => strlen($apiKey),
            ],
            'request' => [
                'url' => $url,
                'phone' => $phoneFormatted,
            ],
            'response' => [
                'status' => $response->status(),
                'body' => $response->json() ?: $response->body(),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'config' => [
                'url' => $apiUrl,
                'instance' => $instance,
            ]
        ], 500);
    }
});
