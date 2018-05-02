<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class LocalizarForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('localizar'); //nome formulario
        $this->setAttribute('method', 'get');
        $this->setAttribute('class', 'form-inline');


        $this->add(array(
            'name' => 'dataInicio',
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
            'name' => 'dataFim',
            'type' => 'Date',
            'options' => array(
                'label' => 'Data fim:',
            ),
            'attributes' => array(
                'step' => '1',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoRegistro',
            'attributes' => array(
                //'id' => 'comboboxTipo'
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Tipo do Registro',
                'empty_option' => 'Todos',
                'value_options' => $this->getTipoRegistro(),
            )
        ));

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



        $this->addElement('enviar', 'submit', 'Salvar', array('class' => 'btn btn-success'));
    }

    private function getUsuarios() {
        $valueOptions = array();

        $dql = "select u from Usuario\Entity\Usuario u WHERE u.usuarioTipo = '2' And u.statusUsuario = 'A' order by u.nome";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $usuarios = $query->getResult();


        foreach ($usuarios as $usuario) {

            $valueOptions[$usuario->__get('idUsuario')] = $usuario->__get('nome');
        }
        return $valueOptions;
    }

    private function getTipoRegistro() {
        $valueOptions = array();

        $dql = "select tr from Usuario\Entity\TipoRegistro tr";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $TipoRegistros = $query->getResult();

        foreach ($TipoRegistros as $TipoRegistro) {
            $valueOptions[$TipoRegistro->__get('idTipoRegistro')] = $TipoRegistro->__get('nome');
        }
        return $valueOptions;
    }

}
