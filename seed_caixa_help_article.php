<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use App\Models\HelpArticle;

// Selecionar o tenant
$tenant = Tenant::where('id', 'multiimune')->firstOrFail();

// Executar no contexto do tenant
tenancy()->initialize($tenant);

// Conteúdo HTML formatado do artigo
$conteudoHtml = <<<'HTML'
<div class="help-article-content">
    <div class="alert alert-info mb-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm text-blue-700">
                    <strong>O que você vai aprender:</strong> Como abrir, gerenciar e fechar o caixa diário para manter o controle financeiro da sua clínica.
                </p>
            </div>
        </div>
    </div>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">1</span>
            O que é o Caixa Diário?
        </h2>
        <div class="prose prose-blue max-w-none">
            <p class="text-gray-700 leading-relaxed mb-4">
                O <strong>Caixa Diário</strong> é uma ferramenta de controle financeiro que registra todas as movimentações de dinheiro (entradas e saídas) da sua clínica em um dia específico. É como um "livro de caixa" digital que ajuda você a:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4">
                <li>Controlar quanto dinheiro entra e sai diariamente</li>
                <li>Comparar o valor esperado com o valor real ao final do dia</li>
                <li>Identificar divergências ou erros rapidamente</li>
                <li>Manter histórico organizado das movimentações financeiras</li>
                <li>Gerar relatórios precisos para gestão e contabilidade</li>
            </ul>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">2</span>
            Como Abrir um Novo Caixa
        </h2>
        <div class="prose prose-blue max-w-none">
            <p class="text-gray-700 leading-relaxed mb-4">
                Todo dia útil, antes de começar o atendimento, você deve <strong>abrir um novo caixa</strong>. Veja o passo a passo:
            </p>
            
            <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-4">
                <h3 class="font-bold text-gray-900 mb-2">📋 Passo a Passo:</h3>
                <ol class="list-decimal list-inside space-y-3 text-gray-700 ml-2">
                    <li>
                        <strong>Acesse o módulo Financeiro</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">No menu lateral, clique em "Financeiro" → "Caixa"</p>
                    </li>
                    <li>
                        <strong>Clique em "Abrir Novo Caixa"</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Você verá um botão verde no topo da página</p>
                    </li>
                    <li>
                        <strong>Informe o saldo inicial</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Digite quanto dinheiro tem no caixa no início do dia (exemplo: R$ 100,00 de troco)</p>
                    </li>
                    <li>
                        <strong>Confirme a abertura</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">O sistema registra a data, hora e saldo inicial automaticamente</p>
                    </li>
                </ol>
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700">
                            <strong>Importante:</strong> Só pode haver UM caixa aberto por vez. Se tentar abrir um novo com outro já aberto, o sistema pedirá que você feche o anterior primeiro.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">3</span>
            Durante o Dia: Registrando Movimentações
        </h2>
        <div class="prose prose-blue max-w-none">
            <p class="text-gray-700 leading-relaxed mb-4">
                Com o caixa aberto, todas as <strong>receitas</strong> (dinheiro que entra) e <strong>despesas</strong> (dinheiro que sai) devem ser registradas no sistema. O caixa calcula automaticamente:
            </p>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="font-bold text-green-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                        </svg>
                        Entradas (Receitas)
                    </h4>
                    <ul class="text-sm text-green-700 space-y-1 ml-5 list-disc">
                        <li>Pagamentos de consultas</li>
                        <li>Venda de vacinas</li>
                        <li>Pacotes e procedimentos</li>
                        <li>Outros recebimentos</li>
                    </ul>
                </div>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h4 class="font-bold text-red-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                        </svg>
                        Saídas (Despesas)
                    </h4>
                    <ul class="text-sm text-red-700 space-y-1 ml-5 list-disc">
                        <li>Compra de materiais</li>
                        <li>Pagamento de fornecedores</li>
                        <li>Despesas operacionais</li>
                        <li>Outros pagamentos</li>
                    </ul>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-sm text-blue-700">
                    <strong>💡 Dica:</strong> O sistema calcula automaticamente o "Saldo Esperado" = Saldo Inicial + Entradas - Saídas. Esse valor será comparado com o dinheiro real ao fechar o caixa.
                </p>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">4</span>
            Como Fechar o Caixa
        </h2>
        <div class="prose prose-blue max-w-none">
            <p class="text-gray-700 leading-relaxed mb-4">
                Ao final do dia, você deve <strong>fechar o caixa</strong> para encerrar o controle diário. Veja como:
            </p>
            
            <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-4">
                <h3 class="font-bold text-gray-900 mb-2">📋 Passo a Passo:</h3>
                <ol class="list-decimal list-inside space-y-3 text-gray-700 ml-2">
                    <li>
                        <strong>Conte o dinheiro físico no caixa</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Faça a contagem real de cédulas e moedas disponíveis</p>
                    </li>
                    <li>
                        <strong>Acesse o caixa aberto</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Em "Financeiro" → "Caixa", clique no caixa com status "Aberto"</p>
                    </li>
                    <li>
                        <strong>Clique em "Fechar Caixa"</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Um modal aparecerá solicitando o saldo final</p>
                    </li>
                    <li>
                        <strong>Informe o saldo final real</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">Digite o valor que você contou fisicamente (exemplo: R$ 1.250,00)</p>
                    </li>
                    <li>
                        <strong>Compare os valores</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">O sistema mostra: Saldo Esperado vs Saldo Real (diferença, se houver)</p>
                    </li>
                    <li>
                        <strong>Confirme o fechamento</strong>
                        <p class="ml-6 text-sm text-gray-600 mt-1">O caixa fica com status "Fechado" e não pode mais ser alterado</p>
                    </li>
                </ol>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h4 class="font-bold text-purple-900 mb-2">🧮 Exemplo Prático:</h4>
                <div class="text-sm text-gray-700 space-y-2">
                    <p><strong>Abertura do Caixa (8h da manhã):</strong></p>
                    <p class="ml-4">→ Saldo Inicial: <span class="text-green-600 font-semibold">R$ 100,00</span> (troco)</p>
                    
                    <p class="mt-3"><strong>Durante o Dia:</strong></p>
                    <p class="ml-4">→ Receitas: <span class="text-green-600 font-semibold">+R$ 1.500,00</span> (consultas e vacinas)</p>
                    <p class="ml-4">→ Despesas: <span class="text-red-600 font-semibold">-R$ 350,00</span> (compra de materiais)</p>
                    
                    <p class="mt-3"><strong>Fechamento (18h):</strong></p>
                    <p class="ml-4">→ Saldo Esperado: <span class="text-blue-600 font-semibold">R$ 1.250,00</span> (100 + 1500 - 350)</p>
                    <p class="ml-4">→ Saldo Real Contado: <span class="text-blue-600 font-semibold">R$ 1.250,00</span></p>
                    <p class="ml-4">→ Diferença: <span class="text-gray-600 font-semibold">R$ 0,00</span> ✅ <em>(Caixa batendo!)</em></p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">5</span>
            E se o Caixa não Bater?
        </h2>
        <div class="prose prose-blue max-w-none">
            <p class="text-gray-700 leading-relaxed mb-4">
                Se houver diferença entre o <strong>Saldo Esperado</strong> e o <strong>Saldo Real</strong>, pode significar:
            </p>
            
            <div class="space-y-3">
                <div class="flex items-start bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-yellow-800">Falta de Dinheiro (Saldo Real < Esperado)</h4>
                        <p class="text-sm text-yellow-700 mt-1">Pode ter havido erro na contagem, despesa não registrada, ou dinheiro foi retirado sem lançamento.</p>
                    </div>
                </div>

                <div class="flex items-start bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">⚠️</span>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-bold text-yellow-800">Sobra de Dinheiro (Saldo Real > Esperado)</h4>
                        <p class="text-sm text-yellow-700 mt-1">Pode ter havido erro na contagem, receita não registrada, ou dinheiro foi colocado sem lançamento.</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-4">
                <p class="text-sm text-gray-700">
                    <strong>💡 O que fazer?</strong> Revise todos os lançamentos do dia, verifique se alguma transação ficou de fora e conte o dinheiro novamente. Se a diferença persistir, registre-a como "Ajuste de Caixa" para fins de auditoria.
                </p>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="bg-blue-100 text-blue-800 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-semibold">6</span>
            Dicas e Boas Práticas
        </h2>
        <div class="prose prose-blue max-w-none">
            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-green-50 border-l-4 border-green-500 p-4">
                    <h4 class="font-bold text-green-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Faça
                    </h4>
                    <ul class="text-sm text-green-700 space-y-2 ml-2 list-disc">
                        <li>Abra o caixa todos os dias úteis antes do primeiro atendimento</li>
                        <li>Registre TODA movimentação em tempo real</li>
                        <li>Feche o caixa ao final do expediente, sem exceção</li>
                        <li>Guarde comprovantes de todas as transações</li>
                        <li>Faça sangria do caixa se acumular muito dinheiro</li>
                    </ul>
                </div>

                <div class="bg-red-50 border-l-4 border-red-500 p-4">
                    <h4 class="font-bold text-red-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Evite
                    </h4>
                    <ul class="text-sm text-red-700 space-y-2 ml-2 list-disc">
                        <li>Deixar o caixa aberto por mais de um dia</li>
                        <li>Fazer transações sem registrar no sistema</li>
                        <li>Fechar o caixa sem contar o dinheiro real</li>
                        <li>Ignorar pequenas diferenças (elas se acumulam!)</li>
                        <li>Permitir que várias pessoas mexam no caixa sem controle</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">📚 Artigos Relacionados</h2>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-900 mb-2">💰 Lançamentos Financeiros</h4>
                <p class="text-sm text-gray-600">Como registrar receitas e despesas no sistema</p>
            </a>
            <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-900 mb-2">📊 Relatórios Financeiros</h4>
                <p class="text-sm text-gray-600">Como gerar e interpretar relatórios do módulo</p>
            </a>
            <a href="#" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-900 mb-2">💳 Formas de Pagamento</h4>
                <p class="text-sm text-gray-600">Configure cartões, PIX, dinheiro e outros</p>
            </a>
        </div>
    </section>

    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mt-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ainda tem dúvidas?</h3>
                <p class="text-sm text-gray-700 mb-3">
                    Nossa equipe de suporte está pronta para ajudar você a dominar o controle de caixa da sua clínica.
                </p>
                <a href="/ajuda" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                    Buscar mais artigos
                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
HTML;

// Verificar se já existe artigo com esse slug
$artigoExistente = HelpArticle::where('slug', 'abrir-fechar-caixa')->first();

if ($artigoExistente) {
    echo "⚠️  Artigo já existe! Atualizando...\n\n";
    
    $artigoExistente->update([
        'categoria_slug' => 'financeiro',
        'titulo' => 'Como Abrir e Fechar o Caixa Diário',
        'conteudo_html' => $conteudoHtml,
        'resumo' => 'Aprenda a controlar o fluxo de caixa da sua clínica: como abrir o caixa no início do dia, registrar movimentações e fechar com conferência de valores. Guia completo com exemplos práticos.',
        'tags' => ['caixa', 'financeiro', 'controle', 'dinheiro', 'abertura', 'fechamento', 'movimentação', 'receitas', 'despesas'],
        'ordem' => 1,
        'destaque' => true,
        'ativo' => true,
    ]);
    
    echo "✅ Artigo ATUALIZADO com sucesso!\n";
} else {
    echo "📝 Criando novo artigo...\n\n";
    
    HelpArticle::create([
        'categoria_slug' => 'financeiro',
        'titulo' => 'Como Abrir e Fechar o Caixa Diário',
        'slug' => 'abrir-fechar-caixa',
        'conteudo_html' => $conteudoHtml,
        'resumo' => 'Aprenda a controlar o fluxo de caixa da sua clínica: como abrir o caixa no início do dia, registrar movimentações e fechar com conferência de valores. Guia completo com exemplos práticos.',
        'tags' => ['caixa', 'financeiro', 'controle', 'dinheiro', 'abertura', 'fechamento', 'movimentação', 'receitas', 'despesas'],
        'visualizacoes' => 0,
        'ordem' => 1,
        'destaque' => true,
        'ativo' => true,
    ]);
    
    echo "✅ Artigo CRIADO com sucesso!\n";
}

echo "\n📌 Detalhes do Artigo:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Título: Como Abrir e Fechar o Caixa Diário\n";
echo "Categoria: financeiro (Financeiro)\n";
echo "Slug: abrir-fechar-caixa\n";
echo "Destaque: Sim\n";
echo "Tags: " . implode(', ', ['caixa', 'financeiro', 'controle', 'dinheiro', 'abertura', 'fechamento', 'movimentação', 'receitas', 'despesas']) . "\n";
echo "\n🌐 Acesse o artigo em:\n";
echo "http://multiimune.imunify.test/ajuda/artigo/abrir-fechar-caixa\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

// Atualizar o controller para adicionar categoria 'financeiro'
echo "\n⚠️  ATENÇÃO: Você precisa adicionar a categoria 'financeiro' no AjudaController!\n";
echo "Adicione no array \$categorias:\n";
echo "['slug' => 'financeiro', 'nome' => 'Financeiro', 'icone' => '💰', 'descricao' => 'Caixa, lançamentos e relatórios'],\n";
