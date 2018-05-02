<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class PermissaoForm extends AbstractForm
{

    public function __construct($name = null)
    {

        parent::__construct('unidadesForm');
        $this->setAttribute('method', 'post');
        $this->setAttribute('role', 'form');

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'perfilControle',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'idPerfilControle'
            ),
            'options' => array(
                'label' => 'Perfil Controle: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getPerfilControle(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'usuarioTipo',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'idUsuarioTipo'
            ),
            'options' => array(
                'label' => 'Usuário Tipo: ',
                'empty_option' => 'Selecione',
                'value_options' => $this->getStatus(),
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'perfilAcaoNome',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'idPerfilAcaoNome'
            ),
            'options' => array(
                'label' => 'Perfil Ação (Endereço): ',             
            )
        ));
        
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'perfilAcaoApelido',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'idPerfilAcaoApelido'
            ),
            'options' => array(
                'label' => 'Perfil Ação (Apelido): ',             
            )
        ));

        $this->addElement('enviar', 'submit', 'Registrar', array('class' => 'btn btn-info'));
        $this->addElement('atualizar', 'submit', 'Atualizar Banco', array('class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#myModal'));
        
        $this->add(array(
            'name' => 'qualidade',
            'type' => 'radio',
            'options' => array(
                'label' => 'Banco:', //nome campo
                'value_options' => array(
                    'Local' => 'Local',
                    'Producao' => 'Producao',
                    'Homologacao' => 'Homologacao'
                )
            )
        ));
    }

    private function getPerfilControle()
    {
        $valueOptions = array();

        $dql = "select s from Usuario\Entity\PerfilControle s order by s.nome";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $permic = $query->getResult();


        foreach ($permic as $p)
        {

            $valueOptions[$p->__get('idPerfilControle')] = $p->__get('nome');
        }
        return $valueOptions;
    }
    
    private function getStatus()
    {
        $valueOptions = array();

        $dql = "select s from Usuario\Entity\UsuarioTipo s order by s.nome";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tipo = $query->getResult();


        foreach ($tipo as $t)
        {

            $valueOptions[$t->__get('idUsuarioTipo')] = $t->__get('nome');
        }
        return $valueOptions;
    }

}
