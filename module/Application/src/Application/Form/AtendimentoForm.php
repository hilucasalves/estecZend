<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\AtendimentoFieldset;

class AtendimentoForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('atendimentoForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');
        
        $this->setHydrator(new DoctrineHydrator($objectManager));
        
        $atendimentoFieldset = new AtendimentoFieldset($objectManager);
        $atendimentoFieldset->setUseAsBaseFieldset(true);
        $this->add($atendimentoFieldset);
        
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
