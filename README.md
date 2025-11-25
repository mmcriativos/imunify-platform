# MultiImune - Sistema de Gerenciamento de Vacinação

Sistema completo para gerenciamento de atendimentos de vacinação, desenvolvido com Laravel 12 e Tailwind CSS.

## 🏥 Sobre o Sistema

O MultiImune foi desenvolvido para gerenciar atendimentos de vacinação tanto na clínica (Artur Nogueira, SP) quanto em atendimentos domiciliares nas cidades próximas.

### Funcionalidades

- ✅ **Dashboard** com estatísticas mensais
- ✅ **Cadastro de Pacientes** com dados completos
- ✅ **Cadastro de Vacinas** com valores e validade
- ✅ **Cadastro de Cidades** atendidas
- ✅ **Registro de Atendimentos** (Clínica e Domiciliar)
- ✅ **Múltiplas vacinas por atendimento** com controle de lote e validade
- ✅ **Relatórios mensais** e por cidade
- ✅ **Interface moderna** com Tailwind CSS

## 🚀 Como Usar

### 1. Compilar os assets (necessário antes de iniciar):
```bash
npm run dev
```

### 2. Em outro terminal, iniciar o servidor:
```bash
php artisan serve
```

### 3. Acessar o sistema:
- URL: http://localhost:8000
- O sistema já está com dados de teste (9 cidades e 10 vacinas)

## 📊 Dados Pré-carregados

### Cidades (9)
Artur Nogueira, Engenheiro Coelho, Conchal, Cosmópolis, Mogi Mirim, Mogi Guaçu, Limeira, Americana, Campinas

### Vacinas (10)
- Influenza (Gripe) - R$ 80,00
- COVID-19 - R$ 120,00
- Hepatite B - R$ 150,00
- Febre Amarela - R$ 100,00
- Tríplice Viral - R$ 180,00
- E mais 5 vacinas...

## 🎯 Fluxo de Trabalho

### Registrar um Atendimento
1. Acesse **Atendimentos** → **Novo Atendimento**
2. Selecione a data e o paciente
3. Escolha o tipo: **Clínica** ou **Domiciliar**
4. Adicione as vacinas aplicadas (pode adicionar múltiplas)
5. O sistema calcula automaticamente o valor total
6. Clique em **Registrar Atendimento**

---

Desenvolvido com ❤️ para MultiImune - Artur Nogueira, SP

## Laravel Documentation

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) available.

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
