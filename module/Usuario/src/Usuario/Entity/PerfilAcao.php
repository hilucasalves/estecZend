<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="perfilacao")
 * 
 */
class PerfilAcao extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idPerfilAcao;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $apelido;

}
