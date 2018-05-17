<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\TipoServicoFieldset;

class TipoServicoForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('tipoServicoForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $tipoServicoFieldset = new TipoServicoFieldset($objectManager);
        $tipoServicoFieldset->setUseAsBaseFieldset(true);
        $this->add($tipoServicoFieldset);
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'Enviar'
            ),
        ));
    }

}
