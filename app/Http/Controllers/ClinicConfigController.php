<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClinicConfigController extends Controller
{
    public function index()
    {
        $tenant = tenant();
        return view('clinic.config', compact('tenant'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'cnes' => 'nullable|string|max:20',
            'crm' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'zip_code' => 'nullable|string|max:10',
        ]);

        $tenant = tenant();
        $tenant->update($validated);

        return redirect()->route('clinic.config')
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
}
