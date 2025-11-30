<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\VacinaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CarteiraVacinacaoController;
use App\Http\Controllers\LembreteController;
use App\Http\Controllers\WhatsAppConfigController;
use App\Http\Controllers\WhatsAppWebhookController;
use App\Http\Controllers\ClinicConfigController;
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\AjudaController;
use App\Http\Controllers\CampanhasController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenancyServiceProvider with middleware.
| Middleware aplicado: 'web', 'InitializeTenancyByDomain', 'PreventAccessFromCentralDomains'
|
*/

// Rota raiz do tenant - redireciona para login se não autenticado, ou dashboard se autenticado
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('tenant.home');

// Autenticação no contexto do tenant
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Auto-login após registro de tenant
Route::get('/auto-login', [LoginController::class, 'autoLogin'])->name('auto.login');

// Webhook WhatsApp (PÚBLICO - Z-API precisa acessar no contexto do tenant)
Route::post('/webhook/whatsapp', [WhatsAppWebhookController::class, 'receberResposta'])->name('webhook.whatsapp');
Route::get('/webhook/whatsapp/teste', [WhatsAppWebhookController::class, 'teste'])->name('webhook.whatsapp.teste');

// Rota PÚBLICA da carteira de vacinação (acesso via token único)
Route::get('/carteira-publica/{token}', [CarteiraVacinacaoController::class, 'carteiraPublica'])->name('carteira.publica');

// Central de Ajuda (PÚBLICA - acessível sem login)
Route::prefix('ajuda')->name('ajuda.')->group(function () {
    Route::get('/', [AjudaController::class, 'index'])->name('index');
    Route::get('/buscar', [AjudaController::class, 'buscar'])->name('buscar');
    Route::get('/{categoria}', [AjudaController::class, 'categoria'])->name('categoria');
    Route::get('/artigo/{slug}', [AjudaController::class, 'artigo'])->name('artigo');
});

// Páginas de status do tenant (suspensão, arquivamento)
Route::get('/suspended', function () {
    return view('tenant.suspended');
})->name('suspended');

Route::get('/archived', function () {
    return view('tenant.archived');
})->name('archived');

Route::get('/subscription-required', function () {
    return view('tenant.subscription-required');
})->name('subscription.required');

// Todas as rotas protegidas por autenticação no contexto do tenant
Route::middleware(['auth', 'tenant.access'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Pacientes
        Route::resource('pacientes', PacienteController::class);
        
        // Vacinas
        Route::resource('vacinas', VacinaController::class);
        
        // Esquema de Doses
        Route::prefix('vacinas/{vacina}')->name('vacinas.')->group(function () {
            Route::get('/esquema', [\App\Http\Controllers\VacinaController::class, 'esquema'])->name('esquema');
            Route::post('/esquema', [\App\Http\Controllers\VacinaController::class, 'salvarEsquema'])->name('esquema.salvar');
        });
        
        // Estoque de Vacinas
        Route::prefix('estoque')->name('vacinas.')->group(function () {
            Route::get('/', [\App\Http\Controllers\EstoqueController::class, 'index'])->name('estoque');
            Route::post('/ajustar/{vacina}', [\App\Http\Controllers\EstoqueController::class, 'ajustar'])->name('estoque.ajustar');
            Route::post('/adicionar/{vacina}', [\App\Http\Controllers\EstoqueController::class, 'adicionar'])->name('estoque.adicionar');
            Route::post('/remover/{vacina}', [\App\Http\Controllers\EstoqueController::class, 'remover'])->name('estoque.remover');
            Route::get('/historico/{vacina}', [\App\Http\Controllers\EstoqueController::class, 'historico'])->name('estoque.historico');
        });
        
        // Lotes de Vacinas
        Route::prefix('lotes')->name('lotes.')->group(function () {
            Route::get('/', [\App\Http\Controllers\LoteController::class, 'index'])->name('index');
            Route::post('/', [\App\Http\Controllers\LoteController::class, 'store'])->name('store');
            Route::get('/{lote}', [\App\Http\Controllers\LoteController::class, 'show'])->name('show');
            Route::put('/{lote}', [\App\Http\Controllers\LoteController::class, 'update'])->name('update');
            Route::delete('/{lote}', [\App\Http\Controllers\LoteController::class, 'destroy'])->name('destroy');
        });
        
        // Atendimentos
        Route::resource('atendimentos', AtendimentoController::class);
        
        // Cidades
        Route::resource('cidades', CidadeController::class);
        
        // Agenda
        Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/agenda/eventos', [AgendaController::class, 'eventos'])->name('agenda.eventos');
        Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/agenda/{agendamento}', [AgendaController::class, 'show'])->name('agenda.show');
        Route::put('/agenda/{agendamento}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::delete('/agenda/{agendamento}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
        
        // Carteira de Vacinação
        Route::get('/carteira', [CarteiraVacinacaoController::class, 'index'])->name('carteira.index');
        Route::get('/carteira/{id}', [CarteiraVacinacaoController::class, 'show'])->name('carteira.show');
        Route::get('/carteira/{id}/print', [CarteiraVacinacaoController::class, 'print'])->name('carteira.print');
        Route::get('/carteira/{id}/certificado', [CarteiraVacinacaoController::class, 'certificado'])->name('carteira.certificado');
        
        // Lembretes
        Route::get('/dashboard/lembretes', [LembreteController::class, 'index'])->name('lembretes.index');
        Route::post('/dashboard/lembretes/processar', [LembreteController::class, 'processar'])->name('lembretes.processar');
        Route::post('/dashboard/lembretes/simular', [LembreteController::class, 'simular'])->name('lembretes.simular');
        
        // Notificações WhatsApp
        Route::prefix('dashboard/notificacoes')->name('notificacoes.')->group(function () {
            Route::get('/', [NotificacoesController::class, 'index'])->name('index');
            Route::get('/{id}', [NotificacoesController::class, 'show'])->name('show');
            Route::post('/{id}/reenviar', [NotificacoesController::class, 'reenviar'])->name('reenviar');
        });
        
        // Analytics de Lembretes
        Route::get('/dashboard/lembretes/analytics', [\App\Http\Controllers\LembretesAnalyticsController::class, 'index'])->name('lembretes.analytics');
        Route::get('/dashboard/lembretes/analytics/api', [\App\Http\Controllers\LembretesAnalyticsController::class, 'apiDados'])->name('lembretes.analytics.api');
        
        // Confirmações de Presença
        Route::get('/dashboard/confirmacoes', [\App\Http\Controllers\ConfirmacoesController::class, 'index'])->name('confirmacoes.index');
        Route::post('/dashboard/confirmacoes/{id}/confirmar', [\App\Http\Controllers\ConfirmacoesController::class, 'confirmar'])->name('confirmacoes.confirmar');
        Route::post('/dashboard/confirmacoes/{id}/cancelar', [\App\Http\Controllers\ConfirmacoesController::class, 'cancelar'])->name('confirmacoes.cancelar');
        
        // Configurações WhatsApp
        Route::prefix('dashboard/whatsapp')->name('whatsapp.')->group(function () {
            Route::get('/config', [WhatsAppConfigController::class, 'index'])->name('config');
            Route::post('/connect', [WhatsAppConfigController::class, 'connect'])->name('connect');
            Route::get('/status', [WhatsAppConfigController::class, 'checkStatus'])->name('status');
            Route::post('/test', [WhatsAppConfigController::class, 'sendTest'])->name('test');
            Route::post('/disconnect', [WhatsAppConfigController::class, 'disconnect'])->name('disconnect');
            Route::get('/usage', [WhatsAppConfigController::class, 'usage'])->name('usage');
        });
        
        // Configurações da Clínica
        Route::get('/dashboard/clinic/config', [ClinicConfigController::class, 'index'])->name('clinic.config');
        Route::post('/dashboard/clinic/config', [ClinicConfigController::class, 'update'])->name('clinic.config.update');
        
        // Campanhas de Vacinação
        Route::resource('campanhas', CampanhasController::class);
        Route::patch('/campanhas/{campanha}/toggle', [CampanhasController::class, 'toggleStatus'])->name('campanhas.toggle');
        
        // Relatórios
        Route::get('/relatorios/mensal', [DashboardController::class, 'mensal'])->name('relatorios.mensal');
        
        // Relatórios de Estoque
        Route::prefix('relatorios')->name('relatorios.')->group(function () {
            Route::get('/estoque', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'index'])->name('estoque.index');
            Route::get('/estoque/posicao', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'posicaoEstoque'])->name('estoque.posicao');
            Route::get('/estoque/movimentacoes', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'movimentacoes'])->name('estoque.movimentacoes');
            Route::get('/estoque/lotes', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'lotes'])->name('estoque.lotes');
            Route::get('/estoque/giro', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'giroEstoque'])->name('estoque.giro');
            Route::get('/estoque/exportar', [\App\Http\Controllers\RelatoriosEstoqueController::class, 'exportar'])->name('estoque.exportar');
        });
        
        // SIPNI - Integração com SI-PNI Web
        Route::prefix('sipni')->name('sipni.')->group(function () {
            Route::get('/config', [\App\Http\Controllers\SipniConfigController::class, 'index'])->name('config');
            Route::put('/config', [\App\Http\Controllers\SipniConfigController::class, 'update'])->name('config.update');
            Route::post('/activate', [\App\Http\Controllers\SipniConfigController::class, 'activate'])->name('activate');
            Route::post('/suspend', [\App\Http\Controllers\SipniConfigController::class, 'suspend'])->name('suspend');
            Route::get('/test-connection', [\App\Http\Controllers\SipniConfigController::class, 'testConnection'])->name('test-connection');
            
            Route::get('/dashboard', [\App\Http\Controllers\SipniDashboardController::class, 'index'])->name('dashboard');
            Route::get('/exports/{export}', [\App\Http\Controllers\SipniDashboardController::class, 'show'])->name('show');
            Route::post('/exports/{export}/retry', [\App\Http\Controllers\SipniDashboardController::class, 'retry'])->name('retry');
            Route::post('/retry-all', [\App\Http\Controllers\SipniDashboardController::class, 'retryAll'])->name('retry-all');
        });
        
        // FINANCEIRO - Gestão Financeira Completa
        Route::prefix('financeiro')->name('financeiro.')->group(function () {
            // Dashboard
            Route::get('/dashboard', [\App\Http\Controllers\FinanceiroController::class, 'dashboard'])->name('dashboard');
            Route::get('/relatorios', [\App\Http\Controllers\FinanceiroController::class, 'relatorios'])->name('relatorios');
            Route::get('/conciliacoes', [\App\Http\Controllers\FinanceiroController::class, 'conciliacoes'])->name('conciliacoes');
            Route::get('/configuracoes', [\App\Http\Controllers\FinanceiroController::class, 'configuracoes'])->name('configuracoes');
            
            // Caixa
            Route::prefix('caixa')->name('caixa.')->group(function () {
                Route::get('/', [\App\Http\Controllers\CaixaController::class, 'index'])->name('index');
                Route::post('/abrir', [\App\Http\Controllers\CaixaController::class, 'abrir'])->name('abrir');
                Route::get('/{caixa}', [\App\Http\Controllers\CaixaController::class, 'show'])->name('show');
                Route::put('/{caixa}/fechar', [\App\Http\Controllers\CaixaController::class, 'fechar'])->name('fechar');
                Route::put('/{caixa}/reabrir', [\App\Http\Controllers\CaixaController::class, 'reabrir'])->name('reabrir');
            });
            
            // Lançamentos
            Route::prefix('lancamentos')->name('lancamentos.')->group(function () {
                Route::get('/', [\App\Http\Controllers\LancamentoController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\LancamentoController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\LancamentoController::class, 'store'])->name('store');
                Route::get('/{lancamento}', [\App\Http\Controllers\LancamentoController::class, 'show'])->name('show');
                Route::get('/{lancamento}/edit', [\App\Http\Controllers\LancamentoController::class, 'edit'])->name('edit');
                Route::put('/{lancamento}', [\App\Http\Controllers\LancamentoController::class, 'update'])->name('update');
                Route::delete('/{lancamento}', [\App\Http\Controllers\LancamentoController::class, 'destroy'])->name('destroy');
                Route::put('/{lancamento}/confirmar', [\App\Http\Controllers\LancamentoController::class, 'marcarComoConfirmado'])->name('confirmar');
                Route::put('/{lancamento}/cancelar', [\App\Http\Controllers\LancamentoController::class, 'cancelar'])->name('cancelar');
            });
            
            // Categorias Financeiras
            Route::prefix('categorias')->name('categorias.')->group(function () {
                Route::get('/', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'store'])->name('store');
                Route::get('/{categoria}/edit', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'edit'])->name('edit');
                Route::put('/{categoria}', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'update'])->name('update');
                Route::delete('/{categoria}', [\App\Http\Controllers\CategoriaFinanceiraController::class, 'destroy'])->name('destroy');
            });
            
            // Formas de Pagamento
            Route::prefix('formas-pagamento')->name('formas-pagamento.')->group(function () {
                Route::get('/', [\App\Http\Controllers\FormaPagamentoController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\FormaPagamentoController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\FormaPagamentoController::class, 'store'])->name('store');
                Route::get('/{formaPagamento}/edit', [\App\Http\Controllers\FormaPagamentoController::class, 'edit'])->name('edit');
                Route::put('/{formaPagamento}', [\App\Http\Controllers\FormaPagamentoController::class, 'update'])->name('update');
                Route::delete('/{formaPagamento}', [\App\Http\Controllers\FormaPagamentoController::class, 'destroy'])->name('destroy');
            });
        });
    });
// Fim das rotas tenant
