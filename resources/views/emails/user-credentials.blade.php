<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciais de Acesso</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    
                    <!-- Header com Gradiente -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: bold;">
                                🎉 Bem-vindo ao {{ config('app.name') }}!
                            </h1>
                            <p style="margin: 10px 0 0; color: #e0e7ff; font-size: 16px;">
                                Suas credenciais de acesso foram criadas
                            </p>
                        </td>
                    </tr>

                    <!-- Conteúdo Principal -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #374151; font-size: 16px; line-height: 1.6;">
                                Olá <strong>{{ $userName }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #374151; font-size: 16px; line-height: 1.6;">
                                Uma conta foi criada para você com o nível de acesso <strong style="color: #8b5cf6;">{{ $roleName }}</strong>. 
                                Use as credenciais abaixo para fazer login:
                            </p>

                            <!-- Card de Credenciais -->
                            <table role="presentation" style="width: 100%; border-collapse: collapse; background: linear-gradient(135deg, #eff6ff 0%, #f3e8ff 100%); border-radius: 12px; overflow: hidden; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 30px;">
                                        <!-- E-mail -->
                                        <div style="margin-bottom: 20px;">
                                            <p style="margin: 0 0 8px; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                📧 E-mail
                                            </p>
                                            <p style="margin: 0; color: #1f2937; font-size: 18px; font-weight: bold; font-family: 'Courier New', monospace;">
                                                {{ $userEmail }}
                                            </p>
                                        </div>

                                        <!-- Senha -->
                                        <div>
                                            <p style="margin: 0 0 8px; color: #6b7280; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                🔑 Senha Temporária
                                            </p>
                                            <p style="margin: 0; color: #1f2937; font-size: 18px; font-weight: bold; font-family: 'Courier New', monospace; background-color: #ffffff; padding: 12px; border-radius: 8px; border: 2px dashed #8b5cf6;">
                                                {{ $password }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Botão de Login -->
                            <table role="presentation" style="width: 100%; margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $loginUrl }}" 
                                           style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: #ffffff; text-decoration: none; border-radius: 12px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                                            🚀 Acessar Minha Conta
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Informações de Segurança -->
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
                                <p style="margin: 0 0 10px; color: #92400e; font-size: 14px; font-weight: bold;">
                                    🔒 Recomendações de Segurança
                                </p>
                                <ul style="margin: 0; padding-left: 20px; color: #78350f; font-size: 14px; line-height: 1.6;">
                                    <li>Altere sua senha no primeiro acesso</li>
                                    <li>Não compartilhe suas credenciais com ninguém</li>
                                    <li>Use uma senha forte com letras, números e símbolos</li>
                                </ul>
                            </div>

                            <!-- Suas Permissões -->
                            <div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px;">
                                <p style="margin: 0 0 10px; color: #374151; font-size: 14px; font-weight: bold;">
                                    ✨ Seu Nível de Acesso: {{ $roleName }}
                                </p>
                                @if($roleName === 'Administrador')
                                    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                        Você tem acesso total ao sistema, incluindo gerenciamento de usuários, configurações e todas as funcionalidades.
                                    </p>
                                @elseif($roleName === 'Gerente')
                                    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                        Você pode gerenciar pacientes, agendamentos, estoque e visualizar relatórios completos.
                                    </p>
                                @elseif($roleName === 'Operador')
                                    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                        Você pode gerenciar pacientes e agendamentos do dia a dia.
                                    </p>
                                @else
                                    <p style="margin: 0; color: #6b7280; font-size: 14px; line-height: 1.6;">
                                        Você tem acesso de visualização aos dados do sistema.
                                    </p>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0 0 10px; color: #6b7280; font-size: 14px;">
                                Se você não solicitou esta conta ou tem alguma dúvida,<br>
                                entre em contato com o administrador do sistema.
                            </p>
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Nota de Rodapé -->
                <p style="margin: 20px 0 0; color: #9ca3af; font-size: 12px; text-align: center;">
                    Este é um e-mail automático. Por favor, não responda a esta mensagem.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
