import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import listPlugin from '@fullcalendar/list';
import ptBrLocale from '@fullcalendar/core/locales/pt-br';

const agendaConfig = window.agendaConfig || { cores: {}, routes: {} };
const cores = agendaConfig.cores || {};
const routes = agendaConfig.routes || {};

const state = {
    calendar: null,
    pacienteTomSelect: null,
};

const TOAST_STYLES = {
    success: { classes: 'bg-emerald-500 text-white', icon: '✅' },
    error: { classes: 'bg-rose-500 text-white', icon: '⚠️' },
    info: { classes: 'bg-blue-500 text-white', icon: 'ℹ️' },
    warning: { classes: 'bg-amber-500 text-white', icon: '⚠️' },
};

const EVENT_STATUS_CONFIG = {
    agendado: {
        badgeClass: 'agenda-event__badge agenda-event__badge--agendado',
        eventClass: 'agenda-event--agendado',
    },
    confirmado: {
        badgeClass: 'agenda-event__badge agenda-event__badge--confirmado',
        eventClass: 'agenda-event--confirmado',
    },
    realizado: {
        badgeClass: 'agenda-event__badge agenda-event__badge--realizado',
        eventClass: 'agenda-event--realizado',
    },
    cancelado: {
        badgeClass: 'agenda-event__badge agenda-event__badge--cancelado',
        eventClass: 'agenda-event--cancelado',
    },
};

const EVENT_TYPE_ICONS = {
    atendimento: '🩺',
    consulta: '📋',
    lembrete: '⏰',
    outros: '⭐',
};

function showToast(message, type = 'info') {
    if (!message) {
        return;
    }

    let container = document.getElementById('toast-container');

    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-6 right-6 z-50 flex flex-col gap-3';
        document.body.appendChild(container);
    }

    const style = TOAST_STYLES[type] || TOAST_STYLES.info;

    const toast = document.createElement('div');
    toast.className = `flex items-center gap-3 rounded-2xl px-4 py-3 shadow-xl transform transition-all duration-300 opacity-0 translate-y-2 ${style.classes}`;
    toast.innerHTML = `
        <span class="text-lg">${style.icon}</span>
        <span class="text-sm font-medium leading-snug">${message}</span>
    `;

    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', 'translate-y-2');
    });

    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
    }, 3200);

    setTimeout(() => {
        toast.remove();
        if (!container.childElementCount) {
            container.remove();
        }
    }, 3600);
}

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content;
}

function getEventStatusConfig(status) {
    return EVENT_STATUS_CONFIG[status] || EVENT_STATUS_CONFIG.agendado;
}

function createStatusBadge(status, label) {
    if (!status && !label) {
        return null;
    }

    const badge = document.createElement('span');
    const { badgeClass } = getEventStatusConfig(status);
    badge.className = badgeClass;
    badge.textContent = label || status;

    return badge;
}

function renderAgendaEventContent(info) {
    const viewType = info.view?.type || '';
    const isListView = viewType.startsWith('list');

    const container = document.createElement('div');
    container.className = `agenda-event__body${isListView ? ' agenda-event__body--list' : ''}`;

    const header = document.createElement('div');
    header.className = 'agenda-event__header';

    const time = document.createElement('span');
    time.className = `agenda-event__time${isListView ? ' agenda-event__time--list' : ''}`;
    time.textContent = info.timeText || 'Dia inteiro';
    header.appendChild(time);

    const statusBadge = createStatusBadge(
        info.event.extendedProps.status,
        info.event.extendedProps.status_label
    );

    if (statusBadge) {
        if (isListView) {
            statusBadge.classList.add('agenda-event__badge--list');
        }
        header.appendChild(statusBadge);
    }

    container.appendChild(header);

    const title = document.createElement('div');
    title.className = `agenda-event__title${isListView ? ' agenda-event__title--list' : ''}`;

    const icon = EVENT_TYPE_ICONS[info.event.extendedProps.tipo] || '📆';
    title.textContent = `${icon} ${info.event.title}`;
    container.appendChild(title);

    if (info.event.extendedProps.paciente) {
        const meta = document.createElement('div');
        meta.className = `agenda-event__meta${isListView ? ' agenda-event__meta--list' : ''}`;
        meta.textContent = info.event.extendedProps.paciente;
        container.appendChild(meta);
    }

    if (info.event.extendedProps.local) {
        const location = document.createElement('div');
        location.className = `agenda-event__location${isListView ? ' agenda-event__location--list' : ''}`;
        location.textContent = info.event.extendedProps.local;
        container.appendChild(location);
    }

    return { domNodes: [container] };
}

function getEventClassNames(event, viewType = '') {
    const statusConfig = getEventStatusConfig(event.extendedProps.status);
    const classNames = ['agenda-event'];

    if (statusConfig?.eventClass) {
        classNames.push(statusConfig.eventClass);
    }

    if (event.allDay) {
        classNames.push('agenda-event--dia-inteiro');
    }

    if (event.extendedProps.tipo) {
        classNames.push(`agenda-event--tipo-${event.extendedProps.tipo}`);
    }

    if (viewType.startsWith('list')) {
        classNames.push('agenda-event--list');
    }

    return classNames;
}

function formatDateToOffsetISOString(date) {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
        return null;
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    const offsetMinutes = -date.getTimezoneOffset();
    const offsetSign = offsetMinutes >= 0 ? '+' : '-';
    const absoluteOffset = Math.abs(offsetMinutes);
    const offsetHours = String(Math.floor(absoluteOffset / 60)).padStart(2, '0');
    const offsetMins = String(absoluteOffset % 60).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}:${seconds}${offsetSign}${offsetHours}:${offsetMins}`;
}

function convertDatetimeLocalToIso(value) {
    if (!value) {
        return null;
    }

    const parsed = new Date(value);

    if (Number.isNaN(parsed.getTime())) {
        return null;
    }

    return formatDateToOffsetISOString(parsed);
}

async function parseJsonResponse(response) {
    if (response.status === 204 || response.status === 205) {
        return {};
    }

    if (response.status === 419) {
        throw new Error('Sua sessão expirou. Recarregue a página e tente novamente.');
    }

    const contentType = response.headers.get('Content-Type') || '';

    if (contentType.includes('application/json')) {
        return response.json();
    }

    const text = await response.text();
    const sanitized = text.replace(/<[^>]*>/g, '').trim();

    throw new Error(sanitized || `Resposta inesperada do servidor (HTTP ${response.status}).`);
}

function formatDateTimeForInput(dateLike) {
    const date = new Date(dateLike);

    if (Number.isNaN(date.getTime())) {
        return '';
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function initializePacienteSelect() {
    const selectElement = document.getElementById('paciente_id');

    if (!selectElement) {
        return;
    }

    state.pacienteTomSelect = new TomSelect(selectElement, {
        placeholder: selectElement.dataset.placeholder || 'Pesquisar paciente...',
        allowEmptyOption: true,
        closeAfterSelect: true,
        maxOptions: 1000,
        render: {
            option: (data, escape) => `<div class="text-sm text-gray-800">${escape(data.text)}</div>`,
            item: (data, escape) => `<div class="text-sm font-semibold text-gray-800">${escape(data.text)}</div>`,
        },
    });
}

function setPacienteSelectValue(value) {
    const normalizedValue = value ? String(value) : '';
    const selectElement = document.getElementById('paciente_id');

    if (state.pacienteTomSelect) {
        if (normalizedValue) {
            state.pacienteTomSelect.setValue(normalizedValue, true);
        } else {
            state.pacienteTomSelect.clear(true);
        }
    } else if (selectElement) {
        selectElement.value = normalizedValue;
    }
}

function getPacienteSelecionado() {
    if (state.pacienteTomSelect) {
        const value = state.pacienteTomSelect.getValue();
        return value ? value : null;
    }

    const selectElement = document.getElementById('paciente_id');
    return selectElement?.value ? selectElement.value : null;
}

function openModalNovoAgendamento(start = null, end = null) {
    const modal = document.getElementById('modalAgendamento');
    const form = document.getElementById('formAgendamento');
    const btnExcluir = document.getElementById('btnExcluir');
    const modalTitulo = document.getElementById('modalTitulo');

    if (!modal || !form || !btnExcluir) {
        return;
    }

    form.reset();
    setPacienteSelectValue(null);
    atualizarCorPorTipo();

    if (start) {
        const dataInicio = form.querySelector('#data_inicio');
        const dataFim = form.querySelector('#data_fim');
        const endDate = end || new Date(new Date(start).getTime() + 60 * 60 * 1000);

        if (dataInicio) {
            dataInicio.value = formatDateTimeForInput(start);
        }

        if (dataFim) {
            dataFim.value = formatDateTimeForInput(endDate);
        }
    }

    if (modalTitulo) {
        modalTitulo.textContent = 'Novo Agendamento';
    }

    const fieldId = form.querySelector('#agendamento_id');
    if (fieldId) {
        fieldId.value = '';
    }

    btnExcluir.classList.add('hidden');

    modal.classList.remove('hidden');
}

function editarAgendamento(event) {
    const modal = document.getElementById('modalAgendamento');
    const form = document.getElementById('formAgendamento');
    const btnExcluir = document.getElementById('btnExcluir');
    const modalTitulo = document.getElementById('modalTitulo');

    if (!modal || !form || !btnExcluir) {
        return;
    }

    form.reset();

    if (modalTitulo) {
        modalTitulo.textContent = 'Editar Agendamento';
    }

    const fieldId = form.querySelector('#agendamento_id');
    if (fieldId) {
        fieldId.value = event.id;
    }

    const titulo = form.querySelector('#titulo');
    const dataInicio = form.querySelector('#data_inicio');
    const dataFim = form.querySelector('#data_fim');
    const tipo = form.querySelector('#tipo');
    const status = form.querySelector('#status');
    const local = form.querySelector('#local');
    const cor = form.querySelector('#cor');
    const descricao = form.querySelector('#descricao');
    const observacoes = form.querySelector('#observacoes');
    const diaInteiro = form.querySelector('#dia_inteiro');

    if (titulo) titulo.value = event.title || '';

    const dataInicioFormatada = event.extendedProps.data_inicio_input || formatDateTimeForInput(event.start);
    const dataFimFormatada = event.extendedProps.data_fim_input || formatDateTimeForInput(event.end || event.start);

    if (dataInicio) dataInicio.value = dataInicioFormatada;
    if (dataFim) dataFim.value = dataFimFormatada;
    if (tipo) tipo.value = event.extendedProps.tipo || 'atendimento';
    if (status) status.value = event.extendedProps.status || 'agendado';
    if (local) local.value = event.extendedProps.local || '';
    if (cor) cor.value = event.backgroundColor || '#3B82F6';
    if (descricao) descricao.value = event.extendedProps.descricao || '';
    if (observacoes) observacoes.value = event.extendedProps.observacoes || '';
    if (diaInteiro) diaInteiro.checked = Boolean(event.allDay);

    setPacienteSelectValue(event.extendedProps.paciente_id);

    btnExcluir.classList.remove('hidden');
    modal.classList.remove('hidden');
}

function closeModal() {
    const modal = document.getElementById('modalAgendamento');
    const form = document.getElementById('formAgendamento');
    const btnExcluir = document.getElementById('btnExcluir');
    const modalTitulo = document.getElementById('modalTitulo');

    if (!modal || !form) {
        return;
    }

    form.reset();
    setPacienteSelectValue(null);
    const fieldId = form.querySelector('#agendamento_id');
    if (fieldId) {
        fieldId.value = '';
    }
    if (btnExcluir) {
        btnExcluir.classList.add('hidden');
    }
    if (modalTitulo) {
        modalTitulo.textContent = 'Novo Agendamento';
    }
    modal.classList.add('hidden');
}

function atualizarCorPorTipo() {
    const campoCor = document.getElementById('cor');
    const campoTipo = document.getElementById('tipo');

    if (!campoCor || !campoTipo) {
        return;
    }

    const tipo = campoTipo.value;
    campoCor.value = cores[tipo] || '#3B82F6';
}

async function atualizarDatasAgendamento(event) {
    const csrfToken = getCsrfToken();

    if (!csrfToken) {
        showToast('Token CSRF não encontrado. Recarregue a página.', 'error');
        return;
    }

    try {
        const response = await fetch(`/agenda/${event.id}/datas`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                data_inicio: event.start ? formatDateToOffsetISOString(event.start) : null,
                data_fim: event.end
                    ? formatDateToOffsetISOString(event.end)
                    : (event.start ? formatDateToOffsetISOString(event.start) : null),
                dia_inteiro: event.allDay,
                _token: csrfToken,
            }),
        });

        const data = await parseJsonResponse(response);

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao atualizar datas do agendamento.');
        }

        showToast(data.message || 'Agendamento atualizado com sucesso!', 'success');
    } catch (error) {
        console.error(error);
        showToast(error.message || 'Erro ao atualizar datas do agendamento.', 'error');
        state.calendar?.refetchEvents();
    }
}

async function excluirAgendamento() {
    const agendamentoId = document.getElementById('agendamento_id')?.value;

    if (!agendamentoId) {
        showToast('Identificador do agendamento não encontrado.', 'error');
        return;
    }

    if (!confirm('Tem certeza que deseja excluir este agendamento?')) {
        return;
    }

    const csrfToken = getCsrfToken();

    if (!csrfToken) {
        showToast('Token CSRF não encontrado. Recarregue a página.', 'error');
        return;
    }

    try {
        const response = await fetch(`/agenda/${agendamentoId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                _token: csrfToken,
            }),
        });

        const data = await parseJsonResponse(response);

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao excluir agendamento.');
        }

        closeModal();
        state.calendar?.refetchEvents();
        showToast(data.message || 'Agendamento excluído com sucesso!', 'success');
    } catch (error) {
        console.error(error);
        showToast(error.message || 'Erro ao excluir agendamento.', 'error');
    }
}

async function salvarAgendamento(event) {
    event.preventDefault();

    const form = event.currentTarget;
    const agendamentoField = form.querySelector('#agendamento_id');
    const agendamentoId = agendamentoField ? agendamentoField.value : '';
    const csrfToken = getCsrfToken();

    if (!csrfToken) {
        showToast('Token CSRF não encontrado. Recarregue a página.', 'error');
        return;
    }

    const url = agendamentoId ? `/agenda/${agendamentoId}` : (routes.store || '/agenda');
    const method = agendamentoId ? 'PUT' : 'POST';

    const formData = {
        titulo: form.querySelector('#titulo')?.value,
        descricao: form.querySelector('#descricao')?.value,
        data_inicio: form.querySelector('#data_inicio')?.value,
        data_fim: form.querySelector('#data_fim')?.value,
        tipo: form.querySelector('#tipo')?.value,
        status: form.querySelector('#status')?.value,
        paciente_id: getPacienteSelecionado(),
        local: form.querySelector('#local')?.value,
        cor: form.querySelector('#cor')?.value,
        observacoes: form.querySelector('#observacoes')?.value,
        dia_inteiro: Boolean(form.querySelector('#dia_inteiro')?.checked),
        _token: csrfToken,
    };

    const payload = {
        ...formData,
        data_inicio: convertDatetimeLocalToIso(formData.data_inicio),
        data_fim: convertDatetimeLocalToIso(formData.data_fim),
    };

    if (!payload.data_inicio || !payload.data_fim) {
        showToast('Preencha data e hora válidas para o agendamento.', 'error');
        return;
    }

    try {
        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken,
            },
            credentials: 'same-origin',
            body: JSON.stringify(payload),
        });

        const data = await parseJsonResponse(response);

        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao salvar agendamento.');
        }

        closeModal();
        state.calendar?.refetchEvents();
        showToast(data.message || 'Agendamento salvo com sucesso!', 'success');
    } catch (error) {
        console.error(error);
        showToast(error.message || 'Erro ao salvar agendamento.', 'error');
    }
}

function initCalendar() {
    const calendarEl = document.getElementById('calendar');

    console.log('🔍 Procurando elemento #calendar:', calendarEl);

    if (!calendarEl) {
        console.error('❌ Elemento #calendar não encontrado!');
        return;
    }

    console.log('✅ Elemento #calendar encontrado, inicializando FullCalendar...');

    state.calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, listPlugin],
        initialView: 'dayGridMonth',
        locale: ptBrLocale,
        headerToolbar: {
            left: '',
            center: 'title',
            right: '',
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia',
            list: 'Lista',
        },
        editable: true,
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        dayMaxEventRows: 3,
        nowIndicator: true,
        weekends: true,
        height: 'auto',
        slotDuration: '00:30:00',
        slotMinTime: '07:00:00',
        slotMaxTime: '21:00:00',
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        },
        displayEventTime: true,
        eventDisplay: 'block',
        eventContent: renderAgendaEventContent,
        eventClassNames(info) {
            return getEventClassNames(info.event, info.view?.type || '');
        },
        events: routes.eventos || '/agenda/eventos',
        select(info) {
            openModalNovoAgendamento(info.start, info.end);
        },
        eventClick(info) {
            editarAgendamento(info.event);
        },
        eventDrop(info) {
            atualizarDatasAgendamento(info.event);
        },
        eventResize(info) {
            atualizarDatasAgendamento(info.event);
        },
        datesSet(info) {
            const currentDate = state.calendar?.getDate ? state.calendar.getDate() : (info?.view?.currentStart || null);

            window.dispatchEvent(new CustomEvent('agenda:view-changed', {
                detail: info?.view?.type || 'dayGridMonth',
            }));

            window.dispatchEvent(new CustomEvent('agenda:date-changed', {
                detail: {
                    currentDate,
                },
            }));
        },
    });

    state.calendar.render();
    window.dispatchEvent(new CustomEvent('agenda:date-changed', {
        detail: {
            currentDate: state.calendar.getDate(),
        },
    }));
    window.calendar = state.calendar;
}

function initForm() {
    const form = document.getElementById('formAgendamento');

    if (!form) {
        return;
    }

    form.addEventListener('submit', salvarAgendamento);
}

function init() {
    console.log('🚀 Iniciando módulo agenda.js...');
    console.log('📅 FullCalendar carregado:', typeof Calendar !== 'undefined');
    console.log('⚙️ Config da agenda:', window.agendaConfig);
    
    initializePacienteSelect();
    initCalendar();
    initForm();
    
    console.log('✅ Módulo agenda.js inicializado');
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

window.openModalNovoAgendamento = openModalNovoAgendamento;
window.editarAgendamento = editarAgendamento;
window.closeModal = closeModal;
window.atualizarCorPorTipo = atualizarCorPorTipo;
window.excluirAgendamento = excluirAgendamento;
