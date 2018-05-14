<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="turma")
 */
class Turma extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idTurma;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     */
    protected $professor;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataInicio;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataFim;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusTurma;

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
    
    public function getIdTurma() {
        return $this->idTurma;
    }

    public function getProfessor() {
        return $this->professor;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function getStatusTurma() {
        return $this->statusTurma;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdTurma($idTurma) {
        $this->idTurma = $idTurma;
    }

    public function setProfessor($professor) {
        $this->professor = $professor;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setStatusTurma($statusTurma) {
        $this->statusTurma = $statusTurma;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
