<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarMatriculaForm;
use Application\Form\MatriculaForm;
use Application\Entity\Matricula;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class MatriculaController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\MatriculaForm';
        $this->modelClass = 'Application\Entity\Matricula';
        $this->route = 'matricula';
        $this->title = 'Matriculas';
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
        $sql->select('m')->from($this->modelClass, 'm');

        if ($data['aluno']) {
            $aluno = $em->getRepository('Application\Entity\Usuario')->find($data['aluno']);
            $sql->andWhere('m.aluno = :aluno')->setParameter('aluno', $aluno);
        }

        if ($data['turma']) {
            $turma = $em->getRepository('Application\Entity\Usuario')->find($data['turma']);
            $sql->andWhere('m.turma = :turma')->setParameter('turma', $turma);
        }

        if ($data['statusMatricula']) {
            $sql->andWhere('m.statusMatricula = :statusMatricula')->setParameter('statusMatricula', $data['statusMatricula']);
        }

        $sql->AddOrderBy('m.aluno', 'ASC');
        $matriculas = $sql->getQuery()->getResult();

        $form = new LocalizarMatriculaForm();

        $pageAdapter = new ArrayAdapter($matriculas);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('aluno')->setValue($data['aluno']);
        $form->get('turma')->setValue($data['turma']);
        $form->get('statusMatricula')->setValue($data['statusMatricula']);

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
            return $this->redirect()->toRoute('matricula', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new MatriculaForm($em);
        $model = new Matricula();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
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
            return $this->redirect()->toRoute('matricula', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);
        if ($model) {
            $form = new MatriculaForm($em);
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
            return $this->redirect()->toRoute('matricula', array('action' => 'acesso-negado'));
        }
        return array(
            'form' => $form,
        );
    }

}
