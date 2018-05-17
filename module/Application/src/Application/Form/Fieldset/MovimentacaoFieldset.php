<?php

namespace Application\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Application\Entity\Movimentacao;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;

class MovimentacaoFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct(ObjectManager $objectManager) {

        parent::__construct('movimentacao');

        $this->setHydrator(new DoctrineHydrator($objectManager))->setObject(new Movimentacao());

        $this->add(array(
            'name' => 'idMovimentacao',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'produto',
            'attributes' => array(
                'id' => 'produto',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Produto: ',
                'value_options' => $this->getProduto(),
            )
        ));

        $this->add(array(
            'name' => 'qtd',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'number',
            ),
            'options' => array(
                'label' => 'Quantidade:',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoMovimentacao',
            'attributes' => array(
                'id' => 'tipoMovimentacao',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Tipo de Movimentação: ',
                'empty_option' => 'Todos',
                'value_options' => array(
                    'E' => 'Entrada',
                    'S' => 'Saida',
                ),
            )
        ));
        
        $this->add(array(
            'name' => 'dataValidade',
            'attributes' => array(
                'class' => 'form-control',
                'type' => 'date',
            ),
            'options' => array(
                'label' => 'Data de Validade:',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusMovimentacao',
            'attributes' => array(
                'id' => 'statusMovimentacao',
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

    private function getProduto() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];

        $produtos = $em->getRepository('Application\Entity\Produto')->findAll();

        foreach ($produtos as $produto) {

            $valueOptions[$produto->__get('idProduto')] = $produto->__get('nome');
        }
        return $valueOptions;
    }

    public function getInputFilterSpecification() {
        return array(
            'produto' => array(
                'required' => true,
            ),
            'qtd' => array(
                'required' => true,
            ),
            'tipoMovimentacao' => array(
                'required' => true,
            ),
        );
    }

}
