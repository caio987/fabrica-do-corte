function sair() {
    window.location.href = "../php/sair.php?";
}
const caixa = document.getElementById('caixa');
const link = document.getElementById('link');

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const resposta = await fetch('../php/informacoes.php');
        const dados = await resposta.json();
        if (dados.tipo == 'Proprietário') {
            let links = `
                <a href="infoContaCliente.html" class="link ativo">Informações da conta</a>
                <a href="agendamentoSalvo.html" class="link">Agendamento</a>
                <a href="gerenciaEstabelecimento.html" class="link">Estabelecimento</a>
                    `;
            let html = `
                <div class="margem">
                <label for="">Nome:</label><br>
                <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.nome_proprietario}"><br>
            </div>
            <div class="margem">
                <label for="">E-mail:</label><br>
                <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.email_proprietario}"><br>
            </div>
            <div class="margem">
                <label for="">Telefone:</label><br>
                <input style="width: 70%; margin: 0; display: inline;" type="tel" disabled value="${dados.dados.telefone_estabelecimento}"><br>
            </div>
            <div class="margem">
                <label for="">Nome do estabelecimento:</label><br>
                <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.nome_estabelecimento}"><br>
            </div>
            <div class="margem">
                <label for="">Localização:</label><br>
                <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.localizacao}"><br>
                </div>
            <div class="margem">
                <label for="">Texto de apresentação</label><br>
                <textarea id="apresentacao" name="" id="" style="width: 88%; margin: 0px; display: inline; height: 147px;" disabled >${dados.dados.apresentacao}</textarea><br>
            </div>
            <div class="margem">
                <label for="">Logo:</label></br>
                <img src="${dados.dados.logo}" alt="${dados.dados.nome_estabelecimento}"><br>
            </div>
            <div class="margem">
                <label for="">Foto do estabelecimento</label></br>
                <img src="${dados.dados.foto}" alt="${dados.dados.foto}"><br>
            </div>
            <button id="button" type="button" onclick="sair()" style="display:block;margin: 10px auto;">Sair da conta</button>
                    `;
            caixa.innerHTML = html;
            link.innerHTML = links;
        } else if (dados.tipo == 'Cliente') {
            let links = `
                        <a href="infoContaCliente.html" class="link ativo">Informações da conta</a>
                        <a href="agendamentoSalvo.html" class="link">Agendamento</a>
                    `;
            let html = `
                <div class="margem">
                    <label for="">Nome:</label>
                    <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.nome}"><br>
                </div>
                <div class="margem">
                    <label for="">Sobrenome:</label>
                    <input style="width: 70%; margin: 0 0px 0 0; display: inline;" type="text" disabled value="${dados.dados.sobrenome}"><br>
                </div>
                <div class="margem">
                    <label for="">E-mail:</label>
                    <input style="width: 70%; margin: 0; display: inline;" type="text" disabled value="${dados.dados.email}"><br>
                </div>
                <button id="button" type="button" onclick="sair()">Sair da conta</button>
            </div>
                    `;
            caixa.innerHTML = html;
            link.innerHTML = links;
        }else{
            console.log('Erro')
            console.log(dados.tipo)
        }

    } catch (error) {
        console.error('Erro ao pegar os dados', error)
    }
});