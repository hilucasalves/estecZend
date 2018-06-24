-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24-Jun-2018 às 18:41
-- Versão do servidor: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estec2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE `atendimento` (
  `idAtendimento` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idTurma` int(10) UNSIGNED DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `idTipoServico` int(10) UNSIGNED NOT NULL,
  `idMatricula` int(10) UNSIGNED DEFAULT NULL,
  `statusAtendimento` char(1) NOT NULL,
  `dataPrevisao` date NOT NULL,
  `dataFim` datetime DEFAULT NULL,
  `feedback` mediumtext,
  `nota` double DEFAULT NULL,
  `observacao` mediumtext,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `matricula`
--

CREATE TABLE `matricula` (
  `idMatricula` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idTurma` int(10) UNSIGNED NOT NULL,
  `statusMatricula` char(1) NOT NULL,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `idMovimentacao` int(10) UNSIGNED NOT NULL,
  `idProduto` int(10) UNSIGNED NOT NULL,
  `qtd` int(10) UNSIGNED NOT NULL,
  `tipoMovimentacao` char(1) NOT NULL,
  `dataValidade` date DEFAULT NULL,
  `statusMovimentacao` char(1) NOT NULL DEFAULT 'A',
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilacao`
--

CREATE TABLE `perfilacao` (
  `idPerfilAcao` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `apelido` varchar(45) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `perfilacao`
--

INSERT INTO `perfilacao` (`idPerfilAcao`, `nome`, `apelido`) VALUES
(1, 'index', 'Index'),
(2, 'add', 'Adicionar'),
(3, 'view', 'Visualizar'),
(4, 'edit', 'Alterar'),
(5, 'delete', 'Excluir'),
(6, 'acesso-negado', 'Acesso Negado'),
(7, 'alterar-senha', 'Alterar Senha'),
(8, 'logout', 'sair'),
(9, 'meus-dados', 'Meus Dados'),
(10, 'excel', 'Exportar em Excel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilcontrole`
--

CREATE TABLE `perfilcontrole` (
  `idPerfilControle` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `apelido` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `perfilcontrole`
--

INSERT INTO `perfilcontrole` (`idPerfilControle`, `nome`, `apelido`, `dataAtualizacao`) VALUES
(1, 'Auth', 'Autenticação', '2018-06-24 12:38:38'),
(2, 'Usuario', 'Usuário', '2018-06-24 12:38:38'),
(3, 'TipoServico', 'Serviços', '2018-06-24 12:39:36'),
(4, 'Produto', 'Estoque', '2018-06-24 12:39:36'),
(5, 'Movimentacao', 'Movimentações', '2018-06-24 12:40:06'),
(6, 'Turma', 'Turmas', '2018-06-24 12:40:06'),
(7, 'Matricula', 'Matrículas', '2018-06-24 12:40:33'),
(8, 'Atendimento', 'Atendimentos', '2018-06-24 12:40:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilpermissao`
--

CREATE TABLE `perfilpermissao` (
  `idPerfilPermissao` int(11) NOT NULL,
  `idPerfilRecurso` int(11) NOT NULL,
  `idUsuarioTipo` int(11) NOT NULL,
  `permitido` int(11) NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `perfilpermissao`
--

INSERT INTO `perfilpermissao` (`idPerfilPermissao`, `idPerfilRecurso`, `idUsuarioTipo`, `permitido`, `dataAtualizacao`) VALUES
(1, 1, 1, 1, '2018-06-24 12:48:33'),
(2, 2, 1, 1, '2018-06-24 12:48:33'),
(3, 3, 1, 1, '2018-06-24 13:01:30'),
(4, 4, 1, 1, '2018-06-24 13:01:30'),
(5, 5, 1, 1, '2018-06-24 13:01:30'),
(6, 6, 1, 1, '2018-06-24 13:01:30'),
(7, 7, 1, 1, '2018-06-24 13:01:30'),
(8, 8, 1, 1, '2018-06-24 13:01:52'),
(9, 9, 1, 1, '2018-06-24 13:01:52'),
(10, 10, 1, 1, '2018-06-24 13:06:29'),
(11, 11, 1, 1, '2018-06-24 13:06:29'),
(12, 12, 1, 1, '2018-06-24 13:06:29'),
(13, 13, 1, 1, '2018-06-24 13:06:29'),
(14, 14, 1, 1, '2018-06-24 13:06:29'),
(15, 15, 1, 1, '2018-06-24 13:08:47'),
(16, 16, 1, 1, '2018-06-24 13:08:47'),
(17, 17, 1, 1, '2018-06-24 13:08:47'),
(18, 18, 1, 1, '2018-06-24 13:08:47'),
(19, 19, 1, 1, '2018-06-24 13:08:47'),
(20, 20, 1, 1, '2018-06-24 13:12:38'),
(21, 21, 1, 1, '2018-06-24 13:13:13'),
(22, 22, 1, 1, '2018-06-24 13:13:13'),
(23, 23, 1, 1, '2018-06-24 13:13:13'),
(24, 24, 1, 1, '2018-06-24 13:13:13'),
(25, 25, 1, 1, '2018-06-24 13:13:13'),
(26, 26, 1, 1, '2018-06-24 13:16:06'),
(27, 27, 1, 1, '2018-06-24 13:16:07'),
(28, 28, 1, 1, '2018-06-24 13:16:07'),
(29, 29, 1, 1, '2018-06-24 13:16:07'),
(30, 30, 1, 1, '2018-06-24 13:16:07'),
(31, 31, 1, 1, '2018-06-24 13:18:33'),
(32, 32, 1, 1, '2018-06-24 13:18:34'),
(33, 33, 1, 1, '2018-06-24 13:18:34'),
(34, 34, 1, 1, '2018-06-24 13:18:34'),
(35, 35, 1, 1, '2018-06-24 13:18:34'),
(36, 36, 1, 1, '2018-06-24 16:32:46'),
(37, 37, 1, 1, '2018-06-24 13:24:21'),
(38, 38, 1, 1, '2018-06-24 13:24:21'),
(39, 39, 1, 1, '2018-06-24 13:24:21'),
(40, 40, 1, 1, '2018-06-24 13:24:22'),
(41, 41, 1, 1, '2018-06-24 13:24:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfilrecurso`
--

CREATE TABLE `perfilrecurso` (
  `idPerfilRecurso` int(11) NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idPerfilControle` int(11) NOT NULL,
  `idPerfilAcao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `perfilrecurso`
--

INSERT INTO `perfilrecurso` (`idPerfilRecurso`, `dataAtualizacao`, `idPerfilControle`, `idPerfilAcao`) VALUES
(1, '2018-06-24 12:48:14', 1, 1),
(2, '2018-06-24 12:48:14', 1, 8),
(3, '2018-06-24 12:58:18', 2, 1),
(4, '2018-06-24 12:58:18', 2, 2),
(5, '2018-06-24 12:58:56', 2, 3),
(6, '2018-06-24 12:58:56', 2, 4),
(7, '2018-06-24 12:59:35', 2, 5),
(8, '2018-06-24 12:59:35', 2, 7),
(9, '2018-06-24 12:59:48', 2, 9),
(10, '2018-06-24 13:05:41', 3, 1),
(11, '2018-06-24 13:05:41', 3, 2),
(12, '2018-06-24 13:05:41', 3, 3),
(13, '2018-06-24 13:05:41', 3, 4),
(14, '2018-06-24 13:05:41', 3, 5),
(15, '2018-06-24 13:08:02', 4, 1),
(16, '2018-06-24 13:08:02', 4, 2),
(17, '2018-06-24 13:08:02', 4, 3),
(18, '2018-06-24 13:08:02', 4, 4),
(19, '2018-06-24 13:08:02', 4, 5),
(20, '2018-06-24 13:10:26', 5, 1),
(21, '2018-06-24 13:10:26', 5, 2),
(22, '2018-06-24 13:10:26', 5, 3),
(23, '2018-06-24 13:10:26', 5, 4),
(24, '2018-06-24 13:10:26', 5, 5),
(25, '2018-06-24 13:10:26', 5, 10),
(26, '2018-06-24 13:15:03', 6, 1),
(27, '2018-06-24 13:15:03', 6, 2),
(28, '2018-06-24 13:15:03', 6, 3),
(29, '2018-06-24 13:15:03', 6, 4),
(30, '2018-06-24 13:15:03', 6, 5),
(31, '2018-06-24 13:17:50', 7, 1),
(32, '2018-06-24 13:17:50', 7, 2),
(33, '2018-06-24 13:17:50', 7, 3),
(34, '2018-06-24 13:17:50', 7, 4),
(35, '2018-06-24 13:17:50', 7, 5),
(36, '2018-06-24 13:22:55', 8, 1),
(37, '2018-06-24 13:22:55', 8, 2),
(38, '2018-06-24 13:22:55', 8, 3),
(39, '2018-06-24 13:22:55', 8, 4),
(40, '2018-06-24 13:22:55', 8, 5),
(41, '2018-06-24 13:22:55', 8, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `idProduto` int(10) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `qtd` int(10) UNSIGNED NOT NULL,
  `statusProduto` char(1) NOT NULL,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tiposervico`
--

CREATE TABLE `tiposervico` (
  `idTipoServico` int(10) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `descricao` mediumtext,
  `statusTipoServico` char(1) NOT NULL DEFAULT 'A',
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

CREATE TABLE `turma` (
  `idTurma` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nome` varchar(30) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `statusTurma` char(1) NOT NULL,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idUsuarioTipo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dataNascimento` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefoneFixo` varchar(15) DEFAULT NULL,
  `telefoneCelular` varchar(15) DEFAULT NULL,
  `senha` varchar(80) DEFAULT NULL,
  `statusUsuario` char(1) NOT NULL,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idUsuarioTipo`, `nome`, `dataNascimento`, `email`, `telefoneFixo`, `telefoneCelular`, `senha`, `statusUsuario`, `dataInsercao`, `dataAtualizacao`) VALUES
(1, 1, 'Administrador', '2018-05-13', 'teste@teste.com', '(11)11111111', '(11)111111111', '$2y$10$DU00pIv/nO63aJTc19vBAOQnhvvKTrzfzlr9pQVBdh0h3Pik8qFiW', 'A', '2018-05-13 00:00:00', '2018-05-25 09:19:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuariotipo`
--

CREATE TABLE `usuariotipo` (
  `idUsuarioTipo` int(11) NOT NULL,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Extraindo dados da tabela `usuariotipo`
--

INSERT INTO `usuariotipo` (`idUsuarioTipo`, `nome`, `dataAtualizacao`) VALUES
(1, 'Administrador', '2014-06-26 17:30:55'),
(2, 'Professor', '2018-06-24 12:31:08'),
(3, 'Aluno', '2018-06-24 12:31:08'),
(4, 'Cliente', '2018-06-24 12:31:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atendimento`
--
ALTER TABLE `atendimento`
  ADD PRIMARY KEY (`idAtendimento`),
  ADD KEY `atendimento_FKIndex1` (`idTipoServico`),
  ADD KEY `atendimento_FKIndex2` (`idMatricula`),
  ADD KEY `atendimento_FKIndex3` (`idTurma`),
  ADD KEY `atendimento_FKIndex4` (`idUsuario`);

--
-- Indexes for table `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`idMatricula`),
  ADD KEY `matricula_FKIndex1` (`idTurma`),
  ADD KEY `matricula_FKIndex2` (`idUsuario`);

--
-- Indexes for table `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`idMovimentacao`),
  ADD KEY `movimentacao_FKIndex1` (`idProduto`);

--
-- Indexes for table `perfilacao`
--
ALTER TABLE `perfilacao`
  ADD PRIMARY KEY (`idPerfilAcao`);

--
-- Indexes for table `perfilcontrole`
--
ALTER TABLE `perfilcontrole`
  ADD PRIMARY KEY (`idPerfilControle`);

--
-- Indexes for table `perfilpermissao`
--
ALTER TABLE `perfilpermissao`
  ADD PRIMARY KEY (`idPerfilPermissao`),
  ADD KEY `fk_perfilPermissao_perfilRecurso1_idx` (`idPerfilRecurso`),
  ADD KEY `fk_perfilPermissao_usuarioTipo1_idx` (`idUsuarioTipo`);

--
-- Indexes for table `perfilrecurso`
--
ALTER TABLE `perfilrecurso`
  ADD PRIMARY KEY (`idPerfilRecurso`),
  ADD KEY `fk_perfilRecurso_perfilControle1_idx` (`idPerfilControle`),
  ADD KEY `fk_perfilRecurso_perfilAcao1_idx` (`idPerfilAcao`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`idProduto`);

--
-- Indexes for table `tiposervico`
--
ALTER TABLE `tiposervico`
  ADD PRIMARY KEY (`idTipoServico`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`idTurma`),
  ADD KEY `turma_FKIndex1` (`idUsuario`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idUsuarioTipo` (`idUsuarioTipo`);

--
-- Indexes for table `usuariotipo`
--
ALTER TABLE `usuariotipo`
  ADD PRIMARY KEY (`idUsuarioTipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atendimento`
--
ALTER TABLE `atendimento`
  MODIFY `idAtendimento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matricula`
--
ALTER TABLE `matricula`
  MODIFY `idMatricula` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `idMovimentacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perfilacao`
--
ALTER TABLE `perfilacao`
  MODIFY `idPerfilAcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `perfilcontrole`
--
ALTER TABLE `perfilcontrole`
  MODIFY `idPerfilControle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `perfilpermissao`
--
ALTER TABLE `perfilpermissao`
  MODIFY `idPerfilPermissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `perfilrecurso`
--
ALTER TABLE `perfilrecurso`
  MODIFY `idPerfilRecurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `idProduto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tiposervico`
--
ALTER TABLE `tiposervico`
  MODIFY `idTipoServico` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `idTurma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuariotipo`
--
ALTER TABLE `usuariotipo`
  MODIFY `idUsuarioTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `atendimento`
--
ALTER TABLE `atendimento`
  ADD CONSTRAINT `atendimento_ibfk_1` FOREIGN KEY (`idTipoServico`) REFERENCES `tiposervico` (`idTipoServico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `atendimento_ibfk_2` FOREIGN KEY (`idMatricula`) REFERENCES `matricula` (`idMatricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `atendimento_ibfk_3` FOREIGN KEY (`idTurma`) REFERENCES `turma` (`idTurma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `atendimento_ibfk_4` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `turma` (`idTurma`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `produto` (`idProduto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `perfilpermissao`
--
ALTER TABLE `perfilpermissao`
  ADD CONSTRAINT `fk_perfilPermissao_perfilRecurso1` FOREIGN KEY (`idPerfilRecurso`) REFERENCES `perfilrecurso` (`idPerfilRecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfilPermissao_usuarioTipo1` FOREIGN KEY (`idUsuarioTipo`) REFERENCES `usuariotipo` (`idUsuarioTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `perfilrecurso`
--
ALTER TABLE `perfilrecurso`
  ADD CONSTRAINT `fk_perfilRecurso_perfilAcao1` FOREIGN KEY (`idPerfilAcao`) REFERENCES `perfilacao` (`idPerfilAcao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfilRecurso_perfilControle1` FOREIGN KEY (`idPerfilControle`) REFERENCES `perfilcontrole` (`idPerfilControle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `idUsuarioTipo` FOREIGN KEY (`idUsuarioTipo`) REFERENCES `usuariotipo` (`idUsuarioTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
