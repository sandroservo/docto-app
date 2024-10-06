<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Professional::query();

        // Se houver uma pesquisa, filtre os resultados
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Ordenar os resultados em ordem decrescente e paginá-los
        $professionals = $query->orderBy('created_at', 'desc')->paginate(10);

        // Retornar a view com os profissionais
        return view('professionals.index', compact('professionals'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('professionals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Professional::create($request->all());
        return to_route('professionals.index')->with('success', 'Professional cadastrado com sucesso!');
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Professional $professional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    //public function edit(Professional $professional)
    public function edit($id)
    {
        $professional = Professional::findOrFail($id);
        return view('professionals.edit', compact('professional'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validação dos campos
        $request->validate([
            'name' => 'required',
            'specialty' => 'required',
            'status' => 'required',
        ]);

        // Encontra o profissional existente
        $professional = Professional::findOrFail($id);

        // Atualiza o profissional com os novos dados
        $professional->update($request->all());

        // Definindo a mensagem de sucesso
        session()->flash('success', 'Profissional atualizado com sucesso!');

        // Redireciona para a listagem de profissionais
        return redirect()->route('professionals.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(Professional $professional)
    public function destroy($id)
    {
        $professional = Professional::findOrFail($id);
        $professional->delete();

        return redirect()->route('professionals.index')->with('success', 'Profissional excluído com sucesso.');
    }
}
