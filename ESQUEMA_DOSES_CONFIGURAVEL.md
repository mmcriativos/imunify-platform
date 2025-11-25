# 💉 Sistema de Esquema de Doses Configurável

## 📋 Visão Geral

O sistema agora possui **esquemas de doses 100% configuráveis** para cada vacina, eliminando código hardcoded e permitindo que cada tenant ajuste o calendário vacinal conforme sua necessidade.

---

## ✅ O Que Foi Implementado

### 1. **Nova Tabela: `vacina_esquema_doses`**

Armazena o esquema completo de cada vacina:

```sql
- dose_numero (1, 2, 3...)
- nome_dose ("1ª dose", "Reforço", "Dose única")
- idade_minima_meses (ex: 2 meses)
- idade_maxima_meses (ex: 12 meses)
- intervalo_minimo_dias (dias após dose anterior)
- intervalo_maximo_dias
- obrigatoria (SUS = true, privada = false)
- rede ('sus', 'privada', 'ambas')
- observacoes
```

### 2. **Model `VacinaEsquemaDose`**

Métodos úteis:
- `estaNoPeriodoIdeal($idadeMeses)` - Verifica se paciente está na idade certa
- `estaAtrasada($idadeMeses)` - Detecta atraso
- `calcularDataPrevista($dataUltimaDose, $dataNascimento)` - Calcula quando tomar
- Scopes: `obrigatorias()`, `sus()`, `ordenadas()`

### 3. **Service `ProximaDoseService`**

Centraliza toda lógica de cálculo:

```php
// Calcular todas próximas doses do paciente
$proximaDoseService->calcularProximasDoses($paciente);

// Doses próximas do vencimento (para lembretes)
$proximaDoseService->dosesProximasVencimento($paciente, 7);

// Próxima dose de vacina específica
$proximaDoseService->proximaDoseVacina($paciente, $vacina);
```

### 4. **Seeder com Calendário Oficial do Ministério da Saúde**

Popula automaticamente esquemas para:
- BCG
- Hepatite B (3 doses)
- Pentavalente (3 doses)
- Pneumocócica 10 e 13
- Meningocócica C e B
- Rotavírus
- Influenza
- Febre Amarela
- Tríplice Viral
- Tetra Viral
- Hepatite A
- Varicela
- DTP / dT
- HPV
- COVID-19

### 5. **Interface Administrativa**

**Rota:** `/vacinas/{vacina}/esquema`

Permite ao tenant:
- Ver esquema atual
- Adicionar/remover doses
- Configurar idade mínima/máxima
- Definir intervalos
- Marcar como obrigatória ou opcional
- Definir se é SUS, privada ou ambas
- Adicionar observações

### 6. **Indicadores Visuais**

**Na listagem de vacinas:**
- ✅ Badge verde: "Esquema configurado: X doses"
- ⚠️ Badge amarelo: "Esquema não configurado" + link

**Botão roxo** na listagem para acessar configuração rápida

---

## 🔄 Refatorações Realizadas

### **EnviarLembretesVacinas.php**
- ❌ **ANTES:** Calendário hardcoded (BCG, Hepatite B, Pentavalente...)
- ✅ **DEPOIS:** Usa `ProximaDoseService->dosesProximasVencimento()`

### **CarteiraVacinacaoController.php**
- ❌ **ANTES:** Método `getVacinasSugeridas()` com lógica hardcoded enorme
- ✅ **DEPOIS:** Usa `ProximaDoseService->calcularProximasDoses()`

### **carteira/publica.blade.php**
- ❌ **ANTES:** Intervalos genéricos (60, 90, 180 dias)
- ✅ **DEPOIS:** Lê do esquema configurado

---

## 📊 Vantagens

### ✅ **Precisão**
- Cada vacina tem seu esquema próprio
- Intervalos exatos do fabricante/Ministério da Saúde
- Idades mínimas e máximas respeitadas

### ✅ **Flexibilidade**
- Tenant pode ajustar conforme protocolos locais
- Adicionar doses extras (ex: imunossuprimidos)
- Marcar doses como opcionais

### ✅ **Manutenibilidade**
- Sem código hardcoded espalhado
- Service centralizado
- Fácil adicionar novas vacinas

### ✅ **Transparência**
- Tenant vê exatamente o que está configurado
- Pode validar com calendário oficial
- Observações documentadas

---

## 🚀 Como Usar

### **1. Configurar Esquema de Nova Vacina**

1. Ir em **Vacinas → Listagem**
2. Clicar no **botão roxo** (ícone de clipboard)
3. Adicionar doses necessárias
4. Definir idades e intervalos
5. Salvar

### **2. Editar Esquema Existente**

1. Mesma rota acima
2. Modificar campos desejados
3. Adicionar/remover doses
4. Salvar

### **3. Validar Precisão**

- Comparar com calendário do Ministério da Saúde
- Conferir bula do fabricante
- Ajustar conforme protocolos da clínica

---

## 📝 Exemplos de Configuração

### **Hepatite B - SUS (3 doses)**

| Dose | Idade Mín | Intervalo | Obrigatória |
|------|-----------|-----------|-------------|
| 1ª   | 0 meses   | -         | ✅ Sim      |
| 2ª   | 1 mês     | 30 dias   | ✅ Sim      |
| 3ª   | 6 meses   | 150 dias  | ✅ Sim      |

### **Influenza (Anual)**

| Dose | Idade Mín | Intervalo | Obrigatória |
|------|-----------|-----------|-------------|
| Anual| 6 meses   | 365 dias  | ✅ Sim      |

### **Meningocócica B - Privada (3 doses)**

| Dose | Idade Mín | Intervalo | Obrigatória | Rede    |
|------|-----------|-----------|-------------|---------|
| 1ª   | 3 meses   | -         | ❌ Não      | Privada |
| 2ª   | 5 meses   | 60 dias   | ❌ Não      | Privada |
| Reforço| 12 meses| 180 dias  | ❌ Não      | Privada |

---

## 🔧 Detalhes Técnicos

### **Migrations Executadas**

```bash
✅ clinica-demo: 2025_11_23_000001_create_vacina_esquema_doses_table
✅ clinica-teste: 2025_11_23_000001_create_vacina_esquema_doses_table
✅ multiimune: 2025_11_23_000001_create_vacina_esquema_doses_table
```

### **Seeders Executados**

```bash
✅ clinica-demo: VacinaEsquemaDoseSeeder
✅ clinica-teste: VacinaEsquemaDoseSeeder
✅ multiimune: VacinaEsquemaDoseSeeder
```

### **Arquivos Criados/Modificados**

**Novos:**
- `database/migrations/tenant/2025_11_23_000001_create_vacina_esquema_doses_table.php`
- `app/Models/VacinaEsquemaDose.php`
- `app/Services/ProximaDoseService.php`
- `database/seeders/VacinaEsquemaDoseSeeder.php`
- `resources/views/vacinas/esquema.blade.php`

**Modificados:**
- `app/Models/Vacina.php` (+ relacionamento `esquemaDoses()`)
- `app/Http/Controllers/VacinaController.php` (+ métodos `esquema()`, `salvarEsquema()`)
- `app/Console/Commands/EnviarLembretesVacinas.php` (refatorado)
- `app/Http/Controllers/CarteiraVacinacaoController.php` (refatorado)
- `resources/views/vacinas/index.blade.php` (+ indicador visual)
- `routes/tenant.php` (+ rotas de esquema)

---

## ⚠️ Pontos de Atenção

### **Vacinas Sem Esquema**
- Aparecem com badge amarelo na listagem
- Sistema não gera sugestões automáticas
- Tenant deve configurar manualmente

### **Compatibilidade**
- Views antigas continuam funcionando
- Método `getVacinasSugeridas()` marcado como deprecado
- Migração gradual sem quebrar funcionalidades

### **Performance**
- Service usa eager loading (`with('esquemaDoses')`)
- Queries otimizadas com índices
- Cache pode ser adicionado futuramente se necessário

---

## 🎯 Próximos Passos (Sugestões)

1. **Dashboard de Validação**
   - Listar vacinas sem esquema
   - Comparar com calendário oficial
   - Alertar divergências

2. **Importação/Exportação**
   - Exportar esquemas em JSON
   - Importar de outras clínicas
   - Templates pré-configurados

3. **Histórico de Mudanças**
   - Rastrear alterações no esquema
   - Auditoria de modificações
   - Reverter para versões anteriores

4. **Notificações**
   - Alertar quando MS atualizar calendário
   - Sugerir ajustes baseados em novos guidelines
   - Validação automática

---

## 📞 Suporte

Para dúvidas sobre configuração de esquemas vacin ais:
1. Consultar calendário do Ministério da Saúde
2. Verificar bula do fabricante
3. Contatar suporte técnico do sistema

---

**Última atualização:** 23/11/2025
**Versão:** 1.0.0
