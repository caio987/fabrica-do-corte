//Exibir a mensagem de erro/cadastrado
//Pega o que foi enviado pela barra de pesquisa
const pegar = new URLSearchParams(window.location.search);
//Pega a menssagem enviada
const mensagem = pegar.get('mensagem')
if (mensagem) {
  //Exibe um alert com a mensagem de erro
  alert(mensagem)
}