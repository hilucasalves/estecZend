<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Application\Form\Fieldset\ProdutoFieldset;

class ProdutoForm extends AbstractForm {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('produtoForm');
        $this->setAttribute('role', 'form');
        $this->setAttribute('method', 'post');

        $this->setHydrator(new DoctrineHydrator($objectManager));

        $produtoFieldset = new ProdutoFieldset($objectManager);
        $produtoFieldset->setUseAsBaseFieldset(true);
        $this->add($produtoFieldset);
        
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
