const apiUrl = './js/gerenciar_funcionario.php'; 
let funcionarioEmEdicao = null;

function listarFuncionarios() {
    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (funcionarios) {
            const listaFuncionarios = $('#lista-funcionarios');
            listaFuncionarios.empty(); 

            if (Array.isArray(funcionarios) && funcionarios.length > 0) {
                funcionarios.forEach(funcionario => {
                    const li = $(`
                        <li>
                            <strong>Nome:</strong> ${funcionario.nome} <br>
                            <strong>Cargo:</strong> ${funcionario.cargo} <br>
                            <strong>Carga Horária:</strong> ${funcionario.carga_horaria} <br>
                            <strong>Tempo de Serviço:</strong> ${funcionario.tempo_servico} <br>
                            <strong>Preço do Serviço:</strong> R$${parseFloat(funcionario.precoservico).toFixed(2)} <br>
                            <button class="editar" onclick="editarFuncionario(${funcionario.id_funcionario})">Editar</button>
                            <button class="excluir" onclick="excluirFuncionario(${funcionario.id_funcionario})">Excluir</button>
                        </li>
                    `);
                    listaFuncionarios.append(li);
                });
            } else {
                listaFuncionarios.html('<p>Nenhum funcionário encontrado.</p>');
            }
        },
        error: function (error) {
            console.error('Erro ao listar os funcionários:', error);
        }
    });
}


$('#btnCadastrar').on('click', function () {    //cadastro e edição
    const nome = $('#nome').val().trim();
    const cargo = $('#cargo').val().trim();
    const cargaHoraria = $('#carga_horaria').val().trim();
    const tempoServico = $('#tempo_servico').val().trim();
    const precoServico = parseFloat($('#precoservico').val().trim());

    if (!nome || !cargo || !cargaHoraria || !tempoServico || isNaN(precoServico)) {
        alert('Preencha todos os campos corretamente.');
        return;
    }

    const funcionario = { nome, cargo, carga_horaria: cargaHoraria, tempo_servico: tempoServico, precoservico: precoServico };

    if (funcionarioEmEdicao) {  // se edição
        funcionario.id_funcionario = funcionarioEmEdicao;
        $.ajax({
            url: apiUrl,
            method: 'PUT',
            data: JSON.stringify(funcionario),   // joga pra json
            contentType: 'application/json',
            success: function (response) {
                alert(response.message || 'Funcionário atualizado com sucesso.');
                listarFuncionarios();
                limparFormulario();
            },
            error: function (error) {
                console.error('Erro ao editar funcionário:', error);
            }
        });
    } else {    //cadastro
        $.ajax({
            url: apiUrl,
            method: 'POST',
            data: JSON.stringify(funcionario),
            contentType: 'application/json',
            success: function (response) {
                alert(response.message || 'Funcionário cadastrado com sucesso.');
                listarFuncionarios();
                limparFormulario();
            },
            error: function (error) {
                console.error('Erro ao cadastrar funcionário:', error);
            }
        });
    }
});

function excluirFuncionario(id) {
    $.ajax({
        url: apiUrl,
        method: 'DELETE',
        data: JSON.stringify({ id_funcionario: id }),
        contentType: 'application/json',
        success: function (response) {
            alert(response.message || 'Funcionário excluído com sucesso.');
            listarFuncionarios();
        },
        error: function (error) {
            console.error('Erro ao excluir funcionário:', error);
        }
    });
}

function editarFuncionario(id) {
    $.ajax({
        url: apiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (funcionarios) {
            const funcionario = funcionarios.find(f => f.id_funcionario == id);

            if (funcionario) {
                $('#nome').val(funcionario.nome);
                $('#cargo').val(funcionario.cargo);
                $('#carga_horaria').val(funcionario.carga_horaria);
                $('#tempo_servico').val(funcionario.tempo_servico);
                $('#precoservico').val(funcionario.precoservico);

                funcionarioEmEdicao = id; 
                $('#btnCadastrar').text('Atualizar');
            }
        },
        error: function (error) {
            console.error('Erro ao buscar funcionário:', error);
        }
    });
}

function limparFormulario() {
    $('#formulario')[0].reset();
    funcionarioEmEdicao = null;
    $('#btnCadastrar').text('Cadastrar');
}

listarFuncionarios();
