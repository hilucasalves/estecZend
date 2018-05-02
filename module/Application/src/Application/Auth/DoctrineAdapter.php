<?php

namespace Application\Auth;

use Doctrine\ORM\EntityManager;
use Zend\Authentication\Adapter\AdapterInterface,
    \Zend\Authentication\Result;

class DoctrineAdapter implements AdapterInterface
{

    protected $entityManager;
    protected $cpf;
    protected $senha;

    /*  public function __construct(EntityManager $entityManager) {
      $this->entityManager = $entityManager;
      } */

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function authenticate()
    {

        $login = $this->findByCpfAndSenha($this->getCpf(), $this->getSenha());
        if ($login)
        {
            return new Result(Result::SUCCESS, array('login' => $login));
        } else
        {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
        }
    }

    public function findByCpfAndSenha($cpf, $senha)
    {
        $bcrypt = new \Zend\Crypt\Password\Bcrypt();

        $em = $GLOBALS['entityManager'];
        
        //pega o login no banco em que o cpf seja igual ao digita e que o status seja ativo (1)
        $login = $em->getRepository('Application\Entity\Login')->findOneBy(array('cpf' => $cpf, 'status' => 1));
        
        //var_dump($login);die;

        if ($login)
        {
            $password = $login->__get('senha');

            if ($bcrypt->verify($senha, $password))
                return $login;
            else
                return false;
        } else
            return false;
    }

}
