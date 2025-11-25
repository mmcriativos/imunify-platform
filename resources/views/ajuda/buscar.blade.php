@extends('layouts.tenant-app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-600 mb-8">
        <a href="{{ route('ajuda.index') }}" class="hover:text-indigo-600 transition">Central de Ajuda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900">Resultados da Busca</span>
    </nav>

    {{-- Header com busca --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            Resultados para: <span class="text-indigo-600">"{{ $termo }}"</span>
        </h1>
        
        {{-- Busca novamente --}}
        <form action="{{ route('ajuda.buscar') }}" method="GET" class="max-w-2xl">
            <div class="relative">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $termo }}"
                    placeholder="Refinar busca..."
                    class="w-full px-6 py-3 pl-12 pr-24 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    {{-- Resultados --}}
    @if($resultados->count() > 0)
    <div class="mb-6">
        <p class="text-gray-600">
            Encontrados <strong class="text-gray-900">{{ $resultados->total() }}</strong> resultados
        </p>
    </div>

    <div class="space-y-4 mb-8">
        @foreach($resultados as $artigo)
        <a href="{{ route('ajuda.artigo', $artigo->slug) }}" class="block group">
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:border-indigo-500 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="text-3xl">{{ $artigo->categoria_icone }}</div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">
                                {{ $artigo->categoria_nome }}
                            </span>
                            @if($artigo->destaque)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                DESTAQUE
                            </span>
                            @endif
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition mb-2">
                            {{ $artigo->titulo }}
                        </h2>
                        
                        @if($artigo->resumo)
                        <p class="text-gray-600 mb-3 line-clamp-2">
                            {{ $artigo->resumo }}
                        </p>
                        @endif
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($artigo->visualizacoes) }} visualizações
                            </span>
                            
                            @if($artigo->tags)
                            <div class="flex items-center gap-2">
                                @foreach(array_slice($artigo->tags, 0, 3) as $tag)
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">
                                    {{ $tag }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Paginação --}}
    <div class="flex justify-center">
        {{ $resultados->links() }}
    </div>

    @else
    {{-- Nenhum resultado --}}
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-3">
            Nenhum resultado encontrado
        </h2>
        <p class="text-gray-600 mb-8">
            Não encontramos artigos com o termo "<strong>{{ $termo }}</strong>".<br>
            Tente usar palavras-chave diferentes ou explore as categorias.
        </p>
        
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('ajuda.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Ir para Página Inicial
            </a>
        </div>
    </div>
    @endif

    {{-- Sugestões de categorias --}}
    @if($resultados->count() === 0)
    <div class="mt-16 pt-8 border-t border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Explorar por Categoria</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
            $categorias = [
                ['slug' => 'whatsapp', 'nome' => 'WhatsApp', 'icone' => '📱'],
                ['slug' => 'agendamentos', 'nome' => 'Agendamentos', 'icone' => '📅'],
                ['slug' => 'vacinas', 'nome' => 'Vacinas', 'icone' => '💉'],
                ['slug' => 'pacientes', 'nome' => 'Pacientes', 'icone' => '👥'],
                ['slug' => 'relatorios', 'nome' => 'Relatórios', 'icone' => '📊'],
                ['slug' => 'configuracoes', 'nome' => 'Configurações', 'icone' => '⚙️'],
            ];
            @endphp
            
            @foreach($categorias as $cat)
            <a href="{{ route('ajuda.categoria', $cat['slug']) }}" class="group p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition text-center">
                <div class="text-3xl mb-2">{{ $cat['icone'] }}</div>
                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                    {{ $cat['nome'] }}
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
