<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuarioferias")
 */
class UsuarioFerias extends AbstractModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuarioFerias;
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\Usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     */
    protected $usuario;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $inicioFerias;    

    /**
     * @ORM\Column(type="datetime")
     */
    protected $fimFerias;    

    /**
     * @ORM\Column(type="integer")
     */
    protected $diasCorridos;   
    
    /**
     * @ORM\Column(type="date")
     */
    protected $dataInsercao;
   
    
    public function __construct()
    {
        $this->dataInsercao = new \Datetime();
    }
    
}

