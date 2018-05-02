<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="documentotipo")
 * 
 */
class DocumentoTipo extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idDocumentoTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $documentoTipo;

    /**
     * @ORM\Column(type="string")
     */
    protected $sistema;

}
