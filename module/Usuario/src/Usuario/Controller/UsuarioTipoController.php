<?php

namespace Usuario\Controller;

use Uaitec\Controller\AbstractCrudController;

class UsuarioTipoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Usuario\Form\UsuarioTipoForm';
        $this->modelClass = 'Usuario\Entity\UsuarioTipo';
        $this->route = 'usuarioTipo';
       
        $this->title = 'Perfil do Usuário ';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'Não';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

}
