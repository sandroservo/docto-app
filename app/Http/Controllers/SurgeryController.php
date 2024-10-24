<?php

namespace App\Http\Controllers;

//declare(strict_types=1);

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use PDF; // Importar o DomPDF
use App\Models\City;
use App\Models\Indication;
use App\Models\Professional;
use App\Models\State;
use App\Models\Surgery;
use App\Models\Surgery_type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SurgeryController extends Controller
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View

    {
        // Pega o valor da busca
        $search = $request->input('search');

        // Cria a query para listar as cirurgias
        $query = Surgery::query();

        // Se houver busca, filtra por nome do paciente
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Ordena pelo ID, do mais recente (maior ID) para o mais antigo (menor ID)
        $surgeryRecord = $query->orderBy('id', 'desc')->paginate(10);

        // Retorna a view com os registros e o campo de busca
        return view('surgeries.index', compact('surgeryRecord'));
    }

    public function getCities($id)
    {
        // Buscar as cidades relacionadas ao estado selecionado
    // Supondo que 'state_id' seja a chave estrangeira na tabela cities
    $cities = City::where('state', $id)->get(['id', 'name']);

    // Retornar as cidades em formato JSON
    return response()->json($cities);
    }

    

    public function report($id)


    {
        // Buscar o registro da cirurgia com base no ID
        $surgeryRecord = Surgery::with('state', 'city', 'indication', 'surgery_type', 'user', 'professional')->findOrFail($id);

        // Buscar os profissionais por especialidade
        $anestesista = Professional::where('specialty', 'A')->where('id', $surgeryRecord->anestesista_id)->first();
        $cirurgiao = Professional::where('specialty', 'C')->where('id', $surgeryRecord->cirurgiao_id)->first();
        $pediatra = Professional::where('specialty', 'P')->where('id', $surgeryRecord->pediatra_id)->first();
        $enfermeiro = Professional::where('specialty', 'E')->where('id', $surgeryRecord->enfermeiro_id)->first();

        // Retornar a view do relatório com os dados
        return view('surgeries.report', compact('surgeryRecord', 'anestesista', 'cirurgiao', 'pediatra', 'enfermeiro'));
        
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Obtenha a lista de estados do banco de dados
        $users = User::all();
        $states = State::all();
        $cities = City::all(); // Buscar todas as cidades
        //$indications = Indication::all(); // Buscar todas as cidades
        $indications = Indication::orderBy('descricao', 'asc')->get();
        $surgery_types = Surgery_type::orderBy('descricao', 'asc')->get();
        $professionals = Professional::all();
        //dd($professionals);
        // Carregar cirurgias com suas relações e paginar os resultados
        $surgeryRecords = Surgery::with(['state', 'city', 'indication', 'surgery_type', 'user', 'professional'])->paginate(10);

        // Retornar a view de listagem, passando os registros para a view
        return view('surgery_form.index', compact('surgeryRecords', 'users', 'states', 'cities', 'surgery_types', 'indications', 'professionals'));
    }

    public function register()
    {


        return view('register-cad.index');
    }

    public function storeSurgery(Request $request)
    {
        // Validação do campo
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        // Criação da nova cirurgia
        $cirurgia = Surgery_type::create([
            'descricao' => $request->descricao,
        ]);

        // Retornar a cirurgia criada em formato JSON
        return response()->json($cirurgia);
    }

    public function storeIndication(Request $request)
    {
        // Validação
        $request->validate([
            'descricao' => 'required|string|max:255',
        ]);

        // Criar nova indicação
        $indication = Indication::create([
            'descricao' => $request->descricao,
        ]);

        // Retornar a nova indicação em formato JSON
        return response()->json($indication);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'name' => 'required|string|max:255',
            'age' => 'required|string|max:3', // Liste todas as idades possíveis aqui
            'state_id' => 'required|exists:states,id',
            'citie_id' => 'required|exists:cities,id',
            'medical_record' => 'required|string|max:50',
            'origin_department' => 'nullable|string|max:255',
            'indication_id' => 'nullable|exists:indications,id',
            'anestesista_id' => 'nullable|exists:professionals,id',
            'cirurgiao_id' => 'nullable|exists:professionals,id',

            'pediatra_id' => 'nullable|exists:professionals,id',

            'enfermeiro_id' => 'nullable|exists:professionals,id',
            'anesthesia' => 'required|string|max:255',
            'surgery_id' => 'required|exists:surgery_types,id',
            'admission_date' => 'required|date',
            'admission_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',

            'apgar' => 'nullable|string|max:255',
            'ligadura' => 'nullable|boolean',
            'social_status' => 'nullable|string|max:50',
        ]);


        
        $request->user()->surgeries()->create($validated);
        //dd($validated);
        return to_route('surgeries.index')->with('success', 'Cirurgia cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surgery $surgery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Surgery $surgery)

    {

        //$this->authorize('update', $surgery);

        
        // Carrega todos os usuários, estados, profissionais, tipos de cirurgia, etc.
        $users = User::all();
        $states = State::all();
        $cities = City::all(); // Carregar apenas cidades do estado selecionado
        $indications = Indication::all();
        $surgery_types = Surgery_type::all();
        $professionals = Professional::all();

        $enfermeiros = Professional::where('specialty', 'E')->get();

        // dd($surgery);

        return view('surgery_form.edit', compact('surgery', 'users', 'professionals', 'enfermeiros', 'states', 'cities', 'surgery_types', 'indications'));
    }


    

public function update(Request $request, Surgery $surgery)
{
    // Remova a linha do authorize se não estiver utilizando Policies.
    //$this->authorize('update', $surgery);

    // Formatar admission_time e end_time antes da validação, se estiverem preenchidos
    if ($request->filled('time')) {
        $request->merge([
            'time' => \Carbon\Carbon::parse($request->input('time'))->format('H:i')
        ]);
    }
    if ($request->filled('admission_time')) {
        $request->merge([
            'admission_time' => \Carbon\Carbon::parse($request->input('admission_time'))->format('H:i')
        ]);
    }

    if ($request->filled('end_time')) {
        $request->merge([
            'end_time' => \Carbon\Carbon::parse($request->input('end_time'))->format('H:i')
        ]);
    }

    // Validação dos dados
    $validated = $request->validate([
        'date' => 'required|date',
        'time' => 'nullable|date_format:H:i',
        'name' => 'required|string|max:255',
        'age' => 'required|regex:/^\d{1,2}[dma]$/', // Validação do formato "1d", "2m", "3a"
        'state_id' => 'required|exists:states,id',
        'citie_id' => 'required|exists:cities,id',
        'medical_record' => 'required|string|max:50',
        'origin_department' => 'required|string|max:255',
        'indication_id' => 'required|exists:indications,id',
        'anestesista_id' => 'required|exists:professionals,id',
        'cirurgiao_id' => 'required|exists:professionals,id',
        'pediatra_id' => 'nullable|exists:professionals,id', // Descomentado caso necessário
        'enfermeiro_id' => 'required|exists:professionals,id',
        'anesthesia' => 'required|string|max:255',
        'surgery_id' => 'required|exists:surgery_types,id',
        'admission_date' => 'required|date',
        'admission_time' => 'nullable|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i',
        'apgar' => 'nullable|integer|min:0|max:10', // Descomentado caso necessário
        'ligation' => 'required|boolean',
        'social_status' => 'nullable|string|max:50', // Permitindo null
    ]);

    // Atualiza os dados da cirurgia com os valores validados
    $surgery->update($validated);

    // Redireciona para a lista de cirurgias após a atualização
    return redirect()->route('surgeries.index')->with('success', 'Cirurgia atualizada com sucesso!');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surgery $surgery)
    {
        // Buscar o registro da cirurgia pelo ID
        //$surgery = Surgery::findOrFail($id);

        // Deletar a cirurgia
        $surgery->delete();

        // Redirecionar de volta para a lista com mensagem de sucesso
        return redirect()->route('surgeries.index')->with('success', 'Cirurgia excluída com sucesso!');
    }
}
