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
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idUsuarioTipo", referencedColumnName="idUsuarioTipo")
     */
    protected $usuarioTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="date")
     */
    protected $dataNascimento;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneFixo;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefoneCelular;

    /**
     * @ORM\Column(type="string")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string")
     */
    protected $statusUsuario;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;
    
    public function __construct() {
        $this->dataInsercao = new  \DateTime();
    }
}
