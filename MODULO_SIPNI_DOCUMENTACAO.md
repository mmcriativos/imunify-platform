# 🏥 MÓDULO SIPNI - Integração Automática com SI-PNI Web

## 📋 Sumário
- [Visão Geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Configuração](#configuração)
- [Como Usar](#como-usar)
- [Campos Obrigatórios](#campos-obrigatórios)
- [Modelo de Negócio](#modelo-de-negócio)
- [Troubleshooting](#troubleshooting)

---

## 🎯 Visão Geral

O **Módulo SIPNI** automatiza completamente a exportação de dados de vacinação para o **e-SUS VE / RNDS** (Rede Nacional de Dados em Saúde), sucessor do SI-PNI Web legado, eliminando a digitação manual e economizando horas de trabalho das enfermeiras.

**Nota Importante:** Desde 2019, o Ministério da Saúde substituiu o SI-PNI Web legado por sistemas modernos integrados via e-SUS VE e RNDS.

### ✨ Benefícios
- ✅ **Automação 100%**: Ao registrar uma vacina no sistema, ela é automaticamente exportada para o SIPNI
- ✅ **Zero Digitação Manual**: Não é mais necessário digitar cada aplicação no SIPNI-Web
- ✅ **Conformidade Legal**: Atende às exigências do Ministério da Saúde
- ✅ **Rastreabilidade Completa**: Histórico de todas as exportações com protocolo SIPNI
- ✅ **Reenvio Automático**: Tentativas automáticas em caso de falha

---

## 🔧 Funcionalidades

### 1. Exportação Automática
Quando uma vacina é aplicada e registrada no sistema, o módulo:
1. Valida os dados obrigatórios
2. Formata no padrão SIPNI
3. Envia automaticamente para a API
4. Registra o protocolo de confirmação
5. Tenta reenviar automaticamente em caso de erro

### 2. Dashboard de Monitoramento
- Visualize todas as exportações (enviadas, pendentes, com erro)
- Filtre por período, status, paciente
- Veja detalhes completos de cada exportação
- Reenvie manualmente exportações com erro

### 3. Configuração Flexível
- Configure credenciais do SIPNI
- Ative/desative o módulo quando necessário
- Teste a conexão antes de ativar
- Ambientes de homologação e produção

---

## ⚙️ Configuração

### Passo 1: Executar Migrations

```bash
# Rodar migrations dos campos SIPNI
php artisan migrate

# Se for multi-tenant:
php artisan tenants:migrate
```

### Passo 2: Obter Credenciais do DataSUS

**ANTES de configurar o sistema**, você precisa:

1. **Acessar o Portal de Serviços do DataSUS**: https://servicos-datasus.saude.gov.br/
2. **Solicitar Acesso**: Pedir permissão para consumir API do e-SUS VE ou RNDS
3. **Aguardar Aprovação**: A equipe do DataSUS avaliará sua solicitação
4. **Ambiente de Homologação**: Você receberá credenciais de teste
5. **Validar Integração**: Testar a integração no ambiente de homologação
6. **Acesso à Produção**: Após validação, receberá credenciais de produção

### Passo 3: Configurar CNES e Credenciais no Sistema

Acesse: **Dashboard → SIPNI → Configurações**

Preencha:
1. **CNES**: Cadastro Nacional de Estabelecimentos de Saúde
2. **Ambiente**: Homologação (testes) ou Produção
3. **URL da API**: URL fornecida pelo DataSUS (e-SUS VE ou RNDS)
4. **Usuário**: Credencial fornecida pelo DataSUS
5. **Senha**: Senha fornecida pelo DataSUS

### Passo 4: Configurar Dados Complementares

#### 3.1 Código SIPNI das Vacinas
Em **Vacinas → Editar**, adicione:
- `codigo_sipni`: Código oficial da vacina no sistema SIPNI
- `estrategia_vacinacao`: Rotina, Campanha, Especial, etc.

#### 3.2 CNS dos Profissionais
Em **Usuários → Editar**, adicione:
- `cpf`: CPF do profissional
- `cns`: Cartão Nacional de Saúde
- `conselho_classe`: COREN, CRM, etc.
- `numero_conselho`: Número de registro

#### 3.3 Dados dos Pacientes
No cadastro de pacientes, certifique-se de preencher:
- `cpf` ou `cns` (obrigatório)
- `data_nascimento` (obrigatório)
- `nome_mae` (obrigatório para SIPNI)
- `sexo` (obrigatório)

### Passo 5: Testar Conexão

Clique em **"Testar Conexão"** na página de configurações para validar as credenciais.

### Passo 6: Ativar Módulo

Após configurar tudo, clique em **"Ativar Módulo"**. A partir desse momento, todas as vacinações serão exportadas automaticamente.

---

## 📝 Como Usar

### Exportação Automática

1. **Registre a vacinação normalmente** em Atendimentos
2. Preencha: paciente, vacina, lote, data
3. Salve o atendimento
4. ✅ **Pronto!** O sistema exporta automaticamente para o SIPNI

### Acompanhamento

Acesse **Dashboard → SIPNI → Dashboard** para:
- Ver todas as exportações
- Verificar status (enviado, pendente, erro)
- Ver número de protocolo SIPNI
- Reenviar exportações com erro

### Reenvio Manual

Se uma exportação falhar:
1. Acesse o dashboard SIPNI
2. Localize a exportação com erro
3. Clique em "Reenviar"
4. Ou use "Reprocessar Erros" para reenviar todas de uma vez

---

## 📋 Campos Obrigatórios SIPNI

### Paciente
| Campo | Descrição |
|-------|-----------|
| CPF ou CNS | Identificação nacional |
| Nome Completo | Nome do paciente |
| Data de Nascimento | DD/MM/AAAA |
| Nome da Mãe | Nome completo da mãe |
| Sexo | M ou F |

### Vacinação
| Campo | Descrição |
|-------|-----------|
| Código SIPNI | Código oficial da vacina |
| Lote | Número do lote |
| Data de Aplicação | DD/MM/AAAA |
| Fabricante | Laboratório fabricante |

### Estabelecimento
| Campo | Descrição |
|-------|-----------|
| CNES | Cadastro do estabelecimento |

### Profissional
| Campo | Descrição |
|-------|-----------|
| CNS | Cartão Nacional de Saúde |
| Nome | Nome do profissional |

---

## 💰 Modelo de Negócio

### Precificação Sugerida

**Módulo SIPNI Premium**: R$ 397,00/mês

### O que está incluído:
- ✅ Exportação automática ilimitada
- ✅ Dashboard de monitoramento
- ✅ Reenvio automático de erros
- ✅ Suporte técnico prioritário
- ✅ Atualizações de conformidade
- ✅ Backup de todas as exportações
- ✅ Relatórios de auditoria

### Comparação com Concorrente

| Recurso | Concorrente | Imunify SIPNI |
|---------|-------------|---------------|
| Exportação Automática | ✅ | ✅ |
| Dashboard Completo | ❌ | ✅ |
| Reenvio de Erros | ❌ | ✅ |
| Histórico Completo | ❌ | ✅ |
| Multi-tenant | ❌ | ✅ |
| Preço/mês | R$ 497,00 | R$ 397,00 |

### Ativação do Módulo

```php
// Criar módulo SIPNI para um tenant
$module = TenantModule::create([
    'tenant_id' => 'clinica123',
    'module_name' => 'sipni_integration',
    'monthly_fee' => 397.00,
    'active' => true,
    'expires_at' => now()->addMonth(),
]);
```

---

## 🛠️ Troubleshooting

### Erro: "Módulo SIPNI não está ativo"
**Solução**: Ative o módulo em Configurações SIPNI

### Erro: "Paciente sem CPF ou CNS"
**Solução**: Adicione CPF ou CNS no cadastro do paciente

### Erro: "Vacina sem código SIPNI"
**Solução**: Configure o código SIPNI da vacina em Vacinas → Editar

### Erro: "Profissional sem CNS"
**Solução**: Adicione o CNS do profissional em Usuários → Editar

### Erro: "Estabelecimento sem CNES"
**Solução**: Configure o CNES em Configurações SIPNI

### Erro: "Falha na conexão com SIPNI"
**Solução**: 
1. Verifique se a URL da API está correta
2. Teste a conexão em Configurações
3. Verifique se as credenciais estão válidas

### Exportação Pendente há muito tempo
**Solução**: 
1. Verifique o dashboard SIPNI
2. Veja a mensagem de erro
3. Use "Reenviar" para tentar novamente

---

## 📊 Estrutura do Banco de Dados

### Tabelas Criadas

#### `sipni_exports`
Registra todas as exportações para o SIPNI
- `atendimento_id`: ID do atendimento
- `atendimento_vacina_id`: ID da aplicação específica
- `paciente_id`: ID do paciente
- `vacina_id`: ID da vacina
- `usuario_id`: ID do profissional
- `status`: pendente, processando, enviado, erro, rejeitado
- `protocolo_sipni`: Número do protocolo retornado pelo SIPNI
- `payload`: JSON enviado
- `erro_mensagem`: Detalhes do erro
- `tentativas`: Número de tentativas

#### `tenant_modules`
Controla módulos premium por tenant
- `tenant_id`: ID do tenant/clínica
- `module_name`: Nome do módulo (sipni_integration)
- `active`: Se está ativo
- `monthly_fee`: Valor mensal
- `expires_at`: Data de expiração

### Campos Adicionados

**Tabela `vacinas`:**
- `codigo_sipni`: Código da vacina no SIPNI
- `estrategia_vacinacao`: Tipo de estratégia

**Tabela `users`:**
- `cpf`: CPF do profissional
- `cns`: Cartão Nacional de Saúde
- `conselho_classe`: COREN, CRM, etc.
- `numero_conselho`: Número do registro

**Tabela `pacientes`:**
- `cns`: Cartão Nacional de Saúde
- `nome_mae`: Nome da mãe (obrigatório SIPNI)
- `sexo`: M ou F

**Tabela `tenants`:**
- `cnes`: CNES do estabelecimento
- `sipni_config`: Configurações JSON

---

## 🔐 Segurança

### Dados Criptografados
- Senha do SIPNI é armazenada criptografada
- Certificados digitais em storage seguro
- Logs auditáveis de todas as exportações

### Conformidade
- ✅ LGPD compliant
- ✅ Sigilo médico respeitado
- ✅ Rastreabilidade total
- ✅ Backup automático

---

## 📞 Suporte

Em caso de dúvidas sobre o módulo SIPNI:
1. Consulte esta documentação
2. Veja a Central de Ajuda no sistema
3. Entre em contato com o suporte técnico

---

## 🚀 Próximos Passos

Após configurar o módulo:
1. [ ] Configurar códigos SIPNI de todas as vacinas
2. [ ] Adicionar CNS de todos os profissionais
3. [ ] Validar dados de pacientes existentes
4. [ ] Fazer testes em ambiente de homologação
5. [ ] Ativar em produção
6. [ ] Monitorar dashboard regularmente

---

**Desenvolvido por**: Imunify Team  
**Versão**: 1.0  
**Última Atualização**: Novembro 2025
