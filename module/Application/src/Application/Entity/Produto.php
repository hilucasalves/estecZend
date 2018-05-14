<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="produto")
 */
class Produto extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idProduto;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="integer")
     */
    protected $qtd;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusProduto;

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

    public function getIdProduto() {
        return $this->idProduto;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getQtd() {
        return $this->qtd;
    }

    public function getStatusProduto() {
        return $this->statusProduto;
    }

    public function getDataInsercao() {
        return $this->dataInsercao;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdProduto($idProduto) {
        $this->idProduto = $idProduto;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    public function setStatusProduto($statusProduto) {
        $this->statusProduto = $statusProduto;
    }

    public function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
