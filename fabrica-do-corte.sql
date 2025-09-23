-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23-Set-2025 às 21:54
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fabrica-do-corte`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `id_agendamento` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_disponibilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento_servico`
--

CREATE TABLE `agendamento_servico` (
  `id_servico_agendado` int(11) NOT NULL,
  `id_agendamento` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sobrenome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidade`
--

CREATE TABLE `disponibilidade` (
  `id_disponibilidade` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL,
  `dia` date NOT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disponibilidade_funcionario`
--

CREATE TABLE `disponibilidade_funcionario` (
  `id_disponibilidade_funcionario` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_disponibilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estabelecimento`
--

CREATE TABLE `estabelecimento` (
  `id_estabelecimento` int(11) NOT NULL,
  `nome_proprietario` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_proprietario` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_proprietario` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_estabelecimento` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_estabelecimento` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localizacao` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_barbearia` blob DEFAULT NULL,
  `foto_estabelecimento` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estabelecimentos_salvos`
--

CREATE TABLE `estabelecimentos_salvos` (
  `id_estabelecimento_salvo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id_funcionario` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE `servico` (
  `id_servico` int(11) NOT NULL,
  `id_estabelecimento` int(11) NOT NULL,
  `nome_servico` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(6,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico_funcionario`
--

CREATE TABLE `servico_funcionario` (
  `id_servico_funcionario` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_disponibilidade` (`id_disponibilidade`);

--
-- Índices para tabela `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD PRIMARY KEY (`id_servico_agendado`),
  ADD KEY `id_agendamento` (`id_agendamento`),
  ADD KEY `id_servico` (`id_servico`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`id_disponibilidade`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`);

--
-- Índices para tabela `disponibilidade_funcionario`
--
ALTER TABLE `disponibilidade_funcionario`
  ADD PRIMARY KEY (`id_disponibilidade_funcionario`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_disponibilidade` (`id_disponibilidade`);

--
-- Índices para tabela `estabelecimento`
--
ALTER TABLE `estabelecimento`
  ADD PRIMARY KEY (`id_estabelecimento`),
  ADD UNIQUE KEY `email_proprietario` (`email_proprietario`),
  ADD UNIQUE KEY `localizacao` (`localizacao`);

--
-- Índices para tabela `estabelecimentos_salvos`
--
ALTER TABLE `estabelecimentos_salvos`
  ADD PRIMARY KEY (`id_estabelecimento_salvo`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`);

--
-- Índices para tabela `servico`
--
ALTER TABLE `servico`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `id_estabelecimento` (`id_estabelecimento`);

--
-- Índices para tabela `servico_funcionario`
--
ALTER TABLE `servico_funcionario`
  ADD PRIMARY KEY (`id_servico_funcionario`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_servico` (`id_servico`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  MODIFY `id_servico_agendado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  MODIFY `id_disponibilidade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `disponibilidade_funcionario`
--
ALTER TABLE `disponibilidade_funcionario`
  MODIFY `id_disponibilidade_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estabelecimento`
--
ALTER TABLE `estabelecimento`
  MODIFY `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estabelecimentos_salvos`
--
ALTER TABLE `estabelecimentos_salvos`
  MODIFY `id_estabelecimento_salvo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico`
--
ALTER TABLE `servico`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servico_funcionario`
--
ALTER TABLE `servico_funcionario`
  MODIFY `id_servico_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `agendamento_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`),
  ADD CONSTRAINT `agendamento_ibfk_3` FOREIGN KEY (`id_disponibilidade`) REFERENCES `disponibilidade` (`id_disponibilidade`);

--
-- Limitadores para a tabela `agendamento_servico`
--
ALTER TABLE `agendamento_servico`
  ADD CONSTRAINT `agendamento_servico_ibfk_1` FOREIGN KEY (`id_agendamento`) REFERENCES `agendamento` (`id_agendamento`),
  ADD CONSTRAINT `agendamento_servico_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`);

--
-- Limitadores para a tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD CONSTRAINT `disponibilidade_ibfk_1` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id_estabelecimento`);

--
-- Limitadores para a tabela `disponibilidade_funcionario`
--
ALTER TABLE `disponibilidade_funcionario`
  ADD CONSTRAINT `disponibilidade_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`),
  ADD CONSTRAINT `disponibilidade_funcionario_ibfk_2` FOREIGN KEY (`id_disponibilidade`) REFERENCES `disponibilidade` (`id_disponibilidade`);

--
-- Limitadores para a tabela `estabelecimentos_salvos`
--
ALTER TABLE `estabelecimentos_salvos`
  ADD CONSTRAINT `estabelecimentos_salvos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `estabelecimentos_salvos_ibfk_2` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id_estabelecimento`);

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id_estabelecimento`);

--
-- Limitadores para a tabela `servico`
--
ALTER TABLE `servico`
  ADD CONSTRAINT `servico_ibfk_1` FOREIGN KEY (`id_estabelecimento`) REFERENCES `estabelecimento` (`id_estabelecimento`);

--
-- Limitadores para a tabela `servico_funcionario`
--
ALTER TABLE `servico_funcionario`
  ADD CONSTRAINT `servico_funcionario_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id_funcionario`),
  ADD CONSTRAINT `servico_funcionario_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
