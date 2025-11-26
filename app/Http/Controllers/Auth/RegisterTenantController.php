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
        // Debug temporário
        Log::info('Tentativa de registro', [
            'dados' => $request->all()
        ]);

        // Validar dados
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            Log::error('Validação falhou', [
                'erros' => $validator->errors()->toArray()
            ]);
            
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar se há databases disponíveis no pool
        if (DatabasePool::getAvailableCount() === 0) {
            return back()
                ->with('error', 'No momento estamos com capacidade máxima. Por favor, tente novamente em alguns minutos ou entre em contato conosco.')
                ->withInput();
        }

        try {
            DB::beginTransaction();
            Log::info('=== INÍCIO DO REGISTRO DE TENANT ===');

            // Criar Tenant
            Log::info('1. Criando tenant...');
            $tenant = $this->createTenant($request);
            Log::info('✓ Tenant criado', ['tenant_id' => $tenant->id]);

            // Criar Domínio
            Log::info('2. Criando domínio...');
            $this->createDomain($tenant, $request->subdomain);
            Log::info('✓ Domínio criado');

            // Inicializar contexto do tenant
            Log::info('3. Inicializando tenancy...');
            tenancy()->initialize($tenant);
            Log::info('✓ Tenancy inicializado');

            // Criar usuário admin
            Log::info('4. Criando usuário admin...');
            $user = $this->createAdminUser($request);
            Log::info('✓ Usuário criado', ['user_id' => $user->id]);

            // Popular dados iniciais
            Log::info('5. Populando dados iniciais...');
            $this->seedInitialData($tenant);
            Log::info('✓ Dados populados');

            Log::info('6. Fazendo commit da transação...');
            DB::commit();
            Log::info('✓✓✓ COMMIT REALIZADO - TENANT SALVO COM SUCESSO! ✓✓✓');

            Log::info('Tenant criado com sucesso', [
                'tenant_id' => $tenant->id,
                'domain' => $tenant->domains->first()->domain
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('❌ ERRO ao criar tenant: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Erro ao criar sua clínica. Por favor, tente novamente ou entre em contato.')
                ->withInput();
        }

        // FORA DO TRY-CATCH: Criar token e redirecionar (mesmo se falhar, tenant já foi salvo)
        try {
            Log::info('7. Criando token de auto-login...');
            $loginToken = Str::random(60);
            
            // Usar cache store direto (bypassa CacheManager do Tenancy)
            app('cache')->store()->put('login_token_' . $loginToken, [
                'tenant_id' => $tenant->id,
                'user_email' => $user->email,
            ], now()->addMinutes(5));
            Log::info('✓ Token criado');

            // Redirecionar para dashboard da clínica com token
            $domain = $tenant->domains->first()->domain;
            $protocol = env('APP_ENV') === 'local' ? 'http://' : 'https://';
            $redirectUrl = $protocol . $domain . '/auto-login?token=' . $loginToken;
            
            Log::info('8. Redirecionando para', ['url' => $redirectUrl]);
            
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
        $tenantId = Str::slug($request->subdomain);
        
        // Alocar database do pool
        $databaseName = DatabasePool::allocateDatabase($tenantId);
        
        if (!$databaseName) {
            throw new \Exception('Nenhum database disponível no pool. Por favor, tente novamente mais tarde.');
        }
        
        Log::info("Database '{$databaseName}' alocado para tenant '{$tenantId}'");
        
        // Criar tenant com database específico
        $tenant = Tenant::create([
            'id' => $tenantId,
            'tenancy_db_name' => $databaseName,
        ]);

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
