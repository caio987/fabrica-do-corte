// //Exibir a mensagem de erro/cadastrado
// //Pega o que foi enviado pela barra de pesquisa
// const pegar = new URLSearchParams(window.location.search);
// //Pega a menssagem enviada
// const mensagem = pegar.get('mensagem')
// if (mensagem) {
//   //Exibe um alert com a mensagem de erro
//   alert(mensagem)
//   Swal.fire({
//     title: "Compra Confirmada",
//     text: mensagem,
//     icon: "success"
//   });
// }

document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const mensagem = params.get("mensagem");
    const tipo = params.get("tipo");

    if (!mensagem) return;
 
    Swal.fire({
        title: tipo === "sucesso" ? "Tudo certo!" : "Ops...",
        text: mensagem,
        icon: tipo === "sucesso" ? "success" : "error",
        confirmButtonText: "OK"
    });
});

