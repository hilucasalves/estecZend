<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarioferiasregistro")
 */
class UsuarioFeriasRegistro extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuarioRegistro;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioRegistro", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioRegistro", referencedColumnName="idUsuarioRegistro")
     */
    protected $usuarioRegistro;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioFerias", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioFerias", referencedColumnName="idUsuarioFerias")
     */
    protected $usuarioFerias;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;

    public function __construct() {
        $this->dataInsercao = new \DateTime();
    }

}
