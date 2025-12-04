# Script para monitorar logs de login em tempo real
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "  MONITORAMENTO DE LOGIN EM TEMPO REAL" -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Aguardando tentativas de login..." -ForegroundColor Yellow
Write-Host "Pressione Ctrl+C para parar" -ForegroundColor Yellow
Write-Host ""
Write-Host "==========================================" -ForegroundColor Cyan
Write-Host ""

# Limpar log anterior
if (Test-Path "storage\logs\laravel.log") {
    # Mostrar últimas 10 linhas
    Write-Host "Últimas entradas do log:" -ForegroundColor Green
    Get-Content "storage\logs\laravel.log" -Tail 10
    Write-Host ""
    Write-Host "------- AGUARDANDO NOVOS LOGS -------" -ForegroundColor Yellow
    Write-Host ""
}

# Monitorar em tempo real
Get-Content -Path "storage\logs\laravel.log" -Wait -Tail 0 | ForEach-Object {
    $line = $_
    
    # Colorir por tipo de log
    if ($line -match "===") {
        Write-Host $line -ForegroundColor Cyan
    }
    elseif ($line -match "✅|BEM-SUCEDIDO|SUCESSO") {
        Write-Host $line -ForegroundColor Green
    }
    elseif ($line -match "❌|FALHOU|ERROR|INCORRETA") {
        Write-Host $line -ForegroundColor Red
    }
    elseif ($line -match "TENTATIVA|Auth::attempt|Usuário encontrado") {
        Write-Host $line -ForegroundColor Yellow
    }
    elseif ($line -match "login|LOGIN|senha|password") {
        Write-Host $line -ForegroundColor White
    }
    else {
        Write-Host $line -ForegroundColor Gray
    }
}
