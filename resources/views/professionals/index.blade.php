<x-app-layout>   
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">

            <!-- Exibir mensagem de sucesso -->
            @if (session('success'))
                <div class="bg-green-500 text-white font-bold px-4 py-3 mb-8 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cabeçalho, Campo de Pesquisa e Botão Adicionar -->
            <div class="mb-8 flex justify-between items-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Lista de Profissionais</h2>

                <!-- Formulário de Pesquisa -->
                <form action="{{ route('professionals.index') }}" method="GET" class="flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full sm:w-64 px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:text-white"
                           placeholder="Buscar por nome...">
                    <button type="submit"
                            class="ml-3 px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-700">
                        Buscar
                    </button>
                </form>

                <!-- Botão de Adicionar Profissional -->
                <a href="{{ route('professionals.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 active:bg-blue-800 transition ease-in-out duration-150">
                    Adicionar Profissional
                </a>
            </div>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nome</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Especialidade</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Ações</th>
                    </tr>
                </thead>
                @php
                    $especialidades = [
                        'C' => 'Cirurgião',
                        'A' => 'Anestesista',
                        'E' => 'Enfermeiro',
                        'P' => 'Pediatra',
                    ];
                @endphp

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($professionals as $professional)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $professional->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $especialidades[$professional->specialty] ?? 'Especialidade desconhecida' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ $professional->status == 'Y' ? 'text-green-500' : 'text-red-500' }} dark:text-gray-100">
                                {{ $professional->status == 'Y' ? 'Ativo' : 'Inativo' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('professionals.edit', $professional->id) }}"
                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                    Editar
                                </a>

                                <button type="button"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 ml-4"
                                        onclick="openModal({{ $professional->id }});">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $professionals->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="deleteModal" class="fixed inset-0  items-center justify-center bg-gray-900 bg-opacity-75 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Confirmação</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Tem certeza de que deseja excluir este profissional?</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal();"
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancelar</button>
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Excluir</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function openModal(id) {
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/professionals/${id}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
