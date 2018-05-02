<?php

namespace Usuario\Form;

use Uaitec\Form\AbstractForm;

class LocalizarAbonosForm extends AbstractForm {

    public function __construct($name = null) {
        parent::__construct('localizarFeriasForm'); //nome formulario
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
            'name' => 'entrada',
            'type' => 'Time',
            'options' => array(
                'label' => 'Entrada',
                'format' => 'H:i'
            ),
            'attributes' => array(
                'min' => '00:00',
                'max' => '23:59',
                'class' => 'form-control'
            ),
        ));

        $this->add(array(
            'name' => 'saida',
            'type' => 'Time',
            'options' => array(
                'label' => 'Saída',
                'format' => 'H:i'
            ),
            'attributes' => array(
                'min' => '00:00',
                'max' => '23:59',
                'class' => 'form-control'
            ),
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'tipoRegistro',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Tipo do Registro: ',
                'empty_option' => 'Todos',
                'value_options' => $this->getTipoRegistro(),
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

    private function getTipoRegistro() {
        $valueOptions = array();

        $dql = "select t from Usuario\Entity\TipoRegistro t order by t.nome ASC";
        $em = $GLOBALS['entityManager'];
        $query = $em->createQuery($dql);
        $tiposRegistros = $query->getResult();


        foreach ($tiposRegistros as $tiposRegistro) {

            $valueOptions[$tiposRegistro->__get('idTipoRegistro')] = $tiposRegistro->__get('nome');
        }
        return $valueOptions;
    }

}
