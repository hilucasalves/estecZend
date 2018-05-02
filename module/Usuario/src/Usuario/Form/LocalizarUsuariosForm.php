<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class LocalizarUsuariosForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('localizarUsuariosForm'); //nome formulario
        $this->setAttribute('method', 'get');
        $this->setAttribute('class', 'form-inline');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuario',
            'attributes' => array(
                'id' => 'comboboxTipo',
               
            ),
            'options' => array(
                'label' => 'Usuario: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getUsuarios(),
            )
        ));

        $this->add(array(
            'name' => 'cpf',
            'attributes' => array(
                'style' => 'width:200px',
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'CPF usuário: ',
            ),
        ));


        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'style' => 'width:200px',
                'class' => 'form-control',
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'E-mail: ',
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'orgaoLotacao',
            'attributes' => array(
                'class' => 'form-control',
                   'style' => 'width:500px'
            ),
            'options' => array(
                'label' => 'Orgão Lotação: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getOrgaos(),
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
