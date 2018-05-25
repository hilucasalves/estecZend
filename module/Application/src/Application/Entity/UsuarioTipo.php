<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="usuariotipo")
 * 
 */
class UsuarioTipo extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuarioTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $dataAtualizacao;

    public function getIdUsuarioTipo() {
        return $this->idUsuarioTipo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataAtualizacao() {
        return $this->dataAtualizacao;
    }

    public function setIdUsuarioTipo($idUsuarioTipo) {
        $this->idUsuarioTipo = $idUsuarioTipo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDataAtualizacao($dataAtualizacao) {
        $this->dataAtualizacao = $dataAtualizacao;
    }

}
