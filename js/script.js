//mascara para o cpf
$(document).ready(function () {
    $('#cpf').mask('000.000.000-00', { reverse: true });
});
//mascara para o telefone
$(document).ready(function () {
    $('#telefone').mask('00 00000-0000', { reverse: true });
});
//mascara para o cep
$(document).ready(function () {
    $('#cep').mask('00000-000', { reverse: true });
});

// Função para carregar os estados brasileiros  
function carregarEstados() {
    $.ajax({
        // Pega todos os estados e municípios do IBGE
        url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
        dataType: 'json',
        success: function (data) {
            // Seleciona o elemento select com o id 'estado'
            var selectEstado = $('#estado');
            // Adiciona cada estado como uma opção no select   
            $.each(data, function (index, estado) {
                selectEstado.append('<option value="' + estado.sigla + '">' + estado.nome + '</option>');
            });
            // Após carregar os estados, atualiza os municípios para o estado selecionado
            atualizarMunicipios();
        },
        error: function (error) {
            console.log('Erro ao carregar estados:', error);
        }
    });
}
// Função para carregar os municípios de um estado específico
function carregarMunicipios(uf) {
    $.ajax({
        url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + uf + '/municipios',
        dataType: 'json',
        success: function (data) {
            // Seleciona o elemento select com o id 'municipio'
            var selectMunicipio = $('#municipio');
            // Limpa as opções existentes no select
            selectMunicipio.empty();
            // Adiciona cada município como uma opção no select
            $.each(data, function (index, municipio) {
                selectMunicipio.append('<option value="' + municipio.nome + '">' + municipio.nome + '</option>');
            });
        },
        error: function (error) {
            console.log('Erro ao carregar municípios:', error);
        }
    });
}
// Função para atualizar os municípios conforme o estado selecionado
function atualizarMunicipios() {
    // Obtém a sigla do estado selecionado
    var estadoSelecionado = $('#estado').val();
    // Carrega os municípios do estado selecionado
    carregarMunicipios(estadoSelecionado);
}
// Função executada quando o documento HTML é carregado
$(document).ready(function () {
    // Carrega os estados brasileiros
    carregarEstados();
    // Define um evento de mudança para o select 'estado'
    $('#estado').change(atualizarMunicipios);
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('reset').addEventListener('click', function () {
        document.getElementById('popup-message').textContent = 'O formulário foi limpo.';
        document.getElementById('popup').classList.add('show');
    });

    document.getElementById('close-popup').addEventListener('click', function () {
        document.getElementById('popup').classList.remove('show');
    });
});

