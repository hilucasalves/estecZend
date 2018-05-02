<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 * @ORM\Entity
 * @ORM\Table(name="documento")
 */
class Documento extends AbstractModel {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idDocumento;
    /**
     * @ORM\Column(type="string")
     */
    protected $hashAuth;

    /**
     * @ORM\Column(type="string")
     */
    protected $codVerificador;

    /**
     * @ORM\Column(type="string")
     */
    protected $documentoHtml;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataInsercao;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataAtualizacao;       
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\DocumentoTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="idDocumentoTipo", referencedColumnName="idDocumentoTipo")
     */
    protected $documentoTipo;


    public function __construct() {
        $this->dataInsercao = new \DateTime();
        $this->dataAtualizacao = new \DateTime();
    }

}
