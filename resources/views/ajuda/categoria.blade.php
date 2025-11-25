@extends('layouts.tenant-app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-600 mb-8">
        <a href="{{ route('ajuda.index') }}" class="hover:text-indigo-600 transition">Central de Ajuda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900">{{ $categoria['nome'] }}</span>
    </nav>

    {{-- Header da categoria --}}
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
        <div class="flex items-center gap-4 mb-4">
            <div class="text-5xl">{{ $categoria['icone'] }}</div>
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $categoria['nome'] }}</h1>
                <p class="text-indigo-100 text-lg">{{ $categoria['descricao'] }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-6 text-sm text-indigo-100 mt-6 pt-6 border-t border-indigo-400">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                </svg>
                {{ $artigos->count() }} artigos disponíveis
            </span>
        </div>
    </div>

    {{-- Lista de artigos --}}
    @if($artigos->count() > 0)
    <div class="space-y-4">
        @foreach($artigos as $artigo)
        <a href="{{ route('ajuda.artigo', $artigo->slug) }}" class="block group">
            <div class="bg-white rounded-xl border-2 border-gray-200 p-6 hover:border-indigo-500 hover:shadow-lg transition-all duration-300">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <h2 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition">
                                {{ $artigo->titulo }}
                            </h2>
                            @if($artigo->destaque)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                DESTAQUE
                            </span>
                            @endif
                        </div>
                        
                        @if($artigo->resumo)
                        <p class="text-gray-600 mb-4 line-clamp-2">
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
                    
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum artigo disponível ainda</h3>
        <p class="text-gray-600 mb-6">Esta categoria está sendo preenchida com conteúdo útil.</p>
        <a href="{{ route('ajuda.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar para Central de Ajuda
        </a>
    </div>
    @endif

    {{-- Outras categorias --}}
    <div class="mt-16 pt-8 border-t border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Explorar Outras Categorias</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
            $todasCategorias = [
                ['slug' => 'whatsapp', 'nome' => 'WhatsApp', 'icone' => '📱'],
                ['slug' => 'agendamentos', 'nome' => 'Agendamentos', 'icone' => '📅'],
                ['slug' => 'vacinas', 'nome' => 'Vacinas', 'icone' => '💉'],
                ['slug' => 'pacientes', 'nome' => 'Pacientes', 'icone' => '👥'],
                ['slug' => 'relatorios', 'nome' => 'Relatórios', 'icone' => '📊'],
                ['slug' => 'configuracoes', 'nome' => 'Configurações', 'icone' => '⚙️'],
            ];
            @endphp
            
            @foreach($todasCategorias as $cat)
                @if($cat['slug'] !== $categoria['slug'])
                <a href="{{ route('ajuda.categoria', $cat['slug']) }}" class="group p-4 bg-white border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition text-center">
                    <div class="text-3xl mb-2">{{ $cat['icone'] }}</div>
                    <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                        {{ $cat['nome'] }}
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>

</div>
@endsection
