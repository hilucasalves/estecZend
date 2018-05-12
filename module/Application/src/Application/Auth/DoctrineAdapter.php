<?php

namespace Application\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    \Zend\Authentication\Result;

class DoctrineAdapter implements AdapterInterface {

    protected $entityManager;
    protected $email;
    protected $senha;

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function authenticate() {

        $usuario = $this->findByEmailAndSenha($this->getEmail(), $this->getSenha());
        if ($usuario) {
            return new Result(Result::SUCCESS, array('usuario' => $usuario));
        } else {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
        }
    }

    public function findByEmailAndSenha($email, $senha) {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();

        $em = $GLOBALS['entityManager'];

        //pega o login no banco em que o cpf seja igual ao digita e que o status seja ativo (A)
        $usuario = $em->getRepository('Application\Entity\Usuario')->findOneBy(array('email' => $email, 'statusUsuario' => 'A'));

        if ($usuario) {
            $password = $usuario->__get('senha');

            if ($bcrypt->verify($senha, $password)) return $usuario;
            else return false;
        } else return false;
    }

}
