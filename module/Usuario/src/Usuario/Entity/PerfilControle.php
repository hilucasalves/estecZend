<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="perfilcontrole")
 * 
 */
class PerfilControle extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idPerfilControle;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $apelido;

    /**
     * @ORM\Column(type="string")
     */
    protected $dataAtualizacao;

    public function getIdPerfilControle() {
        return $this->idPerfilControle;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getApelido() {
        return $this->apelido;
    }

    public function setIdPerfilControle($idPerfilControle) {
        $this->idPerfilControle = $idPerfilControle;
        return $this->idPerfilControle;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this->nome;
    }

    public function setApelido($apelido) {
        $this->apelido = $apelido;
        return $this->apelido;
    }

    public function exchangeArray($array) {
        if (is_array($array)) {
            $this->idPerfilControle = $array['idPerfilControle'];
            $this->nome = $array['nome'];
            $this->apelido = $array['apelido'];
        } else {
            $this->idPerfilControle = $array->idPerfilControle;
            $this->nome = $array->nome;
            $this->apelido = $array->apelido;
        }
    }

}
