<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Senha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #f0f9ff 0%, #faf5ff 100%);
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #3ebddb 0%, #8b5cf6 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .email-header svg {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
        }
        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .greeting strong {
            color: #8b5cf6;
        }
        .message {
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .alert-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .alert-box p {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        .alert-box strong {
            color: #78350f;
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .reset-button-container {
            text-align: center;
            margin: 40px 0;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #3ebddb 0%, #8b5cf6 100%);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
            transform: translateY(-2px);
        }
        .alternative-link {
            background: #f3f4f6;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            border: 1px dashed #d1d5db;
        }
        .alternative-link p {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .alternative-link a {
            color: #8b5cf6;
            word-break: break-all;
            font-size: 12px;
        }
        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .info-box strong {
            color: #1e40af;
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
        }
        .info-box ul {
            margin: 0;
            padding-left: 20px;
        }
        .info-box li {
            color: #1e40af;
            font-size: 14px;
            margin: 8px 0;
        }
        .email-footer {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            color: #6b7280;
            font-size: 13px;
            margin: 8px 0;
        }
        .email-footer .brand {
            background: linear-gradient(135deg, #3ebddb 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 16px;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #d1d5db, transparent);
            margin: 30px 0;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-header h1 {
                font-size: 24px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .reset-button {
                padding: 14px 30px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header com gradiente -->
        <div class="email-header">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
            <h1>Redefinição de Senha</h1>
            <p>Recupere o acesso à sua conta</p>
        </div>

        <!-- Corpo do Email -->
        <div class="email-body">
            <p class="greeting">Olá, <strong>{{ $user->name }}</strong>!</p>

            <p class="message">
                Recebemos uma solicitação para redefinir a senha da sua conta no <strong>{{ config('app.name') }}</strong>. 
                Se você fez esta solicitação, clique no botão abaixo para criar uma nova senha.
            </p>

            <!-- Alerta de Segurança -->
            <div class="alert-box">
                <strong>⚠️ Atenção - Link Temporário</strong>
                <p>Este link expira em <strong>60 minutos</strong> por segurança. Se o link expirar, você precisará solicitar um novo.</p>
            </div>

            <!-- Botão de Redefinição -->
            <div class="reset-button-container">
                <a href="{{ $resetUrl }}" class="reset-button">
                    🔐 Redefinir Minha Senha
                </a>
            </div>

            <!-- Link Alternativo -->
            <div class="alternative-link">
                <p><strong>Se o botão não funcionar, copie e cole este link no seu navegador:</strong></p>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>

            <div class="divider"></div>

            <!-- Informações de Segurança -->
            <div class="info-box">
                <strong>🛡️ Dicas de Segurança</strong>
                <ul>
                    <li>Nunca compartilhe este link com outras pessoas</li>
                    <li>Escolha uma senha forte com letras, números e símbolos</li>
                    <li>Não reutilize senhas de outras contas</li>
                    <li>Se você não solicitou esta redefinição, ignore este email</li>
                </ul>
            </div>

            <p class="message" style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                <strong>Não solicitou esta redefinição?</strong><br>
                Se você não pediu para redefinir sua senha, você pode ignorar este email com segurança. 
                Sua conta permanece protegida e nenhuma alteração será feita.
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p style="margin-top: 15px;">
                <span class="brand">{{ config('app.name') }}</span>
            </p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
