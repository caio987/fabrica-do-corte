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
      <li><a href="index.html"><img src="../img/logo.png" alt=""></a></li>
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
      <li><a href="index.html"><img src="../img/logo.png" alt="" style="margin-top: 10px; margin-bottom: -10px; width: 80px;"></a></li>
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

// // Carrosel
// // TESTE-----------------

// let product = document.getElementsByClassName("caixaBarbearia");
// let productStyles = undefined
// let widthRestante = undefined
// let numberProduct = undefined
// let span = document.getElementsByTagName("span");
// // let product_page = Math.ceil(product.length / 4);
// let l = 0;
// let movePer = 0;

// setTimeout(() => {
//   // Pegar todos os produtos e quantos são
//   product = document.getElementsByClassName("caixaBarbearia");
//   numberProduct = product.length

//   function updateWidth(){
//     // Pegar os estilos de um produto e do carrosel
//     productStyles = window.getComputedStyle(product[0])
//     carrosselStyles = window.getComputedStyle(carrossel)

//     // Pega o width desses elementos
//     const widthProduct = parseFloat(productStyles.getPropertyValue("width").replace("px", "")) + 26 // 26 = border + padding
//     const widthVisivel = parseFloat(carrosselStyles.getPropertyValue("width").replace("px", ""))

//     // tamanho_oculto = tamanho_produto * numero_produtos - tamanho_visivel_carrossel
//     widthRestante = widthProduct * numberProduct - widthVisivel

//     // tamanho_mover = tamanho_oculto / numero_produtos
//     movePer = widthRestante / numberProduct

//   }

//   updateWidth()

//   // Atualiza valores para ficar responsivo
//   window.addEventListener("resize", () => updateWidth)
// }, 500) // Espera carregar produtos do db

// // ------------  

// Carrosel
let span = document.getElementsByTagName("span");
let product = document.getElementsByClassName("caixaGeral");
let product_page = Math.ceil(product.length / 4);
let l = 0;
let movePer = 27;
let maxMove = 108;

let right_mover = () => {
  l = l + movePer;
  console.log(l);
  if (product == 1) {
    l = 0;
  }
  for (const i of product) {
    if (l > maxMove) {
      l = l - movePer;
    }
    i.style.left = "-" + l + "%";
  }
};

let left_mover = () => {
  l = l - movePer;
  console.log(l);
  if (l <= 0) {
    l = 0;
  }
  for (const i of product) {
    i.style.left = "-" + l + "%";
  }
};

span[1].onclick = () => { right_mover(); }
span[0].onclick = () => { left_mover(); }
span[1].onclick = () => {
  right_mover();
};
span[0].onclick = () => {
  left_mover();
};