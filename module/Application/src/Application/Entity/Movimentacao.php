<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="movimentacao")
 */
class Movimentacao extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idMovimentacao;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Produto", cascade={"persist"})
     * @ORM\JoinColumn(name="idProduto", referencedColumnName="idProduto")
     */
    protected $produto;

    /**
     * @ORM\Column(type="integer")
     */
    protected $qtd;

    /**
     * @ORM\Column(type="string")
     */
    protected $tipoMovimentacao;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataValidade;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusMovimentacao;

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

    public function getIdMovimentacao() {
        return $this->idMovimentacao;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function getTipoMovimentacao() {
        return $this->tipoMovimentacao;
    }

    public function getDataValidade() {
        return $this->dataValidade;
    }

    public function getStatusMovimentacao() {
        return $this->statusMovimentacao;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdMovimentacao($idMovimentacao) {
        $this->idMovimentacao = $idMovimentacao;
    }

    public function setProduto($produto) {
        $this->produto = $produto;
    }

    public function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    public function setTipoMovimentacao($tipoMovimentacao) {
        $this->tipoMovimentacao = $tipoMovimentacao;
    }

    public function setDataValidade($dataValidade) {
        $this->dataValidade = $dataValidade;
    }

    public function setStatusMovimentacao($statusMovimentacao) {
        $this->statusMovimentacao = $statusMovimentacao;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
