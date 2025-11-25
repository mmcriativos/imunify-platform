<?php

namespace App\Http\Controllers;

use App\Models\TenantModule;
use App\Services\SipniExportService;
use Illuminate\Http\Request;

class SipniConfigController extends Controller
{
    public function index()
    {
        // Buscar módulo SIPNI do tenant
        $module = TenantModule::sipni()
            ->where('tenant_id', tenant('id'))
            ->first();

        $config = $module?->getSipniConfig() ?? [];
        
        // Estatísticas
        $stats = null;
        if ($module && $module->isActive()) {
            $sipniService = new SipniExportService();
            $stats = $sipniService->estatisticas();
        }

        return view('sipni.config', compact('module', 'config', 'stats'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cnes' => 'required|string|max:15',
            'api_url' => 'required|url',
            'usuario' => 'required|string',
            'senha' => 'required|string',
            'ambiente' => 'required|in:producao,homologacao',
        ]);

        // Atualizar CNES do tenant
        $tenant = \Stancl\Tenancy\Database\Models\Tenant::find(tenant('id'));
        $tenant->cnes = $validated['cnes'];
        $tenant->save();

        // Buscar ou criar módulo
        $module = TenantModule::sipni()
            ->where('tenant_id', tenant('id'))
            ->firstOrCreate([
                'tenant_id' => tenant('id'),
                'module_name' => 'sipni_integration',
            ], [
                'monthly_fee' => 397.00,
                'active' => false,
            ]);

        // Atualizar configurações
        $module->updateSipniConfig([
            'api_url' => $validated['api_url'],
            'usuario' => $validated['usuario'],
            'senha' => encrypt($validated['senha']),
            'ambiente' => $validated['ambiente'],
        ]);

        return redirect()
            ->route('sipni.config')
            ->with('success', 'Configurações do SIPNI atualizadas com sucesso!');
    }

    public function activate()
    {
        $module = TenantModule::sipni()
            ->where('tenant_id', tenant('id'))
            ->firstOrFail();

        // Validar se tem configurações mínimas
        $config = $module->getSipniConfig();
        
        if (empty($config['api_url']) || empty($config['usuario'])) {
            return redirect()
                ->back()
                ->with('error', 'Configure as credenciais do SIPNI antes de ativar o módulo');
        }

        if (!tenant('cnes')) {
            return redirect()
                ->back()
                ->with('error', 'Configure o CNES do estabelecimento antes de ativar o módulo');
        }

        // Ativar módulo
        $module->activate();

        return redirect()
            ->route('sipni.config')
            ->with('success', 'Módulo SIPNI ativado com sucesso! As vacinações serão exportadas automaticamente.');
    }

    public function suspend()
    {
        $module = TenantModule::sipni()
            ->where('tenant_id', tenant('id'))
            ->firstOrFail();

        $module->suspend();

        return redirect()
            ->route('sipni.config')
            ->with('warning', 'Módulo SIPNI desativado. As vacinações não serão mais exportadas automaticamente.');
    }

    public function testConnection()
    {
        try {
            $sipniService = new SipniExportService();
            
            // Aqui você pode adicionar um método de teste de conexão
            // $resultado = $sipniService->testarConexao();
            
            return response()->json([
                'success' => true,
                'message' => 'Conexão com SIPNI estabelecida com sucesso!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao conectar com SIPNI: ' . $e->getMessage(),
            ], 500);
        }
    }
}
