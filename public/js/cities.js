document.addEventListener('DOMContentLoaded', function() {
    var stateSelect = document.getElementById('state_id');
    var citySelect = document.getElementById('citie_id');

    stateSelect.addEventListener('change', function() {
        var stateId = stateSelect.value;

        // Limpa o dropdown de cidades
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
                        citySelect.appendChild(option);
                    });
                })
                .catch(function(error) {
                    console.error('Erro ao buscar cidades:', error);
                });
        }
    });
});