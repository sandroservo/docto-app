<x-app-layout>

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-2xl font-bold mb-8 text-slate-200">Dashboard de Cirurgias</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gráfico de Cirurgias por Cidade -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Cirurgias por Cidade</h2>
            <canvas id="cirurgiasPorCidade"></canvas>
        </div>

        <!-- Gráfico de Cirurgias Mais Executadas -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Cirurgias Mais Executadas</h2>
            <canvas id="cirurgiasMaisExecutadas"></canvas>
        </div>
    </div>
</div>

<!-- Incluindo o Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Gráfico: Cirurgias por Cidade
    var cities = {!! json_encode($cities) !!};
    var totalsByCity = {!! json_encode($totalsByCity) !!};

    var ctxCidade = document.getElementById('cirurgiasPorCidade').getContext('2d');
    var chartCidade = new Chart(ctxCidade, {
        type: 'pie',
        data: {
            labels: cities,
            datasets: [{
                label: 'Cirurgias por Cidade',
                data: totalsByCity,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });

    // Gráfico: Cirurgias Mais Executadas
    var surgeryTypes = {!! json_encode($surgeryTypes) !!};
    var totalsBySurgeryType = {!! json_encode($totalsBySurgeryType) !!};

    var ctxCirurgia = document.getElementById('cirurgiasMaisExecutadas').getContext('2d');
    var chartCirurgia = new Chart(ctxCirurgia, {
        type: 'pie',
        data: {
            labels: surgeryTypes,
            datasets: [{
                label: 'Cirurgias Mais Executadas',
                data: totalsBySurgeryType,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
</x-app-layout>
