<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\MatriculaFieldset;

class MatriculaForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('matriculaForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');
        
        $this->setHydrator(new DoctrineHydrator($objectManager));
        
        $matriculaFieldset = new MatriculaFieldset($objectManager);
        $matriculaFieldset->setUseAsBaseFieldset(true);
        $this->add($matriculaFieldset);
        
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
