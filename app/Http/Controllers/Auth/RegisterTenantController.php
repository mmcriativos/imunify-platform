<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use App\Models\DatabasePool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RegisterTenantController extends Controller
{
    /**
     * Mostrar formulário de registro
     */
    public function showForm()
    {
        $plans = Plan::orderBy('price_monthly')->get();
        
        return view('auth.register-clinic', compact('plans'));
    }

    /**
     * Processar registro da clínica
     */
    public function register(Request $request)
    {
        // FORÇAR LOG IMEDIATO
        $logMessage = '🚀🚀🚀 RegisterTenantController@register CHAMADO - ' . now()->toDateTimeString();
        file_put_contents(storage_path('logs/laravel.log'), 
            '[' . now() . '] production.INFO: ' . $logMessage . "\n", 
            FILE_APPEND
        );
        
        Log::info($logMessage, [
            'subdomain' => $request->subdomain,
            'email' => $request->admin_email,
        ]);

        // Validar dados
        file_put_contents(storage_path('logs/laravel.log'), 
            '[' . now() . '] production.INFO: ➤ Passo 0: Iniciando validação...' . "\n", 
            FILE_APPEND
        );
        Log::info('➤ Passo 0: Iniciando validação...');
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            file_put_contents(storage_path('logs/laravel.log'), 
                '[' . now() . '] production.ERROR: ❌ Validação falhou: ' . json_encode($validator->errors()->toArray()) . "\n", 
                FILE_APPEND
            );
            Log::error('❌ Validação falhou', [
                'erros' => $validator->errors()->toArray()
            ]);
            
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        file_put_contents(storage_path('logs/laravel.log'), 
            '[' . now() . '] production.INFO: ✓ Passo 0: Validação OK' . "\n", 
            FILE_APPEND
        );
        Log::info('✓ Passo 0: Validação OK');

        // Verificar se há databases disponíveis no pool
        file_put_contents(storage_path('logs/laravel.log'), 
            '[' . now() . '] production.INFO: ➤ Passo 0.5: Verificando pool...' . "\n", 
            FILE_APPEND
        );
        Log::info('➤ Passo 0.5: Verificando pool...');
        $availableCount = DatabasePool::getAvailableCount();
        file_put_contents(storage_path('logs/laravel.log'), 
            '[' . now() . '] production.INFO: Pool disponível: ' . $availableCount . "\n", 
            FILE_APPEND
        );
        Log::info('Pool disponível: ' . $availableCount);
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ➤➤➤ ANTES DO TRY-CATCH\n", FILE_APPEND);
        
        if ($availableCount === 0) {
            Log::warning('Pool vazio!');
            return back()
                ->with('error', 'No momento estamos com capacidade máxima. Por favor, tente novamente em alguns minutos ou entre em contato conosco.')
                ->withInput();
        }

        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ➤➤➤ ENTRANDO NO TRY-CATCH\n", FILE_APPEND);
        
        try {
            file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ➤➤➤ DENTRO DO TRY - ANTES DO DB::beginTransaction()\n", FILE_APPEND);
            Log::info('➤ Passo 1: Iniciando transação...');
            DB::connection('central')->beginTransaction();
            file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✓✓✓ DB::beginTransaction() EXECUTADO COM SUCESSO!\n", FILE_APPEND);
            Log::info('✓ Transação iniciada');
            Log::info('=== INÍCIO DO REGISTRO DE TENANT ===');

            // Criar Tenant
            Log::info('➤ Passo 2: Criando tenant...');
            $tenant = $this->createTenant($request);
            file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 2 COMPLETO - Tenant ID: {$tenant->id}\n", FILE_APPEND);
            Log::info('✓ Passo 2: Tenant criado', ['tenant_id' => $tenant->id]);

            // Criar Domínio
            Log::info('➤ Passo 3: Criando domínio...');
            file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🌐 Chamando createDomain()...\n", FILE_APPEND);
            $this->createDomain($tenant, $request->subdomain);
            file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 3 COMPLETO - Domínio criado\n", FILE_APPEND);
            Log::info('✓ Passo 3: Domínio criado');

            // Inicializar contexto do tenant
            Log::info('➤ Passo 4: Inicializando tenancy...');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔧 Chamando tenancy()->initialize()...\n", FILE_APPEND);
            
            // DEBUG: Verificar qual banco está sendo usado
            $dbName = $tenant->getInternal('tenancy_db_name');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔍 Database do tenant: {$dbName}\n", FILE_APPEND);
            
            tenancy()->initialize($tenant);
            
            // DEBUG: Verificar conexão ativa
            $currentDb = DB::connection()->getDatabaseName();
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔍 Database ativo após initialize: {$currentDb}\n", FILE_APPEND);
            
            // APÓS tenancy()->initialize(), o storage_path() muda para o tenant!
            // Então usamos base_path() para escrever no storage central
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 4 COMPLETO - Tenancy inicializado\n", FILE_APPEND);
            Log::info('✓ Passo 4: Tenancy inicializado');

            // Rodar migrations manualmente (desabilitado no evento TenantCreated)
            Log::info('➤ Passo 4.5: Executando migrations...');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔨 Executando migrations no banco: {$currentDb}\n", FILE_APPEND);
            Artisan::call('tenants:migrate', [
                '--tenants' => [$tenant->id],
            ]);
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 4.5 COMPLETO - Migrations executadas\n", FILE_APPEND);
            Log::info('✓ Passo 4.5: Migrations executadas');

            // Criar usuário admin
            Log::info('➤ Passo 5: Criando usuário admin...');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 👤 Chamando createAdminUser()...\n", FILE_APPEND);
            $user = $this->createAdminUser($request);
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 5 COMPLETO - User ID: {$user->id}\n", FILE_APPEND);
            Log::info('✓ Passo 5: Usuário criado', ['user_id' => $user->id]);

            // Popular dados iniciais
            Log::info('➤ Passo 6: Populando dados iniciais...');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 📊 Chamando seedInitialData()...\n", FILE_APPEND);
            $this->seedInitialData($tenant);
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ PASSO 6 COMPLETO - Dados populados\n", FILE_APPEND);
            Log::info('✓ Passo 6: Dados populados');

            Log::info('➤ Passo 7: FAZENDO COMMIT DA TRANSAÇÃO...');
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 💾 Chamando DB::commit()...\n", FILE_APPEND);
            DB::connection('central')->commit();
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅✅✅ COMMIT REALIZADO COM SUCESSO!\n", FILE_APPEND);
            Log::info('✓✓✓ PASSO 7: COMMIT REALIZADO - TENANT SALVO COM SUCESSO! ✓✓✓');

            Log::info('Tenant criado com sucesso', [
                'tenant_id' => $tenant->id,
                'domain' => $tenant->domains->first()->domain
            ]);

        } catch (\Exception $e) {
            DB::connection('central')->rollBack();
            
            Log::error('❌❌❌ ERRO FATAL ao criar tenant: ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Erro ao criar sua clínica: ' . $e->getMessage())
                ->withInput();
        }

        // FORA DO TRY-CATCH: Criar token e redirecionar (mesmo se falhar, tenant já foi salvo)
        try {
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔐 Criando token de auto-login...\n", FILE_APPEND);
            Log::info('➤ Passo 8: Criando token de auto-login...');
            $loginToken = Str::random(60);
            
            // Usar cache store direto (bypassa CacheManager do Tenancy)
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🔐 Salvando token no cache...\n", FILE_APPEND);
            app('cache')->store()->put('login_token_' . $loginToken, [
                'tenant_id' => $tenant->id,
                'user_email' => $user->email,
            ], now()->addMinutes(5));
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] ✅ Token salvo: " . substr($loginToken, 0, 20) . "...\n", FILE_APPEND);
            Log::info('✓ Passo 8: Token criado', ['token' => substr($loginToken, 0, 10) . '...']);

            // Redirecionar para dashboard da clínica com token
            $domain = $tenant->domains->first()->domain;
            $protocol = env('APP_ENV') === 'local' ? 'http://' : 'https://';
            $redirectUrl = $protocol . $domain . '/auto-login?token=' . $loginToken;
            
            file_put_contents(base_path('storage/logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🌐 URL de redirect: {$redirectUrl}\n", FILE_APPEND);
            Log::info('➤ Passo 9: Redirecionando para', ['url' => $redirectUrl]);
            
            return redirect()->away($redirectUrl);
            
        } catch (\Exception $e) {
            // Se falhar o redirect, pelo menos mostra mensagem de sucesso
            Log::warning('Erro ao criar token/redirect, mas tenant foi criado', [
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('register.form')
                ->with('success', 'Clínica criada com sucesso! Acesse: https://' . $tenant->domains->first()->domain);
        }
    }

    /**
     * Validar dados do formulário
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // Dados da clínica
            'clinic_name' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required', 
                'string', 
                'max:50', 
                'alpha_dash',
                function ($attribute, $value, $fail) {
                    // Bloquear subdomínios reservados
                    $reserved = ['www', 'admin', 'api', 'app', 'mail', 'ftp', 'localhost', 'imunify'];
                    if (in_array(strtolower($value), $reserved)) {
                        $fail('Este subdomínio está reservado.');
                    }
                    
                    // Verificar se já existe
                    $domain = env('APP_ENV') === 'local' 
                        ? $value . '.localhost'
                        : $value . '.imunify.com.br';
                        
                    if (DB::table('domains')->where('domain', $domain)->exists()) {
                        $fail('Este subdomínio já está em uso.');
                    }
                },
            ],
            
            // Dados de contato
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'cnpj' => ['required', 'string', 'size:18'], // Com máscara: 00.000.000/0000-00
            
            // Endereço (opcional)
            'cep' => ['nullable', 'string', 'size:8'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'size:2'],
            
            // Usuário admin
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            // Plano
            'plan_id' => ['required', 'exists:plans,id'],
            
            // Termos
            'accept_terms' => ['accepted'],
        ], [
            'subdomain.alpha_dash' => 'O subdomínio deve conter apenas letras, números e hífens.',
            'accept_terms.accepted' => 'Você deve aceitar os termos de uso.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);
    }

    /**
     * Criar tenant
     */
    protected function createTenant(Request $request)
    {
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ createTenant() - INÍCIO\n", FILE_APPEND);
        
        $tenantId = Str::slug($request->subdomain);
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ Tenant ID gerado: {$tenantId}\n", FILE_APPEND);
        
        // Alocar database do pool
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ Chamando DatabasePool::allocateDatabase()\n", FILE_APPEND);
        $databaseName = DatabasePool::allocateDatabase($tenantId);
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ Database alocado: {$databaseName}\n", FILE_APPEND);
        
        if (!$databaseName) {
            throw new \Exception('Nenhum database disponível no pool. Por favor, tente novamente mais tarde.');
        }
        
        Log::info("Database '{$databaseName}' alocado para tenant '{$tenantId}'");
        
        // Criar tenant com database específico do pool
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ Criando tenant via Tenant::create()\n", FILE_APPEND);
        $tenant = Tenant::create([
            'id' => $tenantId,
            'data' => [
                'tenancy_db_name' => $databaseName, // Salva no JSON ANTES de disparar TenantCreated
            ],
        ]);
        
        file_put_contents(storage_path('logs/laravel.log'), "[" . date('Y-m-d H:i:s') . "] 🏗️ Tenant criado com ID: {$tenant->id}, Database: {$databaseName}\n", FILE_APPEND);

        // Configurar dados
        $tenant->plan_id = $request->plan_id;
        $tenant->clinic_name = $request->clinic_name;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->cnpj = $request->cnpj;
        $tenant->address = $request->address;
        $tenant->city = $request->city;
        $tenant->state = $request->state;
        $tenant->zip_code = $request->cep;
        $tenant->status = 'active';
        $tenant->timezone = 'America/Sao_Paulo';
        
        // Trial de 7 dias
        $tenant->trial_ends_at = now()->addDays(7);
        $tenant->subscription_ends_at = now()->addDays(7);
        
        $tenant->save();
        
        // Notificar admin se pool está ficando baixo
        if (DatabasePool::isPoolLow()) {
            Log::warning('Pool de databases está baixo!', [
                'available' => DatabasePool::getAvailableCount(),
            ]);
            // TODO: Enviar email para admin
        }

        return $tenant;
    }

    /**
     * Criar domínio
     */
    protected function createDomain(Tenant $tenant, string $subdomain)
    {
        $domain = env('APP_ENV') === 'local' 
            ? $subdomain . '.localhost'
            : $subdomain . '.imunify.com.br';

        $tenant->domains()->create([
            'domain' => $domain,
        ]);
    }

    /**
     * Criar usuário admin
     */
    protected function createAdminUser(Request $request)
    {
        return User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Popular dados iniciais
     */
    protected function seedInitialData(Tenant $tenant)
    {
        // Cidades padrão
        DB::table('cidades')->insert([
            ['nome' => 'São Paulo', 'uf' => 'SP', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Rio de Janeiro', 'uf' => 'RJ', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Campinas', 'uf' => 'SP', 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Vacinas padrão
        DB::table('vacinas')->insert([
            [
                'nome' => 'Influenza (Gripe)',
                'fabricante' => 'Diversos',
                'numero_doses' => 1,
                'intervalo_doses_dias' => null,
                'descricao' => 'Vacina contra Influenza (Gripe)',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'COVID-19',
                'fabricante' => 'Diversos',
                'numero_doses' => 2,
                'intervalo_doses_dias' => 28,
                'descricao' => 'Vacina contra COVID-19',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Hepatite B',
                'fabricante' => 'Diversos',
                'numero_doses' => 3,
                'intervalo_doses_dias' => 30,
                'descricao' => 'Vacina contra Hepatite B',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Verificar disponibilidade de subdomínio (AJAX)
     */
    public function checkSubdomain(Request $request)
    {
        $subdomain = Str::slug($request->input('subdomain'));
        
        // Reservados
        $reserved = ['www', 'admin', 'api', 'app', 'mail', 'ftp', 'localhost', 'imunify'];
        if (in_array(strtolower($subdomain), $reserved)) {
            return response()->json([
                'available' => false,
                'message' => 'Este subdomínio está reservado.'
            ]);
        }
        
        // Verificar se existe
        $domain = env('APP_ENV') === 'local' 
            ? $subdomain . '.localhost'
            : $subdomain . '.imunify.com.br';
            
        $exists = DB::table('domains')->where('domain', $domain)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists 
                ? 'Este subdomínio já está em uso.' 
                : 'Subdomínio disponível!',
            'full_domain' => $domain,
        ]);
    }
}
