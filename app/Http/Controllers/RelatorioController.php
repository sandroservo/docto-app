<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Surgery;
use App\Models\Surgery_type;
use Illuminate\Http\Request;
use PDF;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inicia a query para cirurgias 
        $query = Surgery::query();

        // Aplica os filtros de data, se fornecidos
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('date', [$request->input('data_inicio'), $request->input('data_fim')]);
        } elseif ($request->filled('data_inicio')) {
            $query->where('date', '>=', $request->input('data_inicio'));
        } elseif ($request->filled('data_fim')) {
            $query->where('date', '<=', $request->input('data_fim'));
        }

        // Ordena os resultados em ordem decrescente pelo campo `id`
        $surgeries = $query->orderByDesc('id')->paginate(10); // Paginação de 10 cirurgias por página

        return view('relatorio.index', compact('surgeries'));
    }




    public function gerarPdf()
    {
        // Carregar as cirurgias em ordem decrescente e com os relacionamentos necessários
        $surgeries = Surgery::with('cirurgiao', 'surgery_type')
            ->orderByDesc('date') // Substitua `date` pelo campo relevante para a ordenação
            ->get();

        // Carregar a view de PDF e passar os dados
        $pdf = PDF::loadView('relatorio.pdf', compact('surgeries'))
            ->setPaper('a4', 'landscape'); // Define o papel como A4 e orientação paisagem

        // Retornar o PDF para download
        return $pdf->stream('relatorio_cirurgias.pdf');
    }




    public function gerarPdfCirurgia($id)
    {

        // Buscar a cirurgia específica pelo ID e carregar os relacionamentos
        $surgery = Surgery::with(['cirurgiao', 'anestesista', 'pediatra', 'enfermeiro'])->findOrFail($id);
        // Buscar a cirurgia específica pelo ID
        //$surgery = Surgery::with('cirurgiao')->findOrFail($id);

        // Carregar a view de PDF e passar os dados
        $pdf = PDF::loadView('relatorio.detalhes', compact('surgery'));

        // Retornar o PDF para exibir no navegador
        return $pdf->stream('detalhes_cirurgia.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
