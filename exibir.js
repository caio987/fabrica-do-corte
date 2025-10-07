//Esperar carregar a página
document.addEventListener('DOMContentLoaded', async()=>{
    try {
        //Elemento html que vai exibir a resposta
        const div = document.getElementById('div');
        //Fazer uma requirição ao PHP
        const resposta = await fetch('../php/exibir.php');
        const dados = await resposta.json();
        //Caso não tenha nenhum estabelecimento com nome
        if (!dados || dados.length === 0) {
            div.innerHTML = 'Nenhum estabelecimento encontrado';
            return;
        }
        //O que será exibido no html
        let html = '';
        dados.forEach(e => {
            html+= /*html*/`
                <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 100px;">
                    <h2>${e.nome_estabelecimento}</h2>                   
                    ${e.logo ? `<img src="${e.logo}" alt="${e.nome_estabelecimento}"></img>` : '<p>Sem imagem</p>'}
                    <p>Localização: ${e.localizacao}</p>
                    ${e.foto ? `<img src="${e.foto}" alt="${e.nome_estabelecimento}"></img>` : '<p>Sem imagem</p>'}
                    <p>Contato: ${e.telefone_estabelecimento}</p>
                </div>
            `
        });
        div.innerHTML = html;
    } catch (error) {
        console.error('Erro ao pegar os dados da sessão ', error)

    }
})