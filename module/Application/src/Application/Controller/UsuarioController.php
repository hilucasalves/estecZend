<?php

namespace Application\Controller;


use Uaitec\Controller\AbstractCrudController;
use Usuario\Form\UsuarioForm;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;


class UsuarioController extends AbstractCrudController
{

   public function __construct()
    {
        $this->formClass = 'Application\Form\UsuarioForm';
        $this->modelClass = 'Application\Entity\Usuario';
        $this->route = 'usuario/default';
        $this->title = 'Usuario';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'Não';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

    
    public function indexAction()
    {
        echo "S";die;
    }
    
public function editAction()
    {
        
    }
    


}
