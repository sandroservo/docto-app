<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-blue-600 dark:text-blue-400">Relatório de Cirurgia</h1>
                    <!-- Botão de voltar -->
                    <a href="{{ url('/surgeries') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Voltar
                    </a>
                </div>

                <!-- Dados do Paciente -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">Dados do Paciente</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Nome:</strong> {{ $surgeryRecord->name }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Data:</strong> {{ \Carbon\Carbon::parse($surgeryRecord->date)->format('d/m/Y') }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Hora:</strong> {{ $surgeryRecord->time }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Idade:</strong> {{ $surgeryRecord->age }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Cidade:</strong> {{ $surgeryRecord->city->name }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Estado:</strong> {{ $surgeryRecord->state->name }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Prontuário:</strong> {{ $surgeryRecord->medical_record }}</p>
                    </div>
                </div>

                <!-- Profissionais Envolvidos -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">Profissionais Envolvidos</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Anestesista:</strong> {{ $anestesista ? $anestesista->name : 'Não informado' }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Cirurgião:</strong> {{ $cirurgiao ? $cirurgiao->name : 'Não informado' }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Pediatra:</strong> {{ $pediatra ? $pediatra->name : 'Não informado' }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Enfermeiro:</strong> {{ $enfermeiro ? $enfermeiro->name : 'Não informado' }}</p>
                    </div>
                </div>

                <!-- Dados da Cirurgia -->
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 border-b pb-2 mb-4">Dados da Cirurgia</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Cirurgia:</strong> {{ $surgeryRecord->surgery_type->descricao }}</p>
                        <p class="text-white"><strong>Anestesia:</strong> 
                            @php
                                $anesthesiaTypes = [
                                    'RA' => 'Raque-anestesia',
                                    'S' => 'Sedação',
                                    'GE' => 'Geral Entubada',
                                    'I' => 'Inalatória',
                                    'L' => 'Local'
                                ];
                            @endphp
                            {{ isset($anesthesiaTypes[$surgeryRecord->anesthesia]) ? $anesthesiaTypes[$surgeryRecord->anesthesia] : 'Não informado' }}
                        </p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Data de Admissão:</strong> {{ \Carbon\Carbon::parse($surgeryRecord->admission_date)->format('d/m/Y') }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Hora de Admissão:</strong> {{ $surgeryRecord->admission_time }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Hora de Término:</strong> {{ $surgeryRecord->end_time }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Apgar:</strong> {{ $surgeryRecord->apgar }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Ligadura:</strong> {{ $surgeryRecord->ligation ? 'Sim' : 'Não' }}</p>
                        <p class="text-white"><strong class="text-gray-600 dark:text-gray-400">Status Social:</strong> {{ $surgeryRecord->social_status }}</p>
                    </div>
                </div>

                <!-- Informações de rodapé -->
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Relatório gerado em {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
