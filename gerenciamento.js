let datasSelecionadas = [];
let horariosSelecionados = [];
let servico = [];
let preco = [];
const caixa = document.getElementById('caixa');
const formFuncionario = document.getElementById('formFuncionario');

// ====== ADICIONAR NOVO FUNCIONÁRIO ======
async function adFuncionario() {
  formFuncionario.style.display = 'block';
  delete document.querySelector('#formFuncionario form').dataset.editando; // limpa modo edição

  try {
    // Carrega serviços disponíveis
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

    // Carrega dias e horários disponíveis
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

// ====== CARREGA FUNCIONÁRIOS E SERVIÇOS EXISTENTES ======
document.addEventListener('DOMContentLoaded', async () => {
  try {
    const funcionarios = document.getElementById('caixaFuncionario');

    // Carrega informações dos serviços existentes
    const resposta = await fetch('../php/informacaoEstabelecimento.php');
    const dados = await resposta.json();
    dados.forEach(item => {
      caixa.innerHTML += `<input type="text" name="servico" value="${item.nome_servico}">
                          <input type="text" name="preco" value="${item.preco}"><br>`;
    });

    // Carrega os funcionários já cadastrados
    const resposta_funcionario = await fetch('../php/funcionario.php');
    const dados_funcionario = await resposta_funcionario.json();

    // === Recria a caixa de "Novo" ===
    funcionarios.innerHTML = `
      <div id="funcionario" class="funcionario" onclick="adFuncionario()">
        <img src="../img/icons/+.png" alt="">
        <p>Novo</p>
      </div>
    `;

    // === Lista os barbeiros cadastrados ===
    dados_funcionario.forEach(item => {
      funcionarios.innerHTML += `
        <div class="funcionario">
          <p>${item.nome}</p>
          <img src="${item.foto}" alt="${item.nome}">
          <button type="button" class="buttonBonito" onclick="editarFuncionario(${item.id_funcionario})">Editar</button>
        </div>
      `;
    });

  } catch (erro) {
    console.error('Erro ao carregar dados:', erro);
  }
});

// ====== ADICIONAR NOVOS SERVIÇOS ======
function adicionar() {
  if (servico.includes(document.getElementById('corte').value)) {
    alert('Corte já está adicionado');
  } else {
    caixa.innerHTML = '';
    servico.push(document.getElementById('corte').value);
    preco.push(document.getElementById('preco').value);
    servico.forEach((item, i) => {
      caixa.innerHTML += `<input type="text" name="servico" value="${item}">
                          <input type="text" name="preco" value="${preco[i]}"><br>`;
    });
  }
}

// ====== CALENDÁRIO DE DISPONIBILIDADE ======
document.addEventListener('DOMContentLoaded', async function () {
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
      if (datasBloqueadas.includes(dataStr)) {
        alert('Essa data já está cadastrada');
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
    datasSelecionadas.forEach(d =>
      calendar.addEvent({
        title: "Selecionado",
        start: d,
        display: 'background',
        backgroundColor: '#444743'
      })
    );
    datasBloqueadas.forEach(d =>
      calendar.addEvent({
        title: "Indisponível",
        start: d,
        display: 'background',
        backgroundColor: '#512d2d'
      })
    );
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

// ====== ENVIAR DISPONIBILIDADE ======
async function enviarDisponibilidade() {
  if (datasSelecionadas.length === 0 || horariosSelecionados.length === 0) {
    alert("Selecione pelo menos uma data e um horário!");
    return;
  }

  try {
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

// ====== CADASTRO DE SERVIÇOS ======
async function cadastroServico() {
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

// ====== CADASTRAR / EDITAR FUNCIONÁRIO ======
async function enviarFuncionario() {
  const form = document.querySelector('#formFuncionario form');
  const nome = form.nome.value;
  const foto = form.foto.files[0];
  const servicosSelecionados = [form.selectServico1.value, form.selectServico2.value, form.selectServico3.value].filter(v => v !== "");
  const checkboxes = Array.from(form.querySelectorAll('input[name="diasHorarios[]"]:checked'));
  const diasHorariosSelecionados = checkboxes.map(cb => cb.value);

  const formData = new FormData();
  formData.append('nome', nome);
  if (foto) formData.append('foto', foto);
  formData.append('servicos', JSON.stringify(servicosSelecionados));
  formData.append('diasHorarios', JSON.stringify(diasHorariosSelecionados));
  formData.append('horariosSelecionados', JSON.stringify(horariosSelecionados));

  let endpoint = '../php/cadastrarFuncionario.php';
  if (form.dataset.editando) {
    formData.append('id', form.dataset.editando);
    endpoint = '../php/editarFuncionario.php';
  }

  try {
    const resposta = await fetch(endpoint, { method: 'POST', body: formData });
    const resultado = await resposta.text();
    console.log('Retorno do PHP:', resultado);

    alert(form.dataset.editando ? 'Funcionário atualizado!' : 'Funcionário cadastrado!');
    form.reset();
    formFuncionario.style.display = 'none';
    delete form.dataset.editando;
    location.reload();

  } catch (erro) {
    console.error('Erro ao enviar dados:', erro);
  }
}

// ====== EDITAR FUNCIONÁRIO EXISTENTE ======
async function editarFuncionario(id) {
  formFuncionario.style.display = 'block';
  const form = document.querySelector('#formFuncionario form');
  form.dataset.editando = id;

  try {
    // 1️⃣ Carrega selects e checkboxes antes de preencher
    const [respServicos, respDias] = await Promise.all([
      fetch("../php/servicoInformacao.php"),
      fetch("../php/buscarDisponibilidade.php")
    ]);

    const servicosDisponiveis = await respServicos.json();
    const diasHorariosDisponiveis = await respDias.json();

    // Preenche selects
    const selects = [form.selectServico1, form.selectServico2, form.selectServico3];
    selects.forEach(select => {
      select.innerHTML = '<option value="">Selecione um corte</option>';
      servicosDisponiveis.forEach(s => {
        const option = document.createElement('option');
        option.value = s.id_servico;
        option.textContent = s.nome_servico;
        select.appendChild(option);
      });
    });

    // Preenche checkboxes
    const container = document.getElementById('diasHorariosContainer');
    container.innerHTML = '';
    diasHorariosDisponiveis.forEach(item => {
      const div = document.createElement('div');
      div.innerHTML = `
        <label>
          <input type="checkbox" name="diasHorarios[]" value="${item.id_disponibilidade}">
          ${item.dia} - ${item.horario}
        </label>`;
      container.appendChild(div);
    });

    // 2️⃣ Busca dados do barbeiro
    const resp = await fetch(`../php/editarFuncionarioDados.php?id=${id}`);
    const dados = await resp.json();
    console.log("💈 Dados carregados para edição:", dados);

    // 3️⃣ Preenche nome e foto
    form.nome.value = dados.nome;
    if (dados.foto && dados.foto.startsWith("data:image")) {
      const imgPreview = document.getElementById('fotoPreview');
      if (imgPreview) {
        imgPreview.src = dados.foto;
        imgPreview.style.display = 'block';
      }
    }

    // 4️⃣ Marca os serviços selecionados
    selects.forEach(sel => {
      for (const option of sel.options) {
        if (dados.servicos.includes(option.value)) {
          option.selected = true;
        }
      }
    });

    // 5️⃣ Marca os dias e horários
    const checkboxes = form.querySelectorAll('input[name="diasHorarios[]"]');
    checkboxes.forEach(cb => {
      if (dados.diasHorarios.includes(cb.value)) {
        cb.checked = true;
      }
    });

  } catch (erro) {
    console.error('Erro ao carregar dados do barbeiro:', erro);
  }
}
