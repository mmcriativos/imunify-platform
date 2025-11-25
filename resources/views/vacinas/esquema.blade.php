@extends('layouts.tenant-app')

@section('title', 'Esquema de Doses - ' . $vacina->nome)
@section('page-title', 'Esquema de Doses')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('vacinas.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Esquema de Doses</h1>
                    <p class="text-gray-600 mt-1">{{ $vacina->nome }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('vacinas.edit', $vacina) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Editar Vacina
                </a>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Info Box -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Configure o esquema vacinal</p>
                    <p>Defina quantas doses são necessárias, idade recomendada e intervalos entre doses. O sistema usará essas informações para sugerir automaticamente as próximas doses na carteira de vacinação e enviar lembretes.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <form method="POST" action="{{ route('vacinas.esquema.salvar', $vacina) }}" x-data="esquemaDoses({{ $esquemaDoses->toJson() }})">
        @csrf

        <!-- Lista de Doses -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Configuração de Doses
                </h2>
            </div>

            <div class="p-6">
                <template x-for="(dose, index) in doses" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 bg-gray-50">
                        <!-- Cabeçalho da Dose -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-bold" x-text="dose.dose_numero + 'ª Dose'"></span>
                                <input type="text" 
                                       x-model="dose.nome_dose" 
                                       :name="'doses[' + index + '][nome_dose]'"
                                       placeholder="Ex: 1ª dose, Reforço, Dose única"
                                       class="flex-1 max-w-xs px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-0 focus:border-blue-500 text-sm">
                            </div>
                            <button type="button" 
                                    @click="removerDose(index)"
                                    x-show="doses.length > 1"
                                    class="text-red-600 hover:text-red-800 transition p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Hidden inputs para dados necessários -->
                        <input type="hidden" :name="'doses[' + index + '][dose_numero]'" x-model="dose.dose_numero">

                        <!-- Campos -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Idade Mínima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    📅 Idade Mínima (meses)
                                </label>
                                <input type="number" 
                                       x-model="dose.idade_minima_meses" 
                                       :name="'doses[' + index + '][idade_minima_meses]'"
                                       min="0"
                                       placeholder="Ex: 2"
                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-0 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Idade recomendada para aplicação</p>
                            </div>

                            <!-- Idade Máxima -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    ⏰ Idade Máxima (meses)
                                </label>
                                <input type="number" 
                                       x-model="dose.idade_maxima_meses" 
                                       :name="'doses[' + index + '][idade_maxima_meses]'"
                                       min="0"
                                       placeholder="Ex: 12"
                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-0 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Idade limite (opcional)</p>
                            </div>

                            <!-- Intervalo Mínimo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    🔄 Intervalo Mínimo (dias)
                                </label>
                                <input type="number" 
                                       x-model="dose.intervalo_minimo_dias" 
                                       :name="'doses[' + index + '][intervalo_minimo_dias]'"
                                       min="0"
                                       placeholder="Ex: 30"
                                       class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-0 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Dias após dose anterior</p>
                            </div>

                            <!-- Observações -->
                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    📝 Observações
                                </label>
                                <textarea x-model="dose.observacoes" 
                                          :name="'doses[' + index + '][observacoes]'"
                                          rows="2"
                                          placeholder="Ex: Apenas para grupos de risco, intervalo varia conforme fabricante..."
                                          class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-0 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Botão Adicionar Dose -->
                <button type="button" 
                        @click="adicionarDose()"
                        class="w-full py-3 border-2 border-dashed border-purple-300 rounded-lg text-purple-600 hover:bg-purple-50 transition flex items-center justify-center gap-2 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Adicionar Nova Dose
                </button>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="flex items-center justify-between">
            <a href="{{ route('vacinas.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Salvar Esquema
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function esquemaDoses(esquemaExistente) {
    return {
        doses: esquemaExistente.length > 0 ? esquemaExistente : [
            {
                dose_numero: 1,
                nome_dose: '1ª dose',
                idade_minima_meses: null,
                idade_maxima_meses: null,
                intervalo_minimo_dias: null,
                intervalo_maximo_dias: null,
                obrigatoria: true,
                rede: 'sus',
                observacoes: null
            }
        ],
        
        adicionarDose() {
            const proximoNumero = this.doses.length + 1;
            this.doses.push({
                dose_numero: proximoNumero,
                nome_dose: proximoNumero + 'ª dose',
                idade_minima_meses: null,
                idade_maxima_meses: null,
                intervalo_minimo_dias: null,
                intervalo_maximo_dias: null,
                obrigatoria: true,
                rede: 'sus',
                observacoes: null
            });
        },
        
        removerDose(index) {
            if (this.doses.length > 1) {
                this.doses.splice(index, 1);
                // Reordenar números de dose
                this.doses.forEach((dose, idx) => {
                    dose.dose_numero = idx + 1;
                    if (dose.nome_dose && dose.nome_dose.match(/^\d+ª dose$/)) {
                        dose.nome_dose = (idx + 1) + 'ª dose';
                    }
                });
            }
        }
    }
}
</script>
@endpush
@endsection
