<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Lista de Cirurgias</h1>

        <!-- Campo de Pesquisa -->
        <form method="GET" action="{{ route('surgeries.index') }}" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                class="border border-gray-300 p-2 w-1/3" placeholder="Buscar por nome do paciente...">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
        </form>

        <!-- Verificar se existem registros -->
        @if($surgeryRecords->count())
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 py-2">Data</th>
                        <th class="w-1/6 py-2">Nome do Paciente</th>
                        <th class="w-1/6 py-2">Idade</th>
                        <th class="w-1/6 py-2">Estado</th>
                        <th class="w-1/6 py-2">Cidade</th>
                        <th class="w-1/6 py-2">Departamento</th>
                        <th class="w-1/6 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surgeryRecords as $surgery)
                        <tr class="border-b">
                            <td class="py-2">{{ $surgery->date }}</td>
                            <td class="py-2">{{ $surgery->name }}</td>
                            <td class="py-2">{{ $surgery->age }}</td>
                            <td class="py-2">{{ $surgery->state->name }}</td>
                            <td class="py-2">{{ $surgery->city->name }}</td>
                            <td class="py-2">{{ $surgery->origin_department }}</td>
                            <td class="py-2">
                                <a href="{{ route('surgeries.edit', $surgery->id) }}" class="text-blue-500">Editar</a> |
                                <form action="{{ route('surgeries.destroy', $surgery->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500" onclick="return confirm('Tem certeza?')">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="mt-4">
                {{ $surgeryRecords->links() }}
            </div>
        @else
            <p>Nenhuma cirurgia encontrada.</p>
        @endif
    </div>
</x-app-layout>
