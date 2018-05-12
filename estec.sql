-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Maio-2018 às 18:56
-- Versão do servidor: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET FOREIGN_KEY_CHECKS=0;
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
CREATE DATABASE IF NOT EXISTS `estec2` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `estec2`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE `atendimento` (
  `idAtendimento` int(10) UNSIGNED NOT NULL,
  `turma_idTurma` int(10) UNSIGNED DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tiposervico_idTipoServico` int(10) UNSIGNED NOT NULL,
  `matricula_idMatricula` int(10) UNSIGNED DEFAULT NULL,
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
  `usuario_idUsuario` int(10) UNSIGNED NOT NULL,
  `turma_idTurma` int(10) UNSIGNED NOT NULL,
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
  `produto_idProduto` int(10) UNSIGNED NOT NULL,
  `qtd` int(10) UNSIGNED NOT NULL,
  `tipoMovimentacao` char(1) NOT NULL,
  `dataValidade` date DEFAULT NULL,
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
(7, 'localizar', 'Localizar'),
(8, 'alterar-senha', 'Alterar Senha'),
(9, 'permissao', 'Permissão'),
(10, 'localizar-usuario', 'buscar usuario'),
(11, 'logout', 'sair'),
(12, 'documento', 'Documento'),
(13, 'enable', 'enable'),
(14, 'disable', 'disable');

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
(1, 'Usuario', 'Usuário', '2017-03-21 17:15:58'),
(2, 'UsuarioFuncao', 'Usuario Funcao', '2017-03-21 17:16:00'),
(3, 'UsuarioLogin', 'Usuario Login', '2017-03-21 17:16:03'),
(4, 'UsuarioTipo', 'Usuario Tipo', '2017-03-21 17:16:05'),
(5, 'PerfilPermissao', 'Perfil Permissao', '2017-03-21 17:16:08'),
(6, 'Perfil', 'Perfil', '2017-03-21 17:16:10'),
(7, 'Auth', 'Autoriazação', '2017-03-21 17:16:12'),
(8, 'Documentos', 'Documentos de assinatura', '2017-10-05 20:12:50'),
(9, 'Turma', 'Turma', '2018-05-05 11:54:10');

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
(1, 1, 1, 1, '2017-10-05 19:56:17'),
(3, 2, 1, 1, '2017-10-05 19:56:26'),
(4, 3, 1, 1, '2017-10-05 19:56:34'),
(5, 4, 1, 1, '2017-10-05 19:56:47'),
(7, 5, 1, 1, '2017-10-05 19:57:09'),
(8, 6, 1, 1, '2017-10-05 19:57:16'),
(9, 7, 1, 1, '2017-10-05 19:57:24'),
(10, 8, 1, 1, '2017-10-05 19:57:37'),
(11, 9, 1, 1, '2017-10-05 19:57:44'),
(12, 10, 1, 1, '2017-10-05 19:58:03'),
(13, 11, 1, 1, '2017-10-05 19:58:12'),
(14, 12, 1, 1, '2017-10-05 19:58:19'),
(15, 14, 1, 1, '2017-10-05 20:13:42'),
(16, 15, 1, 1, '2017-11-27 13:40:56'),
(17, 1, 2, 1, '2017-10-05 19:56:17'),
(18, 2, 2, 1, '2017-10-05 19:56:26'),
(19, 3, 2, 1, '2017-10-05 19:56:34'),
(20, 4, 2, 1, '2017-10-05 19:56:47'),
(21, 5, 2, 1, '2017-10-05 19:57:09'),
(22, 6, 2, 1, '2017-10-05 19:57:16'),
(23, 7, 2, 1, '2017-10-05 19:57:24'),
(24, 8, 2, 1, '2017-10-05 19:57:37'),
(25, 9, 2, 1, '2017-10-05 19:57:44'),
(26, 10, 2, 1, '2017-10-05 19:58:03'),
(27, 11, 2, 1, '2017-10-05 19:58:12'),
(28, 12, 2, 1, '2017-10-05 19:58:19'),
(29, 14, 2, 1, '2017-10-05 20:13:42'),
(30, 15, 2, 1, '2017-11-27 13:40:56'),
(31, 1, 3, 1, '2017-10-05 19:56:17'),
(32, 2, 3, 1, '2017-10-05 19:56:26'),
(33, 3, 3, 1, '2017-10-05 19:56:34'),
(34, 4, 3, 1, '2017-10-05 19:56:47'),
(35, 5, 3, 1, '2017-10-05 19:57:09'),
(36, 6, 3, 1, '2017-10-05 19:57:16'),
(37, 7, 3, 1, '2017-10-05 19:57:24'),
(38, 8, 3, 1, '2017-10-05 19:57:37'),
(39, 9, 3, 1, '2017-10-05 19:57:44'),
(40, 10, 3, 1, '2017-10-05 19:58:03'),
(41, 11, 3, 1, '2017-10-05 19:58:12'),
(42, 12, 3, 1, '2017-10-05 19:58:19'),
(43, 14, 3, 1, '2017-10-05 20:13:42'),
(44, 15, 3, 1, '2017-11-27 13:40:56'),
(45, 1, 4, 1, '2017-10-05 19:56:17'),
(46, 2, 4, 1, '2017-10-05 19:56:26'),
(47, 3, 4, 1, '2017-10-05 19:56:34'),
(48, 4, 4, 1, '2017-10-05 19:56:47'),
(49, 5, 4, 1, '2017-10-05 19:57:09'),
(50, 6, 4, 1, '2017-10-05 19:57:16'),
(51, 7, 4, 1, '2017-10-05 19:57:24'),
(52, 8, 4, 1, '2017-10-05 19:57:37'),
(53, 9, 4, 1, '2017-10-05 19:57:44'),
(54, 10, 4, 1, '2017-10-05 19:58:03'),
(55, 11, 4, 1, '2017-10-05 19:58:12'),
(56, 12, 4, 1, '2017-10-05 19:58:19'),
(57, 14, 4, 1, '2017-10-05 20:13:42'),
(58, 15, 4, 1, '2017-11-27 13:40:56'),
(59, 16, 1, 1, '2018-05-05 11:54:56'),
(60, 17, 1, 1, '2018-05-06 13:01:15'),
(61, 18, 1, 1, '2018-05-06 13:01:15');

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
(1, '2017-10-05 19:53:00', 7, 1),
(2, '2017-10-05 19:53:15', 1, 1),
(3, '2017-10-05 19:53:23', 1, 2),
(4, '2017-10-05 19:53:29', 1, 3),
(5, '2017-10-05 19:53:39', 1, 4),
(6, '2017-10-05 19:53:52', 1, 5),
(7, '2017-10-05 19:54:04', 1, 6),
(8, '2017-10-05 19:54:16', 1, 7),
(9, '2017-10-05 19:54:28', 1, 8),
(10, '2017-10-05 19:54:36', 1, 9),
(11, '2017-10-05 19:54:50', 1, 10),
(12, '2017-10-05 19:54:57', 1, 11),
(14, '2017-10-05 20:13:20', 8, 1),
(15, '2017-11-27 13:40:24', 1, 12),
(16, '2018-05-05 11:54:27', 9, 1),
(17, '2018-05-06 13:00:29', 9, 13),
(18, '2018-05-06 13:00:29', 9, 14);

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

--
-- Extraindo dados da tabela `turma`
--

INSERT INTO `turma` (`idTurma`, `idUsuario`, `nome`, `dataInicio`, `dataFim`, `statusTurma`, `dataInsercao`, `dataAtualizacao`) VALUES
(1, 1, 'Turma 1', '2018-05-11', '2018-06-30', 'A', '0000-00-00 00:00:00', NULL),
(2, 2, 't2', '2018-05-12', '2018-05-30', 'I', '2018-05-12 12:39:16', NULL),
(3, 1, 't5', '2018-05-01', '2018-05-30', 'A', '2018-05-12 13:22:53', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) UNSIGNED NOT NULL,
  `idUsuarioTipo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `dataNascimento` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefoneFixo` varchar(15) DEFAULT NULL,
  `telefoneCelular` varchar(15) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `statusUsuario` char(1) NOT NULL,
  `dataInsercao` datetime NOT NULL,
  `dataAtualizacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idUsuarioTipo`, `nome`, `dataNascimento`, `email`, `telefoneFixo`, `telefoneCelular`, `senha`, `statusUsuario`, `dataInsercao`, `dataAtualizacao`) VALUES
(1, 1, 'teste', '1992-04-24', 'teste@teste.com', '31983231019', '31983231019', '$2y$10$SdsU6EEEDPNuP9SnWNJNtuv.K8KDJlLXXO/c6zHjAAyVNGapf5Q/e', 'A', '0000-00-00 00:00:00', NULL),
(2, 1, 'Teste 2', '2018-01-01', 'teste2@teste.com', '1111111111', '1111111111', NULL, 'A', '0000-00-00 00:00:00', NULL);

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
(2, 'Bolsista', '2017-08-25 20:16:38'),
(3, 'Coordenador', '2017-05-26 18:40:19'),
(4, 'Colaborador', '2017-12-20 18:45:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atendimento`
--
ALTER TABLE `atendimento`
  ADD PRIMARY KEY (`idAtendimento`),
  ADD KEY `atendimento_FKIndex1` (`tiposervico_idTipoServico`),
  ADD KEY `atendimento_FKIndex2` (`matricula_idMatricula`),
  ADD KEY `atendimento_FKIndex3` (`turma_idTurma`);

--
-- Indexes for table `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`idMatricula`),
  ADD KEY `matricula_FKIndex1` (`turma_idTurma`),
  ADD KEY `matricula_FKIndex2` (`usuario_idUsuario`);

--
-- Indexes for table `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`idMovimentacao`),
  ADD KEY `movimentacao_FKIndex1` (`produto_idProduto`);

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
  MODIFY `idPerfilAcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `perfilcontrole`
--
ALTER TABLE `perfilcontrole`
  MODIFY `idPerfilControle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `perfilpermissao`
--
ALTER TABLE `perfilpermissao`
  MODIFY `idPerfilPermissao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `perfilrecurso`
--
ALTER TABLE `perfilrecurso`
  MODIFY `idPerfilRecurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
  MODIFY `idTurma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuariotipo`
--
ALTER TABLE `usuariotipo`
  MODIFY `idUsuarioTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

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
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `idUsuarioTipo` FOREIGN KEY (`idUsuarioTipo`) REFERENCES `usuariotipo` (`idUsuarioTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
