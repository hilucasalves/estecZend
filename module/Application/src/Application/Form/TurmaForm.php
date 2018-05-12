<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\TurmaFieldset;

class TurmaForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('turmaForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $turmaFieldset = new TurmaFieldset($objectManager);
        $turmaFieldset->setUseAsBaseFieldset(true);
        $this->add($turmaFieldset);
        
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
