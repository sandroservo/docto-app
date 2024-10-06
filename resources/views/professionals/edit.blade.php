<x-app-layout> 
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-white">Editar Profissional</h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Atualize os dados do profissional abaixo.
                </p>
            </div>

            <!-- Formulário de Edição -->
            <form action="{{ route('professionals.update', $professional->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT') <!-- Usar método PUT para atualização -->

                <!-- Nome -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome Completo</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $professional->name) }}" class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Nome completo do profissional">
                    {{-- <x-input-error :messages="$errors->get('name')" class="mt-2" /> --}}
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Especialidade -->
                    <div>
                        <label for="specialty" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Especialidade</label>
                        <select id="specialty" name="specialty" class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="A" {{ $professional->specialty == 'A' ? 'selected' : '' }}>Anestesista</option>
                            <option value="C" {{ $professional->specialty == 'C' ? 'selected' : '' }}>Cirurgião</option>
                            <option value="P" {{ $professional->specialty == 'P' ? 'selected' : '' }}>Pediatra</option>
                            <option value="E" {{ $professional->specialty == 'E' ? 'selected' : '' }}>Enfermeiro</option>
                        </select>
                    </div>
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="Y" {{ $professional->status == 'Y' ? 'selected' : '' }}>Ativo</option>
                            <option value="N" {{ $professional->status == 'N' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                </div>

                <!-- Botão de Atualizar -->
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white font-bold py-3 px-4 rounded-md shadow-lg hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-700 transition duration-300">
                        Atualizar Profissional
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
