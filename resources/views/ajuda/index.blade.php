@extends('layouts.tenant-app')

@section('page-title', 'Central de Ajuda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header com busca destacada --}}
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mb-4 shadow-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-3">
            Central de Ajuda Imunify
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            Tudo o que você precisa saber para aproveitar ao máximo o sistema
        </p>

        {{-- Busca principal --}}
        <form action="{{ route('ajuda.buscar') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Buscar artigos, tutoriais e guias..."
                    class="w-full px-6 py-4 pl-14 pr-32 text-lg border border-gray-300 rounded-2xl shadow-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    autofocus
                >
                <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-md">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    {{-- Categorias --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            Navegue por Categoria
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categorias as $cat)
            <a href="{{ route('ajuda.categoria', $cat['slug']) }}" class="group">
                <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:border-indigo-500 hover:shadow-xl transition-all duration-300 h-full">
                    <div class="flex items-start gap-4">
                        <div class="text-4xl">{{ $cat['icone'] }}</div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition mb-2">
                                {{ $cat['nome'] }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">
                                {{ $cat['descricao'] }}
                            </p>
                            <span class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600">
                                {{ $cat['total_artigos'] }} artigos
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Artigos em destaque --}}
    @if($destaques->count() > 0)
    <div class="mb-16">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
            <h2 class="text-2xl font-bold text-gray-900">
                Artigos em Destaque
            </h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($destaques as $artigo)
            <a href="{{ route('ajuda.artigo', $artigo->slug) }}" class="group">
                <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-6 hover:shadow-xl transition-all duration-300 h-full">
                    <div class="flex items-start gap-3 mb-3">
                        <span class="text-2xl">{{ $artigo->categoria_icone }}</span>
                        <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">
                            {{ $artigo->categoria_nome }}
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition mb-2 line-clamp-2">
                        {{ $artigo->titulo }}
                    </h3>
                    @if($artigo->resumo)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $artigo->resumo }}
                    </p>
                    @endif
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($artigo->visualizacoes) }} visualizações
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Artigos populares (sidebar) --}}
    @if($populares->count() > 0)
    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 border border-indigo-100">
        <div class="flex items-center gap-2 mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-900">
                Mais Acessados
            </h2>
        </div>
        
        <div class="space-y-4">
            @foreach($populares as $index => $artigo)
            <a href="{{ route('ajuda.artigo', $artigo->slug) }}" class="flex items-start gap-4 p-4 bg-white rounded-xl hover:shadow-md transition-all group">
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm">{{ $artigo->categoria_icone }}</span>
                        <span class="text-xs font-medium text-indigo-600">{{ $artigo->categoria_nome }}</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2">
                        {{ $artigo->titulo }}
                    </h4>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format($artigo->visualizacoes) }} visualizações
                    </p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
