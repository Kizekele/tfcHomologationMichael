<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::orderBy('nom_agent')->get();

        return view('configuration.agents.index', compact('agents'));
    }

    public function create()
    {
        return view('configuration.agents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricule_agent' => ['required', 'string', 'max:20', 'unique:agent,matricule_agent'],
            'nom_agent' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', 'unique:agent,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,agent'],
            'fonction_agent' => ['nullable', 'string', 'max:100'],
            'telephone_agent' => ['nullable', 'string', 'max:20'],
        ]);

        Agent::create($data);

        return redirect()->route('configuration.agents.index')->with('success', 'Agent ajouté avec succès.');
    }

    public function edit(Agent $agent)
    {
        return view('configuration.agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'matricule_agent' => ['required', 'string', 'max:20', Rule::unique('agent', 'matricule_agent')->ignore($agent->matricule_agent, 'matricule_agent')],
            'nom_agent' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('agent', 'email')->ignore($agent->matricule_agent, 'matricule_agent')],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,agent'],
            'fonction_agent' => ['nullable', 'string', 'max:100'],
            'telephone_agent' => ['nullable', 'string', 'max:20'],
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $agent->update($data);

        return redirect()->route('configuration.agents.index')->with('success', 'Agent mis à jour.');
    }

    public function destroy(Agent $agent)
    {
        if ($agent->matricule_agent === auth('agent')->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($agent->isAdmin() && Agent::role('admin')->count() <= 1) {
            return back()->with('error', 'Impossible de supprimer le dernier administrateur.');
        }

        $agent->delete();

        return redirect()->route('configuration.agents.index')->with('success', 'Agent supprimé.');
    }
}
