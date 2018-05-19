<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Produto;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class ProdutoFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('produto');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Produto());

        $this->add(array(
            'name' => 'idProduto',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'nome',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Nome do Produto:',
            ),
        ));

        $this->add(array(
            'name' => 'qtd',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'step' => '1'
            ),
            'options' => array(
                'label' => 'Quantidade em estoque:',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusProduto',
            'attributes' => array(
                'id' => 'statusProduto',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'value_options' => array(
                    'A' => 'Ativo',
                    'I' => 'Inativo',
                ),
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'nome' => array(
                'required' => true,
            ),
            'qtd' => array(
                'required' => true,
            ),
        );
    }

}
