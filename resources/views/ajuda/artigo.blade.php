@extends('layouts.tenant-app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-600 mb-8 flex-wrap">
        <a href="{{ route('ajuda.index') }}" class="hover:text-indigo-600 transition">Central de Ajuda</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('ajuda.categoria', $artigo->categoria_slug) }}" class="hover:text-indigo-600 transition">
            {{ $artigo->categoria_nome }}
        </a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="font-medium text-gray-900 line-clamp-1">{{ $artigo->titulo }}</span>
    </nav>

    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        
        {{-- Conteúdo principal --}}
        <div class="lg:col-span-8">
            
            {{-- Header do artigo --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">{{ $artigo->categoria_icone }}</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold">
                        {{ $artigo->categoria_nome }}
                    </span>
                    @if($artigo->destaque)
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-sm font-bold rounded-full shadow-md">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Destaque
                    </span>
                    @endif
                </div>
                
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    {{ $artigo->titulo }}
                </h1>
                
                <div class="flex items-center gap-6 text-sm text-gray-600">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($artigo->visualizacoes) }} visualizações
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $artigo->updated_at->format('d/m/Y') }}
                    </span>
                </div>

                @if($artigo->tags && count($artigo->tags) > 0)
                <div class="flex items-center gap-2 mt-4 flex-wrap">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    @foreach($artigo->tags as $tag)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 transition">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Conteúdo do artigo --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm">
                <div class="prose prose-lg max-w-none">
                    {!! $artigo->conteudo_html !!}
                </div>
            </div>

            {{-- Feedback útil/não útil --}}
            <div class="mt-8 p-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-3 text-center">
                    Este artigo foi útil?
                </h3>
                <div class="flex items-center justify-center gap-4">
                    <button class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 rounded-xl hover:border-green-500 hover:bg-green-50 transition group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                        <span class="font-semibold text-gray-700 group-hover:text-green-700">Sim, ajudou!</span>
                    </button>
                    <button class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 rounded-xl hover:border-red-500 hover:bg-red-50 transition group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                        </svg>
                        <span class="font-semibold text-gray-700 group-hover:text-red-700">Não ajudou</span>
                    </button>
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-4 mt-8 lg:mt-0">
            
            {{-- Artigos relacionados --}}
            @if($relacionados->count() > 0)
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100 mb-6 sticky top-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Artigos Relacionados
                </h3>
                
                <div class="space-y-3">
                    @foreach($relacionados as $relacionado)
                    <a href="{{ route('ajuda.artigo', $relacionado->slug) }}" class="block p-4 bg-white rounded-xl hover:shadow-md transition group">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl flex-shrink-0">{{ $relacionado->categoria_icone }}</span>
                            <div>
                                <h4 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 mb-1">
                                    {{ $relacionado->titulo }}
                                </h4>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($relacionado->visualizacoes) }} visualizações
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Voltar para categoria --}}
            <a href="{{ route('ajuda.categoria', $artigo->categoria_slug) }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-white border-2 border-gray-300 rounded-xl hover:border-indigo-500 hover:shadow-md transition font-semibold text-gray-700 hover:text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Ver Todos em {{ $artigo->categoria_nome }}
            </a>

        </div>

    </div>

</div>

{{-- CSS adicional para formatação de conteúdo --}}
<style>
.prose h2 {
    @apply text-2xl font-bold text-gray-900 mt-8 mb-4;
}
.prose h3 {
    @apply text-xl font-semibold text-gray-900 mt-6 mb-3;
}
.prose p {
    @apply text-gray-700 leading-relaxed mb-4;
}
.prose ul, .prose ol {
    @apply ml-6 mb-4 space-y-2;
}
.prose ul {
    @apply list-disc;
}
.prose ol {
    @apply list-decimal;
}
.prose li {
    @apply text-gray-700;
}
.prose code {
    @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono text-indigo-600;
}
.prose pre {
    @apply bg-gray-900 text-gray-100 p-4 rounded-xl overflow-x-auto mb-4;
}
.prose pre code {
    @apply bg-transparent text-gray-100 p-0;
}
.prose blockquote {
    @apply border-l-4 border-indigo-500 pl-4 py-2 my-4 bg-indigo-50 rounded-r-lg;
}
.prose strong {
    @apply font-semibold text-gray-900;
}
.prose a {
    @apply text-indigo-600 hover:text-indigo-700 underline;
}
.prose img {
    @apply rounded-xl shadow-md my-6;
}
</style>
@endsection
