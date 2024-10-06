<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                        Lista de Cirurgias Registradas
                    </h2>

                    <!-- Campo de Pesquisa (com tamanho maior) -->
                    <form method="GET" action="{{ route('surgeries.index') }}" class="flex w-full max-w-lg">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por paciente"
                               class="border border-gray-300 p-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 w-2/3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 w-1/3">
                            Buscar
                        </button>
                    </form>

                    <a href="{{ route('surgeries.create') }}" class="inline-flex items-center bg-green-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-green-600 dark:hover:bg-green-500 ml-4">
                        <span class="mr-2 text-lg font-bold">+</span> Adicionar
                    </a>
                </div>

                <!-- MENSAGEM DE SUCESSO -->
                @if (session('success'))
                    <div class="bg-green-500 dark:bg-green-600 text-white p-4 rounded-md shadow-md mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome do Paciente</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hora</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cidade</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($surgeryRecord as $record)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $record->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $record->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($record->data)->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $record->time }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $record->city ? $record->city->name : 'Cidade não definida' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $record->state ? $record->state->name : 'Cidade não definida' }}</td>
                                                
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <a href="{{ route('surgeries.report', $record->id) }}" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500 mr-4">
                                                        <i class="fas fa-file-pdf"></i> Detalhes
                                                    </a>
                                                    <a href="{{ route('surgeries.edit', $record->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-500 mr-4">Editar</a>
                                                    
                                                    <!-- Botão de exclusão com modal -->
                                                    <button onclick="openModal({{ $record->id }})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500">Excluir</button>

                                                    <!-- Formulário oculto de exclusão -->
                                                    <form id="delete-form-{{ $record->id }}" action="{{ route('surgeries.destroy', $record->id) }}" method="POST" class="hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginação -->
                            <div class="mt-4">
                                {{ $surgeryRecord->appends(['search' => request('search')])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmationModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Confirmar Exclusão
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Tem certeza de que deseja excluir esta cirurgia? Essa ação não pode ser desfeita.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Sim, excluir
                    </button>
                    <button onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-600 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                        Não, cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let formId = null;

        function openModal(id) {
            formId = id; // Armazenar o ID do formulário a ser excluído
            document.getElementById('confirmationModal').classList.remove('hidden');
        }

        function closeModal() {
            formId = null; // Limpar o ID armazenado
            document.getElementById('confirmationModal').classList.add('hidden');
        }

        document.getElementById('confirmDelete').addEventListener('click', function () {
            if (formId) {
                // Submeter o formulário de exclusão
                document.getElementById('delete-form-' + formId).submit();
            }
        });
    </script>
</x-app-layout>
