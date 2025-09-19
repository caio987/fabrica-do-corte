let contador = 1;
const totalImagens = 3;
const delay = 4000;

setInterval(function () {
    proximaImagem();
}, delay)

function proximaImagem() {
    contador++;
    if (contador > totalImagens) {
        contador = 1;
    }
    document.getElementById("radio" + contador).checked = true;
}


let carrossel = document.getElementById("carrossel");
let caixaEstabelecimento = document.getElementById("caixaEstabelecimento");

function lojas(variavel) {
    fetch("/db.json")
        .then(response => response.json())
        .then(data => {
            const barbearias = data.barbearias;

            barbearias.map(loja => {
                let caixa = document.createElement("div");
                caixa.classList.add("caixaBarbearia");
                caixa.id = loja.id
                caixa.onclick = function () {
                    // document.querySelectorAll(".caixaBarbearia").forEach(loja => {
                    //     loja.classList.remove("active");
                    // });
                    // document.querySelectorAll(".sinopse").forEach(loja => {
                    //     loja.classList.remove("active");
                    // });
                    caixa.classList.toggle("active")
                    sinopse.classList.toggle("active")
                }

                let sinopse = document.createElement("p")
                sinopse.innerHTML = loja.sinopse
                sinopse.classList.add("sinopse")

                let foto = document.createElement("img");
                foto.src = "../" + loja.img; // Ajuste do caminho
                foto.classList.add("fotoBarbearia");

                let nome = document.createElement("p");
                nome.classList.add("nomeEstabelecimento");
                nome.innerHTML = loja.nome;

                let avaliacao = document.createElement("div");
                avaliacao.classList.add("avaliacao");

                let nota = document.createElement("img");
                nota.src = "/img/icons/avaliacao.png";

                let curtidas = document.createElement("p");
                curtidas.innerHTML = loja.curtidas;

                let coracao = document.createElement("span");
                coracao.innerHTML = "❤";

                let caixaInformacoes = document.createElement("div")
                caixaInformacoes.classList.add("caixaInformacoes")

                let seta = document.createElement("img")
                seta.src = "/img/icons/seta.png"
                seta.classList.add("seta")

                let localizacao = document.createElement("p")
                localizacao.classList.add("localizacao")
                localizacao.innerHTML = loja.localizacao

                avaliacao.appendChild(nota);
                curtidas.appendChild(coracao);
                avaliacao.appendChild(curtidas);
                caixa.appendChild(foto);
                caixaInformacoes.appendChild(nome);
                caixaInformacoes.appendChild(avaliacao);
                caixa.appendChild(caixaInformacoes);

                if (variavel == 1) {
                    carrossel.appendChild(caixa);
                } else {
                    caixaInformacoes.appendChild(localizacao);
                    caixa.appendChild(seta);
                    caixaEstabelecimento.appendChild(caixa);
                    caixa.appendChild(sinopse)
                }
            });
        });
}

// cadastro barbeiro
function avancar() {
    document.getElementById("etapa").innerText = "2";
    document.getElementById("etapa1").classList.toggle("invisivel")
    document.getElementById("etapa2").classList.toggle("invisivel")
    document.getElementById("botao2").style.display = "block"
    document.getElementById("botao3").style.display = "block"
    document.getElementById("botao1").style.display = "none"
}
function voltar() {
    document.getElementById("etapa1").classList.toggle("invisivel")
    document.getElementById("etapa2").classList.toggle("invisivel")
    document.getElementById("etapa").innerText = "1";
    document.getElementById("botao2").style.display = "none"
    document.getElementById("botao3").style.display = "none"
    document.getElementById("botao1").style.display = "block"
}


// Carrosel
let span = document.getElementsByTagName('span');
let product = document.getElementsByClassName('caixaBarbearia');
let product_page = Math.ceil(product.length / 4);
let l = 0;
let movePer = 27;
let maxMove = 108;

let right_mover = () => {
    l = l + movePer;
    console.log(l)
    if (product == 1) { l = 0 }
    for (const i of product) {
        if (l > maxMove) { l = l - movePer; }
        i.style.left = '-' + l + '%';
    }
}

let left_mover = () => {
    l = l - movePer;
    console.log(l)
    if (l <= 0) { l = 0; }
    for (const i of product) {
        i.style.left = '-' + l + '%';
    }
}

span[1].onclick = () => { right_mover(); }
span[0].onclick = () => { left_mover(); }