<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="atendimento")
 */
class Atendimento extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idAtendimento;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     */
    protected $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Turma", cascade={"persist"})
     * @ORM\JoinColumn(name="idTurma", referencedColumnName="idTurma")
     */
    protected $turma;

    /**
     * @ORM\Column(type="string")
     */
    protected $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\TipoServico", cascade={"persist"})
     * @ORM\JoinColumn(name="idTipoServico", referencedColumnName="idTipoServico")
     */
    protected $tipoServico;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Matricula", cascade={"persist"})
     * @ORM\JoinColumn(name="idMatricula", referencedColumnName="idMatricula")
     */
    protected $matricula;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusAtendimento;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataPrevisao;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataFim;

    /**
     * @ORM\Column(type="string")
     */
    protected $feedback;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $nota;

    /**
     * @ORM\Column(type="string")
     */
    protected $observacao;

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

    public function getIdAtendimento() {
        return $this->idAtendimento;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getTurma() {
        return $this->turma;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getTipoServico() {
        return $this->tipoServico;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getStatusAtendimento() {
        return $this->statusAtendimento;
    }

    public function getDataPrevisao() {
        return $this->dataPrevisao;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function getFeedback() {
        return $this->feedback;
    }

    public function getNota() {
        return $this->nota;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdAtendimento($idAtendimento) {
        $this->idAtendimento = $idAtendimento;
    }

    public function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    public function setTurma($turma) {
        $this->turma = $turma;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setTipoServico($tipoServico) {
        $this->tipoServico = $tipoServico;
    }

    public function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    public function setStatusAtendimento($statusAtendimento) {
        $this->statusAtendimento = $statusAtendimento;
    }

    public function setDataPrevisao($dataPrevisao) {
        $this->dataPrevisao = $dataPrevisao;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }

    public function setNota($nota) {
        $this->nota = $nota;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
