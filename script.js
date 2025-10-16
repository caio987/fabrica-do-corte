let contador = 1;
const totalImagens = 3;
const delay = 4000;

setInterval(function () {
  proximaImagem();
}, delay);

function proximaImagem() {
  contador++;
  if (contador > totalImagens) {
    contador = 1;
  }
  document.getElementById("radio" + contador).checked = true;
}

// Gerador de header
window.addEventListener("DOMContentLoaded", async () => {
  const header = document.querySelector("header");

  const response = await fetch("../php/user_session.php");
  const data = await response.json();

  header.innerHTML = ""; // Limpa os links padrão

  if (data.logado) {
    // Usuário logado
    header.innerHTML = `
        <nav>
      <ul class="navNormal">
        <li><a href="index.html"><img src="../img/logo.png" alt=""></a></li>
        <li><a href="busca.html" class="links">Barbearias</a></li>
        <li><a href="index.html#quemSomos" class="links">Quem somos</a></li>
        <li><a href="infoContaCliente.html" class="links">Minha Conta</a></li>
      </ul>

      <li class="logoMobile"><a href="index.html"><img src="../img/logo.png" alt=""></a></li>
        <div class="mobileMenu" onclick="tresLinhas()">
          <div class="linha1"></div>
          <div class="linha2"></div>
          <div class="linha3"></div>
        </div>
    </nav>
      <ul class="navMobile">
      <hr>
      <li><a href="busca.html" class="links">Barbearias</a></li>
      <hr>
      <li><a href="index.html#quemSomos" class="links">Quem somos</a></li>
      <hr>
      <li><a href="infoContaCliente.html" class="links">Minha Conta</a></li>
      </ul>
      
    </nav>
        `;
  } else {
    // Não logado
    header.innerHTML = `
    <nav>
      <ul class="navNormal">
        <li><a href="index.html"><img src="../img/logo.png" alt=""></a></li>
        <li><a href="busca.html" class="links">Barbearias</a></li>
        <li><a href="index.html#quemSomos" class="links">Quem somos</a></li>
        <li><a href="escolherCadastro.html" class="links">Cadastrar</a></li>
        <li><a href="login.html" class="links">Login</a></li>
      </ul>
      <li class="logoMobile"><a href="index.html"><img src="../img/logo.png" alt=""></a></li>
        <div class="mobileMenu" onclick="tresLinhas()">
          <div class="linha1"></div>
          <div class="linha2"></div>
          <div class="linha3"></div>
        </div>
    </nav>
      <ul class="navMobile">
      <hr>
      <li><a href="busca.html" class="links">Barbearias</a></li>
      <hr>
      <li><a href="index.html#quemSomos" class="links">Quem somos</a></li>
      <hr>
      <li><a href="escolherCadastro.html" class="links">Cadastrar</a></li>
      <hr>
      <li><a href="login.html" class="links">Login</a></li>
      <hr>
      </ul>`;
  }
});
// Menu
function tresLinhas() {
  navMobile = document.querySelector(".navMobile")
  navMobile.classList.toggle("show")

  if (navMobile.classList.contains("show")) {
    // delay(50)
    document.querySelector(".linha1").classList.add("active")
    document.querySelector(".linha2").classList.add("active")
    document.querySelector(".linha3").classList.add("active")
  } else {
    // delay(50)
    document.querySelector(".linha1").classList.remove("active")
    document.querySelector(".linha2").classList.remove("active")
    document.querySelector(".linha3").classList.remove("active")
  }
}

let carrossel = document.getElementById("carrossel");

function lojas(variavel) {
  fetch("../db.json")
    .then((response) => response.json())
    .then((data) => {
      const barbearias = data.barbearias;
      const container = document.getElementById("caixaEstabelecimento");

      barbearias.forEach((loja) => {
        const caixaGeral = document.createElement("div");
        caixaGeral.classList.add("caixaGeral");

        // ============= CASO 1 =============
        if (variavel == 1) {
          const foto = document.createElement("img");
          foto.src = "../" + loja.img;
          foto.classList.add("fotoBarbearia");

          const nome = document.createElement("p");
          nome.classList.add("nomeEstabelecimento");
          nome.innerText = loja.nome;

          const avaliacao = document.createElement("div");
          avaliacao.classList.add("avaliacao");

          const nota = document.createElement("img");
          nota.src = "../img/icons/avaliacao.png";
          avaliacao.appendChild(nota);

          const curtidas = document.createElement("p");
          curtidas.innerHTML = loja.curtidas + " ❤";
          avaliacao.appendChild(curtidas);

          caixaGeral.appendChild(foto);
          caixaGeral.appendChild(nome);
          caixaGeral.appendChild(avaliacao);

          carrossel.appendChild(caixaGeral);
        }

        // // ============= CASO 2 =============
        // else if (variavel == 2) {
        //   const caixa = document.createElement("div");
        //   caixa.classList.add("caixaBarbearia");

        //   const foto = document.createElement("img");
        //   foto.src = "../" + loja.img;
        //   foto.classList.add("fotoBarbearia");

        //   const nome = document.createElement("p");
        //   nome.classList.add("nomeEstabelecimento");
        //   nome.innerText = loja.nome;

        //   const localizacao = document.createElement("p");
        //   localizacao.classList.add("localizacao");
        //   localizacao.innerText = loja.localizacao;

        //   const contato = document.createElement("p");
        //   contato.classList.add("contato");
        //   contato.innerText = loja.contato;

        //   const sinopse = document.createElement("p");
        //   sinopse.classList.add("sinopse");
        //   sinopse.innerText = loja.sinopse;

        //   const seta = document.createElement("img");
        //   seta.src = "../img/icons/seta.png";
        //   seta.classList.add("seta");

        //   const caixaInvisivel = document.createElement("div");
        //   caixaInvisivel.classList.add("caixaInvisivel");
        //   caixaInvisivel.appendChild(sinopse);
          
        //   caixaGeral.onclick = () => {
        //     caixaGeral.classList.toggle("active");
        //     caixaInvisivel.classList.toggle("active");
        //   };
          
        //   const caixaInformacoes = document.createElement("div");
        //   caixaInformacoes.classList.add("caixaInformacoes");
        //   caixaInformacoes.appendChild(nome);
        //   caixaInformacoes.appendChild(localizacao);
        //   caixaInformacoes.appendChild(contato);

        //   caixa.appendChild(foto);
        //   caixa.appendChild(caixaInformacoes);
        //   caixa.appendChild(seta);

        //   caixaGeral.appendChild(caixa);
        //   caixaGeral.appendChild(caixaInvisivel);

        //   container.appendChild(caixaGeral);
        // }
      });
    });
}


// cadastro barbeiro
function avancar() {
  document.getElementById("etapa").innerText = "2";
  document.getElementById("etapa1").classList.toggle("invisivel");
  document.getElementById("etapa2").classList.toggle("invisivel");
  document.getElementById("botao2").style.display = "inline-block";
  document.getElementById("botao3").style.display = "inline-block";
  document.getElementById("botao1").style.display = "none";
}
function voltar() {
  document.getElementById("etapa1").classList.toggle("invisivel");
  document.getElementById("etapa2").classList.toggle("invisivel");
  document.getElementById("etapa").innerText = "1";
  document.getElementById("botao2").style.display = "none";
  document.getElementById("botao3").style.display = "none";
  document.getElementById("botao1").style.display = "inline-block";
}

// Carrosel
// TESTE-----------------

let product = document.getElementsByClassName("caixaBarbearia");
let productStyles = undefined
let widthRestante = undefined
let numberProduct = undefined
let span = document.getElementsByTagName("span");
// let product_page = Math.ceil(product.length / 4);
let l = 0;
let movePer = 0;

setTimeout(() => {
  // Pegar todos os produtos e quantos são
  product = document.getElementsByClassName("caixaBarbearia");
  numberProduct = product.length

  function updateWidth(){
    // Pegar os estilos de um produto e do carrosel
    productStyles = window.getComputedStyle(product[0])
    carrosselStyles = window.getComputedStyle(carrossel)

    // Pega o width desses elementos
    const widthProduct = parseFloat(productStyles.getPropertyValue("width").replace("px", "")) + 26 // 26 = border + padding
    const widthVisivel = parseFloat(carrosselStyles.getPropertyValue("width").replace("px", ""))

    // tamanho_oculto = tamanho_produto * numero_produtos - tamanho_visivel_carrossel
    widthRestante = widthProduct * numberProduct - widthVisivel

    // tamanho_mover = tamanho_oculto / numero_produtos
    movePer = widthRestante / numberProduct

  }

  updateWidth()

  // Atualiza valores para ficar responsivo
  window.addEventListener("resize", () => updateWidth)
}, 500) // Espera carregar produtos do db

// ------------



let right_mover = () => {
  l = l + movePer;
  if (product == 1) {
    l = 0;
  }
  for (const i of product) {
    if (l > widthRestante) {
      l = l - movePer;
    }
    i.style.left = "-" + l + "px";
  }
};

let left_mover = () => {
  l = l - movePer;
  if (l <= 0) {
    l = 0;
  }
  for (const i of product) {
    i.style.left = "-" + l + "px";
  }
};

span[1].onclick = () => { right_mover(); }
span[0].onclick = () => { left_mover(); }
// span[1].onclick = () => {
//   right_mover();
// };
// span[0].onclick = () => {
//   left_mover();
// };