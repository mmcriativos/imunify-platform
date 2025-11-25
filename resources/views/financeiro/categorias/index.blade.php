@extends('layouts.tenant-app')

@section('title', 'Categorias Financeiras')
@section('page-title', 'Categorias Financeiras')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🏷️ Categorias Financeiras</h1>
                <p class="text-sm text-gray-600 mt-1">Gerencie as categorias de receitas e despesas</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('financeiro.dashboard') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    ← Voltar
                </a>
                <a href="{{ route('financeiro.categorias.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                    + Nova Categoria
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Receitas -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="text-2xl">📈</span>
                    Receitas ({{ $receitas->count() }})
                </h2>
            </div>
            
            <div class="p-6">
                @forelse($receitas as $categoria)
                    <div class="flex items-center justify-between p-4 bg-green-50 border-2 border-green-200 rounded-lg mb-3 hover:shadow-md transition group">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $categoria->icone }}</span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $categoria->nome }}</p>
                                @if($categoria->cor)
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="w-4 h-4 rounded-full border-2 border-gray-300" style="background-color: {{ $categoria->cor }}"></div>
                                        <span class="text-xs text-gray-500">{{ $categoria->cor }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('financeiro.categorias.edit', $categoria) }}" 
                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('financeiro.categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('Deseja excluir esta categoria?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="font-medium">Nenhuma categoria de receita</p>
                        <p class="text-sm mt-1">Crie sua primeira categoria</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Despesas -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-rose-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="text-2xl">📉</span>
                    Despesas ({{ $despesas->count() }})
                </h2>
            </div>
            
            <div class="p-6">
                @forelse($despesas as $categoria)
                    <div class="flex items-center justify-between p-4 bg-red-50 border-2 border-red-200 rounded-lg mb-3 hover:shadow-md transition group">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $categoria->icone }}</span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $categoria->nome }}</p>
                                @if($categoria->cor)
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="w-4 h-4 rounded-full border-2 border-gray-300" style="background-color: {{ $categoria->cor }}"></div>
                                        <span class="text-xs text-gray-500">{{ $categoria->cor }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('financeiro.categorias.edit', $categoria) }}" 
                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('financeiro.categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('Deseja excluir esta categoria?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 p-2 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="font-medium">Nenhuma categoria de despesa</p>
                        <p class="text-sm mt-1">Crie sua primeira categoria</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
