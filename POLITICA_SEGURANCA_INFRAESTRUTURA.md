# 🔒 Política de Segurança - Informações Técnicas

## ⚠️ Regra de Ouro: Nunca Expor Infraestrutura

### ❌ NUNCA Mencionar em Conteúdo Público:
- Nome de APIs/SDKs de terceiros (Z-API, Twilio, etc)
- URLs de endpoints
- Estrutura de credenciais (Instance ID, tokens, etc)
- Nomes de serviços de infraestrutura
- Providers de cloud (AWS, Azure, etc - quando específico)

### ✅ SEMPRE Usar Termos Genéricos:
- "Credenciais de conexão fornecidas pela Imunify"
- "API de WhatsApp Business"
- "Nosso sistema de mensagens"
- "Infraestrutura Imunify"
- "Plataforma de comunicação"

---

## 🎯 Justificativa

### 1. **Proteção Contra Concorrentes**
- Concorrentes podem criar trials na mesma API
- Reverter engenharia do sistema
- Copiar stack tecnológico
- Criar produtos similares

### 2. **Segurança da Operação**
- Evita ataques direcionados
- Protege pontos de falha conhecidos
- Dificulta DDoS/abusos
- Mantém vantagem competitiva

### 3. **Profissionalismo**
- Cliente vê "solução própria" (mais valor)
- Não expõe dependências externas
- Imagem de produto mais robusto
- Reduz questionamentos sobre terceirização

---

## 📋 Checklist de Revisão

Antes de publicar qualquer conteúdo público (artigos de ajuda, docs, blog):

- [ ] Não menciona nomes de APIs/SDKs?
- [ ] URLs são genéricas ou internas?
- [ ] Credenciais são abstraídas?
- [ ] Termos técnicos são substituídos por marketing?
- [ ] Cliente entende sem ver "bastidores"?

---

## 🔄 Locais Já Auditados

### ✅ Limpos (sem menções)
- [x] Centro de Ajuda (`resources/views/ajuda/*`)
- [x] HelpArticlesSeeder (artigos públicos)
- [x] Views públicas do sistema

### ⚠️ Mantidos (documentação interna)
- Arquivos `*.md` na raiz (apenas para desenvolvedores)
- Comentários em código (não visíveis ao cliente)
- Migrations/seeders (só equipe técnica)

---

## 📝 Script de Atualização

Sempre que adicionar novos artigos de ajuda, rodar:

```bash
# Verificar menções
grep -r "Z-API\|z-api\|zapi" resources/views/ajuda/
grep -r "Z-API\|z-api\|zapi" database/seeders/HelpArticlesSeeder.php

# Se encontrar algo, substituir por termos genéricos
```

---

## 💡 Exemplos de Substituição

### ❌ Antes (Expõe infraestrutura)
```
"Insira suas credenciais Z-API (Instance ID, Token, Client Token)"
"Conectando ao endpoint https://api.z-api.io/..."
"Usando Twilio para SMS"
```

### ✅ Depois (Genérico e profissional)
```
"Insira as credenciais de conexão fornecidas pela Imunify"
"Conectando à plataforma de mensagens..."
"Enviando via nosso sistema de comunicação"
```

---

## 🎯 Conclusão

**Regra simples**: Se o cliente não precisa saber, não diga.

Mantenha o foco em **valor** e **resultados**, não em **como** funciona por baixo dos panos.

---

**Documento atualizado em**: 18/11/2025  
**Responsável**: Equipe de Segurança
