<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;


/**

 * UsuarioLogin 
 * @ORM\Entity
 * @ORM\Table(name="login")
 * */
class UsuarioLogin extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idLogin;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;
    
        /**
     * @ORM\Column(type="datetime")
     */
    protected $dataCriacao;
        /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioLoginStatus", cascade={"persist"})
     * @ORM\JoinColumn(name="idLoginStatus", referencedColumnName="idLoginStatus")
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Usuario\Entity\Usuario", mappedBy="login")
     */
    protected $usuario;    
        
    public function __construct() {
        $this->dataCriacao = new  \DateTime();
        $this->dataAtualizacao = new  \DateTime();
    }   
    function getIdLogin() {
        return $this->idLogin;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setIdLogin($idLogin) {
        $this->idLogin = $idLogin;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    function setFlgExterno($flgExterno) {
        $this->flgExterno = $flgExterno;
    }


     

}

