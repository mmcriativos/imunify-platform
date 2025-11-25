<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Vacinação - {{ $paciente->nome }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
        }
        .certificado {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 60px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }
        .certificado::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(102, 126, 234, 0.05) 30%, rgba(102, 126, 234, 0.05) 70%, transparent 70%);
            transform: rotate(-45deg);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-center;
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        h1 {
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .subtitle {
            font-size: 16px;
            color: #718096;
            font-weight: 500;
        }
        .content {
            position: relative;
            z-index: 1;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f7fafc;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .section-title {
            font-size: 14px;
            color: #667eea;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-size: 11px;
            color: #a0aec0;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
            color: #2d3748;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background: #667eea;
            color: white;
        }
        th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            color: #4a5568;
        }
        tbody tr:hover {
            background: #edf2f7;
        }
        .footer {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .qr-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            background: white;
            padding: 10px;
            border: 2px solid #667eea;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .validation-text {
            font-size: 11px;
            color: #718096;
            margin-top: 5px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #2d3748;
            width: 300px;
            margin: 30px auto 0;
            text-align: center;
        }
        .signature-name {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }
        .signature-role {
            font-size: 12px;
            color: #718096;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(102, 126, 234, 0.03);
            font-weight: 900;
            pointer-events: none;
            z-index: 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-success {
            background: #c6f6d5;
            color: #22543d;
        }
        @media print {
            body {
                padding: 0;
                background: white;
            }
            .certificado {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="certificado">
        <div class="watermark">MULTIIMUNE</div>
        
        <!-- Cabeçalho -->
        <div class="header">
            <div class="logo">💉</div>
            <h1>Certificado de Vacinação Digital</h1>
            <p class="subtitle">Emitido por MultiImune Clínica de Vacinação</p>
        </div>

        <div class="content">
            <!-- Dados do Paciente -->
            <div class="section">
                <div class="section-title">📋 Dados do Paciente</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nome Completo</span>
                        <span class="info-value">{{ $paciente->nome }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Data de Nascimento</span>
                        <span class="info-value">
                            {{ $paciente->data_nascimento ? \Carbon\Carbon::parse($paciente->data_nascimento)->format('d/m/Y') : 'Não informado' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">CPF</span>
                        <span class="info-value">{{ $paciente->cpf ?? 'Não informado' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Código do Paciente</span>
                        <span class="info-value">#{{ str_pad($paciente->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>

            <!-- Histórico de Vacinas -->
            <div class="section">
                <div class="section-title">💉 Histórico de Imunizações</div>
                <table>
                    <thead>
                        <tr>
                            <th>Vacina</th>
                            <th>Data</th>
                            <th>Dose</th>
                            <th>Lote</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vacinasAplicadas as $vacina)
                            <tr>
                                <td><strong>{{ $vacina['vacina'] }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($vacina['data'])->format('d/m/Y') }}</td>
                                <td>{{ $vacina['dose'] }}</td>
                                <td>{{ $vacina['lote'] ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-success">✓ Aplicada</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: #a0aec0;">
                                    Nenhuma vacina registrada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <div class="qr-container">
                <div id="qrcode-pdf" class="qr-code"></div>
                <p class="validation-text">
                    Escaneie o QR Code para validar este certificado online
                </p>
            </div>
            
            <p style="font-size: 12px; color: #718096; margin-bottom: 10px;">
                Emitido em: {{ now()->format('d/m/Y \à\s H:i') }}
            </p>
            
            <div class="signature">
                <div class="signature-name">{{ tenant()->clinic_name ?? 'MultiImune Clínica de Vacinação' }}</div>
                <div class="signature-role">
                    @if(tenant()->cnes || tenant()->crm)
                        @if(tenant()->cnes)
                            CNES: {{ tenant()->cnes }}
                        @endif
                        @if(tenant()->cnes && tenant()->crm)
                            •
                        @endif
                        @if(tenant()->crm)
                            CRM: {{ tenant()->crm }}
                        @endif
                    @else
                        <span class="text-red-600">⚠️ CNES e CRM não cadastrados</span>
                    @endif
                </div>
            </div>
            
            <p style="font-size: 10px; color: #a0aec0; margin-top: 20px;">
                Este certificado é válido em todo território nacional e pode ser apresentado em escolas, viagens e estabelecimentos de saúde.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new QRCode(document.getElementById("qrcode-pdf"), {
                text: "{{ route('carteira.show', $paciente->id) }}",
                width: 130,
                height: 130,
                colorDark: "#667eea",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            
            // Auto-imprimir após carregar
            setTimeout(() => {
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>
