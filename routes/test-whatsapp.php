<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/test-whatsapp/{phone}', function ($phone) {
    $apiUrl = config('services.evolution.url');
    $apiKey = config('services.evolution.api_key');
    $instance = config('services.evolution.instance_name');
    
    // Formatar número
    $phoneFormatted = preg_replace('/[^0-9]/', '', $phone);
    if (strlen($phoneFormatted) === 11 || strlen($phoneFormatted) === 10) {
        $phoneFormatted = '55' . $phoneFormatted;
    }
    
    $url = "{$apiUrl}/instances/{$instance}/token/{$apiKey}/send-text";
    
    $message = '🧪 *Teste de Notificação - MultiImune*' . PHP_EOL . PHP_EOL .
               '✅ Sistema configurado com sucesso!' . PHP_EOL . PHP_EOL .
               '📱 Lembretes automáticos ativos.' . PHP_EOL . PHP_EOL .
               '_' . now()->format('d/m/Y H:i:s') . '_';
    
    try {
        $response = Http::timeout(30)->post($url, [
            'phone' => $phoneFormatted,
            'message' => $message
        ]);
        
        return response()->json([
            'url' => $url,
            'phone' => $phoneFormatted,
            'status' => $response->status(),
            'response' => $response->json(),
            'body' => $response->body(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'url' => $url,
            'phone' => $phoneFormatted,
        ], 500);
    }
});
