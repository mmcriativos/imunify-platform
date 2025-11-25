<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Lancamento;
use Illuminate\Http\Request;

class CaixaController extends Controller
{
    public function index()
    {
        $caixas = Caixa::with(['usuarioAbertura', 'usuarioFechamento'])
            ->orderBy('data', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $caixaAberto = Caixa::aberto()->first();
        
        return view('financeiro.caixa.index', compact('caixas', 'caixaAberto'));
    }

    public function abrir(Request $request)
    {
        // Verifica se já existe caixa aberto
        $caixaAberto = Caixa::aberto()->first();
        if ($caixaAberto) {
            return back()->with('error', 'Já existe um caixa aberto. Feche-o antes de abrir um novo.');
        }

        $request->validate([
            'saldo_inicial' => 'required|numeric|min:0'
        ]);

        $caixa = Caixa::create([
            'usuario_abertura_id' => auth()->id(),
            'data' => now()->toDateString(),
            'hora_abertura' => now()->toTimeString(),
            'saldo_inicial' => $request->saldo_inicial ?? $request->valor_inicial ?? 0,
            'saldo_esperado' => $request->saldo_inicial ?? $request->valor_inicial ?? 0,
            'total_entradas' => 0,
            'total_saidas' => 0,
            'status' => 'aberto'
        ]);

        return redirect()->route('financeiro.caixa.show', $caixa)
            ->with('success', 'Caixa aberto com sucesso!');
    }

    public function show(Caixa $caixa)
    {
        $caixa->load(['usuarioAbertura', 'usuarioFechamento', 'lancamentos.categoria', 'lancamentos.formaPagamento']);
        
        // Recalcula totalizadores
        $caixa->calcularTotalizadores();
        $caixa->valor_esperado = $caixa->calcularValorEsperado();
        
        return view('financeiro.caixa.show', compact('caixa'));
    }

    public function fechar(Request $request, Caixa $caixa)
    {
        if ($caixa->isFechado()) {
            return back()->with('error', 'Este caixa já está fechado.');
        }

        $request->validate([
            'valor_real' => 'required|numeric|min:0',
            'observacoes' => 'nullable|string'
        ]);

        // Recalcula totalizadores antes de fechar
        $caixa->calcularTotalizadores();
        $caixa->valor_esperado = $caixa->calcularValorEsperado();
        $caixa->save();

        // Fecha o caixa
        $caixa->fechar($request->valor_real, $request->observacoes);

        return redirect()->route('financeiro.caixa.show', $caixa)
            ->with('success', 'Caixa fechado com sucesso!');
    }

    public function reabrir(Caixa $caixa)
    {
        if ($caixa->isAberto()) {
            return back()->with('error', 'Este caixa já está aberto.');
        }

        // Verifica se não há outro caixa aberto
        $outroAberto = Caixa::aberto()->first();
        if ($outroAberto) {
            return back()->with('error', 'Já existe um caixa aberto. Feche-o antes de reabrir este.');
        }

        $caixa->update([
            'status' => 'aberto',
            'data_fechamento' => null,
            'usuario_fechamento_id' => null,
            'valor_real' => null,
            'diferenca' => null
        ]);

        return redirect()->route('financeiro.caixa.show', $caixa)
            ->with('success', 'Caixa reaberto com sucesso!');
    }
}
