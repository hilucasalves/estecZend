<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarTipoServicoForm;
use Application\Form\TipoServicoForm;
use Application\Entity\TipoServico;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class TipoServicoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\TipoServicoForm';
        $this->modelClass = 'Application\Entity\TipoServico';
        $this->route = 'tipoServico';
        $this->title = 'Serviços Ofertados';
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
        $sql->select('ts')->from($this->modelClass, 'ts');

        if ($data['servico']) {
            $sql->andWhere('ts.idTipoServico = :servico')->setParameter('servico', $data['servico']);
        }

        if ($data['statusTipoServico']) {
            $sql->andWhere('ts.statusTipoServico = :statusTipoServico')->setParameter('statusTipoServico', $data['statusTipoServico']);
        }

        $sql->AddOrderBy('ts.nome', 'ASC');
        $turmas = $sql->getQuery()->getResult();

        $form = new LocalizarTipoServicoForm();

        $pageAdapter = new ArrayAdapter($turmas);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('servico')->setValue($data['servico']);
        $form->get('statusTipoServico')->setValue($data['statusTipoServico']);

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
            return $this->redirect()->toRoute('tipoServico', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new TipoServicoForm($em);
        $model = new TipoServico();

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
            return $this->redirect()->toRoute('tipoServico', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);

        if ($model) {

            $form = new TipoServicoForm($em);
            $form->bind($model);
            $form->get('enviar')->setValue('Salvar');

            if ($this->getRequest()->isPost()) {
                $form->setData($this->getRequest()->getPost());
                if ($form->isValid()) {
                    $em->persist($model);
                    $em->flush();
                    $this->flashMessenger()->addInfoMessage('Alterado com sucesso.');
                    return $this->redirect()->toRoute($this->route);
                }
                $this->flashMessenger()->addErrorMessage('Erro. Não foi possível alterar.');
            }
            return array(
                'form' => $form,
            );
        } else {
            return $this->redirect()->toRoute('tipoServico', array('action' => 'acesso-negado'));
        }
    }

}
