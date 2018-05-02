<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class AlterarTipoUsuarioForm extends AbstractForm
{

    public function __construct($name = null)
    {
        parent::__construct('alterarTipoUsuario'); //nome formulario
        $this->setAttribute('method', 'post');

        $this->addElement('idUsuario', 'hidden', 'idUsuario');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuarioTipo',
            'options' => array(
                'label' => 'Perfil',
                'empty_option' => 'Selecione',
                'value_options' => $this->getTipoUsuario(),
            )
        ));

        $this->addElement('enviar', 'submit', 'Salvar');
    }

    private function getTipoUsuario()
    {
        $valueOptions = array();

        $dql = "select u from Usuario\Entity\UsuarioTipo u";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tipos = $query->getResult();

        foreach ($tipos as $tipo)
        {
            $valueOptions[$tipo->__get('idUsuarioTipo')] = $tipo->__get('nome');
        }
        return $valueOptions;
    }

}
