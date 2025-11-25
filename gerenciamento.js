let datasSelecionadas = [];
let horariosSelecionados = [];
let servico = [];
let preco = [];
const caixa = document.getElementById('caixa');
const formFuncionario = document.getElementById('formFuncionario');

async function adFuncionario() {
  formFuncionario.style.display = 'block';
  try {
    const resposta = await fetch("../php/servicoInformacao.php");
    const dados = await resposta.json();

    const selects = [document.getElementById('selectServico1'), document.getElementById('selectServico2'), document.getElementById('selectServico3')];
    selects.forEach(select => {
      select.innerHTML = '<option value="">Selecione um corte</option>';
      dados.forEach(servico => {
        const option = document.createElement('option');
        option.value = servico.id_servico;
        option.textContent = servico.nome_servico;
        select.appendChild(option);
      });
    });

    const respDias = await fetch("../php/buscarDisponibilidade.php");
    const diasHorarios = await respDias.json();

    const container = document.getElementById('diasHorariosContainer');
    container.innerHTML = '';
    diasHorarios.forEach(item => {
      const div = document.createElement('div');
      div.innerHTML = `<label><input type="checkbox" name="diasHorarios[]" value="${item.id_disponibilidade}"> ${item.dia} - ${item.horario}</label>`;
      container.appendChild(div);
    });

  } catch (e) {
    console.error('Erro ao carregar dados:', e);
    document.getElementById('diasHorariosContainer').innerHTML = 'Erro ao carregar!';
  }
}

document.addEventListener('DOMContentLoaded', async () => {
  fetch("../php/datasExpiradas.php");
  try {
    const funcionarios = document.getElementById('caixaFuncionario');
    const resposta = await fetch('../php/informacaoEstabelecimento.php');
    const dados = await resposta.json();
    dados.forEach(item => {
      caixa.innerHTML += `<input type="text" name="servico" value="${item.nome_servico}" disabled><input type="text" name="preco" value="${item.preco}" disabled><br>`;
    });
    const resposta_funcionatrio = await fetch('../php/funcionario.php');
    const dados_funcionario = await resposta_funcionatrio.json();
    dados_funcionario.forEach(item => {
      funcionarios.innerHTML += /*html*/`
            <div class="funcionario">
              <img src=${item.foto} alt=${item.nome}>
              <p>${item.nome}</p>
            </div>
        `
    })
  } catch (erro) {
    console.error('Erro ao carregar dados:', erro);
  }


});

function adicionar() {
  const corteValue = document.getElementById('corte').value;
  const precoValue = document.getElementById('preco').value;

  // Verifica se o serviço já está cadastrado ou se algum campo está vazio
  if (servico.includes(corteValue) || corteValue === '' || precoValue === '') {
    Swal.fire({
      title: "ERRO",
      text: "Usuário já cadastrado ou campo(s) sem valor",
      icon: "error",  // Corrigido para usar o valor "error"
      confirmButtonText: "OK"
    });
  } else {
    caixa.innerHTML = '';  // Limpa a área 'caixa' antes de adicionar novos itens

    // Adiciona o novo serviço e preço
    servico.push(corteValue);
    preco.push(precoValue);

    // Cria o HTML dinamicamente para a lista atualizada
    servico.forEach((item, i) => {
      // Cria o campo de input para o serviço
      const serviceInput = document.createElement('input');
      serviceInput.type = 'text';
      serviceInput.name = 'servico';
      serviceInput.value = item;

      // Cria o campo de input para o preço
      const priceInput = document.createElement('input');
      priceInput.type = 'text';
      priceInput.name = 'preco';
      priceInput.value = preco[i];

      // Cria a quebra de linha
      const lineBreak = document.createElement('br');

      // Adiciona os inputs e a quebra de linha na 'caixa'
      caixa.appendChild(serviceInput);
      caixa.appendChild(priceInput);
      caixa.appendChild(lineBreak);
    });
  }
}


document.addEventListener('DOMContentLoaded', async function() {
  const hoje = new Date();
  hoje.setHours(0, 0, 0, 0);
  const calendarEl = document.getElementById('calendar');
  const horariosEl = document.getElementById('horarios');
  let datasBloqueadas = [];

  try {
    const resposta = await fetch('../php/datasCadastradas.php');
    datasBloqueadas = await resposta.json();
  } catch (erro) {
    console.error('Erro ao carregar datas cadastradas:', erro);
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'pt-br',
    validRange: function (nowDate) {
      const maxDate = new Date(nowDate);
      maxDate.setMonth(maxDate.getMonth() + 3);
      return { start: nowDate, end: maxDate };
    },
    dateClick: function (info) {
      const dataStr = info.dateStr;
      if (datasBloqueadas.includes(dataStr)) { alert('Essa data já está cadastrada'); return; }
      if (datasSelecionadas.includes(dataStr)) { datasSelecionadas.splice(datasSelecionadas.indexOf(dataStr), 1); }
      else { datasSelecionadas.push(dataStr); }
      atualizarEventos();
      mostrarHorarios(dataStr);
    }
  });

  calendar.render();
  atualizarEventos();

  function atualizarEventos() {
    calendar.getEvents().forEach(e => e.remove());
    datasSelecionadas.forEach(d => calendar.addEvent({ title: "Selecionado", start: d, display: 'background', backgroundColor: '#444743' }));
    datasBloqueadas.forEach(d => calendar.addEvent({ title: "Indisponível", start: d, display: 'background', backgroundColor: '#512d2d' }));
  }

  function mostrarHorarios(dataStr) {
    horariosSelecionados = [];
    horariosEl.innerHTML = '';
    horariosEl.style.display = 'flex';
    const startHour = 8;
    const endHour = 20;
    const intervalo = 30;
    for (let h = startHour; h < endHour; h++) {
      for (let m = 0; m < 60; m += intervalo) {
        const horaStr = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
        const btn = document.createElement('button');
        btn.textContent = horaStr;
        btn.classList.add('hora-btn');
        btn.addEventListener('click', () => {
          if (horariosSelecionados.includes(horaStr)) {
            horariosSelecionados.splice(horariosSelecionados.indexOf(horaStr), 1);
            btn.classList.remove('selecionada');
          } else {
            horariosSelecionados.push(horaStr);
            btn.classList.add('selecionada');
          }
        });
        horariosEl.appendChild(btn);
      }
    }
  }
});

async function enviarDisponibilidade() {
  // Verifica se há pelo menos uma data e um horário
  if (datasSelecionadas.length === 0 || horariosSelecionados.length === 0) {
    alert("Selecione pelo menos uma data e um horário!");
    return;
  }

  try {
    // 1️⃣ Envia datas e horários ao PHP
    const resp1 = await fetch("../php/disponibilidade.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        datas: datasSelecionadas,
        horarios: horariosSelecionados
      })
    });

    const texto1 = await resp1.text();
    console.log("📅 Retorno de disponibilidade.php:", texto1);

    alert("Dados enviados com sucesso!");
    location.reload();
  } catch (erro) {
    console.error("Erro ao enviar dados:", erro);
    alert("Erro ao enviar os dados. Verifique o console para mais detalhes.");
  }
}

async function cadastroServico() {
  // 2️⃣ Envia serviços e preços ao PHP
  const resp2 = await fetch("../php/servico.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      servico: servico,
      preco: preco
    })
  });

  const texto2 = await resp2.text();
  console.log("💈 Retorno de servico.php:", texto2);
  alert("Serviço cadastrado");
  location.reload();

}


async function enviarFuncionario() {
  const form = document.querySelector('#formFuncionario form');
  const nome = form.nome.value;
  const foto = form.foto.files[0];
  const servicosSelecionados = [form.selectServico1.value, form.selectServico2.value, form.selectServico3.value].filter(v => v !== "");
  const checkboxes = Array.from(form.querySelectorAll('input[name="diasHorarios[]"]:checked'));
  const diasHorariosSelecionados = checkboxes.map(cb => cb.value); // IDs corretos

  const formData = new FormData();
  formData.append('nome', nome);
  formData.append('foto', foto);
  formData.append('servicos', JSON.stringify(servicosSelecionados));
  formData.append('diasHorarios', JSON.stringify(diasHorariosSelecionados));
  formData.append('horariosSelecionados', JSON.stringify(horariosSelecionados));

  try {
    const resposta = await fetch('../php/cadastrarFuncionario.php', { method: 'POST', body: formData });
    const resultado = await resposta.text();

    // Exibe no console
    console.log('Retorno do PHP:\n', resultado);
    console.log('Nome do funcionário:', nome);
    console.log('Serviços selecionados:', servicosSelecionados);
    console.log('Dias/Horários selecionados (IDs):', diasHorariosSelecionados);
    console.log('Horários do calendário selecionados:', horariosSelecionados);

    form.reset();
    formFuncionario.style.display = 'none';
    location.reload();
  } catch (erro) {
    console.error('Erro ao cadastrar funcionário:', erro);
  }
}