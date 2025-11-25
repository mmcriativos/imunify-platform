<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MultiImune - Clínica de Vacinação em Artur Nogueira. Atendimento clínico e domiciliar com vacinas importadas e nacionais.">
    <title>@yield('title', 'MultiImune | Clínica de Vacinação - Artur Nogueira')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/site.js'])
    @stack('styles')
</head>
<body class="font-sans text-slate-900 bg-slate-50 antialiased">
    <div class="relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -left-36 -top-32 w-80 h-80 bg-emerald-200/60 blur-3xl rounded-full"></div>
            <div class="absolute right-0 top-16 w-96 h-96 bg-sky-200/70 blur-3xl rounded-full"></div>
            <div class="absolute -right-24 bottom-0 w-72 h-72 bg-purple-200/60 blur-3xl rounded-full"></div>
        </div>

        <header class="relative z-10" id="topo">
            <nav class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex items-center justify-between">
                <a href="#topo" class="flex items-center gap-3">
                    <img src="https://multiimune.com.br/images/logo.png" alt="MultiImune" class="h-12 w-auto" loading="lazy">
                    <div class="hidden sm:block">
                        <p class="text-lg font-extrabold text-emerald-600 tracking-tight">MultiImune</p>
                        <p class="text-xs text-slate-600">Clínica de Vacinação</p>
                    </div>
                </a>
                <div class="hidden lg:flex items-center gap-10 text-sm font-semibold text-slate-700">
                    <a href="#vacinas" class="hover:text-emerald-600 transition-colors">Vacinas</a>
                    <a href="#domiciliar" class="hover:text-emerald-600 transition-colors">Atendimento Domiciliar</a>
                    <a href="#sobre" class="hover:text-emerald-600 transition-colors">Sobre</a>
                    <a href="#depoimentos" class="hover:text-emerald-600 transition-colors">Depoimentos</a>
                    <a href="#contato" class="hover:text-emerald-600 transition-colors">Contato</a>
                </div>
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-emerald-600 transition-colors">Área restrita</a>
                    <a href="#contato" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-sky-500 text-white font-semibold px-5 py-2.5 rounded-full shadow-lg hover:shadow-xl transition-transform hover:-translate-y-0.5">Agendar atendimento</a>
                </div>
                <button class="lg:hidden inline-flex items-center justify-center w-11 h-11 rounded-full bg-white/80 backdrop-blur shadow-md border border-white/60" data-site-menu-trigger aria-label="Abrir menu">
                    <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </nav>
            <div class="lg:hidden" data-site-menu-panel>
                <div class="mx-6 rounded-2xl bg-white/90 backdrop-blur border border-white/60 shadow-xl p-6 space-y-4 text-sm font-semibold">
                    <a href="#vacinas" class="block text-slate-700 hover:text-emerald-600 transition-colors">Vacinas</a>
                    <a href="#domiciliar" class="block text-slate-700 hover:text-emerald-600 transition-colors">Atendimento Domiciliar</a>
                    <a href="#sobre" class="block text-slate-700 hover:text-emerald-600 transition-colors">Sobre</a>
                    <a href="#depoimentos" class="block text-slate-700 hover:text-emerald-600 transition-colors">Depoimentos</a>
                    <a href="#contato" class="block text-slate-700 hover:text-emerald-600 transition-colors">Contato</a>
                    <hr class="border-slate-200">
                    <a href="{{ route('login') }}" class="block text-slate-700 hover:text-emerald-600 transition-colors">Área restrita</a>
                    <a href="#contato" class="block text-center bg-gradient-to-r from-emerald-500 to-sky-500 text-white font-semibold px-5 py-3 rounded-xl shadow-lg">Agendar atendimento</a>
                </div>
            </div>
        </header>

        <main class="relative z-10">
            @yield('content')
        </main>

        <footer class="relative z-10 border-t border-slate-200/70 bg-white/90 backdrop-blur mt-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-4 gap-10 text-sm text-slate-600">
                <div>
                    <img src="https://multiimune.com.br/images/logo.png" alt="MultiImune" class="h-12 w-auto mb-4" loading="lazy">
                    <p class="leading-relaxed">Clínica de vacinação de excelência em Artur Nogueira. Atendimento clínico e domiciliar com vacinas importadas e nacionais, priorizando segurança, conforto e cuidado em cada aplicação.</p>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-slate-900 mb-3">Navegue</h4>
                    <ul class="space-y-2">
                        <li><a href="#vacinas" class="hover:text-emerald-600 transition-colors">Vacinas</a></li>
                        <li><a href="#domiciliar" class="hover:text-emerald-600 transition-colors">Atendimento Domiciliar</a></li>
                        <li><a href="#sobre" class="hover:text-emerald-600 transition-colors">Sobre</a></li>
                        <li><a href="#contato" class="hover:text-emerald-600 transition-colors">Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-slate-900 mb-3">Contato</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Artur Nogueira, São Paulo - Brasil</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:contato@multiimune.com.br" class="hover:text-emerald-600 transition-colors">contato@multiimune.com.br</a>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>(19) 0000-0000</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-base font-semibold text-slate-900 mb-3">Receba novidades</h4>
                    <p class="text-sm text-slate-600 mb-4">Inscreva-se para receber conteúdos sobre saúde, campanhas de vacinação e ofertas exclusivas.</p>
                    <form class="space-y-3" data-site-newsletter>
                        <input type="email" required placeholder="Seu e-mail" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500">
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 rounded-xl transition-colors">Quero receber</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-slate-200/60 py-6">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-slate-500">
                    <p>© {{ date('Y') }} MultiImune. Todos os direitos reservados.</p>
                    <div class="flex items-center gap-4">
                        <a href="#topo" class="hover:text-emerald-600 transition-colors">Voltar ao topo</a>
                        <a href="{{ route('login') }}" class="hover:text-emerald-600 transition-colors">Área restrita</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
