<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teste Simples - Atendimento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #10B981;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        button {
            background: #10B981;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background: #059669;
        }
        .info {
            background: #EFF6FF;
            border-left: 4px solid #3B82F6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Teste Simples de Atendimento</h1>
        
        <div class="info">
            <strong>⚠️ Este é um formulário de teste simplificado</strong><br>
            Sem TomSelect, sem Flatpickr, sem validações complexas.<br>
            Apenas HTML puro + CSRF token.
        </div>
        
        <form action="{{ route('atendimentos.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Data:</label>
                <input type="date" name="data" value="{{ date('Y-m-d') }}" required>
            </div>
            
            <div class="form-group">
                <label>Paciente:</label>
                <select name="paciente_id" required>
                    <option value="">Selecione...</option>
                    @foreach(\App\Models\Paciente::orderBy('nome')->limit(20)->get() as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Tipo:</label>
                <select name="tipo" required>
                    <option value="clinica">Clínica</option>
                    <option value="domiciliar">Domiciliar</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Vacina:</label>
                <select name="vacinas[0][vacina_id]" required>
                    <option value="">Selecione...</option>
                    @foreach(\App\Models\Vacina::where('ativo', true)->orderBy('nome')->limit(20)->get() as $vacina)
                        <option value="{{ $vacina->id }}">{{ $vacina->nome }} - R$ {{ number_format($vacina->preco_venda_pix ?? 0, 2, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Quantidade:</label>
                <input type="number" name="vacinas[0][quantidade]" value="1" min="1" required>
            </div>
            
            <div class="form-group">
                <label>Valor Unitário (R$):</label>
                <input type="number" step="0.01" name="vacinas[0][valor_unitario]" value="100.00" min="0" required>
            </div>
            
            <button type="submit">✅ REGISTRAR ATENDIMENTO (TESTE)</button>
        </form>
        
        <div class="info" style="margin-top: 30px; background: #FEF3C7; border-left-color: #F59E0B;">
            <strong>📌 Como usar:</strong><br>
            1. Preencha todos os campos<br>
            2. Clique em "REGISTRAR ATENDIMENTO (TESTE)"<br>
            3. Se funcionar: problema está no JavaScript<br>
            4. Se não funcionar: problema está no backend
        </div>
    </div>
</body>
</html>
