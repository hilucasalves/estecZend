<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\MovimentacaoFieldset;

class MovimentacaoForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('movimentacaoForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $movimentacaoFieldset = new MovimentacaoFieldset($objectManager);
        $movimentacaoFieldset->setUseAsBaseFieldset(true);
        $this->add($movimentacaoFieldset);
        
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
