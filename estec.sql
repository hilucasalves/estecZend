-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.21-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para estec
CREATE DATABASE IF NOT EXISTS `estec` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `estec`;

-- Copiando estrutura para tabela estec.login
CREATE TABLE IF NOT EXISTS `login` (
  `idLogin` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_swedish_ci NOT NULL,
  `nome` varchar(250) COLLATE utf8_swedish_ci NOT NULL,
  `senha` varchar(65) COLLATE utf8_swedish_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8_swedish_ci NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idLoginStatus` int(11) DEFAULT NULL,
  PRIMARY KEY (`idLogin`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  KEY `fk_login_loginStatus1_idx` (`idLoginStatus`),
  CONSTRAINT `fk_login_loginStatus1` FOREIGN KEY (`idLoginStatus`) REFERENCES `loginstatus` (`idLoginStatus`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=817 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.login: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` (`idLogin`, `email`, `nome`, `senha`, `cpf`, `dataCriacao`, `dataAtualizacao`, `idLoginStatus`) VALUES
	(816, 'a@a.com', 'teste', '$2y$10$MQFbZ4rxrQAHrAKCriMCA.NsO1nQYsPVvjRYlegu5UHCTn/FeFrGe', '10815522630', '2018-04-20 13:59:50', '2018-04-25 15:07:54', 1);
/*!40000 ALTER TABLE `login` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.loginstatus
CREATE TABLE IF NOT EXISTS `loginstatus` (
  `idLoginStatus` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idLoginStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.loginstatus: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `loginstatus` DISABLE KEYS */;
INSERT INTO `loginstatus` (`idLoginStatus`, `nome`) VALUES
	(1, 'Ativo'),
	(2, 'Inativo');
/*!40000 ALTER TABLE `loginstatus` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.perfilacao
CREATE TABLE IF NOT EXISTS `perfilacao` (
  `idPerfilAcao` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `apelido` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`idPerfilAcao`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.perfilacao: ~11 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilacao` DISABLE KEYS */;
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
	(11, 'logout', 'sair');
/*!40000 ALTER TABLE `perfilacao` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.perfilcontrole
CREATE TABLE IF NOT EXISTS `perfilcontrole` (
  `idPerfilControle` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `apelido` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPerfilControle`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.perfilcontrole: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilcontrole` DISABLE KEYS */;
INSERT INTO `perfilcontrole` (`idPerfilControle`, `nome`, `apelido`, `dataAtualizacao`) VALUES
	(1, 'Usuario', 'Usuário', '2017-03-21 14:15:58'),
	(2, 'UsuarioFuncao', 'Usuario Funcao', '2017-03-21 14:16:00'),
	(3, 'UsuarioLogin', 'Usuario Login', '2017-03-21 14:16:03'),
	(4, 'UsuarioTipo', 'Usuario Tipo', '2017-03-21 14:16:05'),
	(5, 'PerfilPermissao', 'Perfil Permissao', '2017-03-21 14:16:08'),
	(6, 'Perfil', 'Perfil', '2017-03-21 14:16:10'),
	(7, 'Auth', 'Autoriazação', '2017-03-21 14:16:12'),
	(8, 'Documentos', 'Documentos de assinatura', '2017-10-05 17:12:50');
/*!40000 ALTER TABLE `perfilcontrole` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.perfilpermissao
CREATE TABLE IF NOT EXISTS `perfilpermissao` (
  `idPerfilPermissao` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfilRecurso` int(11) NOT NULL,
  `idUsuarioTipo` int(11) NOT NULL,
  `permitido` int(11) NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idPerfilPermissao`),
  KEY `fk_perfilPermissao_perfilRecurso1_idx` (`idPerfilRecurso`),
  KEY `fk_perfilPermissao_usuarioTipo1_idx` (`idUsuarioTipo`),
  CONSTRAINT `fk_perfilPermissao_perfilRecurso1` FOREIGN KEY (`idPerfilRecurso`) REFERENCES `perfilrecurso` (`idPerfilRecurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilPermissao_usuarioTipo1` FOREIGN KEY (`idUsuarioTipo`) REFERENCES `usuariotipo` (`idUsuarioTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.perfilpermissao: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilpermissao` DISABLE KEYS */;
INSERT INTO `perfilpermissao` (`idPerfilPermissao`, `idPerfilRecurso`, `idUsuarioTipo`, `permitido`, `dataAtualizacao`) VALUES
	(1, 1, 1, 1, '2017-10-05 16:56:17'),
	(3, 2, 1, 1, '2017-10-05 16:56:26'),
	(4, 3, 1, 1, '2017-10-05 16:56:34'),
	(5, 4, 1, 1, '2017-10-05 16:56:47'),
	(7, 5, 1, 1, '2017-10-05 16:57:09'),
	(8, 6, 1, 1, '2017-10-05 16:57:16'),
	(9, 7, 1, 1, '2017-10-05 16:57:24'),
	(10, 8, 1, 1, '2017-10-05 16:57:37'),
	(11, 9, 1, 1, '2017-10-05 16:57:44'),
	(12, 10, 1, 1, '2017-10-05 16:58:03'),
	(13, 11, 1, 1, '2017-10-05 16:58:12'),
	(14, 12, 1, 1, '2017-10-05 16:58:19');
/*!40000 ALTER TABLE `perfilpermissao` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.perfilrecurso
CREATE TABLE IF NOT EXISTS `perfilrecurso` (
  `idPerfilRecurso` int(11) NOT NULL AUTO_INCREMENT,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idPerfilControle` int(11) NOT NULL,
  `idPerfilAcao` int(11) NOT NULL,
  PRIMARY KEY (`idPerfilRecurso`),
  KEY `fk_perfilRecurso_perfilControle1_idx` (`idPerfilControle`),
  KEY `fk_perfilRecurso_perfilAcao1_idx` (`idPerfilAcao`),
  CONSTRAINT `fk_perfilRecurso_perfilAcao1` FOREIGN KEY (`idPerfilAcao`) REFERENCES `perfilacao` (`idPerfilAcao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilRecurso_perfilControle1` FOREIGN KEY (`idPerfilControle`) REFERENCES `perfilcontrole` (`idPerfilControle`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.perfilrecurso: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilrecurso` DISABLE KEYS */;
INSERT INTO `perfilrecurso` (`idPerfilRecurso`, `dataAtualizacao`, `idPerfilControle`, `idPerfilAcao`) VALUES
	(1, '2017-10-05 16:53:00', 7, 1),
	(2, '2017-10-05 16:53:15', 1, 1),
	(3, '2017-10-05 16:53:23', 1, 2),
	(4, '2017-10-05 16:53:29', 1, 3),
	(5, '2017-10-05 16:53:39', 1, 4),
	(6, '2017-10-05 16:53:52', 1, 5),
	(7, '2017-10-05 16:54:04', 1, 6),
	(8, '2017-10-05 16:54:16', 1, 7),
	(9, '2017-10-05 16:54:28', 1, 8),
	(10, '2017-10-05 16:54:36', 1, 9),
	(11, '2017-10-05 16:54:50', 1, 10),
	(12, '2017-10-05 16:54:57', 1, 11);
/*!40000 ALTER TABLE `perfilrecurso` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `idLogin` int(11) NOT NULL,
  `idUsuarioTipo` int(11) DEFAULT NULL,
  `nome` varchar(200) COLLATE utf8_swedish_ci DEFAULT NULL,
  `rg` varchar(40) COLLATE utf8_swedish_ci DEFAULT NULL,
  `dataNascimento` date DEFAULT NULL,
  `telefoneCelular` varchar(20) COLLATE utf8_swedish_ci DEFAULT NULL,
  `dataAtualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dataInsercao` datetime DEFAULT NULL,
  `statusUsuario` char(1) COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `idLogin_UNIQUE` (`idLogin`),
  KEY `fk_usuario_login1_idx` (`idLogin`),
  KEY `fk_usuario_usuarioTipo1_idx` (`idUsuarioTipo`),
  CONSTRAINT `fk_usuario_login1` FOREIGN KEY (`idLogin`) REFERENCES `login` (`idLogin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_usuarioTipo1` FOREIGN KEY (`idUsuarioTipo`) REFERENCES `usuariotipo` (`idUsuarioTipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=810 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.usuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idUsuario`, `idLogin`, `idUsuarioTipo`, `nome`, `rg`, `dataNascimento`, `telefoneCelular`, `dataAtualizacao`, `dataInsercao`, `statusUsuario`) VALUES
	(809, 816, 1, 'Teste', NULL, '2018-04-20', NULL, '2018-04-20 14:19:35', '2018-04-20 14:19:29', 'A');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

-- Copiando estrutura para tabela estec.usuariotipo
CREATE TABLE IF NOT EXISTS `usuariotipo` (
  `idUsuarioTipo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `dataAtualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idUsuarioTipo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- Copiando dados para a tabela estec.usuariotipo: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuariotipo` DISABLE KEYS */;
INSERT INTO `usuariotipo` (`idUsuarioTipo`, `nome`, `dataAtualizacao`) VALUES
	(1, 'Administrador', '2014-06-26 14:30:55');
/*!40000 ALTER TABLE `usuariotipo` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
