<x-app-layout> 
    <div class="container mx-auto py-12">
        <h2 class="text-2xl font-bold mb-8">Painel de BI - Estatísticas de Cirurgias</h2>

        <!-- Filtros -->
        <div class="flex items-center space-x-4 mb-8">
            <!-- Filtro de Data -->
            <div>
                <label class="block font-medium">Data Inicial</label>
                <input type="date" id="startDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            </div>
            <div>
                <label class="block font-medium">Data Final</label>
                <input type="date" id="endDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            </div>

            <!-- Filtro de Cidade -->
            <div>
                <label class="block font-medium">Cidade</label>
                <select id="cityFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Todas</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro de Profissional -->
            <div>
                <label class="block font-medium">Profissional</label>
                <select id="professionalFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Todos</option>
                    @foreach ($professionals as $professional)
                        <option value="{{ $professional->id }}">{{ $professional->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Botão de Aplicar Filtros -->
            <button onclick="applyFilters()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Aplicar Filtros
            </button>
        </div>

        <!-- Gráficos -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Cirurgias Mais Executadas</h3>
            <canvas id="mostExecutedSurgeriesChart"></canvas>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Profissionais com Mais Participações</h3>
            <canvas id="topProfessionalsChart"></canvas>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4">Cidades com Mais Cirurgias Executadas</h3>
            <canvas id="topCitiesChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inicializa os gráficos com valores vazios
        const mostExecutedSurgeriesCtx = document.getElementById('mostExecutedSurgeriesChart').getContext('2d');
        const mostExecutedSurgeriesChart = new Chart(mostExecutedSurgeriesCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total de Cirurgias',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            }
        });

        const topProfessionalsCtx = document.getElementById('topProfessionalsChart').getContext('2d');
        const topProfessionalsChart = new Chart(topProfessionalsCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Participações',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                }]
            }
        });

        const topCitiesCtx = document.getElementById('topCitiesChart').getContext('2d');
        const topCitiesChart = new Chart(topCitiesCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total de Cirurgias',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                }]
            }
        });

        function applyFilters() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const city = document.getElementById('cityFilter').value;
            const professional = document.getElementById('professionalFilter').value;

            // Faz a requisição AJAX para o endpoint de BI
            fetch(`/surgeries/bi?start_date=${startDate}&end_date=${endDate}&city=${city}&professional=${professional}`)
                .then(response => {
                    if (!response.ok) throw new Error("Erro na requisição");
                    return response.json();
                })
                .then(data => {
                    console.log("Dados recebidos:", data); // Log para verificação
                    updateCharts(data);
                })
                .catch(error => console.error("Erro ao carregar os dados:", error));
        }

        function updateCharts(data) {
            // Atualização do gráfico de Cirurgias Mais Executadas
            if (data.mostExecutedSurgeries) {
                mostExecutedSurgeriesChart.data.labels = data.mostExecutedSurgeries.labels;
                mostExecutedSurgeriesChart.data.datasets[0].data = data.mostExecutedSurgeries.data;
                mostExecutedSurgeriesChart.update();
            }

            // Atualização do gráfico de Participação dos Profissionais
            if (data.topProfessionals) {
                topProfessionalsChart.data.labels = data.topProfessionals.labels;
                topProfessionalsChart.data.datasets[0].data = data.topProfessionals.data;
                topProfessionalsChart.update();
            }

            // Atualização do gráfico de Cirurgias por Cidade
            if (data.topCities) {
                topCitiesChart.data.labels = data.topCities.labels;
                topCitiesChart.data.datasets[0].data = data.topCities.data;
                topCitiesChart.update();
            }
        }
    </script>
</x-app-layout>
