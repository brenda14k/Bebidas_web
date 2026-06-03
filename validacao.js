// faz os campos dessaparecem quando seleciona agua ou refrigerante 
document.addEventListener('DOMContentLoaded', function () {

    var toggle   = document.querySelector('.nav-dropdown-toggle');
    var dropdown = document.querySelector('.nav-dropdown');

    if (toggle && dropdown) {

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });
    }

    var secaoInicial = document.body.dataset.secaoAtiva || 'form';
    mostrarSecao(secaoInicial);

    document.querySelectorAll('.msg-campo').forEach(function (span) {
        if (span.textContent.trim() !== '') {
            span.classList.add('visivel');

            var wrapper = span.closest('.campo-wrapper');
            if (wrapper) wrapper.classList.add('campo-erro');
        }
    });

    // ===== CONTROLE DOS CAMPOS =====

    function atualizarCampos() {

        const tipo = document.getElementById('tipo');

        if (!tipo) return;

        const origem = document.getElementById('campo-origem');
        const sabor  = document.getElementById('campo-sabor');

        if (tipo.value === 'A') {
            if (origem) origem.style.display = 'none';
            if (sabor)  sabor.style.display  = 'none';
        }
        else if (tipo.value === 'R') {
            if (sabor)  sabor.style.display  = 'none';
            if (origem) origem.style.display = 'block';
        }
        else {
            if (origem) origem.style.display = 'block';
            if (sabor)  sabor.style.display  = 'block';
        }
    }

    const campoTipo = document.getElementById('tipo');

    if (campoTipo) {
        campoTipo.addEventListener('change', atualizarCampos);
        atualizarCampos();
    }

    // ===== LIMPAR ERROS NO RESET DO FORMULÁRIO =====
    var formulario = document.querySelector('form');
    if (formulario) {
        formulario.addEventListener('reset', function () {
            document.querySelectorAll('.msg-campo').forEach(function (span) {
                span.classList.remove('visivel');
                span.textContent = '';
            });
            document.querySelectorAll('.campo-erro').forEach(function (wrapper) {
                wrapper.classList.remove('campo-erro');
            });
            setTimeout(atualizarCampos, 0);
        });
    }

});

/* ── Alterna seção visível ─────────────────────────── */

function mostrarSecao(qual) {

    document.querySelectorAll('.secao').forEach(function (s) {
        s.classList.remove('ativa');
    });

    var alvo = document.getElementById('secao-' + qual);

    if (alvo) alvo.classList.add('ativa');

    var dropdown = document.querySelector('.nav-dropdown');

    if (dropdown) dropdown.classList.remove('open');
}

// ===== OPÇÕES DINÂMICAS POR TIPO =====

const tipo   = document.getElementById('tipo');
const opcoes = document.getElementById('opcoes');

const dados = {
    A: [
        { value: "AM", text: "Água Mineral" },
        { value: "AG", text: "Água com Gás" },
        { value: "AL", text: "Água Saborizada Limão" },
        { value: "AR", text: "Água Saborizada Laranja" },
    ],
    R: [
        { value: "CC", text: "Coca-Cola" },
        { value: "CZ", text: "Coca-Cola Zero" },
        { value: "PP", text: "Pepsi" },
        { value: "PB", text: "Pepsi Black" },
        { value: "GU", text: "Guaraná" },
        { value: "GZ", text: "Guaraná Zero" },
        { value: "FL", text: "Fanta Laranja" },
        { value: "FU", text: "Fanta Uva" },
    ],
    V: [
        { value: "VS",  text: "Suave" },
        { value: "VDM", text: "Demi-sec" },
        { value: "VSC", text: "Seco" },
    ],
    C: [
        { value: "CA", text: "Com Açúcar" },
        { value: "SA", text: "Sem Açúcar" },
        { value: "AD", text: "Com Adoçante" },
    ],
    CH: [
        { value: "CA", text: "Com Açúcar" },
        { value: "SA", text: "Sem Açúcar" },
        { value: "AD", text: "Com Adoçante" },
    ],
    S: [
        { value: "CA", text: "Com Açúcar" },
        { value: "SA", text: "Sem Açúcar" },
        { value: "AD", text: "Com Adoçante" },
    ],
    BT: [
        { value: "BPB", text: "Popping Boba" },
        { value: "BPT", text: "Pérolas de Tapioca" },
        { value: "BG",  text: "Gelatina" },
    ],
};

function atualizarOpcoes() {
    const selecionado = opcoes ? (opcoes.dataset.selected || '') : '';
    const valor = tipo ? tipo.value : '';

    if (!opcoes) return;

    opcoes.innerHTML = '<option value="">Selecione</option>';

    if (dados[valor]) {
        dados[valor].forEach(function(item) {
            const option = document.createElement('option');
            option.value       = item.value;
            option.textContent = item.text;
            opcoes.appendChild(option);
            if (item.value === selecionado) { option.selected = true; }
        });
    }
}

if (tipo && opcoes) {
    tipo.addEventListener('change', atualizarOpcoes);
    window.addEventListener('load', atualizarOpcoes);
}