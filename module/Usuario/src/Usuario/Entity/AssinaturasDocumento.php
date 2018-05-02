<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="assinaturas")
 */
class AssinaturasDocumento extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idAssinatura;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     */
    protected $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Documento", cascade={"persist"})
     * @ORM\JoinColumn(name="idDocumento", referencedColumnName="idDocumento")
     */
    protected $documento;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;

    public function __construct() {
        $this->dataInsercao = new \DateTime();
    }

}
