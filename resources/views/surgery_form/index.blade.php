<x-app-layout>
    <!-- Notificação Toast (inicialmente oculto) -->
    <div id="toast"
        class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-0 transition-opacity duration-300"
        style="display: none;">
        <span id="toast-message"></span>
    </div>

    <!-- Removendo a margem e ajustando o padding para aproximar o formulário da barra de menu -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-gray-100">Cadastro de Cirurgias
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Preencha os dados do paciente e da cirurgia abaixo.
                </p>
            </div>

            <!-- MENSAGEM DE SUCESSO -->
            @if (session('success'))
                <div class="bg-green-500 dark:bg-green-600 text-white p-4 rounded-md shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('surgeries.store') }}" class="space-y-6">
                @csrf
                @if (isset($surgeryRecord))
                    @method('PUT')
                @endif

                <!-- Data e Hora -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                    <!-- Data -->
                    <div class="md:col-span-1">
                        <x-input-label for="date" :value="__('Data')" class="dark:text-gray-300" />
                        <x-text-input id="date"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="date" name="date" value="{{ old('date', $surgeryRecord->date ?? '') }}" />
                        <x-input-error :messages="$errors->get('date')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Hora -->
                    <div class="md:col-span-1">
                        <x-input-label for="time" :value="__('Hora')" class="dark:text-gray-300" />
                        <x-text-input id="time"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="time" name="time" value="{{ old('time', $surgeryRecord->time ?? '') }}" />
                        <x-input-error :messages="$errors->get('time')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Nome do Paciente -->
                    <div class="md:col-span-4">
                        <x-input-label for="name" :value="__('Nome do Paciente')" class="dark:text-gray-300" />
                        <x-text-input id="name"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="text" name="name" value="{{ old('name', $surgeryRecord->name ?? '') }}"
                            placeholder="Nome completo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-red-400" />
                    </div>
                </div>

                <!-- Idade, Estado, Cidade e Prontuário -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Idade -->
                    @php
                        // Definindo as faixas de idades de forma programática
                        $idades = [
                            'd' => range(1, 31), // Dias: 1d até 31d
                            'm' => range(1, 12), // Meses: 1m até 12m
                            'a' => range(1, 90), // Anos: 1a até 90a
                        ];
                    @endphp

                    <!-- Idade -->
                    <div>
                        <x-input-label for="age" :value="__('Idade')" class="dark:text-gray-300" />

                        <select id="age" name="age"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione a Idade --</option>

                            <!-- Opções para dias -->
                            @foreach ($idades['d'] as $dia)
                                <option value="{{ $dia . 'd' }}"
                                    {{ old('age', $surgeryRecord->age ?? '') == $dia . 'd' ? 'selected' : '' }}>
                                    {{ $dia . 'd' }}
                                </option>
                            @endforeach

                            <!-- Opções para meses -->
                            @foreach ($idades['m'] as $mes)
                                <option value="{{ $mes . 'm' }}"
                                    {{ old('age', $surgeryRecord->age ?? '') == $mes . 'm' ? 'selected' : '' }}>
                                    {{ $mes . 'm' }}
                                </option>
                            @endforeach

                            <!-- Opções para anos -->
                            @foreach ($idades['a'] as $ano)
                                <option value="{{ $ano . 'a' }}"
                                    {{ old('age', $surgeryRecord->age ?? '') == $ano . 'a' ? 'selected' : '' }}>
                                    {{ $ano . 'a' }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('age')" class="mt-2 dark:text-red-400" />
                    </div>


                    <!-- Estado -->
                    <div>
                        <x-input-label for="state_id" :value="__('Estado')" class="dark:text-gray-300" />
                        <select id="state_id" name="state_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione o Estado --</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}"
                                    {{ old('state_id', $surgeryRecord->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('state_id')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Cidade -->
                    <div>
                        <x-input-label for="citie_id" :value="__('Cidade')" class="dark:text-gray-300" />
                        <select id="citie_id" name="citie_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione a Cidade --</option>
                            @if (old('citie_id') || isset($surgeryRecord->citie_id))
                                <!-- Exibir temporariamente a cidade que será substituída via AJAX -->
                                <option value="{{ old('citie_id', $surgeryRecord->citie_id ?? '') }}" selected>
                                    Carregando cidade...
                                </option>
                            @endif
                        </select>
                        <x-input-error :messages="$errors->get('citie_id')" class="mt-2 dark:text-red-400" />
                    </div>


                    <!-- Prontuário -->
                    <div>
                        <x-input-label for="medical_record" :value="__('Prontuário')" class="dark:text-gray-300" />
                        <x-text-input id="medical_record"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="text" name="medical_record" :value="old('medical_record', $surgeryRecord->medical_record ?? '')"
                            placeholder="Número do prontuário" />
                        <x-input-error :messages="$errors->get('medical_record')" class="mt-2 dark:text-red-400" />
                    </div>
                </div>

                <!-- Origem do Setor, Anestesia, Apgar, Ligadura -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Origem do Setor -->
                    <div>
                        <x-input-label for="origin_department" :value="__('Origem do Setor')" class="dark:text-gray-300" />
                        <select id="origin_department" name="origin_department"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="CPM"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'CPM' ? 'selected' : '' }}>
                                CPM</option>
                            <option value="OBS"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'OBS' ? 'selected' : '' }}>
                                OBS</option>
                            <option value="ALCON"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'ALCON' ? 'selected' : '' }}>
                                ALCON</option>
                            <option value="ALTO_RISCO"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'ALTO_RISCO' ? 'selected' : '' }}>
                                ALTO RISCO</option>
                            <option value="ADN"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'ADN' ? 'selected' : '' }}>
                                ADN</option>
                            <option value="HC"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'HC' ? 'selected' : '' }}>
                                HC</option>
                            <option value="PA"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'PA' ? 'selected' : '' }}>
                                PA</option>
                            <option value="UTI"
                                {{ old('origin_department', $surgeryRecord->origin_department ?? '') == 'UTI' ? 'selected' : '' }}>
                                UTI</option>
                        </select>
                        <x-input-error :messages="$errors->get('origin_department')" class="mt-2 dark:text-red-400" />

                    </div>

                    <!-- Indicação -->
                    <div>
                        <x-input-label for="indication_id" :value="__('Indicação')" class="dark:text-gray-300" />
                        <select id="indication_id" name="indication_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="add-indication">-- adicionar --</option>
                            @foreach ($indications as $indication)
                                <option value="{{ $indication->id }}"
                                    {{ isset($surgeryRecord) && $surgeryRecord->indication_id == $indication->id ? 'selected' : '' }}>
                                    {{ $indication->descricao }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('indication_id')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Anestesia -->
                    <div>
                        <x-input-label for="anesthesia" :value="__('Anestesia')" class="dark:text-gray-300" />
                        <select id="anesthesia" name="anesthesia"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="RA"
                                {{ old('anesthesia', $surgeryRecord->anesthesia ?? '') == 'RA' ? 'selected' : '' }}>
                                Raque-anestesia</option>
                            <option value="S"
                                {{ old('anesthesia', $surgeryRecord->anesthesia ?? '') == 'S' ? 'selected' : '' }}>
                                Sedação</option>
                            <option value="GE"
                                {{ old('anesthesia', $surgeryRecord->anesthesia ?? '') == 'GE' ? 'selected' : '' }}>
                                Geral Entubada</option>
                            <option value="I"
                                {{ old('anesthesia', $surgeryRecord->anesthesia ?? '') == 'I' ? 'selected' : '' }}>
                                Inalatória</option>
                            <option value="L"
                                {{ old('anesthesia', $surgeryRecord->anesthesia ?? '') == 'L' ? 'selected' : '' }}>
                                Local</option>
                        </select>
                        <x-input-error :messages="$errors->get('anesthesia')" class="mt-2 dark:text-red-400" />

                    </div>



                    <!-- Anestesista -->
                    <div>
                        <x-input-label for="anestesista_id" :value="__('Anestesista')" class="dark:text-gray-300" />
                        <select id="anestesista_id" name="anestesista_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            @foreach ($professionals as $profissional)
                                @if ($profissional->specialty == 'A')
                                    <option value="{{ $profissional->id }}"
                                        {{ old('anestesista_id', $surgeryRecord->anestesista_id ?? '') == $profissional->id ? 'selected' : '' }}>
                                        {{ $profissional->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('anestesista_id')" class="mt-2 dark:text-red-400" />

                    </div>
                </div>
                <!-- Origem do Setor, Anestesia, Apgar, Ligadura -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <div>
                        <x-input-label for="surgery_id" :value="__('Cirurgia')" class="dark:text-gray-300" />
                        <select id="surgery_id" name="surgery_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="add-option">-- adicionar --</option>
                            @foreach ($surgery_types as $surgery)
                                <option value="{{ $surgery->id }}"
                                    {{ old('surgery_id', $surgeryRecord->surgery_id ?? '') == $surgery->id ? 'selected' : '' }}>
                                    {{ $surgery->descricao }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('surgery_id')" class="mt-2 dark:text-red-400" />

                    </div>

                    <!-- Anestesia -->
                    <div>
                        <x-input-label for="cirurgiao_id" :value="__('Cirurgião')" class="dark:text-gray-300" />
                        <select id="cirurgiao_id" name="cirurgiao_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            @foreach ($professionals as $cirurgiao)
                                @if ($cirurgiao->specialty == 'C')
                                    <option value="{{ $cirurgiao->id }}"
                                        {{ old('cirurgiao_id', $surgeryRecord->cirurgiao_id ?? '') == $cirurgiao->id ? 'selected' : '' }}>
                                        {{ $cirurgiao->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('cirurgiao_id')" class="mt-2 dark:text-red-400" />

                    </div>


                    <!-- Apgar -->
                    <div>
                        <x-input-label for="pediatra_id" :value="__('Pediatra')" class="dark:text-gray-300" />
                        <select id="pediatra_id" name="pediatra_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            @foreach ($professionals as $profissional)
                                @if ($profissional->specialty == 'P')
                                    <option value="{{ $profissional->id }}"
                                        {{ old('pediatra_id', $surgeryRecord->pediatra_id ?? '') == $profissional->id ? 'selected' : '' }}>
                                        {{ $profissional->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('pediatra_id')" class="mt-2 dark:text-red-400" />

                    </div>

                    <!-- Enfermeiro -->
                    <div>
                        <x-input-label for="enfermeiro_id" :value="__('Enfermeiro')" class="dark:text-gray-300" />
                        <select id="enfermeiro_id" name="enfermeiro_id"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            @foreach ($professionals as $profissional)
                                @if ($profissional->specialty == 'E')
                                    <option value="{{ $profissional->id }}"
                                        {{ old('enfermeiro_id', $surgeryRecord->enfermeiro_id ?? '') == $profissional->id ? 'selected' : '' }}>
                                        {{ $profissional->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('enfermeiro_id')" class="mt-2 dark:text-red-400" />

                    </div>

                </div>

                <!-- Data, Hora de Admissão e Hora de Término -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <!-- Data de Admissão -->
                    <div>
                        <x-input-label for="admission_date" :value="__('Data de Admissão')" class="dark:text-gray-300" />
                        <x-text-input id="admission_date"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="date" name="admission_date" :value="old('admission_date', $surgeryRecord->admission_date ?? '')" />
                        <x-input-error :messages="$errors->get('admission_date')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Hora de Admissão -->
                    <div>
                        <x-input-label for="admission_time" :value="__('Hora de Admissão')" class="dark:text-gray-300" />
                        <x-text-input id="admission_time"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="time" name="admission_time" :value="old('admission_time', $surgeryRecord->admission_time ?? '')" />
                        <x-input-error :messages="$errors->get('admission_time')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Hora de Término -->
                    <div>
                        <x-input-label for="end_time" :value="__('Hora de Término')" class="dark:text-gray-300" />
                        <x-text-input id="end_time"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            type="time" name="end_time" :value="old('end_time', $surgeryRecord->end_time ?? '')" />
                        <x-input-error :messages="$errors->get('end_time')" class="mt-2 dark:text-red-400" />
                    </div>

                    <!-- Apgar -->
                    <div>
                        <x-input-label for="apgar" :value="__('Apgar')" class="dark:text-gray-300" />
                        <select id="apgar" name="apgar"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>

                            <!-- Opções numéricas geradas pelo loop -->
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}"
                                    {{ old('apgar', $surgeryRecord->apgar ?? '') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor

                            <!-- Opções adicionais -->
                            <option value="FM"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == 'FM' ? 'selected' : '' }}>FM</option>
                            <option value="1M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '1M' ? 'selected' : '' }}>1M</option>
                            <option value="2M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '2M' ? 'selected' : '' }}>2M</option>
                            <option value="3M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '3M' ? 'selected' : '' }}>3M</option>
                            <option value="4M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '4M' ? 'selected' : '' }}>4M</option>
                            <option value="5M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '5M' ? 'selected' : '' }}>5M</option>
                            <option value="6M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '6M' ? 'selected' : '' }}>6M</option>
                            <option value="7M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '7M' ? 'selected' : '' }}>7M</option>
                            <option value="8M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '8M' ? 'selected' : '' }}>8M</option>
                            <option value="9M"
                                {{ old('apgar', $surgeryRecord->apgar ?? '') == '9M' ? 'selected' : '' }}>9M</option>


                        </select>

                        {{-- <x-input-error :messages="$errors->get('apgar')" class="mt-2 dark:text-red-400" /> --}}
                    </div>
                    <!-- Ligadura -->
                    <div>
                        <x-input-label for="ligadura" :value="__('Ligadura')" class="dark:text-gray-300" />
                        <select id="ligadura" name="ligadura"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="1"
                                {{ old('ligadura', $surgeryRecord->ligation ?? '') == '1' ? 'selected' : '' }}>Sim
                            </option>
                            <option value="0"
                                {{ old('ligadura', $surgeryRecord->ligation ?? '') == '0' ? 'selected' : '' }}>Não
                            </option>
                        </select>
                        {{-- <x-input-error :messages="$errors->get('ligadura')" class="mt-2 dark:text-red-400" /> --}}
                    </div>

                    <!-- Social -->
                    <div>
                        <x-input-label for="social_status" :value="__('Social')" class="dark:text-gray-300" />
                        <select id="social_status" name="social_status"
                            class="block mt-1 w-full dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                            <option value="">-- Selecione --</option>
                            <option value="A"
                                {{ old('social_status', $surgeryRecord->social_status ?? '') == 'A' ? 'selected' : '' }}>
                                Alta
                            </option>
                            <option value="M"
                                {{ old('social_status', $surgeryRecord->social_status ?? '') == 'M' ? 'selected' : '' }}>
                                Média
                            </option>
                            <option value="B"
                                {{ old('social_status', $surgeryRecord->social_status ?? '') == 'B' ? 'selected' : '' }}>
                                Baixa
                            </option>
                            <option value="ND" {{ old('social_status', $surgery->social_status ?? '') == 'ND' ? 'selected' : '' }}>Não definido</option>
                        </select>
                        <x-input-error :messages="$errors->get('social_status')" class="mt-2 dark:text-red-400" />

                    </div>
                </div>

                <!-- Botão de Enviar -->
                <div class="flex space-x-4">
                    <!-- Botão de Cadastrar -->
                    <x-primary-button
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold py-3 px-4 rounded-md shadow-lg hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-4 text-center focus:ring-blue-300 dark:focus:ring-blue-800 transition duration-300">
                        {{ isset($surgeryRecord) ? 'Atualizar Cirurgia' : 'Cadastrar Cirurgia' }}
                    </x-primary-button>

                    <!-- Botão de Cancelar -->
                    <a href="{{ route('surgeries.store') }}"
                        class="w-full bg-gray-500 text-white font-bold py-3 px-4 rounded-md shadow-lg hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-800 transition duration-300 text-center">
                        Cancelar
                    </a>
                </div>
            </form>
            <!-- Modal para adicionar nova cirurgia -->
            <div
                id="addModal"class="hidden fixed z-50 inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center">
                <div class="modal-content bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-1/3">
                    <h2 class="text-xl font-semibold dark:text-gray-300">Adicionar Nova Cirurgia</h2>
                    <form id="addSurgeryForm">
                        @csrf <!-- CSRF token para Laravel -->
                        <div class="mt-4">
                            <label for="new_surgery"
                                class="block text-sm font-medium dark:text-gray-300">Descrição</label>
                            <input type="text" id="new_surgery" name="new_surgery"
                                class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border dark:border-gray-600 rounded-md"
                                required>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" id="closeModal"
                                class="bg-red-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal para adicionar nova indicação -->
            <div id="addIndicationModal"
                class="hidden fixed z-50 inset-0 bg-gray-600 bg-opacity-75 items-center justify-center">
                <div class="modal-content bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-1/3">
                    <h2 class="text-xl font-semibold dark:text-gray-300">Adicionar Nova Indicação</h2>
                    <form id="addIndicationForm">
                        @csrf <!-- CSRF token para Laravel -->
                        <div class="mt-4">
                            <label for="new_indication"
                                class="block text-sm font-medium dark:text-gray-300">Descrição</label>
                            <input type="text" id="new_indication" name="new_indication"
                                class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300 border dark:border-gray-600 rounded-md"
                                required>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" id="closeIndicationModal"
                                class="bg-red-500 text-white px-4 py-2 rounded-md mr-2">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/cities.js') }}"></script>
    <script src="{{ asset('js/addcirurgia.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var stateSelect = document.getElementById('state_id');
            var citySelect = document.getElementById('citie_id');
            var selectedCityId =
                "{{ old('citie_id', $surgeryRecord->citie_id ?? '') }}"; // Cidade selecionada anteriormente
            var stateIdOnLoad =
                "{{ old('state_id', $surgeryRecord->state_id ?? '') }}"; // Estado selecionado anteriormente

            // Função para carregar as cidades via AJAX
            function populateCitiesOnError(stateId, selectedCityId) {
                // Limpa o dropdown de cidades antes de popular
                citySelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                if (stateId) {
                    // Faz a requisição para buscar as cidades com base no estado selecionado
                    fetch('/get-cities/' + stateId)
                        .then(function(response) {
                            return response.json();
                        })
                        .then(function(cities) {
                            // Adiciona as cidades no dropdown
                            cities.forEach(function(city) {
                                var option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;

                                // Verifica se a cidade atual corresponde à cidade previamente selecionada
                                if (city.id == selectedCityId) {
                                    option.selected = true;
                                }

                                citySelect.appendChild(option);
                            });
                        })
                        .catch(function(error) {
                            console.error('Erro ao buscar cidades:', error);
                        });
                }
            }

            // Executar o AJAX apenas se houver um estado e cidade já selecionados (após erro de validação)
            if (stateIdOnLoad) {
                populateCitiesOnError(stateIdOnLoad,
                    selectedCityId); // Carrega as cidades com a cidade previamente selecionada
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const indicationModal = document.getElementById('addIndicationModal');
            const indicationSelectField = document.getElementById(
                'indication_id'); // Campo select da página principal
            const closeIndicationModalButton = document.getElementById('closeIndicationModal');
            const addIndicationForm = document.getElementById('addIndicationForm');
            const mainForm = document.getElementById('mainForm'); // Formulário principal

            // Quando o select muda de valor no campo "Indicação"
            indicationSelectField.addEventListener('change', function() {
                if (this.value === 'add-indication') {
                    indicationModal.classList.add('active'); // Exibe o modal
                    indicationModal.style.display = 'flex'; // Exibe o modal
                }
            });

            // Fechar o modal ao clicar no botão "Cancelar"
            closeIndicationModalButton.addEventListener('click', function() {
                indicationModal.classList.remove('active');
                indicationModal.style.display = 'none'; // Esconde o modal
                indicationSelectField.value = ""; // Reseta o select para "Selecione"
            });

            // Submissão do formulário para adicionar nova indicação
            addIndicationForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Previne a validação e submissão do formulário principal

                const newIndication = document.getElementById('new_indication').value;

                // Enviar os dados via AJAX para o backend
                fetch('/add-indication', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            descricao: newIndication
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Adicionar a nova indicação ao campo select com o ID retornado do backend
                        const newOption = document.createElement('option');
                        newOption.text = data.descricao;
                        newOption.value = data.id; // Usando o ID retornado do backend
                        indicationSelectField.add(newOption);
                        indicationSelectField.value = newOption.value; // Seleciona a nova indicação

                        // Fecha o modal e reseta o formulário do modal
                        addIndicationForm.reset();
                        indicationModal.style.display = 'none'; // Esconde o modal
                    })
                    .catch(error => {
                        console.error('Erro ao adicionar a indicação:', error);
                    });
            });

            // Submissão do formulário principal
            mainForm.addEventListener('submit', function(event) {
                // Validação e submissão do formulário principal
                console.log('Submetendo formulário principal');
            });
        });
    </script>

</x-app-layout>
