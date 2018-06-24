<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="perfilpermissao")
 * 
 */
class PerfilPermissao extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idPerfilPermissao;

    /**
     * @ORM\Column(type="integer")
     */
    protected $permitido;

    /**
     * @ORM\Column(type="string")
     */
    protected $dataAtualizacao;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\PerfilRecurso", cascade={"persist"})
     * @ORM\JoinColumn(name="idPerfilRecurso", referencedColumnName="idPerfilRecurso")
     * */
    protected $recurso;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioTipo", referencedColumnName="idUsuarioTipo")
     * */
    protected $usuarioTipo;

    public function getIdPerfilPermissao() {
        return $this->idPerfilPermissao;
    }

    public function getPermitido() {
        return $this->permitido;
    }

    public function getRecurso() {
        return $this->recurso;
    }

    public function getUsuarioTipo() {
        return $this->usuarioTipo;
    }

    public function setIdPerfilPermissao($idPerfilPermissao) {
        $this->idPerfilPermissao = $idPerfilPermissao;
    }

    public function setPermitido($permitido) {
        $this->permitido = $permitido;
    }

    public function setRecurso($recurso) {
        $this->recurso = $recurso;
    }

    public function setUsuarioTipo($usuarioTipo) {
        $this->usuarioTipo = $usuarioTipo;
    }

    public function exchangeArray($array) {
        if (is_array($array)) {
            $this->idPerfilPermissao = $array['idPerfilPermissao'];
            $this->permitido = $array['permitido'];

            $em = $GLOBALS['entityManager'];
            $this->recurso = $em->getRepository('Usuario\Entity\PerfilRecurso')->find($array['recurso']);
            $this->usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find($array['usuarioTipo']);
        } else {
            $this->idPerfilPermissao = $array->idPerfilPermissao;
            $this->permitido = $array['permitido'];
        }
    }

}
