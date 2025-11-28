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

    const selects = [
      document.getElementById('selectServico1'),
      document.getElementById('selectServico2'),
      document.getElementById('selectServico3')
    ];

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
    Swal.fire({
      title: 'Erro',
      text: 'Não foi possível carregar os serviços ou horários!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
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
    const resposta_funcionario = await fetch('../php/funcionario.php');
    const dados_funcionario = await resposta_funcionario.json();
    dados_funcionario.forEach(item => {
      const funcionario = document.createElement('div');
      funcionario.className='funcionario'
      const foto = document.createElement('img');
      const nome = document.createElement('p');
      const excluir = document.createElement('button');
      excluir.textContent = 'Excluir';
       excluir.style.backgroundColor = "#d9534f";
          excluir.style.color = "white";
          excluir.style.border = "none";
          excluir.style.padding = "8px 14px";
          excluir.style.borderRadius = "5px";
          excluir.style.cursor = "pointer";
        excluir.addEventListener('click', async () => {
    try {
        const resposta = await fetch(`../php/excluirBarbeiro.php?id=${item.id_funcionario}`);
        const dados = await resposta.text();

        if (dados.toLowerCase().includes('erro')) {
            // Se a resposta contiver "erro", mostramos como erro
            Swal.fire({
                title: 'Erro',
                text: dados,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // Caso contrário, mostramos como sucesso
            Swal.fire({
                title: 'Sucesso',
                text: dados,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Opcional: recarregar a página ou remover o item da lista
                location.reload();
            });
        }
    } catch (erro) {
        Swal.fire({
            title: 'Erro',
            text: 'Não foi possível conectar ao servidor!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error('Erro ao excluir barbeiro:', erro);
    }
});

      foto.src=item.foto;
      nome.textContent = item.nome;
      funcionarios.appendChild(funcionario);
      funcionario.appendChild(foto);
      funcionario.appendChild(nome);
      funcionario.appendChild(excluir);
      
        ;
    });
  } catch (erro) {
    console.error('Erro ao carregar dados:', erro);
    Swal.fire({
      title: 'Erro',
      text: 'Não foi possível carregar os funcionários ou serviços!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  }
});

function adicionar() {
  const corteValue = document.getElementById('corte').value;
  const precoValue = document.getElementById('preco').value;

  if (servico.includes(corteValue) || corteValue === '' || precoValue === '') {
    Swal.fire({
      title: "Erro",
      text: "Serviço já cadastrado ou campo(s) vazio(s)",
      icon: "error",
      confirmButtonText: "OK"
    });
  } else {
    caixa.innerHTML = '';
    servico.push(corteValue);
    preco.push(precoValue);

    servico.forEach((item, i) => {
      const serviceInput = document.createElement('input');
      serviceInput.type = 'text';
      serviceInput.name = 'servico';
      serviceInput.value = item;

      const priceInput = document.createElement('input');
      priceInput.type = 'text';
      priceInput.name = 'preco';
      priceInput.value = preco[i];

      const lineBreak = document.createElement('br');

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
    Swal.fire({
      title: 'Erro',
      text: 'Não foi possível carregar as datas cadastradas!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
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
      if (datasBloqueadas.includes(dataStr)) {
        Swal.fire({
          title: 'Indisponível',
          text: 'Essa data já está cadastrada',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        return;
      }
      if (datasSelecionadas.includes(dataStr)) {
        datasSelecionadas.splice(datasSelecionadas.indexOf(dataStr), 1);
      } else {
        datasSelecionadas.push(dataStr);
      }
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
  if (datasSelecionadas.length === 0 || horariosSelecionados.length === 0) {
    Swal.fire({
      title: 'Erro',
      text: 'Selecione pelo menos uma data e um horário!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return;
  }

  try {
    const resp1 = await fetch("../php/disponibilidade.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ datas: datasSelecionadas, horarios: horariosSelecionados })
    });

    const texto1 = await resp1.text();
    console.log("📅 Retorno de disponibilidade.php:", texto1);

    Swal.fire({
      title: 'Sucesso!',
      text: 'Dados enviados com sucesso!',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => location.reload());

  } catch (erro) {
    console.error("Erro ao enviar dados:", erro);
    Swal.fire({
      title: 'Erro',
      text: 'Erro ao enviar os dados. Veja o console.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  }
}

async function cadastroServico() {
  if(servico.length === 0 || preco.length === 0){
    Swal.fire({
      title: 'Erro',
      text: 'Nenhum serviço para cadastrar!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return;
  }

  try {
    const resp2 = await fetch("../php/servico.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ servico, preco })
    });

    const texto2 = await resp2.text();
    console.log("💈 Retorno de servico.php:", texto2);

    Swal.fire({
      title: 'Sucesso!',
      text: 'Serviço cadastrado com sucesso!',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => location.reload());

  } catch (erro) {
    console.error("Erro ao cadastrar serviço:", erro);
    Swal.fire({
      title: 'Erro',
      text: 'Não foi possível cadastrar o serviço. Veja o console.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  }
}

async function enviarFuncionario() {
  const form = document.querySelector('#formFuncionario form');
  const nome = form.nome.value;
  const foto = form.foto.files[0];
  const servicosSelecionados = [form.selectServico1.value, form.selectServico2.value, form.selectServico3.value].filter(v => v !== "");
  const checkboxes = Array.from(form.querySelectorAll('input[name="diasHorarios[]"]:checked'));
  const diasHorariosSelecionados = checkboxes.map(cb => cb.value);

  if(!nome || !foto || servicosSelecionados.length === 0 || diasHorariosSelecionados.length === 0){
    Swal.fire({
      title: 'Erro',
      text: 'Preencha todos os campos obrigatórios!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    return;
  }

  const formData = new FormData();
  formData.append('nome', nome);
  formData.append('foto', foto);
  formData.append('servicos', JSON.stringify(servicosSelecionados));
  formData.append('diasHorarios', JSON.stringify(diasHorariosSelecionados));
  formData.append('horariosSelecionados', JSON.stringify(horariosSelecionados));

  try {
    const resposta = await fetch('../php/cadastrarFuncionario.php', { method: 'POST', body: formData });
    const resultado = await resposta.text();
    console.log('Retorno do PHP:\n', resultado);

    Swal.fire({
      title: 'Sucesso!',
      text: 'Funcionário cadastrado com sucesso!',
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => {
      form.reset();
      formFuncionario.style.display = 'none';
      location.reload();
    });

  } catch (erro) {
    console.error('Erro ao cadastrar funcionário:', erro);
    Swal.fire({
      title: 'Erro',
      text: 'Não foi possível cadastrar o funcionário. Veja o console.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  }
}
