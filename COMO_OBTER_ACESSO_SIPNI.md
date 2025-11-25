# 🔑 Como Obter Acesso à API e-SUS VE / RNDS

## 📋 Pré-requisitos

Antes de solicitar acesso, você precisa ter:

- ✅ **CNES ativo** do estabelecimento de saúde
- ✅ **Certificado Digital ICP-Brasil** (e-CNPJ ou e-CPF)
- ✅ **Responsável técnico** cadastrado
- ✅ **Sistema homologado** (seu software pronto para integrar)

---

## 🌐 Passo 1: Acessar o Portal de Serviços

Acesse: **https://servicos-datasus.saude.gov.br/**

Este é o canal oficial para integradores solicitarem acesso às APIs do DataSUS.

---

## 📝 Passo 2: Cadastrar ou Fazer Login

1. Se for a primeira vez, **crie uma conta** no portal
2. Se já tem conta, **faça login** com suas credenciais
3. Mantenha seus dados atualizados

---

## 🎯 Passo 3: Escolher o Sistema

Você pode solicitar acesso a:

### Opção 1: **RNDS** (Rede Nacional de Dados em Saúde)
- ✅ Sistema mais moderno e recomendado
- ✅ Padronização FHIR (Fast Healthcare Interoperability Resources)
- ✅ Integração com múltiplos sistemas de saúde
- 📚 Documentação: https://rnds.saude.gov.br/

### Opção 2: **e-SUS VE** (Vigilância Epidemiológica)
- ✅ Específico para notificações de vacinação
- ✅ Substituto oficial do SI-PNI Web legado
- 📚 Documentação: Disponível no portal após aprovação

---

## 📋 Passo 4: Preencher Formulário de Solicitação

No portal, você precisará informar:

1. **Dados do Estabelecimento**
   - CNES
   - Razão Social
   - CNPJ
   - Endereço completo

2. **Dados do Sistema**
   - Nome do sistema (ex: "Imunify")
   - Versão
   - Finalidade da integração
   - Funcionalidades que serão utilizadas

3. **Dados do Responsável Técnico**
   - Nome completo
   - CPF
   - E-mail
   - Telefone
   - Registro profissional (se aplicável)

4. **Documentação Técnica**
   - Arquitetura do sistema
   - Fluxo de dados
   - Medidas de segurança implementadas

---

## ⏳ Passo 5: Aguardar Análise

- ⏱️ **Prazo médio**: 15 a 30 dias úteis
- 📧 Você receberá notificações por e-mail sobre o status
- 🔍 A equipe do DataSUS pode solicitar informações adicionais

---

## 🧪 Passo 6: Ambiente de Homologação

Após aprovação, você receberá:

### Credenciais de Teste
- 🔑 **Client ID** (identificador do sistema)
- 🔒 **Client Secret** (senha de acesso)
- 🌐 **URL do ambiente de homologação**
- 📄 **Documentação técnica da API**

### O que fazer
1. Configure essas credenciais no Imunify (ambiente: Homologação)
2. Realize testes de integração
3. Valide todos os cenários de uso
4. Documente os testes realizados

---

## ✅ Passo 7: Validação e Homologação

O DataSUS irá:

1. **Monitorar** seus testes no ambiente de homologação
2. **Validar** se a integração está correta
3. **Verificar** conformidade com os padrões
4. **Aprovar** para produção

### Checklist de Validação
- [ ] Envio correto de dados de vacinação
- [ ] Tratamento adequado de erros
- [ ] Campos obrigatórios preenchidos
- [ ] Formatos de data/hora corretos
- [ ] Códigos de vacinas padronizados (SIGTAP)
- [ ] CNS e CPF válidos
- [ ] CNES correto
- [ ] Logs de auditoria implementados

---

## 🚀 Passo 8: Acesso à Produção

Após validação bem-sucedida:

### Você receberá
- 🔑 **Credenciais de produção**
- 🌐 **URL da API de produção**
- 📜 **Certificado digital** (instruções de instalação)
- 📋 **SLA** (Acordo de Nível de Serviço)

### Configure no Imunify
1. Acesse: **Dashboard → SIPNI → Configurações**
2. Altere para **Ambiente: Produção**
3. Insira as credenciais de produção
4. Insira a URL da API de produção
5. Teste a conexão
6. **Ative o módulo**

---

## 🔐 Certificado Digital

### Por que é necessário?
- 🛡️ **Segurança**: Garante autenticidade da comunicação
- 🔒 **Criptografia**: Protege dados sensíveis de saúde
- ✅ **Conformidade**: Exigência legal para dados de saúde
- 🎯 **Identificação**: Comprova identidade do estabelecimento

### Tipos aceitos
- **e-CNPJ**: Certificado da pessoa jurídica (clínica/hospital)
- **e-CPF**: Certificado do responsável técnico

### Onde obter?
- Certisign
- Serasa Experian
- Valid
- Soluti
- Outras Autoridades Certificadoras credenciadas pela ICP-Brasil

---

## 📞 Suporte e Contato

### Portal de Serviços do DataSUS
- 🌐 **Site**: https://servicos-datasus.saude.gov.br/
- 📧 **E-mail**: Disponível no portal
- 📞 **Telefone**: 136 (Disque Saúde)

### Documentação Técnica
- 📚 **RNDS**: https://rnds.saude.gov.br/
- 📚 **e-SUS APS**: https://sisaps.saude.gov.br/esus/
- 📚 **FHIR**: https://www.hl7.org/fhir/

---

## ⚠️ Observações Importantes

### SI-PNI Web Legado (DESCONTINUADO)
- ❌ O sistema antigo foi **desativado em 2019**
- ❌ Não aceita mais novas integrações
- ✅ Substituído por **e-SUS VE** e **RNDS**

### Migração
Se você tinha integração com o SI-PNI antigo:
1. Solicite migração no Portal de Serviços
2. Adapte seu sistema para a nova API
3. Realize nova homologação
4. Obtenha novas credenciais

---

## 📊 Estimativa de Tempo Total

| Etapa | Tempo Estimado |
|-------|----------------|
| Preparação de documentos | 1-2 dias |
| Solicitação no portal | 1 dia |
| Análise pelo DataSUS | 15-30 dias |
| Testes em homologação | 5-15 dias |
| Validação final | 5-10 dias |
| **TOTAL** | **26-58 dias** |

---

## ✅ Próximos Passos Após Obter Acesso

1. Configure as credenciais no Imunify
2. Configure códigos SIPNI de todas as vacinas
3. Adicione CNS de todos os profissionais
4. Valide dados de pacientes existentes
5. Ative o módulo
6. Monitore o dashboard de exportações

---

**Desenvolvido por**: Imunify Team  
**Atualizado em**: Novembro 2025
