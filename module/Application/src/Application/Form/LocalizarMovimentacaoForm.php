<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarMovimentacaoForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarMovimentacaoForm');
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusMovimentacao',
            'attributes' => array(
                'id' => 'statusMovimentacao',
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
                'value' => 'Enviar'
            ),
        ));
    }

    private function getProduto() {
        $valueOptions = array();
        
        $em = $GLOBALS['entityManager'];
        
        $produtos = $em->getRepository('Application\Entity\Movimentacao')->findAll();
        
        foreach ($produtos as $produto) {

            $valueOptions[$produto->produto->__get('idProduto')] = $produto->produto->__get('nome');
        }
        return $valueOptions;
    }

}
