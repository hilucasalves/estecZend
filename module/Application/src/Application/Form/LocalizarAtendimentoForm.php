<?php

namespace Application\Form;

use Uaitec\Form\AbstractForm;

class LocalizarAtendimentoForm extends AbstractForm {

    public function __construct($name = null) {

        parent::__construct('localizarAtendimentoForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-inline');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'cliente',
            'attributes' => array(
                'id' => 'cliente',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Cliente: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getCliente(),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'turma',
            'attributes' => array(
                'id' => 'turma',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Turma: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getTurma(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoServico',
            'attributes' => array(
                'id' => 'tipoServico',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Serviço: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getTipoServico(),
            )
        ));
        
        $this->add(array(
            'name' => 'dataPrevisao',
            'type' => 'Date',
            'attributes' => array(
                'class' => 'form-control',
                'min' => date('Y-m-d'),
                'max' => date('Y-m-d', strtotime('+1 years')),
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Data de Previsão: ',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusAtendimento',
            'attributes' => array(
                'id' => 'statusAtendimento',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Status: ',
                'empty_option' => 'Todos',
                'value_options' => array(
                             'A' => 'Ativo',
                             'F' => 'Finalizado',
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
    
    private function getCliente() {
        $valueOptions = array();
        
        $em = $GLOBALS['entityManager'];
        $clientes = $em->getRepository('Application\Entity\Usuario')->findAll();
        
        foreach ($clientes as $cliente) {
            $valueOptions[$cliente->__get('idUsuario')] = $cliente->__get('nome');
        }
        return $valueOptions;
    }

    private function getTurma() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $turmas = $em->getRepository('Application\Entity\Turma')->findAll();

        foreach ($turmas as $turma) {
            $valueOptions[$turma->__get('idTurma')] = $turma->__get('nome');
        }
        return $valueOptions;
    }
    
    private function getTipoServico() {
        $valueOptions = array();

        $em = $GLOBALS['entityManager'];
        $tipoServicos = $em->getRepository('Application\Entity\TipoServico')->findAll();

        foreach ($tipoServicos as $tipoServico) {
            $valueOptions[$tipoServico->__get('idTipoServico')] = $tipoServico->__get('nome');
        }
        return $valueOptions;
    }

}
