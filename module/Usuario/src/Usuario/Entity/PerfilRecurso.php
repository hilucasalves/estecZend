<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="perfilrecurso")
 * 
 */
class PerfilRecurso extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idPerfilRecurso;

  
    /**
     * @ORM\Column(type="string")
     */
    protected $dataAtualizacao;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\PerfilControle")
     * @ORM\JoinColumn(name="idPerfilControle", referencedColumnName="idPerfilControle")
     */
    
    protected $controle;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Usuario\Entity\PerfilAcao")
     * @ORM\JoinColumn(name="idPerfilAcao", referencedColumnName="idPerfilAcao")
     */
    
    protected $acao;
    
   
}
