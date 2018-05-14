<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="matricula")
 */
class Matricula extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idMatricula;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     */
    protected $aluno;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Turma", cascade={"persist"})
     * @ORM\JoinColumn(name="idTurma", referencedColumnName="idTurma")
     */
    protected $turma;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusMatricula;

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

    public function getIdMatricula() {
        return $this->idMatricula;
    }

    public function getAluno() {
        return $this->aluno;
    }

    public function getTurma() {
        return $this->turma;
    }

    public function getStatusMatricula() {
        return $this->statusMatricula;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdMatricula($idMatricula) {
        $this->idMatricula = $idMatricula;
    }

    public function setAluno($aluno) {
        $this->aluno = $aluno;
    }

    public function setTurma($turma) {
        $this->turma = $turma;
    }

    public function setStatusMatricula($statusMatricula) {
        $this->statusMatricula = $statusMatricula;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
