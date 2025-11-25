@extends('layouts.tenant-app')

@section('title', 'Agenda - ' . (tenant('clinic_name') ?? 'MultiImune'))
@section('page-title', 'Agenda')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<style>
.agenda-hero {
    position: relative;
    overflow: hidden;
    border-radius: 1.75rem;
    background: linear-gradient(115deg, #4338ca 0%, #6366f1 45%, #ec4899 100%);
    color: #fff;
    box-shadow: 0 40px 90px rgba(79, 70, 229, 0.32);
}

.agenda-hero__glow {
    position: absolute;
    width: 22rem;
    height: 22rem;
    border-radius: 999px;
    filter: blur(130px);
    opacity: 0.6;
    pointer-events: none;
}

.agenda-hero__glow--left {
    top: -6rem;
    left: -8rem;
    background: rgba(255, 255, 255, 0.55);
}

.agenda-hero__glow--right {
    bottom: -7rem;
    right: -6rem;
    background: rgba(236, 72, 153, 0.55);
}

.agenda-stat-card {
    position: relative;
    overflow: hidden;
    padding: 1.35rem 1.5rem;
    border-radius: 1.25rem;
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(10px);
    box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.agenda-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 24px 55px rgba(15, 23, 42, 0.24);
}

.agenda-stat-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.35), transparent);
    opacity: 0;
    transition: opacity 0.25s ease;
}

.agenda-stat-card:hover::before {
    opacity: 1;
}

.agenda-stat-card__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.9rem;
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.28);
}

.agenda-filters {
    position: relative;
    padding: 1.75rem;
    border-radius: 1.75rem;
    background: rgba(255, 255, 255, 0.88);
    border: 1px solid rgba(129, 140, 248, 0.18);
    box-shadow: 0 35px 90px rgba(15, 23, 42, 0.12);
    backdrop-filter: blur(12px);
}

.agenda-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.agenda-legend__label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #6366f1;
}

.agenda-legend__item {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 0.9rem;
    border-radius: 999px;
    background: rgba(79, 70, 229, 0.08);
    border: 1px solid rgba(129, 140, 248, 0.18);
    backdrop-filter: blur(6px);
}

.agenda-legend__swatch {
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 9999px;
    border: 1px solid rgba(15, 23, 42, 0.1);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.45);
}

.agenda-nav {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}

.agenda-nav__button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.55rem 1.2rem;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
    color: #4338ca;
    border: 1px solid rgba(99, 102, 241, 0.18);
    background: linear-gradient(135deg, rgba(224, 231, 255, 0.9), rgba(233, 213, 255, 0.9));
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 14px 24px rgba(129, 140, 248, 0.18);
}

.agenda-nav__button:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 32px rgba(99, 102, 241, 0.22);
}

.agenda-nav__button--light {
    background: rgba(255, 255, 255, 0.85);
}

.agenda-nav__button--disabled,
.agenda-nav__button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

.view-toggle {
    display: inline-flex;
    gap: 0.45rem;
    padding: 0.4rem;
    border-radius: 999px;
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(129, 140, 248, 0.2);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4);
}

.view-toggle__button {
    padding: 0.45rem 1.4rem;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4338ca;
    background: rgba(255, 255, 255, 0.65);
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.view-toggle__button:hover {
    background: rgba(255, 255, 255, 0.85);
}

.view-toggle__button--active {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    box-shadow: 0 16px 28px rgba(79, 70, 229, 0.25);
}

.agenda-calendar-wrapper {
    position: relative;
    background: linear-gradient(135deg, rgba(129, 140, 248, 0.25), rgba(236, 72, 153, 0.25));
    border-radius: 1.75rem;
    padding: 1px;
}

.agenda-calendar-wrapper::before {
    content: '';
    position: absolute;
    inset: 12px;
    border-radius: 1.5rem;
    pointer-events: none;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.12), rgba(236, 72, 153, 0.12));
    opacity: 0.5;
}

.agenda-calendar {
    position: relative;
    z-index: 1;
    background: #fff;
    border-radius: 1.55rem;
    padding: 2.25rem;
    box-shadow: 0 40px 80px rgba(79, 70, 229, 0.16);
    border: 1px solid rgba(129, 140, 248, 0.12);
}

.fc .fc-toolbar.fc-header-toolbar {
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(139, 92, 246, 0.08));
    border: 1px solid rgba(129, 140, 248, 0.15);
}

.fc .fc-toolbar-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #1f2937;
    text-transform: capitalize;
}

.fc .fc-button {
    border-radius: 0.5rem;
    border: none;
    font-weight: 600;
    padding: 0.4rem 1rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
}

.fc .fc-button:hover,
.fc .fc-button:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.fc .fc-button-primary:disabled {
    background: rgba(129, 140, 248, 0.2);
    color: rgba(15, 23, 42, 0.4);
    box-shadow: none;
}

.fc-theme-standard td,
.fc-theme-standard th {
    border-color: rgba(148, 163, 184, 0.32);
}

.fc .fc-daygrid-day-number {
    font-weight: 600;
    color: #0f172a;
}

.fc .fc-daygrid-day.fc-day-today {
    background: linear-gradient(180deg, rgba(129, 140, 248, 0.12), rgba(167, 139, 250, 0.18));
    box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.24);
}

.fc .fc-daygrid-day:hover {
    background: rgba(129, 140, 248, 0.1);
}

.fc .fc-scrollgrid {
    border: 1px solid rgba(229, 231, 235, 1);
    border-radius: 0.75rem;
    overflow: hidden;
}

.fc .fc-daygrid-event {
    margin: 0.25rem 0.3rem;
    border-radius: 0.5rem;
    padding: 0.4rem 0.6rem;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    cursor: pointer;
}

.fc .fc-daygrid-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    z-index: 10;
}

/* Estilização customizada dos eventos */
.fc-event-main-frame {
    border-radius: 0.375rem;
    transition: all 0.2s ease;
}

.fc-event-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.125rem;
}

.fc-event-title {
    font-weight: 600;
    color: inherit;
    line-height: 1.2;
}

.fc-event-paciente {
    font-size: 0.7rem;
    margin-top: 0.125rem;
    font-style: italic;
}

/* Melhorar visualização do link "+X mais" */
.fc .fc-daygrid-more-link {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white !important;
    border-radius: 0.375rem;
    padding: 0.25rem 0.5rem;
    font-weight: 600;
    font-size: 0.75rem;
    margin: 0.25rem 0.3rem;
    text-align: center;
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.3);
    transition: all 0.2s ease;
}

.fc .fc-daygrid-more-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(99, 102, 241, 0.4);
}

.agenda-event {
    position: relative;
    backdrop-filter: blur(6px);
    color: #0f172a;
}

.agenda-event__body {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.agenda-event__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}

.agenda-event__time {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(15, 23, 42, 0.7);
}

.agenda-event__title {
    font-weight: 700;
    color: #0f172a;
    font-size: 0.88rem;
}

.agenda-event__meta,
.agenda-event__location {
    font-size: 0.78rem;
    color: rgba(30, 41, 59, 0.78);
}

.agenda-event__badge {
    padding: 0.2rem 0.65rem;
    border-radius: 999px;
    font-size: 0.7rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    font-weight: 700;
}

.agenda-event__badge--agendado {
    background: rgba(59, 130, 246, 0.18);
    color: #1d4ed8;
}

.agenda-event__badge--confirmado {
    background: rgba(34, 197, 94, 0.18);
    color: #15803d;
}

.agenda-event__badge--realizado {
    background: rgba(14, 165, 233, 0.2);
    color: #0369a1;
}

.agenda-event__badge--cancelado {
    background: rgba(239, 68, 68, 0.18);
    color: #b91c1c;
}

.agenda-event.agenda-event--agendado {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.18), rgba(147, 197, 253, 0.28)) !important;
    border-color: rgba(59, 130, 246, 0.28) !important;
}

.agenda-event.agenda-event--confirmado {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.16), rgba(74, 222, 128, 0.24)) !important;
    border-color: rgba(16, 185, 129, 0.3) !important;
}

.agenda-event.agenda-event--realizado {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.14), rgba(14, 165, 233, 0.24)) !important;
    border-color: rgba(14, 165, 233, 0.28) !important;
}

.agenda-event.agenda-event--cancelado {
    background: linear-gradient(135deg, rgba(248, 113, 113, 0.16), rgba(239, 68, 68, 0.24)) !important;
    border-color: rgba(239, 68, 68, 0.32) !important;
}

.fc .fc-daygrid-day-top {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem;
}

.fc .fc-daygrid-day-events {
    margin: 0;
}

.fc .fc-list-table {
    border-radius: 1rem;
    overflow: hidden;
    border-color: rgba(148, 163, 184, 0.25);
}

.fc .fc-list-event {
    border-left: 4px solid transparent;
    padding: 1rem 1.25rem;
}

.fc .fc-list-event:hover {
    background: rgba(129, 140, 248, 0.08);
}

.fc .fc-list-day-cushion,
.fc .fc-list-table td,
.fc .fc-list-table th {
    border-color: rgba(148, 163, 184, 0.2);
}

.ts-wrapper.ts-single .ts-control {
    border: 2px solid #D1D5DB;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    min-height: 3rem;
    box-shadow: none;
    transition: all 0.2s ease;
    background-color: #fff;
}

.ts-wrapper.ts-single.focus .ts-control,
.ts-wrapper.ts-single.dropdown-active .ts-control {
    border-color: #A855F7;
    box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.12);
}

.ts-wrapper .ts-control .item {
    color: #4B5563;
    font-weight: 600;
}

.ts-wrapper .ts-control .ts-placeholder {
    color: #9CA3AF;
    font-weight: 500;
}

.ts-dropdown {
    border: 2px solid #A855F7;
    border-radius: 0.75rem;
    box-shadow: 0 18px 35px rgba(79, 70, 229, 0.15);
    padding: 0.5rem 0;
}

.ts-dropdown .option {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    color: #4B5563;
}

.ts-dropdown .option.active {
    background-color: #A855F7;
    color: #fff;
}

/* Responsividade do FullCalendar */
@media (max-width: 640px) {
    .fc .fc-toolbar {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .fc .fc-toolbar-title {
        font-size: 1.25rem !important;
        margin-top: 0.5rem;
    }
    
    .fc .fc-button {
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
    }
    
    .fc .fc-daygrid-event {
        margin: 0.15rem 0.2rem;
        padding: 0.25rem 0.35rem;
        font-size: 0.75rem;
    }
    
    .fc .fc-col-header-cell-cushion {
        padding: 0.25rem;
        font-size: 0.75rem;
    }
    
    .fc .fc-daygrid-day-number {
        font-size: 0.8rem;
        padding: 0.25rem;
    }
    
    .agenda-event__time {
        font-size: 0.65rem;
    }
    
    .agenda-event__title {
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .fc .fc-toolbar-title {
        font-size: 1rem !important;
    }
    
    .fc .fc-col-header-cell-cushion {
        font-size: 0.7rem;
    }
    
    .fc .fc-daygrid-day-number {
        font-size: 0.75rem;
    }
}
</style>
@endpush

@section('content')
@php
    $statsData = [
        [
            'label' => 'Agendamentos ativos',
            'value' => $stats['total'] ?? 0,
            'description' => 'Total cadastrados no sistema',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75v2.25m10.5-2.25v2.25M4.5 9.75h15M5.25 5.25h13.5A1.5 1.5 0 0120.25 6.75v12a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-12a1.5 1.5 0 011.5-1.5z"/></svg>',
        ],
        [
            'label' => 'Hoje',
            'value' => $stats['hoje'] ?? 0,
            'description' => 'Compromissos para hoje',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a8.25 8.25 0 110 16.5 8.25 8.25 0 010-16.5z"/></svg>',
        ],
        [
            'label' => 'Próximos 7 dias',
            'value' => $stats['proximos7dias'] ?? 0,
            'description' => 'Agenda da semana',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m0 13.5V21m8.25-9H21m-18 0H3m13.364-6.364l-1.591 1.59m-7.546 7.546l-1.59 1.591m0-10.727l1.59 1.591m7.546 7.546l1.591 1.59M12 8.25l1.458 2.708 2.992.435-2.225 2.168.525 2.978L12 14.708l-2.75 1.431.525-2.978-2.225-2.168 2.992-.435z"/></svg>',
        ],
        [
            'label' => 'Confirmados',
            'value' => $stats['confirmados'] ?? 0,
            'description' => 'Pacientes confirmados',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4.5-4.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>',
        ],
    ];
    $canceladosTotal = $stats['cancelados'] ?? 0;
@endphp

<!-- Header compacto -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Agenda de Atendimentos</h1>
                <p class="text-sm text-gray-600 mt-0.5">Gerencie seus compromissos e agendamentos</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="openModalNovoAgendamento()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-200 hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Novo
            </button>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-5 py-2.5 rounded-lg shadow-md transition duration-200 border border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Cards de estatísticas -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach($statsData as $index => $card)
        @php
            $gradients = [
                'from-blue-50 to-blue-100',
                'from-green-50 to-green-100', 
                'from-amber-50 to-amber-100',
                'from-purple-50 to-purple-100'
            ];
            $iconColors = [
                'text-blue-600',
                'text-green-600',
                'text-amber-600', 
                'text-purple-600'
            ];
        @endphp
        <div class="bg-gradient-to-br {{ $gradients[$index] }} rounded-xl p-5 border border-gray-200">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="{{ $iconColors[$index] }}">
                            {!! $card['icon'] !!}
                        </div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-600">{{ $card['label'] }}</p>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($card['value'], 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">{{ $card['description'] }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Controles e legenda -->
<div class="bg-white shadow-lg rounded-xl p-4 sm:p-5 mb-4 sm:mb-6 border border-gray-100">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <!-- Legenda -->
        <div class="flex flex-wrap items-center gap-2 sm:gap-3 lg:gap-4">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 w-full sm:w-auto mb-1 sm:mb-0">Legenda:</span>
            @foreach($cores as $tipo => $cor)
                <span class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full bg-gray-50 border border-gray-200">
                    <span class="agenda-legend__swatch" data-color="{{ $cor }}"></span>
                    <span class="text-xs sm:text-sm font-semibold capitalize text-gray-700">{{ ucfirst($tipo) }}</span>
                </span>
            @endforeach
        </div>

        <!-- Navegação e visualização -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <!-- Botões de navegação -->
            <div class="inline-flex items-center justify-center gap-1 sm:gap-2 bg-gray-50 rounded-lg sm:rounded-xl p-1 border border-gray-200" id="calendarNav">
                <button type="button" class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition shadow-sm" data-calendar-nav="prev" aria-label="Anterior">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button type="button" class="inline-flex items-center gap-1 sm:gap-1.5 px-2 sm:px-3 h-8 sm:h-9 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 font-semibold text-xs sm:text-sm transition shadow-sm" data-calendar-nav="today">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Hoje
                </button>
                <button type="button" class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition shadow-sm" data-calendar-nav="next" aria-label="Próximo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <!-- Toggle de visualização -->
            <div class="inline-flex items-center justify-center gap-0.5 sm:gap-1 bg-gray-50 rounded-lg sm:rounded-xl p-1 border border-gray-200" id="calendarViewToggle">
                <button type="button" data-view="dayGridMonth" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold transition bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-md">
                    Mês
                </button>
                <button type="button" data-view="timeGridWeek" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold text-gray-600 hover:bg-white hover:text-gray-900 transition">
                    Semana
                </button>
                <button type="button" data-view="timeGridDay" class="flex-1 sm:flex-initial px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold text-gray-600 hover:bg-white hover:text-gray-900 transition">
                    Dia
                </button>
                <button type="button" data-view="listWeek" class="flex-1 sm:flex-initial px-2 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold text-gray-600 hover:bg-white hover:text-gray-900 transition">
                    Lista
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Calendário -->
<div class="bg-white shadow-lg rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 border border-gray-100">
    <div id="calendar"></div>
</div>
</div>

<!-- Modal de Agendamento -->
<div id="modalAgendamento" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-xl sm:rounded-2xl shadow-2xl max-w-2xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
        <!-- Header do Modal -->
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-4 sm:p-6 rounded-t-xl sm:rounded-t-2xl sticky top-0 z-10">
            <div class="flex justify-between items-center">
                <h2 id="modalTitulo" class="text-lg sm:text-2xl font-bold text-white">Novo Agendamento</h2>
                <button onclick="closeModal()" class="text-white hover:text-gray-200 transition p-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Corpo do Modal -->
        <form id="formAgendamento" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <input type="hidden" id="agendamento_id" name="id">

            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-bold text-gray-700 mb-2">Título *</label>
                <input type="text" id="titulo" name="titulo" required
                       placeholder="Ex: Atendimento - João Silva"
                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
            </div>

            <!-- Paciente -->
            <div>
                <label for="paciente_id" class="block text-sm font-bold text-gray-700 mb-2">Paciente</label>
                <select id="paciente_id" name="paciente_id"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base"
                        data-placeholder="Pesquisar paciente...">
                    <option value="">Selecione um paciente (opcional)</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }} - CPF: {{ $paciente->cpf }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Data e Hora de Início -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label for="data_inicio" class="block text-sm font-bold text-gray-700 mb-2">Data/Hora Início *</label>
                    <input type="datetime-local" id="data_inicio" name="data_inicio" required
                           class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
                </div>
                <div>
                    <label for="data_fim" class="block text-sm font-bold text-gray-700 mb-2">Data/Hora Fim *</label>
                    <input type="datetime-local" id="data_fim" name="data_fim" required
                           class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
                </div>
            </div>

            <!-- Tipo e Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label for="tipo" class="block text-sm font-bold text-gray-700 mb-2">Tipo *</label>
                    <select id="tipo" name="tipo" required onchange="atualizarCorPorTipo()"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
                        <option value="atendimento">Atendimento</option>
                        <option value="consulta">Consulta</option>
                        <option value="lembrete">Lembrete</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select id="status" name="status"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
                        <option value="agendado">Agendado</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="realizado">Realizado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
            </div>

            <!-- Local -->
            <div>
                <label for="local" class="block text-sm font-bold text-gray-700 mb-2">Local</label>
                <input type="text" id="local" name="local"
                       placeholder="Ex: Clínica, Domicílio, etc"
                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base">
            </div>

            <!-- Cor -->
            <div>
                <label for="cor" class="block text-sm font-bold text-gray-700 mb-2">Cor</label>
                <input type="color" id="cor" name="cor" value="#3B82F6"
                       class="w-full h-10 sm:h-12 px-2 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition">
            </div>

            <!-- Descrição -->
            <div>
                <label for="descricao" class="block text-sm font-bold text-gray-700 mb-2">Descrição</label>
                <textarea id="descricao" name="descricao" rows="3"
                          placeholder="Detalhes do agendamento"
                          class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base"></textarea>
            </div>

            <!-- Observações -->
            <div>
                <label for="observacoes" class="block text-sm font-bold text-gray-700 mb-2">Observações</label>
                <textarea id="observacoes" name="observacoes" rows="2"
                          placeholder="Observações adicionais"
                          class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg sm:rounded-xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 transition text-sm sm:text-base"></textarea>
            </div>

            <!-- Dia Inteiro -->
            <div class="flex items-center gap-2 sm:gap-3">
                <input type="checkbox" id="dia_inteiro" name="dia_inteiro" value="1"
                       class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600 rounded focus:ring-purple-500">
                <label for="dia_inteiro" class="text-sm font-semibold text-gray-700">Evento de dia inteiro</label>
            </div>

            <!-- Botões -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 transform hover:scale-105 text-sm sm:text-base">
                    💾 Salvar Agendamento
                </button>
                <button type="button" id="btnExcluir" onclick="excluirAgendamento()" 
                        class="hidden bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 text-sm sm:text-base">
                    🗑️ Excluir
                </button>
                <button type="button" onclick="closeModal()" 
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-xl shadow-lg transition duration-300 text-sm sm:text-base">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script type="application/json" id="agenda-config">
{!! json_encode([
    'cores' => $cores,
    'routes' => [
        'eventos' => route('agenda.eventos'),
        'store' => route('agenda.store'),
        'buscar' => url('/agenda'),
        'atualizar' => url('/agenda'),
        'excluir' => url('/agenda'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script>
const agendaConfigScript = document.getElementById('agenda-config');
if (agendaConfigScript) {
    window.agendaConfig = JSON.parse(agendaConfigScript.textContent);
    agendaConfigScript.remove();
}

function applyLegendSwatchColors() {
    document.querySelectorAll('.agenda-legend__swatch').forEach((el) => {
        const color = el.getAttribute('data-color');
        if (!color) {
            return;
        }
        el.style.backgroundColor = color;
    });
}

function initViewToggle() {
    const toggle = document.getElementById('calendarViewToggle');
    if (!toggle) {
        return;
    }

    function syncView(viewType) {
        toggle.querySelectorAll('[data-view]').forEach((btn) => {
            const isActive = btn.getAttribute('data-view') === viewType;
            
            if (isActive) {
                btn.classList.add('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'text-white', 'shadow-md');
                btn.classList.remove('text-gray-600', 'hover:bg-white', 'hover:text-gray-900');
            } else {
                btn.classList.remove('bg-gradient-to-r', 'from-indigo-500', 'to-purple-600', 'text-white', 'shadow-md');
                btn.classList.add('text-gray-600', 'hover:bg-white', 'hover:text-gray-900');
            }
        });
    }

    window.addEventListener('agenda:view-changed', (event) => {
        syncView(event.detail);
    });

    toggle.querySelectorAll('[data-view]').forEach((button) => {
        button.addEventListener('click', () => {
            const view = button.getAttribute('data-view');
            if (!view || typeof window.calendar?.changeView !== 'function') {
                return;
            }

            window.calendar.changeView(view);
            syncView(view);
        });
    });
}

function updateTodayButtonState(dateLike = null) {
    const button = document.querySelector('[data-calendar-nav="today"]');

    if (!button) {
        return;
    }

    let referenceDate = null;

    if (dateLike) {
        referenceDate = new Date(dateLike);
    } else if (window.calendar?.getDate) {
        referenceDate = window.calendar.getDate();
    }

    if (!(referenceDate instanceof Date) || Number.isNaN(referenceDate.getTime())) {
        button.disabled = false;
        button.classList.remove('opacity-50', 'cursor-not-allowed');
        return;
    }

    const today = new Date();
    const isSameDay =
        referenceDate.getFullYear() === today.getFullYear() &&
        referenceDate.getMonth() === today.getMonth() &&
        referenceDate.getDate() === today.getDate();

    button.disabled = isSameDay;
    if (isSameDay) {
        button.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        button.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function initCalendarNav() {
    const nav = document.getElementById('calendarNav');

    if (!nav) {
        return;
    }

    nav.querySelectorAll('[data-calendar-nav]').forEach((button) => {
        button.addEventListener('click', () => {
            if (!window.calendar) {
                return;
            }

            const action = button.getAttribute('data-calendar-nav');

            if (action === 'prev') {
                window.calendar.prev();
            } else if (action === 'next') {
                window.calendar.next();
            } else if (action === 'today') {
                window.calendar.today();
            }
        });
    });

    updateTodayButtonState();
}

window.addEventListener('agenda:date-changed', (event) => {
    updateTodayButtonState(event.detail?.currentDate || null);
});

// Aguardar o script do módulo carregar primeiro
document.addEventListener('DOMContentLoaded', () => {
    applyLegendSwatchColors();
    initViewToggle();
    initCalendarNav();
});
</script>

{{-- FullCalendar via CDN para evitar problemas de MIME type --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/pt-br.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<script>
// Adapter do código agenda.js para funcionar com FullCalendar global
(function() {
    const agendaConfig = window.agendaConfig || { cores: {}, routes: {} };
    const cores = agendaConfig.cores || {};
    const routes = agendaConfig.routes || {};
    
    let calendar = null;
    let pacienteTomSelect = null;

    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-emerald-500' : type === 'error' ? 'bg-rose-500' : 'bg-blue-500'} text-white`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function initCalendar() {
        console.log('🔍 Procurando elemento #calendar');
        const calendarEl = document.getElementById('calendar');
        
        if (!calendarEl) {
            console.error('❌ Elemento #calendar não encontrado!');
            return;
        }
        
        console.log('✅ Elemento #calendar encontrado, inicializando FullCalendar...');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            initialView: 'dayGridMonth',
            headerToolbar: false,
            height: 'auto',
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: 3,
            weekends: true,
            events: routes.eventos || '/agenda/eventos',
            eventDisplay: 'block',
            displayEventTime: true,
            displayEventEnd: false,
            
            // Customizar aparência do evento
            eventContent: function(arg) {
                const event = arg.event;
                const time = arg.timeText;
                const title = event.title || 'Sem título';
                const tipo = event.extendedProps?.tipo || 'outros';
                const paciente = event.extendedProps?.paciente_nome || '';
                const status = event.extendedProps?.status || 'agendado';
                
                // Ícones por tipo
                const icons = {
                    'atendimento': '🩺',
                    'consulta': '📋',
                    'vacina': '💉',
                    'retorno': '🔄',
                    'exame': '🔬',
                    'outros': '📅'
                };
                
                // Classes de status
                const statusClasses = {
                    'agendado': 'opacity-100',
                    'confirmado': 'opacity-100 ring-2 ring-green-400',
                    'realizado': 'opacity-60',
                    'cancelado': 'opacity-40 line-through'
                };
                
                const icon = icons[tipo] || icons.outros;
                const statusClass = statusClasses[status] || statusClasses.agendado;
                
                return {
                    html: `
                        <div class="fc-event-main-frame ${statusClass}" style="padding: 2px 4px;">
                            <div class="fc-event-time font-semibold text-xs">${icon} ${time}</div>
                            <div class="fc-event-title text-xs font-medium truncate">${title}</div>
                            ${paciente ? `<div class="fc-event-paciente text-xs opacity-80 truncate">${paciente}</div>` : ''}
                        </div>
                    `
                };
            },
            
            // Limitar altura dos eventos
            eventMaxStack: 3,
            
            select: function(info) {
                console.log('📅 Dia selecionado:', info.startStr);
                window.openModalNovoAgendamento(info.startStr);
                calendar.unselect();
            },
            
            eventClick: function(info) {
                if (typeof window.editarAgendamento === 'function') {
                    window.editarAgendamento(info.event.id);
                }
            },
            
            eventDrop: function(info) {
                fetch(`${routes.atualizar || '/agenda'}/${info.event.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        data: info.event.startStr.split('T')[0],
                        hora: info.event.startStr.split('T')[1]?.substring(0, 5)
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast('Agendamento atualizado!', 'success');
                    } else {
                        info.revert();
                        showToast(data.message || 'Erro ao atualizar', 'error');
                    }
                })
                .catch(() => {
                    info.revert();
                    showToast('Erro ao atualizar agendamento', 'error');
                });
            }
        });
        
        calendar.render();
        window.calendar = calendar;
        console.log('✅ FullCalendar renderizado!');
    }

    function initPacienteSelect() {
        const selectEl = document.getElementById('paciente_id');
        if (!selectEl) return;
        
        // Usar pacientes já carregados no select
        pacienteTomSelect = new TomSelect(selectEl, {
            create: false,
            maxItems: 1,
            placeholder: 'Selecione um paciente...',
            searchField: ['text'],
            render: {
                option: function(item, escape) {
                    return `<div><strong>${escape(item.text)}</strong></div>`;
                },
                item: function(item, escape) {
                    return `<div>${escape(item.text)}</div>`;
                }
            }
        });
    }

    // Funções globais que o template precisa
    window.openModalNovoAgendamento = function(data = null) {
        const modal = document.getElementById('modalAgendamento');
        const form = document.getElementById('formAgendamento');
        const titulo = document.getElementById('modalTitulo');
        const btnExcluir = document.getElementById('btnExcluir');
        
        if (form) form.reset();
        if (pacienteTomSelect) pacienteTomSelect.clear();
        
        // Limpar ID para modo criação
        const idInput = document.getElementById('agendamento_id');
        if (idInput) idInput.value = '';
        
        if (titulo) titulo.textContent = 'Novo Agendamento';
        if (btnExcluir) btnExcluir.classList.add('hidden');
        
        if (data) {
            // data vem no formato YYYY-MM-DD, precisa adicionar hora padrão
            const dataInicio = document.getElementById('data_inicio');
            const dataFim = document.getElementById('data_fim');
            
            if (dataInicio) {
                dataInicio.value = `${data}T08:00`;
            }
            if (dataFim) {
                dataFim.value = `${data}T09:00`;
            }
        }
        
        if (modal) {
            modal.classList.remove('hidden');
            const tituloInput = document.getElementById('titulo');
            if (tituloInput) tituloInput.focus();
        }
        
        console.log('✅ Modal aberto, data:', data);
    };

    window.closeModal = function() {
        const modal = document.getElementById('modalAgendamento');
        if (modal) modal.classList.add('hidden');
    };

    window.editarAgendamento = function(id) {
        console.log('🔍 Buscando agendamento ID:', id);
        console.log('🔗 Route buscar:', routes.buscar);
        
        if (!id) {
            console.error('❌ ID não fornecido');
            return;
        }
        
        if (!routes.buscar) {
            console.error('❌ Route "buscar" não configurada');
            showToast('Rota de busca não configurada', 'error');
            return;
        }
        
        const url = `${routes.buscar}/${id}`;
        console.log('📡 Fazendo requisição para:', url);
        
        fetch(url)
            .then(r => {
                console.log('📥 Resposta recebida:', r.status);
                return r.json();
            })
            .then(data => {
                console.log('📦 Dados recebidos:', data);
                
                if (data.success && data.agendamento) {
                    const ag = data.agendamento;
                    console.log('✅ Agendamento encontrado:', ag);
                    
                    const modal = document.getElementById('modalAgendamento');
                    const titulo = document.getElementById('modalTitulo');
                    const btnExcluir = document.getElementById('btnExcluir');
                    
                    if (titulo) titulo.textContent = 'Editar Agendamento';
                    if (btnExcluir) btnExcluir.classList.remove('hidden');
                    
                    // Preencher campos (formato já vem correto: YYYY-MM-DDTHH:mm)
                    const campos = {
                        'agendamento_id': ag.id,
                        'titulo': ag.titulo || '',
                        'paciente_id': ag.paciente_id || '',
                        'data_inicio': ag.data_inicio || '',
                        'data_fim': ag.data_fim || '',
                        'tipo': ag.tipo || 'atendimento',
                        'status': ag.status || 'agendado',
                        'local': ag.local || '',
                        'cor': ag.cor || '#3B82F6',
                        'descricao': ag.descricao || '',
                        'observacoes': ag.observacoes || '',
                        'dia_inteiro': ag.dia_inteiro || false
                    };
                    
                    Object.keys(campos).forEach(campo => {
                        const el = document.getElementById(campo);
                        if (el) {
                            if (el.type === 'checkbox') {
                                el.checked = campos[campo] ? true : false;
                            } else {
                                el.value = campos[campo];
                            }
                            console.log(`✅ Campo ${campo} preenchido:`, campos[campo]);
                        } else {
                            console.warn(`⚠️ Campo ${campo} não encontrado no DOM`);
                        }
                    });
                    
                    // Atualizar TomSelect se existir
                    if (pacienteTomSelect && ag.paciente_id) {
                        pacienteTomSelect.setValue(ag.paciente_id);
                    }
                    
                    if (modal) {
                        modal.classList.remove('hidden');
                        console.log('✅ Modal aberto');
                    } else {
                        console.error('❌ Modal não encontrado');
                    }
                } else {
                    console.error('❌ Resposta inválida:', data);
                    showToast(data.message || 'Agendamento não encontrado', 'error');
                }
            })
            .catch(err => {
                console.error('❌ Erro na requisição:', err);
                showToast('Erro ao buscar agendamento', 'error');
            });
    };

    window.excluirAgendamento = function() {
        const idInput = document.getElementById('agendamento_id');
        const id = idInput?.value;
        
        if (!id) {
            showToast('ID do agendamento não encontrado', 'error');
            return;
        }
        
        if (!routes.excluir) {
            showToast('Rota de exclusão não configurada', 'error');
            return;
        }
        
        if (!confirm('Tem certeza que deseja excluir este agendamento?')) return;
        
        fetch(`${routes.excluir}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Agendamento excluído!', 'success');
                if (calendar) calendar.refetchEvents();
                window.closeModal();
            } else {
                showToast(data.message || 'Erro ao excluir', 'error');
            }
        })
        .catch(() => showToast('Erro ao excluir agendamento', 'error'));
    };

    window.atualizarCorPorTipo = function() {
        const tipoSelect = document.getElementById('tipo');
        const corInput = document.getElementById('cor');
        
        if (tipoSelect && corInput && cores[tipoSelect.value]) {
            corInput.value = cores[tipoSelect.value];
        }
    };

    // Submissão dos formulários
    function initForms() {
        const form = document.getElementById('formAgendamento');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const idInput = document.getElementById('agendamento_id');
                const id = idInput?.value;
                const formData = new FormData(this);
                
                // Se tem ID, é atualização; senão, é criação
                const url = id ? `${routes.atualizar || '/agenda'}/${id}` : (routes.store || '/agenda');
                const method = 'POST';
                
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showToast(id ? 'Agendamento atualizado!' : 'Agendamento criado!', 'success');
                        if (calendar) calendar.refetchEvents();
                        window.closeModal();
                        form.reset();
                    } else {
                        showToast(data.message || 'Erro ao salvar agendamento', 'error');
                    }
                })
                .catch(() => showToast('Erro ao salvar agendamento', 'error'));
            });
        }
    }

    function init() {
        console.log('🚀 Iniciando agenda via CDN...');
        initCalendar();
        initPacienteSelect();
        initForms();
        console.log('✅ Agenda inicializada!');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endpush
@endsection
