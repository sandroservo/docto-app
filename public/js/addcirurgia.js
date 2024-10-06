document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addModal');
    const selectField = document.getElementById('surgery_id'); // Campo select da página principal
    const closeModalButton = document.getElementById('closeModal');
    const addSurgeryForm = document.getElementById('addSurgeryForm');
    const mainForm = document.getElementById('mainForm'); // Formulário principal

    // Quando o select muda de valor
    selectField.addEventListener('change', function() {
        if (this.value === 'add-option') {
            modal.classList.add('active'); // Exibe o modal
            modal.style.display = 'flex'; // Exibe o modal
        }
    });

    // Fechar o modal ao clicar no botão "Cancelar"
    closeModalButton.addEventListener('click', function() {
        modal.classList.remove('active');
        modal.style.display = 'none'; // Esconde o modal
        selectField.value = ""; // Reseta o select para "Selecione"
    });

    // Submissão do formulário para adicionar nova cirurgia
    addSurgeryForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Previne a validação e submissão do formulário principal

        const newSurgery = document.getElementById('new_surgery').value;

        // Enviar os dados via AJAX para o backend
        fetch('/add-surgery', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify({
                    descricao: newSurgery
                })
            })
            .then(response => response.json())
            .then(data => {
                // Adicionar a nova cirurgia ao campo select com o ID retornado do backend
                const newOption = document.createElement('option');
                newOption.text = data.descricao;
                newOption.value = data.id; // Usando o ID retornado do backend
                selectField.add(newOption);
                selectField.value = newOption.value; // Seleciona a nova cirurgia

                // Fecha o modal e reseta o formulário do modal
                addSurgeryForm.reset();
                modal.style.display = 'none'; // Esconde o modal
            })
            .catch(error => {
                console.error('Erro ao adicionar a cirurgia:', error);
            });
    });

    // Submissão do formulário principal
    mainForm.addEventListener('submit', function(event) {
        // Aqui vai o código de submissão do formulário principal se necessário
        console.log('Submetendo formulário principal');
    });
});