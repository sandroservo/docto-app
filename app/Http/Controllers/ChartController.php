<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        /// Quantidade de cirurgias por cidade 
        $surgeriesByCity = Surgery::with('city')
            ->select('citie_id', DB::raw('count(*) as total'))
            ->groupBy('citie_id')
            ->get();

        // Extrair nomes das cidades e números de cirurgias, verificando se a relação 'city' existe
        $cities = $surgeriesByCity->map(function ($surgery) {
            return $surgery->city ? $surgery->city->name : 'Cidade não definida';
        });

        $totalsByCity = $surgeriesByCity->pluck('total');

        // Cirurgias mais executadas
        $surgeriesByType = Surgery::with('surgery_type')
            ->select('surgery_id', DB::raw('count(*) as total'))
            ->groupBy('surgery_id')
            ->get();

        // Extrair nomes das cirurgias e números de cirurgias, verificando se a relação 'surgery_type' existe
        $surgeryTypes = $surgeriesByType->map(function ($surgery) {
            return $surgery->surgery_type ? $surgery->surgery_type->descricao : 'Tipo Desconhecido';
        });

        $totalsBySurgeryType = $surgeriesByType->pluck('total');

        return view('dashboard', compact('cities', 'totalsByCity', 'surgeryTypes', 'totalsBySurgeryType'));
    }
}
