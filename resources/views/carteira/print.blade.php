<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteira de Vacinação - {{ $paciente->nome }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .patient-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
        }
        
        .patient-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .info-item label {
            display: block;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 3px;
        }
        
        .info-item value {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }
        
        .section-title {
            background: #667eea;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 15px 0;
        }
        
        .vaccine-card {
            background: #f8f9fa;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        .vaccine-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #10b981;
        }
        
        .vaccine-icon {
            width: 40px;
            height: 40px;
            background: #10b981;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        
        .vaccine-name {
            flex: 1;
            font-size: 16px;
            font-weight: bold;
            color: #000;
        }
        
        .doses-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .dose-card {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px;
        }
        
        .dose-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .dose-badge {
            background: #10b981;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .dose-date {
            font-size: 10px;
            color: #666;
        }
        
        .dose-info {
            font-size: 10px;
            color: #666;
            line-height: 1.6;
        }
        
        .dose-info strong {
            color: #000;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .no-vaccines {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none !important;
            }
            
            .vaccine-card {
                page-break-inside: avoid;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Imprimir</button>
    
    <div class="header">
        <h1>Carteira de Vacinação Digital</h1>
        <p>MultiImune - Clínica de Vacinação</p>
    </div>
    
    <div class="patient-info">
        <div class="patient-info-grid">
            <div class="info-item">
                <label>Código</label>
                <value>#{{ str_pad($paciente->id, 6, '0', STR_PAD_LEFT) }}</value>
            </div>
            <div class="info-item">
                <label>Nome do Paciente</label>
                <value>{{ $paciente->nome }}</value>
            </div>
            <div class="info-item">
                <label>Data de Nascimento</label>
                <value>
                    {{ $paciente->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}
                </value>
            </div>
            <div class="info-item">
                <label>Idade</label>
                <value>
                    @if($paciente->data_nascimento)
                        @php
                            $anos = \Carbon\Carbon::parse($paciente->data_nascimento)->age;
                            $meses = \Carbon\Carbon::parse($paciente->data_nascimento)->diffInMonths(now());
                        @endphp
                        @if($anos == 0)
                            {{ $meses }} {{ $meses == 1 ? 'mês' : 'meses' }}
                        @else
                            {{ $anos }} {{ $anos == 1 ? 'ano' : 'anos' }}
                        @endif
                    @else
                        -
                    @endif
                </value>
            </div>
        </div>
        @if($paciente->responsavel_nome)
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <div class="info-item">
                    <label>Responsável</label>
                    <value>{{ $paciente->responsavel_nome }}</value>
                </div>
            </div>
        @endif
    </div>
    
    <div class="section-title">
        📋 Histórico de Imunizações ({{ $vacinasAplicadas->count() }} vacina(s) aplicada(s))
    </div>
    
    @if($vacinasAplicadas->count() > 0)
        @foreach($vacinasAplicadas->groupBy('vacina') as $nomeVacina => $doses)
            <div class="vaccine-card">
                <div class="vaccine-header">
                    <div class="vaccine-icon">
                        💉
                    </div>
                    <div class="vaccine-name">
                        {{ $nomeVacina }}
                        <div style="font-size: 12px; font-weight: normal; color: #666; margin-top: 2px;">
                            {{ $doses->count() }} {{ $doses->count() == 1 ? 'dose aplicada' : 'doses aplicadas' }}
                        </div>
                    </div>
                </div>
                
                <div class="doses-grid">
                    @foreach($doses->sortBy('data') as $dose)
                        <div class="dose-card">
                            <div class="dose-header">
                                <span class="dose-badge">{{ $dose['dose'] }}</span>
                                <span class="dose-date">{{ \Carbon\Carbon::parse($dose['data'])->format('d/m/Y') }}</span>
                            </div>
                            <div class="dose-info">
                                <div><strong>Lote:</strong> {{ $dose['lote'] ?? 'N/A' }}</div>
                                <div><strong>Local:</strong> <span style="text-transform: capitalize;">{{ $dose['tipo'] }}</span></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <div class="no-vaccines">
            <p style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">Nenhuma vacina aplicada ainda</p>
            <p>O histórico de vacinação será preenchido conforme as aplicações forem realizadas.</p>
        </div>
    @endif
    
    <div class="footer">
        <p><strong>MultiImune - Clínica de Vacinação</strong></p>
        <p>Artur Nogueira, São Paulo - Brasil</p>
        <p>Documento emitido em {{ now()->format('d/m/Y H:i') }}</p>
        <p style="margin-top: 10px;">Este documento é válido para apresentação em escolas, empresas e órgãos públicos.</p>
    </div>
</body>
</html>
