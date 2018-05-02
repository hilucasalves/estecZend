<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class LocalizarFechamentoMesForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('LocalizarFechamentoMesForm'); //nome formulario
        $this->setAttribute('method', 'get');
        $this->setAttribute('class', 'form-inline');



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



        $this->addElement('enviar', 'submit', 'Salvar', array('class' => 'btn btn-success'));
    }

    private function getUsuarios() {

        $usuario = new \Application\Controller\AuthController();

        $valueOptions = array();

        if ($usuario->usuarioAutenticado()['usuario']->login->usuario->usuarioTipo->idUsuarioTipo == 1) {
            $dql = "select u from Usuario\Entity\Usuario u WHERE u.statusUsuario = 'A' AND u.uaitec = 'S' order by u.nome";
        } else {
            $dql = "select u from Usuario\Entity\Usuario u WHERE u.statusUsuario = 'A' AND u.uaitec = 'S' AND u.orgaoLotacao = " . $usuario->usuarioAutenticado()['usuario']->orgaoLotacao->idOrgaoLotacao . " order by u.nome";
        }

        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $usuarios = $query->getResult();


        foreach ($usuarios as $usuario) {

            $valueOptions[$usuario->__get('idUsuario')] = $usuario->__get('nome');
        }
        return $valueOptions;
    }

}
