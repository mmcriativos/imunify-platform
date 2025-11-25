<!DOCTYPE html><!DOCTYPE html>

<html lang="pt-BR"><html lang="pt-BR">

<head><head>

    <meta charset="UTF-8">    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carteira de Vacinação - {{ $paciente->nome }}</title>    <title>Carteira de Vacinação - {{ $paciente->nome }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])    @vite(['resources/css/app.css', 'resources/js/app.js'])

        

    <style>    <style>

        body {        .writing-mode-vertical {

            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);            writing-mode: vertical-rl;

            min-height: 100vh;            text-orientation: mixed;

            padding: 20px;        }

        }        body {

    </style>            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

</head>            min-height: 100vh;

<body>            padding: 20px;

    <div class="max-w-7xl mx-auto">        }

        <!-- Header Público -->    </style>

        <div class="bg-white rounded-2xl shadow-2xl p-6 mb-6"></head>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4"><body>

                <div class="flex items-center gap-4">    <div class="max-w-7xl mx-auto">

                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-4 rounded-xl">        <!-- Header Público -->

                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">        <div class="bg-white rounded-2xl shadow-2xl p-6 mb-6">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>            <div class="flex items-center justify-between">

                        </svg>                <div class="flex items-center gap-4">

                    </div>                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-4 rounded-xl">

                    <div>                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <h1 class="text-3xl font-bold text-gray-900">Carteira de Vacinação Digital</h1>                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                        <p class="text-gray-600">MultiImune Clínica de Vacinação</p>                        </svg>

                    </div>                    </div>

                </div>                    <div>

                <div class="text-center md:text-right">                        <h1 class="text-3xl font-bold text-gray-900">Carteira de Vacinação Digital</h1>

                    <p class="text-sm text-gray-600">Acesso público via link seguro</p>                        <p class="text-gray-600">MultiImune Clínica de Vacinação</p>

                    <p class="text-xs text-gray-500 mt-1">🔒 Somente leitura</p>                    </div>

                </div>                </div>

            </div>                <div class="text-right">

        </div>                    <p class="text-sm text-gray-600">Acesso público via link seguro</p>

                    <p class="text-xs text-gray-500 mt-1">🔒 Somente leitura</p>

        <!-- Informações do Paciente -->                </div>

        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">            </div>

            <div class="flex items-center gap-2 mb-4">        </div>

                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>@push('scripts')

                </svg><script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide">Paciente</p>@endpush

            </div>

            @section('content')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4"><div class="mb-6">

                <div>    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">

                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nome</p>        <div class="flex items-center gap-3">

                    <p class="text-lg font-bold text-gray-900">{{ $paciente->nome }}</p>            <a href="{{ route('carteira.index') }}" 

                </div>               class="bg-gray-200 hover:bg-gray-300 p-2 rounded-lg transition">

                <div>                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nascimento</p>                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

                    <p class="text-lg font-bold text-gray-900">                </svg>

                        {{ $paciente->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}            </a>

                    </p>            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-3 rounded-xl shadow-lg">

                </div>                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <div>                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Idade</p>                </svg>

                    <p class="text-lg font-bold text-gray-900">            </div>

                        @if($paciente->data_nascimento)            <div>

                            @php                <h1 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">

                                $anos = \Carbon\Carbon::parse($paciente->data_nascimento)->age;                    Carteira de Vacinação

                            @endphp                </h1>

                            {{ $anos }} {{ $anos == 1 ? 'ano' : 'anos' }}                <p class="text-gray-600 mt-1">Histórico completo de imunizações</p>

                        @else            </div>

                            Não informado        </div>

                        @endif        

                    </p>        <div class="flex gap-3">

                </div>            <a href="{{ route('carteira.certificado', $paciente->id) }}" 

            </div>               target="_blank"

        </div>               class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-300 transform hover:scale-105">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

        <!-- Botões de Compartilhamento -->                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">                </svg>

            <div class="flex flex-col md:flex-row items-center justify-between gap-4">                Certificado PDF

                <div>            </a>

                    <h3 class="text-lg font-bold text-gray-900 mb-1">📱 Compartilhar Carteira</h3>            

                    <p class="text-sm text-gray-600">Envie este link para acessar em qualquer dispositivo</p>            <a href="{{ route('carteira.print', $paciente->id) }}" 

                </div>               target="_blank"

                <div class="flex gap-3">               class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-300 transform hover:scale-105">

                    <button onclick="copiarLink()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg shadow-md transition">                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>                </svg>

                        </svg>                Imprimir Carteira

                        Copiar Link            </a>

                    </button>            

                    <button onclick="compartilharWhatsApp()" class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-5 py-3 rounded-lg shadow-md transition">            <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"

                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">                    class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-300 transform hover:scale-105">

                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        </svg>                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>

                        WhatsApp                </svg>

                    </button>                Nova Aplicação

                </div>            </button>

            </div>        </div>

        </div>    </div>

</div>

        <!-- Histórico de Vacinas (versão simplificada) -->

        <div class="bg-white rounded-2xl shadow-xl p-6"><!-- Informações do Paciente -->

            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2"><div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 mb-6 shadow-lg">

                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">    <div class="flex flex-col lg:flex-row gap-6">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>        <!-- Dados do Paciente -->

                </svg>        <div class="flex-1">

                Histórico de Imunizações            <div class="flex items-center gap-2 mb-3">

            </h2>                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

            @if($vacinasAplicadas->count() > 0)                </svg>

                <div class="space-y-4">                <p class="text-sm font-semibold text-green-700 uppercase tracking-wide">Paciente com imunizações em dia</p>

                    @foreach($vacinasAplicadas->groupBy('vacina') as $nomeVacina => $doses)            </div>

                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:shadow-md transition">            

                            <div class="flex items-center justify-between mb-3">            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                                <h3 class="text-lg font-bold text-gray-900">{{ $nomeVacina }}</h3>        <div>

                                <span class="bg-green-100 text-green-700 text-sm font-bold px-3 py-1 rounded-full">            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Código</p>

                                    {{ $doses->count() }} {{ $doses->count() == 1 ? 'dose' : 'doses' }}            <p class="text-lg font-bold text-gray-900">#{{ str_pad($paciente->id, 6, '0', STR_PAD_LEFT) }}</p>

                                </span>        </div>

                            </div>        <div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nome</p>

                                @foreach($doses->sortBy('data') as $dose)            <p class="text-lg font-bold text-gray-900">{{ $paciente->nome }}</p>

                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">        </div>

                                        <p class="text-xs text-green-700 font-semibold mb-1">{{ $dose['dose'] }}</p>        <div>

                                        <p class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($dose['data'])->format('d/m/Y') }}</p>            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Nascimento</p>

                                        <p class="text-xs text-gray-600 mt-1">Lote: {{ $dose['lote'] ?? 'N/A' }}</p>            <p class="text-lg font-bold text-gray-900">

                                    </div>                {{ $paciente->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}

                                @endforeach            </p>

                            </div>        </div>

                        </div>        <div>

                    @endforeach            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Idade</p>

                </div>            <p class="text-lg font-bold text-gray-900">

            @else                @if($paciente->data_nascimento)

                <p class="text-center text-gray-500 py-8">Nenhuma vacina registrada</p>                    @php

            @endif                        $anos = \Carbon\Carbon::parse($paciente->data_nascimento)->age;

        </div>                        $meses = \Carbon\Carbon::parse($paciente->data_nascimento)->diffInMonths(now());

                    @endphp

        <!-- Rodapé -->                    @if($anos == 0)

        <div class="mt-6 text-center text-white text-sm">                        {{ $meses }} {{ $meses == 1 ? 'mês e ' : 'meses e ' }}

            <p>© 2025 MultiImune Clínica de Vacinação | Este link é pessoal e intransferível</p>                        {{ \Carbon\Carbon::parse($paciente->data_nascimento)->diffInDays(now()) % 30 }} 

        </div>                        {{ \Carbon\Carbon::parse($paciente->data_nascimento)->diffInDays(now()) % 30 == 1 ? 'dia' : 'dias' }}

    </div>                    @else

                        {{ $anos }} {{ $anos == 1 ? 'ano e ' : 'anos e ' }}{{ $meses % 12 }} {{ $meses % 12 == 1 ? 'mês' : 'meses' }}

    <script>                    @endif

        const urlCarteira = "{{ route('carteira.publica', $paciente->token_carteira) }}";                @else

        const nomePaciente = "{{ $paciente->nome }}";                    Não informado

                        @endif

        function copiarLink() {            </p>

            navigator.clipboard.writeText(urlCarteira).then(() => {        </div>

                alert('✅ Link copiado com sucesso!\n\nVocê pode colar e enviar por e-mail, WhatsApp ou qualquer outro aplicativo.\n\n' + urlCarteira);    </div>

            }).catch(() => {    

                // Fallback para navegadores antigos            @if($paciente->responsavel_nome)

                const textarea = document.createElement('textarea');                <div class="mt-4 pt-4 border-t border-green-200">

                textarea.value = urlCarteira;                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Responsável</p>

                document.body.appendChild(textarea);                    <p class="text-base font-semibold text-gray-900">{{ $paciente->responsavel_nome }}</p>

                textarea.select();                </div>

                document.execCommand('copy');            @endif

                document.body.removeChild(textarea);            

                alert('✅ Link copiado!\n\n' + urlCarteira);            <div class="mt-4 flex items-center gap-2">

            });                <button onclick="toggleSugestoes()" 

        }                        class="text-sm text-green-700 font-semibold hover:text-green-800 flex items-center gap-1">

                            <svg id="seta-sugestoes" class="w-4 h-4 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">

        function compartilharWhatsApp() {                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>

            const texto = encodeURIComponent(`🏥 *Carteira de Vacinação Digital*\n\n👤 Paciente: ${nomePaciente}\n\n📱 Acesse aqui:\n${urlCarteira}\n\n_MultiImune Clínica de Vacinação_`);                    </svg>

            window.open(`https://wa.me/?text=${texto}`, '_blank');                    Exibir sugestões automáticas

        }                </button>

    </script>            </div>

</body>        </div>

</html>        

        <!-- QR Code -->
        <div class="lg:border-l lg:border-green-200 lg:pl-6 flex items-center">
            <div class="bg-white rounded-xl p-4 shadow-md text-center">
                <p class="text-xs font-bold text-gray-700 uppercase mb-3">Carteira Digital</p>
                <div id="qrcode" class="flex justify-center mb-3"></div>
                <p class="text-xs text-gray-600 mb-2">Escaneie para acessar</p>
                <button onclick="compartilharCarteira()" class="text-xs bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 mx-auto w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Compartilhar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Campanhas Ativas -->
@if(isset($campanhasAtivas) && $campanhasAtivas->count() > 0)
    <div class="mb-6">
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-300 rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            Campanhas de Vacinação Ativas
                        </h3>
                        <p class="text-emerald-100 text-sm mt-1">
                            {{ $campanhasAtivas->count() }} {{ $campanhasAtivas->count() == 1 ? 'campanha disponível' : 'campanhas disponíveis' }} para este paciente
                        </p>
                    </div>
                    <div class="hidden lg:block">
                        <svg class="w-16 h-16 text-emerald-200 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($campanhasAtivas as $campanha)
                        @php
                            $urgente = $campanha['dias_restantes'] <= 7;
                            $corBorda = $urgente ? 'border-red-400' : 'border-emerald-400';
                            $corBg = $urgente ? 'bg-red-50' : 'bg-white';
                        @endphp
                        
                        <div class="{{ $corBg }} border-2 {{ $corBorda }} rounded-xl p-5 hover:shadow-lg transition-all relative overflow-hidden">
                            @if($urgente)
                                <div class="absolute top-0 left-0 right-0 bg-red-500 text-white text-xs font-bold py-1 px-3 text-center animate-pulse">
                                    ⏰ ÚLTIMOS {{ $campanha['dias_restantes'] }} {{ $campanha['dias_restantes'] == 1 ? 'DIA' : 'DIAS' }}!
                                </div>
                                <div class="mt-6"></div>
                            @endif
                            
                            <div class="flex items-start gap-4">
                                <!-- Ícone -->
                                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 p-3 rounded-xl flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                
                                <!-- Conteúdo -->
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $campanha['nome'] }}</h4>
                                    <p class="text-sm text-gray-700 mb-3">{{ $campanha['descricao'] }}</p>
                                    
                                    <div class="space-y-2 text-sm">
                                        <!-- Vacina -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-700">Vacina:</span>
                                            <span class="text-emerald-700 font-bold">{{ $campanha['vacina'] }}</span>
                                        </div>
                                        
                                        <!-- Público-alvo -->
                                        @if($campanha['publico_alvo'])
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <span class="text-gray-600">{{ $campanha['publico_alvo'] }}</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Período -->
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $campanha['data_inicio'] }} até {{ $campanha['data_fim'] }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Botão de ação -->
                                    <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"
                                            class="mt-4 w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold py-2 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Agendar Vacinação
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Vacinas Sugeridas (oculto inicialmente) -->
@if($vacinasSugeridas->count() > 0)
    <div id="sugestoes" class="hidden mb-6">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-indigo-200 rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            Sugestões Inteligentes de Vacinação
                        </h3>
                        <p class="text-indigo-100 text-sm mt-1">
                            Baseadas no Calendário Nacional do Ministério da Saúde • {{ $vacinasSugeridas->count() }} recomendações
                        </p>
                    </div>
                    
                    <!-- Legenda de Prioridades -->
                    <div class="hidden lg:flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-white font-semibold">Alta prioridade</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <span class="text-white font-semibold">Média prioridade</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Separar por prioridade -->
                @php
                    $altaPrioridade = $vacinasSugeridas->filter(fn($s) => $s['prioridade'] === 'alta');
                    $mediaPrioridade = $vacinasSugeridas->filter(fn($s) => $s['prioridade'] === 'média');
                    $atrasadas = $vacinasSugeridas->filter(fn($s) => isset($s['atrasada']) && $s['atrasada']);
                @endphp
                
                <!-- Alertas de Doses Atrasadas -->
                @if($atrasadas->count() > 0)
                    <div class="mb-6 bg-red-50 border-2 border-red-300 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-red-500 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-red-900 text-lg mb-2">⚠️ Atenção: Vacinas Atrasadas!</h4>
                                <p class="text-red-700 text-sm mb-3">As seguintes vacinas estão com aplicação atrasada. Recomenda-se regularização urgente:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($atrasadas as $sugestao)
                                        <div class="bg-white border-2 border-red-400 rounded-lg p-3 flex items-start gap-3">
                                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="font-bold text-red-900">{{ $sugestao['nome'] }}</p>
                                                <p class="text-sm text-red-700">{{ $sugestao['dose'] }}</p>
                                                <p class="text-xs text-red-600 mt-1">Ideal: {{ $sugestao['idade_recomendada'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Alta Prioridade -->
                @if($altaPrioridade->count() > 0)
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <h4 class="font-bold text-gray-900 text-lg">Alta Prioridade</h4>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $altaPrioridade->count() }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($altaPrioridade as $sugestao)
                                <div class="bg-white border-2 border-red-300 rounded-xl p-4 hover:shadow-lg transition-shadow relative overflow-hidden">
                                    <!-- Faixa de prioridade -->
                                    <div class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                                        URGENTE
                                    </div>
                                    
                                    <div class="flex items-start gap-3 mt-2">
                                        <div class="bg-red-100 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 text-base">{{ $sugestao['nome'] }}</p>
                                            <p class="text-sm text-gray-700 font-semibold">{{ $sugestao['dose'] }}</p>
                                            <div class="mt-2 flex items-center gap-1 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            @if(isset($sugestao['observacao']))
                                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $sugestao['observacao'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Média Prioridade -->
                @if($mediaPrioridade->count() > 0)
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                            <h4 class="font-bold text-gray-900 text-lg">Média Prioridade</h4>
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">
                                {{ $mediaPrioridade->count() }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($mediaPrioridade as $sugestao)
                                <div class="bg-white border-2 border-yellow-300 rounded-xl p-4 hover:shadow-lg transition-shadow">
                                    <div class="flex items-start gap-3">
                                        <div class="bg-yellow-100 p-2 rounded-lg">
                                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900">{{ $sugestao['nome'] }}</p>
                                            <p class="text-sm text-gray-700">{{ $sugestao['dose'] }}</p>
                                            <div class="mt-2 flex items-center gap-1 text-xs text-gray-600">
                                                <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            @if(isset($sugestao['observacao']))
                                                <p class="mt-2 text-xs text-gray-600">{{ $sugestao['observacao'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Histórico de Vacinações -->
<div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Histórico de Imunizações
        </h2>
        <p class="text-purple-100 mt-1">{{ $vacinasAplicadas->count() }} vacina(s) aplicada(s)</p>
        
        <div class="mt-4 flex items-center gap-4 text-sm">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-green-100 border-2 border-green-400 rounded"></div>
                <span class="text-white">Aplicada</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-blue-100 border-2 border-blue-400 rounded"></div>
                <span class="text-white">Agendada</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-purple-100 border-2 border-purple-400 rounded"></div>
                <span class="text-white">Sugestão</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-red-100 border-2 border-red-400 rounded"></div>
                <span class="text-white">Não paga</span>
            </div>
        </div>
    </div>

    @if($vacinasAplicadas->count() > 0)
        <div class="p-6 bg-gray-50">
            <!-- Layout tipo carteira de vacinação física -->
            <div class="space-y-6">
                @php
                    // Agrupar por vacina e organizar em linhas
                    $vacinasPorCategoria = [
                        'BCG' => ['nome' => 'BCG', 'cor' => 'bg-green-50', 'borda' => 'border-green-200'],
                        'Hepatite' => ['nome' => 'Hepatite B', 'cor' => 'bg-green-50', 'borda' => 'border-green-200'],
                        'Pentavalente' => ['nome' => 'Pentavalente/13V', 'cor' => 'bg-blue-50', 'borda' => 'border-blue-200'],
                        'Pneumocócica' => ['nome' => 'Pneumocócica 13 Valente', 'cor' => 'bg-blue-50', 'borda' => 'border-blue-200'],
                        'Meningocócica' => ['nome' => 'Meningocócica/Rotavírus Pentavalente', 'cor' => 'bg-purple-50', 'borda' => 'border-purple-200'],
                        'Rotavírus' => ['nome' => 'Rotavírus', 'cor' => 'bg-purple-50', 'borda' => 'border-purple-200'],
                        'Influenza' => ['nome' => 'Influenza', 'cor' => 'bg-cyan-50', 'borda' => 'border-cyan-200'],
                    ];
                    
                    // Organizar vacinas aplicadas por nome
                    $vacinasAgrupadas = $vacinasAplicadas->groupBy('vacina');
                @endphp

                @foreach($vacinasAgrupadas as $nomeVacina => $doses)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200">
                        <!-- Cabeçalho da Vacina -->
                        <div class="flex">
                            <!-- Label lateral -->
                            <div class="bg-gradient-to-b from-blue-500 to-cyan-500 text-white font-bold text-sm writing-mode-vertical px-3 py-4 flex items-center justify-center min-w-[60px]">
                                <span class="transform -rotate-180" style="writing-mode: vertical-rl; text-orientation: mixed;">
                                    {{ strtoupper(Str::limit($nomeVacina, 15, '')) }}
                                </span>
                            </div>
                            
                            <!-- Grid de doses -->
                            <div class="flex-1 p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach($doses->sortBy('data') as $index => $dose)
                                        @php
                                            $isPaga = !isset($dose['pendente_pagamento']) || !$dose['pendente_pagamento'];
                                            $corCard = $isPaga ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300';
                                            $corBadge = $isPaga ? 'bg-green-500' : 'bg-red-500';
                                        @endphp
                                        
                                        <div class="relative {{ $corCard }} border-2 rounded-lg p-3 hover:shadow-lg transition-shadow">
                                            <!-- Badge de status -->
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="{{ $corBadge }} text-white text-xs font-bold px-2 py-1 rounded-full">
                                                    {{ is_numeric($dose['dose']) ? $dose['dose'] . 'ª Dose' : $dose['dose'] }}
                                                </span>
                                                @if(!$isPaga)
                                                    <span class="text-red-600 text-xs font-semibold">Não paga</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Data -->
                                            <div class="text-sm font-bold text-gray-900 mb-2">
                                                {{ \Carbon\Carbon::parse($dose['data'])->format('d/m/Y') }}
                                            </div>
                                            
                                            <!-- Detalhes -->
                                            <div class="space-y-1 text-xs text-gray-600">
                                                @if(isset($dose['lote']) && $dose['lote'])
                                                    <p><span class="font-semibold">Lote:</span> {{ Str::limit($dose['lote'], 12) }}</p>
                                                @endif
                                                
                                                @if(isset($dose['tipo']))
                                                    <p class="flex items-center gap-1">
                                                        @if($dose['tipo'] === 'clinica')
                                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                            </svg>
                                                        @endif
                                                        <span class="capitalize">{{ $dose['tipo'] }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                            
                                            <!-- Ícone de check se aplicada -->
                                            @if($isPaga)
                                                <div class="absolute -top-1 -right-1 bg-green-500 rounded-full p-1">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @php
                                        // Buscar doses sugeridas desta vacina específica
                                        $dosesSugeridasDessaVacina = $vacinasSugeridas->filter(function($sug) use ($nomeVacina) {
                                            return stripos($sug['nome'], explode(' ', $nomeVacina)[0]) !== false ||
                                                   stripos($nomeVacina, explode(' ', $sug['nome'])[0]) !== false;
                                        });
                                    @endphp
                                    
                                    @foreach($dosesSugeridasDessaVacina as $sugestao)
                                        <div class="relative bg-purple-50 border-2 border-purple-300 border-dashed rounded-lg p-3 hover:shadow-lg transition-shadow">
                                            <!-- Badge de sugestão -->
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                    {{ $sugestao['dose'] }}
                                                </span>
                                                <span class="text-purple-600 text-xs font-semibold">Sugestão</span>
                                            </div>
                                            
                                            <!-- Data prevista -->
                                            <div class="text-sm font-bold text-purple-900 mb-2">
                                                {{ $sugestao['idade_recomendada'] }}
                                            </div>
                                            
                                            <!-- Ação -->
                                            <div class="text-xs text-purple-600 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-semibold">Dose recomendada</span>
                                            </div>
                                            
                                            <!-- Ícone de sugestão -->
                                            <div class="absolute -top-1 -right-1 bg-purple-500 rounded-full p-1">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-500 text-lg font-semibold">Nenhuma vacina aplicada ainda</p>
            <p class="text-gray-400 mt-2">Registre a primeira aplicação para começar o histórico</p>
            <button onclick="window.location.href='{{ route('atendimentos.create', ['paciente_id' => $paciente->id]) }}'"
                    class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Registrar Primeira Aplicação
            </button>
        </div>
    @endif
</div>

<script>
// Gerar QR Code
document.addEventListener('DOMContentLoaded', function() {
    const urlCarteira = "{{ route('carteira.show', $paciente->id) }}";
    new QRCode(document.getElementById("qrcode"), {
        text: urlCarteira,
        width: 128,
        height: 128,
        colorDark: "#059669",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
});

// Função para compartilhar carteira
function compartilharCarteira() {
    const urlCarteira = "{{ route('carteira.show', $paciente->id) }}";
    const nome = "{{ $paciente->nome }}";
    const texto = `Carteira de Vacinação Digital de ${nome}\nAcesse: ${urlCarteira}`;
    
    if (navigator.share) {
        // API Web Share (funciona em mobile)
        navigator.share({
            title: 'Carteira de Vacinação Digital',
            text: texto,
            url: urlCarteira
        }).then(() => {
            console.log('Compartilhado com sucesso');
        }).catch((error) => {
            console.log('Erro ao compartilhar', error);
            copiarLink(urlCarteira);
        });
    } else {
        // Fallback: copiar para área de transferência
        copiarLink(urlCarteira);
    }
}

function copiarLink(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('Link copiado para área de transferência!\n\n' + url);
    }).catch(() => {
        // Fallback para navegadores antigos
        const textarea = document.createElement('textarea');
        textarea.value = url;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('Link copiado para área de transferência!\n\n' + url);
    });
}

function toggleSugestoes() {
    const sugestoes = document.getElementById('sugestoes');
    const seta = document.getElementById('seta-sugestoes');
    
    if (sugestoes.classList.contains('hidden')) {
        sugestoes.classList.remove('hidden');
        seta.classList.add('rotate-180');
    } else {
        sugestoes.classList.add('hidden');
        seta.classList.remove('rotate-180');
    }
}
</script>
@endsection
