document.addEventListener('DOMContentLoaded', function () {
    buscaFuncionarios();

    const filterSelect = document.getElementById('specialty');
    filterSelect.addEventListener('change', function () {
        buscaFuncionarios(this.value); //busca com filtro 
    });
});

function buscaFuncionarios(filter = 'all') { //buscar funcionarios
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'funcionario.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded'); //formato
    xhr.onload = function () {
        if (this.status === 200) {
            const funcionarios = JSON.parse(this.responseText); //jsonpraarray
            const container = document.getElementById('team-container');
            container.innerHTML = '';

            if (funcionarios.length === 0) {
                container.innerHTML = '<p>Nenhum funcionário encontrado para este filtro.</p>';
                return;
            }

            funcionarios.forEach(funcionario => { 
                const card = `
                    <div class="team-card" data-specialty="${funcionario.cargo.toLowerCase()}"> 
                        <img src="${funcionario.foto}" alt="${funcionario.nome}">
                        <h3>${funcionario.nome}</h3>
                        <p>${funcionario.cargo}</p>
                        <p class="preco">Preço: R$ ${funcionario.precoservico.toFixed(2)}</p>
                        <button class="btn" onclick="vaiPagamento('${funcionario.nome}', '${funcionario.cargo}', '${funcionario.carga_horaria}', '${funcionario.tempo_servico}', '${funcionario.foto}', ${funcionario.precoservico})">Agendar</button>
                    </div>
                `;
                container.innerHTML += card;
            });
        }
    };

    xhr.send(`filter=${filter}`); //envia por POST o filtro
}

function vaiPagamento(nome, cargo, cargaHoraria, tempoServico, foto, precoservico) { 
    const funcionario = {
        nome,
        cargo,
        carga_horaria: cargaHoraria, 
        tempo_servico: tempoServico, 
        foto,
        precoservico,
    };
    localStorage.setItem('funcionarioSelecionado', JSON.stringify(funcionario));
    window.location.href = '../calendario/pagamento.html';
}
