<?php

namespace Application\Entity;

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
     * @ORM\OneToOne(targetEntity="Application\Entity\Login", inversedBy="usuario", cascade={"persist"})
     * @ORM\JoinColumn(name="idLogin", referencedColumnName="idLogin")
     * */
    protected $login;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneCelular;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $dataAtualizacao;
    /**
     * @ORM\Column(type="string")
     */
    protected $dataInsercao;
    
     /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioTipo", referencedColumnName="idUsuarioTipo")
     */
    protected $usuarioTipo;


}
