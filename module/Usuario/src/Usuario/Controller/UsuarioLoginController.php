<?php

namespace Usuario\Controller;

use Uaitec\Controller\AbstractCrudController;

class UsuarioLoginController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Usuario\Form\UsuarioLoginForm';
        $this->modelClass = 'Usuario\Entity\UsuarioLogin';
        $this->route = 'usuarioLogin';
        $this->title = 'Login';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'Não';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

    public function editAction() {

        parent::indexAction();

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route, array(
                        'action' => 'add'
            ));
        }


        $model = $this->getModel($key);

        $formClass = $this->formClass;
        $form = new $formClass();
        $form->bind($model);

        $form->get('status')->setValue($model->status->__get('idStatusLogin'));
        $form->get('enviar')->setValue($this->label['add']);

        $urlAction = $this->url()->fromRoute($this->route, array(
            'action' => 'edit',
            'key' => $key
                )
        );

        return $this->save($model, $form, $urlAction, $key);
    }

}
