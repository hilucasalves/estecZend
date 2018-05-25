<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioTipo", referencedColumnName="idUsuarioTipo")
     */
    protected $usuarioTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataNascimento;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneFixo;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneCelular;

    /**
     * @ORM\Column(type="string")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusUsuario;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;

    public function __construct() {
        $this->dataInsercao = new \DateTime();
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getUsuarioTipo() {
        return $this->usuarioTipo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefoneFixo() {
        return $this->telefoneFixo;
    }

    public function getTelefoneCelular() {
        return $this->telefoneCelular;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getStatusUsuario() {
        return $this->statusUsuario;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setUsuarioTipo($usuarioTipo) {
        $this->usuarioTipo = $usuarioTipo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefoneFixo($telefoneFixo) {
        $this->telefoneFixo = $telefoneFixo;
    }

    public function setTelefoneCelular($telefoneCelular) {
        $this->telefoneCelular = $telefoneCelular;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setStatusUsuario($statusUsuario) {
        $this->statusUsuario = $statusUsuario;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
