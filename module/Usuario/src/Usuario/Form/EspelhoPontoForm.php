<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class EspelhoPontoForm extends AbstractForm {

    public function __construct($name = null) {


        parent::__construct('espelhoPonto'); //nome formulario
        $this->setAttribute('method', 'get');
        $this->setAttribute('class', 'form-inline');

        // $attributes = array('class' => 'form-control');
        // $this->addElement('nome', 'text', 'Nome', $attributes);
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuario',
            'attributes' => array(               
                 'id' => 'comboboxTipo'
                
            ),
            'options' => array(
                'label' => 'Usuario: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuarios(),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'orgaoLotacao',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Orgão Lotação: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getOrgaos(),
            )
        ));
        $this->add(array(
            'name' => 'inicio',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data início:',
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'fim',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data fim:',
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control'
            )
        ));



        $this->addElement('enviar', 'submit', 'Salvar', array('class' => 'btn btn-success'));
    }

    private function getOrgaos() {
        $valueOptions = array();

        $dql = "select o from Usuario\Entity\OrgaoLotacao o order by o.orgaoLotacao ASC";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $orgaos = $query->getResult();


        foreach ($orgaos as $orgao) {

            $valueOptions[$orgao->__get('idOrgaoLotacao')] = $orgao->__get('orgaoLotacao');
        }
        return $valueOptions;
    }
    
     private function getUsuarios() {
        $valueOptions = array();

        $dql = "select u from Usuario\Entity\Usuario u WHERE u.statusUsuario = 'A' order by u.nome";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $usuarios = $query->getResult();


        foreach ($usuarios as $usuario) {

            $valueOptions[$usuario->__get('idUsuario')] = $usuario->__get('nome');
        }
        return $valueOptions;
    }

}
