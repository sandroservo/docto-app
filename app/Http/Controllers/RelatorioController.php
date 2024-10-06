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
        // Filtros de data (opcionais)
        $query = Surgery::query('cirurgiao');

        if ($request->filled('admission_date') && $request->filled('admission_date')) {
            $query->whereBetween('date', [$request->admission_date, $request->admission_date]);
        }

        $surgeries = $query->paginate(10); // Paginação de 10 cirurgias por página

        return view('relatorio.index', compact('surgeries'));
    }

    public function gerarPdf()
    {
        // Carregar as cirurgias (carregar a relação cirurgião também)
        $surgeries = Surgery::with('cirurgiao','surgery_type')->get();

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
