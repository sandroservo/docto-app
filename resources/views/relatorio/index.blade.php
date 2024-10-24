<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Relatório de Cirurgias') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <!-- Botão para gerar PDF de todas as cirurgias -->
                    <div class="mb-4 flex justify-start">
                        <button id="btn-exibir-pdf-completo" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                            Exibir Relatório Completo (PDF)
                        </button>
                    </div>

                    <!-- Filtro de Data -->
                    <div class="mb-4 flex justify-between items-center">
                        <form method="GET" action="{{ route('relatorio.index') }}" class="flex space-x-4">
                            <input type="date" name="data_inicio" class="px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" value="{{ request('data_inicio') }}">
                            <input type="date" name="data_fim" class="px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300" value="{{ request('data_fim') }}">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filtrar</button>
                        </form>
                    </div>

                    <!-- Tabela de Relatório de Cirurgias -->
                    <div id="lista-cirurgias" class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Paciente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Idade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Cirurgião</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Hora</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status Social</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($surgeries as $surgery)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->age }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->cirurgiao->name ?? 'Não informado' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($surgery->date)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->time }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $surgery->social_status }}</td>
                                        <!-- Botão Detalhes -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button class="btn-detalhes bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700" data-id="{{ $surgery->id }}">
                                                Detalhes
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Linha oculta para exibir o PDF -->
                                    <tr id="pdf-container-{{ $surgery->id }}" style="display: none;">
                                        <td colspan="8">
                                            <iframe id="pdf-viewer-{{ $surgery->id }}" src="" style="width: 100%; height: 600px; border: none;"></iframe>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div id="paginacao" class="mt-4">
                        {{ $surgeries->links() }}
                    </div>

                    <!-- Seção para exibir o PDF completo -->
                    <div class="mt-6" id="pdf-container-completo" style="display: none;">
                        <iframe id="pdf-viewer-completo" src="" style="width: 100%; height: 600px; border: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Para exibir o PDF completo ao clicar no botão "Exibir Relatório Completo"
        document.getElementById('btn-exibir-pdf-completo').addEventListener('click', function () {
            // Esconde a lista de cirurgias e a paginação
            document.getElementById('lista-cirurgias').style.display = 'none';
            document.getElementById('paginacao').style.display = 'none';

            // Exibe o iframe com o PDF completo
            var iframeCompleto = document.getElementById('pdf-viewer-completo');
            iframeCompleto.src = "{{ route('relatorio.pdf') }}"; // Carrega o PDF geral pela rota
            document.getElementById('pdf-container-completo').style.display = 'block'; // Exibe o container do PDF
        });

        // Para exibir o PDF individual ao clicar no botão Detalhes
        document.querySelectorAll('.btn-detalhes').forEach(function(button) {
            button.addEventListener('click', function() {
                var surgeryId = this.getAttribute('data-id');
                var pdfContainer = document.getElementById('pdf-container-' + surgeryId);
                var iframe = document.getElementById('pdf-viewer-' + surgeryId);

                // Verifica se o PDF já está visível e alterna a exibição
                if (pdfContainer.style.display === 'none') {
                    // Carregar o PDF correspondente
                    iframe.src = "{{ url('relatorio/cirurgia') }}/" + surgeryId + "/pdf";
                    // Exibe a linha do PDF
                    pdfContainer.style.display = 'table-row';
                } else {
                    // Ocultar o PDF se já estiver visível
                    pdfContainer.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
