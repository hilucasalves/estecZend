<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\UsuarioFieldset;

class UsuarioForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('usuarioForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $usuarioFieldset = new UsuarioFieldset($objectManager);
        $usuarioFieldset->setUseAsBaseFieldset(true);
        $this->add($usuarioFieldset);
        
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
