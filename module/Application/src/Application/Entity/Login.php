<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**

 *
 * @ORM\Entity
 * @ORM\Table(name="login")
 * */
class Login extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idLogin;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string")
     */
    protected $cpf;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataCriacao;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\UsuarioLoginStatus", cascade={"persist"})
     * @ORM\JoinColumn(name="idLoginStatus", referencedColumnName="idLoginStatus")
     */
    protected $status;

    /**
     * @ORM\OneToOne(targetEntity="Application\Entity\Usuario", mappedBy="login")
     */
    protected $usuario;


}
