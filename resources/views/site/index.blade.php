@extends('site.layouts.app')

@section('title', 'MultiImune | Clínica de Vacinação em Artur Nogueira')

@section('content')
    <section class="relative pt-10 pb-24" id="inicio">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
                <div class="space-y-8">
                    <span class="inline-flex items-center gap-2 bg-white/70 backdrop-blur px-4 py-2 rounded-full text-sm font-semibold text-emerald-600 shadow-sm border border-white/80">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Vacinação de excelência
                    </span>
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Sua saúde e proteção em primeiro lugar, com conforto e segurança.
                        </h1>
                        <p class="mt-5 text-lg text-slate-600 leading-relaxed">
                            Na MultiImune, oferecemos atendimento clínico e domiciliar com vacinas importadas e nacionais. Equipe especializada, ambiente acolhedor e todo o cuidado que você e sua família merecem.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#contato" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-500 to-sky-500 text-white font-semibold px-7 py-3 rounded-xl shadow-lg hover:shadow-xl transition-transform hover:-translate-y-0.5">
                            Agendar atendimento
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H7"></path>
                            </svg>
                        </a>
                        <a href="#vacinas" class="inline-flex items-center justify-center gap-3 px-7 py-3 rounded-xl border border-emerald-200 bg-white/80 backdrop-blur font-semibold text-emerald-600 hover:text-emerald-700 hover:border-emerald-300 transition">
                            Ver vacinas disponíveis
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-4">
                        <div class="bg-white/70 backdrop-blur rounded-2xl border border-white/60 p-5 shadow-sm">
                            <p class="text-3xl font-extrabold text-emerald-600">15+</p>
                            <p class="text-sm text-slate-500 mt-1">Anos de experiência em imunização e saúde preventiva.</p>
                        </div>
                        <div class="bg-white/70 backdrop-blur rounded-2xl border border-white/60 p-5 shadow-sm">
                            <p class="text-3xl font-extrabold text-emerald-600">98%</p>
                            <p class="text-sm text-slate-500 mt-1">Dos pacientes recomendam nossos serviços.</p>
                        </div>
                        <div class="bg-white/70 backdrop-blur rounded-2xl border border-white/60 p-5 shadow-sm">
                            <p class="text-3xl font-extrabold text-emerald-600">24/7</p>
                            <p class="text-sm text-slate-500 mt-1">Atendimento domiciliar disponível todos os dias.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 -translate-x-6 -translate-y-6 bg-gradient-to-br from-emerald-500/20 to-sky-500/30 rounded-3xl blur-3xl"></div>
                    <div class="relative bg-white/90 backdrop-blur border border-white/70 rounded-3xl shadow-2xl overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <p class="text-sm font-semibold text-slate-500">Vacinas disponíveis</p>
                            </div>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">Catálogo MultiImune</span>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 gap-3">
                                <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">HPV Quadrivalente / 9-valente</p>
                                            <p class="text-xs text-slate-600 mt-1">Importada e nacional</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 bg-white px-2 py-1 rounded-full">Disponível</span>
                                    </div>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">Meningocócica ACWY + B</p>
                                            <p class="text-xs text-slate-600 mt-1">Importada</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Disponível</span>
                                    </div>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">Influenza Tetravalente</p>
                                            <p class="text-xs text-slate-600 mt-1">Nacional e importada</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Disponível</span>
                                    </div>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">Hepatites A e B</p>
                                            <p class="text-xs text-slate-600 mt-1">Dose adulto e pediátrica</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Disponível</span>
                                    </div>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-4">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <p class="font-semibold text-slate-900">Pentavalente e Hexavalente</p>
                                            <p class="text-xs text-slate-600 mt-1">Importada</p>
                                        </div>
                                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Disponível</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-900 text-white rounded-xl p-4">
                                <p class="text-xs font-semibold text-emerald-300 uppercase tracking-widest">E muito mais</p>
                                <p class="mt-2 text-sm text-slate-100">Pneumocócicas, rotavírus, varicela, tríplice viral, febre amarela, dengue, COVID-19 e outros.</p>
                                <a href="#contato" class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-emerald-300 hover:text-emerald-200">
                                    Consultar disponibilidade
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-20" id="vacinas">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-14">
                <div>
                    <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">Vacinas</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900">Catálogo completo para todas as idades</h2>
                    <p class="mt-4 text-lg text-slate-600 max-w-2xl">Trabalhamos com vacinas importadas e nacionais de primeira linha, garantindo eficácia, segurança e conforto para toda a família.</p>
                </div>
                <a href="#contato" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">Consultar disponibilidade
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H7"></path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-lg p-8 space-y-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900">Bebês e crianças</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Proteção completa desde os primeiros dias, com calendário vacinal personalizado e acompanhamento contínuo.</p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Pentavalente / Hexavalente</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Rotavírus (oral)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Pneumocócicas 13 / 15</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Meningocócica ACWY + B</li>
                    </ul>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-lg p-8 space-y-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900">Adolescentes</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Vacinas essenciais para essa fase da vida, com atendimento respeitoso e orientação sobre prevenção.</p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>HPV 4 / HPV 9 (meninos e meninas)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Meningocócica ACWY (reforço)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Tríplice viral / Varicela</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Hepatite A e B</li>
                    </ul>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-lg p-8 space-y-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900">Adultos</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Reforços, atualização de carteira e proteção para viagens internacionais ou situações especiais.</p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Influenza tetravalente</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Dengue (esquema completo)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Febre amarela / Febre tifoide</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>COVID-19 (doses e reforços)</li>
                    </ul>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-lg p-8 space-y-5">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900">Idosos e gestantes</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Cuidado especial para públicos que exigem atenção redobrada e acompanhamento personalizado.</p>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Pneumocócicas 13 / 23</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Herpes-zóster (Shingrix)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>dTpa / dTpa-VIP (gestantes)</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Influenza e COVID-19</li>
                    </ul>
                </article>
            </div>
        </div>
    </section>

    <section class="relative py-20" id="domiciliar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="md:text-center max-w-3xl mx-auto">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/70 backdrop-blur border border-white/70 text-sm font-semibold text-emerald-600">Onde você estiver</span>
                <h2 class="mt-4 text-3xl sm:text-4xl font-extrabold text-slate-900">Atendimento domiciliar com todo o conforto e segurança</h2>
                <p class="mt-4 text-lg text-slate-600">Leve a MultiImune até sua casa ou empresa. Equipe completa, vacinas refrigeradas e protocolo rigoroso de aplicação.</p>
            </div>
            <div class="mt-14 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white/80 backdrop-blur rounded-3xl border border-white/70 shadow-xl p-8 space-y-4">
                    <h3 class="text-xl font-semibold text-slate-900">Agendamento facilitado</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Escolha data, horário e endereço pelo WhatsApp ou telefone. Confirmação imediata com profissional habilitado.</p>
                    <ul class="text-sm text-slate-600 space-y-2">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Flexibilidade de horário.</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Atendimento em Artur Nogueira e região.</li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-emerald-500/90 via-teal-500/90 to-sky-500/90 text-white rounded-3xl shadow-2xl p-8 space-y-4 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml,%3Csvg width=\'28\' height=\'28\' viewBox=\'0 0 28 28\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cpath d=\'M0 0h28v28H0z\'/%3E%3Cpath d=\'M14 9l5 9H9z\' fill=\'%23fff\' fill-opacity=\'.35\'/%3E%3C/g%3E%3C/svg%3E')]"></div>
                    <div class="relative">
                        <h3 class="text-xl font-semibold">Estrutura móvel completa</h3>
                        <p class="text-sm leading-relaxed text-emerald-50">Caixa térmica homologada, materiais descartáveis de primeira linha, ficha clínica digital e cartão de vacinação atualizado.</p>
                        <ul class="mt-4 text-sm text-emerald-50 space-y-2">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>Controle rigoroso de cadeia fria.</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-white/80"></span>Orientação pós-aplicação.</li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white/80 backdrop-blur rounded-3xl border border-white/70 shadow-xl p-8 space-y-4">
                    <h3 class="text-xl font-semibold text-slate-900">Ideal para grupos</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Empresas, escolas, condomínios e eventos corporativos. Atendemos demandas coletivas com agilidade e organização.</p>
                    <ul class="text-sm text-slate-600 space-y-2">
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Campanhas de influenza e COVID.</li>
                        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Planos corporativos personalizados.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-20" id="sobre">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">Nossa história</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900">Compromisso com a saúde da comunidade</h2>
                    <p class="mt-4 text-lg text-slate-600">Desde 2008, a MultiImune atua em Artur Nogueira levando vacinação de qualidade para famílias, empresas e grupos especiais.</p>
                    <ul class="mt-8 space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-semibold">1</span>
                            <div>
                                <p class="font-semibold text-slate-900">Equipe qualificada</p>
                                <p>Enfermeiros e técnicos com formação continuada, treinados nos melhores protocolos de aplicação e biossegurança.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-semibold">2</span>
                            <div>
                                <p class="font-semibold text-slate-900">Ambiente acolhedor</p>
                                <p>Clínica climatizada, sala de espera confortável e atendimento humanizado para crianças, adultos e idosos.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-semibold">3</span>
                            <div>
                                <p class="font-semibold text-slate-900">Certificações e compliance</p>
                                <p>Licenças sanitárias em dia, parceria com laboratórios certificados e rastreabilidade total de lotes.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-2xl p-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-emerald-600">Métricas em destaque</p>
                            <h3 class="text-3xl font-extrabold text-slate-900">Insights que geram ação</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-600">Tempo real</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-emerald-600">Nosso compromisso</p>
                            <h3 class="text-3xl font-extrabold text-slate-900">Saúde com responsabilidade</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-600">Certificada</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-600">
                        <div class="bg-emerald-50/80 rounded-2xl p-5 border border-emerald-100">
                            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest">Experiência</p>
                            <p class="mt-2 text-2xl font-extrabold text-emerald-700">15+</p>
                            <p class="mt-1">Anos de dedicação à imunização em Artur Nogueira e região.</p>
                        </div>
                        <div class="bg-sky-50/80 rounded-2xl p-5 border border-sky-100">
                            <p class="text-xs font-semibold text-sky-600 uppercase tracking-widest">Atendimentos</p>
                            <p class="mt-2 text-2xl font-extrabold text-sky-700">25mil+</p>
                            <p class="mt-1">Pacientes imunizados com segurança e qualidade.</p>
                        </div>
                    </div>
                    <div class="bg-slate-900 text-white rounded-2xl p-6 space-y-4">
                        <p class="text-sm font-semibold text-emerald-300 uppercase tracking-wider">Parceiros de confiança</p>
                        <p class="text-lg leading-relaxed text-slate-100">Trabalhamos com os melhores laboratórios do Brasil: GSK, Sanofi, Pfizer, MSD e Biolab, garantindo qualidade e procedência.</p>
                        <a href="#contato" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-sm font-semibold hover:bg-white/15 transition">
                            Conheça nossa clínica
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative py-20" id="depoimentos">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8 mb-12">
                <div class="max-w-2xl">
                    <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">Depoimentos</span>
                    <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900">O que nossos pacientes dizem</h2>
                </div>
                <div class="flex items-center gap-6 text-sm text-slate-600 bg-white/80 backdrop-blur border border-white/70 rounded-full px-5 py-3 shadow-sm">
                    <div class="flex -space-x-2">
                        <span class="w-10 h-10 rounded-full bg-emerald-200 border border-white"></span>
                        <span class="w-10 h-10 rounded-full bg-sky-200 border border-white"></span>
                        <span class="w-10 h-10 rounded-full bg-purple-200 border border-white"></span>
                    </div>
                    <p><span class="font-semibold text-slate-900">25 mil+</span> pacientes atendidos</p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-xl p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-200"></div>
                        <div>
                            <p class="font-semibold text-slate-900">Mariana S.</p>
                            <p class="text-xs text-slate-500">Mãe de 2 filhos, Artur Nogueira</p>
                        </div>
                    </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        "Ambiente super limpo e acolhedor. As enfermeiras são muito carinhosas com as crianças e sempre explicam tudo antes de aplicar. Recomendo!"
                    </blockquote>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-xl p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-sky-200"></div>
                        <div>
                            <p class="font-semibold text-slate-900">Roberto L.</p>
                            <p class="text-xs text-slate-500">Empresário, Artur Nogueira</p>
                        </div>
                    </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        "Contratei o serviço domiciliar para vacinar toda a família. Pontualidade, profissionalismo e praticidade. Valeu muito a pena!"
                    </blockquote>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-xl p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-purple-200"></div>
                        <div>
                            <p class="font-semibold text-slate-900">Ana Paula C.</p>
                            <p class="text-xs text-slate-500">Pedagoga, Artur Nogueira</p>
                        </div>
                    </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        "Vacinei minha filha recém-nascida na clínica e fui super bem orientada sobre o calendário. Equipe nota 10!"
                    </blockquote>
                </article>
            </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        “Com o MultiImune conseguimos organizar o estoque, reduzir desperdícios e criar campanhas efetivas de reforço. Em seis meses dobramos a receita de domiciliares.”
                    </blockquote>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-xl p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-sky-200"></div>
                        <div>
                            <p class="font-semibold text-slate-900">Eduardo M.</p>
                            <p class="text-xs text-slate-500">CEO, franquia de vacinação</p>
                        </div>
                    </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        “A visão consolidada por unidade e a inteligência comercial nos permitiram padronizar processos e acelerar a expansão com segurança.”
                    </blockquote>
                </article>
                <article class="bg-white/80 backdrop-blur border border-white/70 rounded-3xl shadow-xl p-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-purple-200"></div>
                        <div>
                            <p class="font-semibold text-slate-900">Letícia F.</p>
                            <p class="text-xs text-slate-500">Enfermeira coordenadora</p>
                        </div>
                    </div>
                    <blockquote class="mt-5 text-sm text-slate-600 leading-relaxed">
                        “O fluxo de atendimento ficou muito mais rápido. A equipe técnica ganhou tranquilidade e o paciente percebe uma experiência moderna.”
                    </blockquote>
                </article>
            </div>
        </div>
    </section>

    <section class="relative pb-24" id="faq">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">FAQ</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-extrabold text-slate-900">Perguntas frequentes</h2>
                <p class="mt-4 text-lg text-slate-600">Tire suas dúvidas sobre vacinação, atendimento e segurança.</p>
            </div>
            <div class="mt-12 space-y-5">
                <details class="group bg-white/80 backdrop-blur border border-white/70 rounded-2xl shadow-sm">
                    <summary class="flex items-center justify-between gap-4 px-6 py-4 cursor-pointer">
                        <span class="font-semibold text-slate-900">Preciso agendar ou posso ir sem marcar?</span>
                        <svg class="w-5 h-5 text-emerald-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                        Recomendamos agendar pelo WhatsApp ou telefone para garantir sua vaga, mas também atendemos demandas espontâneas conforme disponibilidade.
                    </div>
                </details>
                <details class="group bg-white/80 backdrop-blur border border-white/70 rounded-2xl shadow-sm">
                    <summary class="flex items-center justify-between gap-4 px-6 py-4 cursor-pointer">
                        <span class="font-semibold text-slate-900">As vacinas são importadas ou nacionais?</span>
                        <svg class="w-5 h-5 text-emerald-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                        Trabalhamos com ambas. Para algumas vacinas, oferecemos opção importada com tecnologia diferenciada e também a versão nacional de alta qualidade.
                    </div>
                </details>
                <details class="group bg-white/80 backdrop-blur border border-white/70 rounded-2xl shadow-sm">
                    <summary class="flex items-center justify-between gap-4 px-6 py-4 cursor-pointer">
                        <span class="font-semibold text-slate-900">O atendimento domiciliar tem custo adicional?</span>
                        <svg class="w-5 h-5 text-emerald-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                        Sim, cobramos uma taxa de deslocamento que varia conforme a localidade. Entre em contato para solicitar orçamento personalizado.
                    </div>
                </details>
            </div>
        </div>
    </section>

    <section class="relative py-24" id="contato">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur border border-white/70 rounded-3xl shadow-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-5">
                    <div class="lg:col-span-3 p-10 space-y-6">
                        <span class="text-sm font-semibold text-emerald-600 uppercase tracking-widest">Pronto para se proteger?</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">Agende seu atendimento agora</h2>
                        <p class="text-lg text-slate-600">Entre em contato pelo WhatsApp ou telefone. Nossa equipe está pronta para tirar suas dúvidas e agendar seu horário com toda praticidade.</p>
                        <ul class="space-y-4 text-sm text-slate-600">
                            <li class="flex items-start gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2"></span>
                                <span>Apresentação guiada por especialistas que vivem o dia a dia de vacinação.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2"></span>
                                <span>Diagnóstico gratuito dos principais gargalos e oportunidades da sua clínica.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2"></span>
                                <span>Plano de implementação com cronograma detalhado e responsáveis definidos.</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:col-span-2 bg-gradient-to-br from-emerald-500 via-teal-500 to-sky-500 text-white p-10 space-y-6">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-widest text-emerald-100">Fale conosco</p>
                            <h3 class="text-2xl font-extrabold">Vamos construir a próxima fase da sua clínica</h3>
                        </div>
                        <form class="space-y-4" data-site-contact>
                            <div>
                                <label for="nome" class="text-xs font-semibold uppercase tracking-widest text-emerald-100">Nome completo</label>
                                <input id="nome" type="text" required class="mt-2 w-full rounded-xl border border-white/30 bg-white/10 px-4 py-2.5 placeholder:text-emerald-100 focus:border-white focus:ring-white">
                            </div>
                            <div>
                                <label for="email" class="text-xs font-semibold uppercase tracking-widest text-emerald-100">E-mail profissional</label>
                                <input id="email" type="email" required class="mt-2 w-full rounded-xl border border-white/30 bg-white/10 px-4 py-2.5 placeholder:text-emerald-100 focus:border-white focus:ring-white">
                            </div>
                            <div>
                                <label for="empresa" class="text-xs font-semibold uppercase tracking-widest text-emerald-100">Clínica ou empresa</label>
                                <input id="empresa" type="text" required class="mt-2 w-full rounded-xl border border-white/30 bg-white/10 px-4 py-2.5 placeholder:text-emerald-100 focus:border-white focus:ring-white">
                            </div>
                            <div>
                                <label for="mensagem" class="text-xs font-semibold uppercase tracking-widest text-emerald-100">Mensagem</label>
                                <textarea id="mensagem" rows="3" class="mt-2 w-full rounded-xl border border-white/30 bg-white/10 px-4 py-2.5 placeholder:text-emerald-100 focus:border-white focus:ring-white" placeholder="Conte-nos sobre seus desafios"></textarea>
                            </div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-white/95 text-emerald-600 font-semibold py-3 hover:bg-white transition">
                                Enviar mensagem
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </button>
                        </form>
                        <p class="text-xs text-emerald-100">Prefer prefer WhatsApp? <a href="https://wa.me/5500000000000" class="underline">Clique para falar agora</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
