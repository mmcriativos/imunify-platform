<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
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
        // Validar dados
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Criar Tenant
            $tenant = $this->createTenant($request);

            // Criar Domínio
            $this->createDomain($tenant, $request->subdomain);

            // Inicializar contexto do tenant
            tenancy()->initialize($tenant);

            // Criar usuário admin
            $user = $this->createAdminUser($request);

            // Popular dados iniciais
            $this->seedInitialData($tenant);

            DB::commit();

            // Login automático
            Auth::login($user);

            // Email de boas-vindas (TODO: criar mailable)
            // Mail::to($user->email)->queue(new WelcomeClinic($tenant, $user));

            // Redirecionar para dashboard da clínica
            $domain = $tenant->domains->first()->domain;
            
            return redirect()
                ->away('http://' . $domain . '/dashboard')
                ->with('success', 'Bem-vindo ao Imunify! Sua clínica foi criada com sucesso. Trial de 7 dias ativado.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Erro ao criar tenant: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('error', 'Erro ao criar sua clínica. Por favor, tente novamente ou entre em contato.')
                ->withInput();
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
            'cnpj' => ['nullable', 'string', 'size:14'],
            
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
        $tenant = Tenant::create([
            'id' => Str::slug($request->subdomain),
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
            ['nome' => 'São Paulo', 'estado' => 'SP', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Rio de Janeiro', 'estado' => 'RJ', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Campinas', 'estado' => 'SP', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Vacinas padrão
        DB::table('vacinas')->insert([
            [
                'nome' => 'Influenza (Gripe)',
                'fabricante' => 'Diversos',
                'doses_necessarias' => 1,
                'intervalo_doses' => null,
                'idade_minima' => '6 meses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'COVID-19',
                'fabricante' => 'Diversos',
                'doses_necessarias' => 2,
                'intervalo_doses' => 28,
                'idade_minima' => '6 meses',
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
