@echo off
echo =========================================
echo   MONITORAMENTO DE LOGIN EM TEMPO REAL
echo =========================================
echo.
echo Aguardando tentativas de login...
echo Pressione Ctrl+C para parar
echo.
echo =========================================
echo.

powershell -Command "Get-Content -Path 'storage\logs\laravel.log' -Wait -Tail 50 | Where-Object { $_ -match 'login|LOGIN|TENTATIVA|Auth::attempt|Usuário|senha' }"
