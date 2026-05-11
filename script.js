document.addEventListener('DOMContentLoaded', () => {

    const botao = document.getElementById('btn-calcular');

    if (!botao) return;

    botao.addEventListener('click', main);

});

function getDados(){

    const dados = {
        largura: parseFloat(document.querySelector('.campo-largura input')?.value) || 0,

        profundidade: parseFloat(document.querySelector('.campo-profundidade input')?.value) || 0,

        garagens: parseFloat(document.querySelector('.campo-garagem input')?.value) || 0,

        andares: parseFloat(document.querySelector('.campo-andares input')?.value) || 0,

        dormitorios: parseFloat(document.querySelector('.campo-dormitorios input')?.value) || 0,

        banheiros: parseFloat(document.querySelector('.campo-banheiros input')?.value) || 0,

        lavabos: parseFloat(document.querySelector('.campo-lavabos input')?.value) || 0,

        sacadas: parseFloat(document.querySelector('.campo-sacadas input')?.value) || 0,

        elevadores: parseFloat(document.querySelector('.campo-elevador input')?.value) || 0,

        cub: document.querySelector('.campo-cub select')?.value || "normal"
    };

    return dados;
}

function getParametros(){

    const parametros = {

        ocupacaoMaximaPorLaje: 80,

        coeficienteMaximo: 2.6,

        pavimentosMaximo: 25,

        indiceVagasPorAndar: 30,

        recuoFrontal: 3,

        recuoLateral: {
            ate3: 0,
            ate4: 1.5,
            ate5: 2,
            ate7: 2.5,
            ate9: 3,
            ate12: 3.5,
            ate15: 4,
            ate19: 4.5,
            ate25: 6
        },

        recuoFundos: {
            ate3: 0,
            ate4: 1.5,
            ate5: 2,
            ate7: 2.5,
            ate9: 3,
            ate12: 3.5,
            ate15: 4,
            ate19: 4.5,
            ate25: 6
        },

        caixaEscada: {
            ate3: 14,
            ate4: 14,
            ate5: 17,
            ate7: 17,
            ate9: 18,
            ate12: 25,
            ate15: 25,
            ate19: 25,
            ate25: 30
        },

        ambientesMinimos: {

            dormitorio: 11,

            banheiro: 3,

            cozinha: 18,

            salaEstar: 6,

            lavabo: 1.5,

            sacada: 3.2
        },

        elevador: 2.6,

        hall: {
            apt4: 5,
            apt6: 10,
            apt8: 15
        },

        maximoApartamentoPorAndar: 6
    };

    return parametros;
}

function main() {
    const dados = getDados();
    console.log(dados)
    const param = getParametros();

    const resultados = calcularResultados(dados, param);

    if (!resultados) return;

    exibirResultados(resultados);
}

function cubConvert(dados){

    const tipo = dados.cub;

    if(tipo === "normal") return 1.0;
    if(tipo === "media") return 1.2;
    if(tipo === "alta") return 1.5;
    return 0;

}

function pavConvert(tipo, numPav, param) {

    const tabela = param[tipo];

    if (numPav <= 3) return tabela.ate3;
    if (numPav <= 4) return tabela.ate4;
    if (numPav <= 5) return tabela.ate5;
    if (numPav <= 7) return tabela.ate7;
    if (numPav <= 9) return tabela.ate9;
    if (numPav <= 12) return tabela.ate12;
    if (numPav <= 15) return tabela.ate15;
    if (numPav <= 19) return tabela.ate19;

    return tabela.ate25;
}

function calcularResultados(dados, param) {
    const r = {}; // Objeto de resultados

    r.pavimentos = dados.andares + dados.garagens;
    r.avisoPavimentos = r.pavimentos > param.pavimentosMaximo;
    r.andarSemGaragem = Math.max(0, dados.andares - dados.garagens);

    if (r.pavimentos > param.pavimentosMaximo) {

        document.getElementById('resultado').innerHTML = `
        <div class="alerta-pavimentos">
            ⚠️ O máximo permitido é ${param.pavimentosMaximo} pavimentos no total.
            no momento há ${dados.andares} pavimentos de apartamentos e ${dados.garagens} pavimentos de garagem.
        </div>
    `;

        return null;
    }

    r.escadas      = pavConvert("caixaEscada",r.pavimentos,param)
    r.recuoLateral = pavConvert("recuoLateral",r.pavimentos,param)
    r.recuoFundos  = pavConvert("recuoFundos",r.pavimentos,param)

    // --- Cálculos de Área ---
    r.ocupacaoMaxPavimento = dados.largura * dados.profundidade * (param.ocupacaoMaximaPorLaje / 100)
    r.areaEmbasamento = r.ocupacaoMaxPavimento * dados.garagens //certo
    r.escadaEmbasamento = r.escadas * dados.garagens // certo
    r.areaEstacionamento = Math.max(0, r.areaEmbasamento - r.escadaEmbasamento);
    r.vagas = param.indiceVagasPorAndar > 0
        ? Math.ceil(r.areaEstacionamento / param.indiceVagasPorAndar)
        : 0;
    r.larguraUtil = Math.max(0, dados.largura - (2 * r.recuoLateral));
    r.profundidadeUtil = Math.max(0, dados.profundidade - param.recuoFrontal - r.recuoFundos);
    r.areaLajePavimentosTipo = r.larguraUtil * r.profundidadeUtil

    if (r.areaLajePavimentosTipo >= 600) {
        r.areaLajePavimentosTipo = r.areaLajePavimentosTipo * 0.9
    }

    r.elevadorAndar = dados.elevadores * param.elevador
    r.areaUtilApartamentoTipo = Math.max(0, r.areaLajePavimentosTipo - r.escadas - r.elevadorAndar);
    r.areaDormitorio = dados.dormitorios * param.ambientesMinimos.dormitorio;
    r.areaBanheiro = dados.banheiros * param.ambientesMinimos.banheiro;
    r.areaLavabo = dados.lavabos * param.ambientesMinimos.lavabo;
    r.areaSacada = dados.sacadas * param.ambientesMinimos.sacada;
    r.cozinhaSala = param.ambientesMinimos.cozinha + param.ambientesMinimos.salaEstar

    //daqui pra frente ja exibe tudo

    r.tamanhoApartamento = Math.max(
        1,
        (r.areaDormitorio +
            r.areaBanheiro +
            r.areaLavabo +
            r.areaSacada +
            r.cozinhaSala) * 1.5
    );
    r.apartamentoAndar = Math.min(param.maximoApartamentoPorAndar, Math.max(0, Math.floor(r.areaUtilApartamentoTipo / r.tamanhoApartamento)));
    r.qtdApartamento = r.andarSemGaragem * r.apartamentoAndar;
    r.avisoVagas = r.qtdApartamento > r.vagas;
    //r.qtdApartamento = Math.min(r.vagas, (dados.andares - dados.garagens) * r.apartamentoAndar);
    //exibir r.areaEmbasamento //EXIBE
    r.areaTotalConstruidoTipo = r.andarSemGaragem * r.areaLajePavimentosTipo //EXIBE
    //r.areaTotalConstruidoTipo = (dados.andares - dados.garagens) * r.areaLajePavimentosTipo //EXIBE
    r.areaTotalEmpreendimento = r.areaTotalConstruidoTipo + r.areaEmbasamento //EXIBE
    r.areaTotalPrivativa = r.tamanhoApartamento * r.qtdApartamento //EXIBE
    //%
    r.coeficientePrivativo = r.areaTotalEmpreendimento > 0 ? r.areaTotalPrivativa / r.areaTotalEmpreendimento : 0;
    //CUB
    r.multiplicadorCUB = 3050 * cubConvert(dados)
    //exibir area total empreendimento //EXIBE

    r.custoDeObra = r.areaTotalEmpreendimento * r.multiplicadorCUB //EXIBE
    r.custoPorUnidade = r.qtdApartamento > 0 ? r.custoDeObra / r.qtdApartamento : 0; //EXIBE

    console.log(`
===== RESULTADOS =====

Pavimentos: ${r.pavimentos}

Escadas: ${r.escadas}
Recuo Lateral: ${r.recuoLateral}
Recuo Fundos: ${r.recuoFundos}

Ocupação Máxima Pavimento: ${r.ocupacaoMaxPavimento}
Área Embasamento: ${r.areaEmbasamento}
Escada Embasamento: ${r.escadaEmbasamento}
Área Estacionamento: ${r.areaEstacionamento}
Vagas: ${r.vagas}

Largura Útil: ${r.larguraUtil}
Profundidade Útil: ${r.profundidadeUtil}

Área Laje Pavimentos Tipo: ${r.areaLajePavimentosTipo}

Elevador Andar: ${r.elevadorAndar}
Área Útil Apartamento Tipo: ${r.areaUtilApartamentoTipo}

Área Dormitório: ${r.areaDormitorio}
Área Banheiro: ${r.areaBanheiro}
Área Lavabo: ${r.areaLavabo}
Área Sacada: ${r.areaSacada}
Cozinha + Sala: ${r.cozinhaSala}

Tamanho Apartamento: ${r.tamanhoApartamento}

Apartamentos por Andar: ${r.apartamentoAndar}
Quantidade Apartamentos: ${r.qtdApartamento}

Area Total Construida Embasamento: ${r.areaEmbasamento}
Área Total Construído Tipo: ${r.areaTotalConstruidoTipo}
Área Total Empreendimento: ${r.areaTotalEmpreendimento}
Área Total Privativa: ${r.areaTotalPrivativa}

Coeficiente Privativo: ${(r.coeficientePrivativo * 100).toFixed(2)}%

Multiplicador CUB: ${r.multiplicadorCUB}

Custo de Obra: ${r.custoDeObra}

Custo por Unidade: ${r.custoPorUnidade}

Aviso Vagas: ${r.avisoVagas}
======================
`);

    return r;
}

function exibirResultados(r) {

    const resultado = document.getElementById('resultado');

    resultado.innerHTML = `
    
        <div class="result-row">
            <strong>Pavimentos:</strong>
            <span>${r.pavimentos}</span>
        </div>
        
        <div class="result-row">
            <strong>Vagas:</strong>
            <span>${r.vagas}</span>
        </div>

        <div class="result-row">
            <strong>Tamanho do Apartamento:</strong>
            <span>${r.tamanhoApartamento.toFixed(2)} m²</span>
        </div>

        <div class="result-row">
            <strong>Apartamentos por Andar:</strong>
            <span>${r.apartamentoAndar}</span>
        </div>

        <div class="result-row">
            <strong>Quantidade Total de Apartamentos:</strong>
            <span>${r.qtdApartamento}</span>
        </div>

        <div class="result-row">
            <strong>Área Total Construída Tipo:</strong>
            <span>${r.areaTotalConstruidoTipo.toFixed(2)} m²</span>
        </div>

        <div class="result-row">
            <strong>Área Total do Empreendimento:</strong>
            <span>${r.areaTotalEmpreendimento.toFixed(2)} m²</span>
        </div>

        <div class="result-row">
            <strong>Área Total Privativa:</strong>
            <span>${r.areaTotalPrivativa.toFixed(2)} m²</span>
        </div>

        <div class="result-row">
            <strong>Coeficiente Privativo:</strong>
            <span>${(r.coeficientePrivativo * 100).toFixed(2)}%</span>
        </div>

        <div class="result-row">
            <strong>Custo da Obra:</strong>
            <span>R$ ${r.custoDeObra.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    })}</span>
        </div>

        <div class="result-row">
            <strong>Custo por Unidade:</strong>
            <span>R$ ${r.custoPorUnidade.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
             })}</span>
        </div>
        
        ${r.avisoVagas ? `
        <div class="alerta-vagas">
            ⚠️ O número de apartamentos ultrapassa a quantidade de vagas disponíveis.
        </div>
    ` : ''}
    
    `;
}