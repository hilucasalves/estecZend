<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="usuariotipo")
 * 
 */
class UsuarioTipo extends AbstractModel
{

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

}
