# Como Testar o Formulário de Atendimento

## Problema Resolvido
O formulário não estava enviando porque os campos de data tinham configuração incorreta que causava conflito no envio.

## O que foi corrigido:

### 1. **Campos de Data** (Commit f5d546b)
- ❌ Antes: Campo visível tinha `name="data"` e campo oculto `name="data_formatted"`
- ❌ JavaScript tentava trocar os nomes durante o submit (causava conflito)
- ✅ Agora: Campo visível `id="data_visual"` (sem name) e campo oculto `name="data"` (enviado)

### 2. **Validação e Debug** (Commit f9eaf9b)
- ✅ Validação: Verifica se há pelo menos uma vacina
- ✅ Validação: Verifica se todos os campos obrigatórios estão preenchidos
- ✅ Debug: Console.log mostra cada etapa do envio
- ✅ Notificações: Mensagens de erro claras para o usuário

## Como testar no servidor de produção:

```bash
# 1. Atualizar código
cd imunify-platform
git pull origin main

# 2. Limpar cache
php artisan view:clear
php artisan cache:clear

# 3. Testar no navegador
# Acesse: https://multiimune.imunify.com.br/atendimentos/create
```

## Como depurar problemas:

### Abra o Console do Navegador (F12)

Quando você clicar em "Registrar Atendimento", verá mensagens assim:

```
✅ Sucesso:
🚀 Formulário sendo enviado...
✅ Vacina 1: {vacina_id: "1", quantidade: "1", valor: "150.00"}
📅 Data: 2025-12-11
👤 Paciente: 123
🏥 Tipo: clinica
✅ Formulário validado! Enviando...
```

```
❌ Se houver erro:
🚀 Formulário sendo enviado...
❌ Vacina 1: Nenhuma vacina selecionada
❌ Formulário com dados inválidos
[NOTIFICAÇÃO VERMELHA] Preencha todos os campos das vacinas corretamente!
```

## Possíveis problemas restantes:

### 1. Se ainda não enviar após as correções:

**Verificar no Console (F12):**
- Procure por erros em vermelho
- Verifique a aba "Network" para ver se a requisição foi feita
- Veja se há erro 419 (CSRF token)

### 2. Se aparecer erro 500:

**No servidor:**
```bash
# Ver logs de erro
tail -50 storage/logs/laravel.log
```

### 3. Se aparecer erro de validação:

**Console mostrará exatamente qual campo está inválido**

## Checklist de Teste:

- [ ] 1. Acesse o formulário de novo atendimento
- [ ] 2. Abra o Console do navegador (F12)
- [ ] 3. Selecione uma data
- [ ] 4. Selecione um paciente
- [ ] 5. Escolha tipo (Clínica ou Domiciliar)
- [ ] 6. Adicione pelo menos uma vacina:
  - [ ] Selecione a vacina
  - [ ] Escolha a tabela de preço
  - [ ] Defina quantidade
  - [ ] Valor será preenchido automaticamente
- [ ] 7. Clique em "Registrar Atendimento"
- [ ] 8. Veja as mensagens no console
- [ ] 9. Se sucesso: será redirecionado para a página do atendimento
- [ ] 10. Se erro: mensagem clara aparecerá na tela e no console

## Estrutura do Formulário:

```html
<form action="/atendimentos" method="POST" id="formAtendimento">
    @csrf
    
    <!-- Data (oculto, formato Y-m-d) -->
    <input type="hidden" name="data" value="2025-12-11">
    
    <!-- Paciente -->
    <select name="paciente_id" required>...</select>
    
    <!-- Tipo -->
    <input type="radio" name="tipo" value="clinica" checked>
    <input type="radio" name="tipo" value="domiciliar">
    
    <!-- Vacinas (array) -->
    <select name="vacinas[0][vacina_id]" required>...</select>
    <input name="vacinas[0][quantidade]" required>
    <input name="vacinas[0][valor_unitario]" required>
    <input name="vacinas[0][lote]">
    
    <button type="submit">Registrar Atendimento</button>
</form>
```

## Se o problema persistir:

1. **Copie TODA a saída do console** (F12) e envie
2. **Tire um print** da tela quando clicar em "Registrar"
3. **Verifique os logs do servidor**: `tail -50 storage/logs/laravel.log`
