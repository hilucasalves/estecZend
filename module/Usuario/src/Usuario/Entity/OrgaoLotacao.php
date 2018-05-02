<?php

namespace Usuario\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uaitec\Model\AbstractModel;
/**
 * @ORM\Entity
 * @ORM\Table(name="orgaolotacao")
 */
class OrgaoLotacao extends AbstractModel
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idOrgaoLotacao;

    /**
     * @ORM\Column(type="string")
     */
    protected $orgaoLotacao;


}
