<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="usuariocargo")
 * 
 */
class UsuarioCargo extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuarioCargo;

    /**
     * @ORM\Column(type="string")
     */
    protected $cargo;

}
