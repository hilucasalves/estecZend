<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarProdutoForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarProdutoForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'produto',
            'attributes' => array(
                'id' => 'produto',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Produto: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getProduto(),
            )
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
                'empty_option' => 'Todos',
                'value_options' => array(
                    'A' => 'Ativo',
                    'I' => 'Inativo',
                ),
            )
        ));

        $this->add(array(
            'type' => 'submit',
            'name' => 'enviar',
            'attributes' => array(
                'class' => 'btn btn-info',
                'value' => 'Localizar'
            ),
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

}
