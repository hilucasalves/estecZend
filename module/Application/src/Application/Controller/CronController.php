<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CronController extends AbstractActionController {

    public function wsCadastroUsuarioAction() {

        $data = $this->params()->fromPost();
        $em = $GLOBALS['entityManager'];

        //Cadastrando o login do novo usuario
        $login = new \Usuario\Entity\UsuarioLogin();
        $filterDigits = new \Zend\Filter\Digits();


        $cpf = $filterDigits->filter($data['cpf']);

        $login->__set('email', $data['email']);
        $login->__set('flgExterno', $data['flgExterno']);
        $login->__set('senha', '$2y$10$4TvwaEdbbbKrwaSRJFBp7Oqy4Uns1S2NWM7WSiddfy3nzVYAwMfTK');
        $login->__set('cpf', $cpf);
        $login->__set('nome', $data['nome']);

        if ($data['status'] == 'I') {
            $status = 2;
        } else {
            $status = 1;
        }
        $idLoginStatus = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find($status);
        $login->__set('status', $idLoginStatus);
        $em->persist($login);
        $em->flush();

        $usuario = new \Usuario\Entity\Usuario();

        $usuario->__set('login', $login);

        $orgaoLotacao = $em->getRepository('Usuario\Entity\OrgaoLotacao')->find($data['orgaoLotacao']);
        $usuario->__set('orgaoLotacao', $orgaoLotacao);
        $usuario->__set('nome', $data['nome']);

        $tipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find($data['idTipoColaborador']);
        $usuario->__set('usuarioTipo', $tipo);
        $usuario->__set('nome', $data['nome']);
        $date = new \DateTime($data['dataNascimento']);
        $usuario->__set('dataNascimento', $date);
        $usuario->__set('telefoneCelular', $data['telefoneCelular']);
        $cargo = $em->getRepository('Usuario\Entity\UsuarioCargo')->find($data['idFuncao']);
        $usuario->__set('usuarioCargo', $cargo);
        $usuario->__set('statusUsuario', $data['status']);

        $em->persist($usuario);
        $em->flush();
        die;
    }

    public function wsAtualizaUsuarioAction() {


        $data = $this->params()->fromPost();
        $filterDigits = new \Zend\Filter\Digits();

        $em = $GLOBALS['entityManager'];
        $cpf = $filterDigits->filter($data['cpf']);

        $login = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('cpf' => $cpf));


        if ($data['status'] == 'I') {
            $status = 2;
        } else {
            $status = 1;
        }
        $idLoginStatus = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find($status);

        $login->__set('flgExterno', $data['flgExterno']);
        $login->__set('email', $data['email']);
        $login->__set('nome', $data['nome']);
        $login->__set('status', $idLoginStatus);
        $login->usuario->__set('nome', $data['nome']);
        $login->usuario->__set('rg', $data['rg']);
        $login->usuario->__set('telefoneCelular', $data['telefoneCelular']);
        $orgaoLotacao = $em->getRepository('Usuario\Entity\OrgaoLotacao')->find($data['orgaoLotacao']);
        $login->usuario->__set('orgaoLotacao', $orgaoLotacao);
        $usuarioCargo = $em->getRepository('Usuario\Entity\usuarioCargo')->find($data['idFuncao']);
        $login->usuario->__set('usuarioCargo', $usuarioCargo);
        $login->usuario->__set('statusUsuario', $data['status']);
        $em->persist($login);
        $em->flush();
        die;
    }

    public function wsOrgaoLotacaoAction() {

        $data = $this->params()->fromPost();

        $em = $GLOBALS['entityManager'];

        $orgaoLotacao = $em->getRepository('Usuario\Entity\OrgaoLotacao')->findOneBy(array('idOrgaoLotacao' => $data['idOrgaoLotacao']));

        if ($orgaoLotacao) {
            $orgaoLotacao->__set('orgaoLotacao', $data['orgaoLotacao']);
            $em->persist($orgaoLotacao);
            $em->flush();
        } else {
            $orgao = new \Usuario\Entity\OrgaoLotacao();
            $orgao->__set('orgaoLotacao', $data['orgaoLotacao']);
            $em->persist($orgao);
            $em->flush();
        }

        die;
    }

    public function wsUsuarioCargoAction() {
        $data = $this->params()->fromPost();
        $em = $GLOBALS['entityManager'];
        $usuarioCargo = $em->getRepository('Usuario\Entity\UsuarioCargo')->findOneBy(array('idUsuarioCargo' => $data['idFuncao']));

        if ($usuarioCargo) {
            $usuarioCargo->__set('cargo', $data['nome']);
            $em->persist($usuarioCargo);
            $em->flush();
        } else {
            $usuarioCargo = new \Usuario\Entity\UsuarioCargo();
            $usuarioCargo->__set('cargo', $data['nome']);
            $em->persist($usuarioCargo);
            $em->flush();
        }

        die;
    }

}
