<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class Usuario extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;

    /**
     * @ORM\OneToOne(targetEntity="Usuario\Entity\UsuarioLogin", inversedBy="usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idLogin", referencedColumnName="idLogin")
     * */
    protected $login;     
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioTipo", referencedColumnName="idUsuarioTipo")
     */
    protected $usuarioTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusUsuario;
    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneCelular;
    /**
     * @ORM\Column(type="date")
     */
    protected $dataNascimento;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $rg;
    
    public function __construct() {
        $this->dataInsercao = new  \DateTime();
    }
}
