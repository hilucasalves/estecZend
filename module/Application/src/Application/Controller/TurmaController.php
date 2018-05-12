<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarTurmaForm;
use Application\Form\TurmaForm;
use Application\Entity\Turma;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class TurmaController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\TurmaForm';
        $this->modelClass = 'Application\Entity\Turma';
        $this->route = 'turma';
        $this->title = 'Turmas';
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
        $sql->select('t')->from($this->modelClass, 't');

        if ($data['turma']) {
            $sql->andWhere('t.idTurma = :turma')->setParameter('turma', $data['turma']);
        }

        if ($data['statusTurma']) {
            $sql->andWhere('t.statusTurma = :statusTurma')->setParameter('statusTurma', $data['statusTurma']);
        }

        $sql->AddOrderBy('t.nome', 'ASC');
        $turmas = $sql->getQuery()->getResult();

        $form = new LocalizarTurmaForm();

        $pageAdapter = new ArrayAdapter($turmas);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('turma')->setValue($data['turma']);
        $form->get('statusTurma')->setValue($data['statusTurma']);

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

        return array(
            'urlView' => $this->back(),
            'model' => $model
        );
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new TurmaForm($em);
        $model = new Turma();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso.');
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
            return $this->redirect()->toRoute('turma', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);

        $form = new TurmaForm($em);
        $form->bind($model);
        $form->get('enviar')->setValue('Salvar');
        $form->get('turma')->get("professor")->setValue($model->professor->idUsuario);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Alterado com sucesso.');
                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível alterar.');
        }
        return array(
            'form' => $form,
        );
    }

}
