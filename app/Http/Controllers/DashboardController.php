<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Professional;
use App\Models\Surgery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }
    public function index(Request $request)
    {

        if (!$request->ajax()) {
            // Renderiza a página normal se a requisição não for AJAX
            $cities = City::all();
            $professionals = Professional::all();
            return view('bi.index', compact('cities', 'professionals'));
        }

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $cityId = $request->query('city');
        $professionalId = $request->query('professional');

        // Filtrar as Cirurgias mais executadas
        $mostExecutedSurgeries = Surgery::select('name', \DB::raw('count(*) as total'))
            ->when($startDate, fn($query) => $query->where('date', '>=', $startDate))
            ->when($endDate, fn($query) => $query->where('date', '<=', $endDate))
            ->when($cityId, fn($query) => $query->where('citie_id', $cityId))
            ->groupBy('name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Filtrar Profissionais com mais participações
        $topProfessionals = Professional::join('surgeries', 'professionals.id', '=', 'surgeries.cirurgiao_id')
            ->select('professionals.name', \DB::raw('count(surgeries.id) as total_participation'))
            ->when($startDate, fn($query) => $query->where('surgeries.date', '>=', $startDate))
            ->when($endDate, fn($query) => $query->where('surgeries.date', '<=', $endDate))
            ->when($cityId, fn($query) => $query->where('surgeries.citie_id', $cityId))
            ->groupBy('professionals.name')
            ->orderByDesc('total_participation')
            ->limit(5)
            ->get();



        // Filtrar Cidades com maior quantidade de cirurgias
        $topCities = City::join('surgeries', 'cities.id', '=', 'surgeries.citie_id')
            ->select('cities.name', \DB::raw('count(surgeries.id) as total_surgeries'))
            ->when($startDate, fn($query) => $query->where('surgeries.date', '>=', $startDate))
            ->when($endDate, fn($query) => $query->where('surgeries.date', '<=', $endDate))
            ->when($professionalId, fn($query) => $query->where('surgeries.professional_id', $professionalId))
            ->groupBy('cities.name')
            ->orderByDesc('total_surgeries')
            ->limit(5)
            ->get();

        return response()->json([
            'mostExecutedSurgeries' => [
                'labels' => $mostExecutedSurgeries->pluck('name'),
                'data' => $mostExecutedSurgeries->pluck('total')
            ],
            'topProfessionals' => [
                'labels' => $topProfessionals->pluck('name'),
                'data' => $topProfessionals->pluck('total_participation')
            ],
            'topCities' => [
                'labels' => $topCities->pluck('name'),
                'data' => $topCities->pluck('total_surgeries')
            ]
        ]);

        
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
