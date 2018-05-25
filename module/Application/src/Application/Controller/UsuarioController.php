<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarUsuarioForm;
use Application\Form\UsuarioForm;
use Application\Entity\Usuario;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class UsuarioController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\UsuarioForm';
        $this->modelClass = 'Application\Entity\Usuario';
        $this->route = 'usuarios';
        $this->title = 'Usuário';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'Não';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

    public function indexAction() {
        $data = $this->getRequest()->getPost();

        $em = $GLOBALS['entityManager'];

        $sql = $em->createQueryBuilder();
        $sql->select('u')->from($this->modelClass, 'u');

        if ($data['usuario']) {
            $sql->andWhere('u.idUsuario = :usuario')->setParameter('usuario', $data['usuario']);
        }

        if ($data['usuarioTipo']) {
            $usuarioTipo = $em->getRepository('Application\Entity\UsuarioTipo')->find($data['usuarioTipo']);
            $sql->andWhere('u.usuarioTipo = :usuarioTipo')->setParameter('usuarioTipo', $usuarioTipo);
        }

        if ($data['statusUsuario']) {
            $sql->andWhere('u.statusUsuario = :statusUsuario')->setParameter('statusUsuario', $data['statusUsuario']);
        }

        $sql->AddOrderBy('u.nome', 'ASC');
        $usuarios = $sql->getQuery()->getResult();

        $form = new LocalizarUsuarioForm();

        $pageAdapter = new ArrayAdapter($usuarios);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('usuario')->setValue($data['usuario']);
        $form->get('statusUsuario')->setValue($data['statusUsuario']);
        $form->get('usuarioTipo')->setValue($data['usuarioTipo']);

        return array(
            'title' => $this->title,
            'form' => $form,
            'paginator' => $paginator,
        );
    }

    public function viewAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        $model = $em->getRepository($this->modelClass)->find($key);

        if ($model) {
            return array(
                'urlView' => $this->back(),
                'model' => $model
            );
        } else {
            return $this->redirect()->toRoute('usuarios', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new UsuarioForm($em);
        $model = new Usuario();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                $bcrypt = new \Zend\Crypt\Password\Bcrypt();
                $dataNascimento = new \DateTime($this->getRequest()->getPost()['usuario']['dataNascimento']);
                $model->__set('senha', $bcrypt->create($dataNascimento->format('dmY')));

                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addInfoMessage('Cadastrado com sucesso.');
                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar.');
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute('usuarios', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);
        if ($model) {
            $form = new UsuarioForm($em);
            $form->bind($model);
            $form->get('enviar')->setValue('Salvar');

            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());
                if ($form->isValid()) {
                    $model->__set('dataAtualizacao', new \DateTime());
                    $em->persist($model);
                    $em->flush();
                    $this->flashMessenger()->addInfoMessage('Alterado com sucesso.');
                    return $this->redirect()->toRoute($this->route);
                }
                $this->flashMessenger()->addErrorMessage('Erro. Não foi possível alterar.');
            }
        } else {
            return $this->redirect()->toRoute('usuarios', array('action' => 'acesso-negado'));
        }
        return array(
            'form' => $form,
        );
    }

}
