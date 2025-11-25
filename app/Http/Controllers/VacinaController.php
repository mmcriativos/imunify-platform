<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacina;
use App\Models\VacinaEsquemaDose;

class VacinaController extends Controller
{
    private const CAMPOS_MONETARIOS = [
        'preco_custo',
        'preco_venda_cartao',
        'preco_venda_pix',
        'preco_promocional',
    ];

    public function index()
    {
        $vacinas = Vacina::with(['lotes' => function($query) {
                $query->where('status', 'Disponivel')->orderBy('data_validade');
            }])
            ->where('ativo', true)
            ->orderBy('nome')
            ->paginate(15);

        return view('vacinas.index', compact('vacinas'));
    }

    public function create()
    {
        return view('vacinas.create');
    }

    public function store(Request $request)
    {
        $this->sanitizeVacinaRequest($request);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'modo_agir' => 'nullable|string',
            'indicacoes' => 'nullable|string',
            'descricao' => 'nullable|string',
            'preco_custo' => 'nullable|numeric|min:0',
            'preco_venda_cartao' => 'nullable|numeric|min:0',
            'preco_venda_pix' => 'nullable|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'validade_dias' => 'nullable|integer|min:0',
            'numero_doses' => 'required|integer|min:1',
            'intervalo_doses_dias' => 'nullable|integer|min:0',
            'ativo' => 'sometimes|boolean',
        ]);

        Vacina::create($validated);

        return redirect()->route('vacinas.index')
            ->with('success', 'Vacina cadastrada com sucesso!');
    }

    public function show(Vacina $vacina)
    {
        return view('vacinas.show', compact('vacina'));
    }

    public function edit(Vacina $vacina)
    {
        return view('vacinas.edit', compact('vacina'));
    }

    public function update(Request $request, Vacina $vacina)
    {
        $this->sanitizeVacinaRequest($request);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'fabricante' => 'nullable|string|max:255',
            'modo_agir' => 'nullable|string',
            'indicacoes' => 'nullable|string',
            'descricao' => 'nullable|string',
            'preco_custo' => 'nullable|numeric|min:0',
            'preco_venda_cartao' => 'nullable|numeric|min:0',
            'preco_venda_pix' => 'nullable|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'validade_dias' => 'nullable|integer|min:0',
            'numero_doses' => 'required|integer|min:1',
            'intervalo_doses_dias' => 'nullable|integer|min:0',
            'ativo' => 'sometimes|boolean',
        ]);

        $vacina->update($validated);

        return redirect()->route('vacinas.index')
            ->with('success', 'Vacina atualizada com sucesso!');
    }

    public function destroy(Vacina $vacina)
    {
        $vacina->update(['ativo' => false]);

        return redirect()->route('vacinas.index')
            ->with('success', 'Vacina desativada com sucesso!');
    }

    private function sanitizeVacinaRequest(Request $request): void
    {
        $sanitized = [];

        foreach (self::CAMPOS_MONETARIOS as $campo) {
            if (!$request->has($campo)) {
                continue;
            }

            $valorBruto = trim((string) $request->input($campo));

            if ($valorBruto === '') {
                $sanitized[$campo] = null;
                continue;
            }

            $valorLimpo = str_replace(' ', '', $valorBruto);

            if (str_contains($valorLimpo, ',')) {
                $normalizado = str_replace('.', '', $valorLimpo);
                $normalizado = str_replace(',', '.', $normalizado);
            } else {
                $normalizado = str_replace(',', '', $valorLimpo);
            }

            $sanitized[$campo] = is_numeric($normalizado)
                ? number_format((float) $normalizado, 2, '.', '')
                : null;
        }

        if (!$request->has('ativo')) {
            $sanitized['ativo'] = true;
        } else {
            $sanitized['ativo'] = $request->boolean('ativo');
        }

        if ($request->has('numero_doses') && (int) $request->input('numero_doses') === 1) {
            $sanitized['intervalo_doses_dias'] = null;
        }

        if (!empty($sanitized)) {
            $request->merge($sanitized);
        }
    }

    /**
     * Exibir esquema de doses da vacina
     */
    public function esquema(Vacina $vacina)
    {
        $esquemaDoses = $vacina->esquemaDoses;
        
        return view('vacinas.esquema', compact('vacina', 'esquemaDoses'));
    }

    /**
     * Salvar esquema de doses
     */
    public function salvarEsquema(Request $request, Vacina $vacina)
    {
        $request->validate([
            'doses' => 'required|array',
            'doses.*.dose_numero' => 'required|integer|min:1',
            'doses.*.nome_dose' => 'nullable|string|max:255',
            'doses.*.idade_minima_meses' => 'nullable|integer|min:0',
            'doses.*.idade_maxima_meses' => 'nullable|integer|min:0',
            'doses.*.intervalo_minimo_dias' => 'nullable|integer|min:0',
            'doses.*.observacoes' => 'nullable|string'
        ]);

        // Limpar esquema existente
        $vacina->esquemaDoses()->delete();

        // Criar novos registros
        foreach ($request->doses as $dose) {
            VacinaEsquemaDose::create([
                'vacina_id' => $vacina->id,
                'dose_numero' => $dose['dose_numero'],
                'nome_dose' => $dose['nome_dose'] ?? null,
                'idade_minima_meses' => !empty($dose['idade_minima_meses']) ? $dose['idade_minima_meses'] : null,
                'idade_maxima_meses' => !empty($dose['idade_maxima_meses']) ? $dose['idade_maxima_meses'] : null,
                'intervalo_minimo_dias' => !empty($dose['intervalo_minimo_dias']) ? $dose['intervalo_minimo_dias'] : null,
                'intervalo_maximo_dias' => null,
                'obrigatoria' => true,
                'rede' => 'ambas',
                'observacoes' => $dose['observacoes'] ?? null,
                'ordem' => $dose['dose_numero']
            ]);
        }

        return redirect()
            ->route('vacinas.esquema', $vacina)
            ->with('success', 'Esquema de doses atualizado com sucesso!');
    }
}
