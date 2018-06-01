<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarAtendimentoForm;
use Application\Form\AtendimentoForm;
use Application\Entity\Atendimento;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use PHPExcel;
use PHPExcel_IOFactory;

class AtendimentoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\AtendimentoForm';
        $this->modelClass = 'Application\Entity\Atendimento';
        $this->route = 'atendimento';
        $this->title = 'Atendimentos';
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
        $sql->select('a')->from($this->modelClass, 'a');

        if ($data['cliente']) {
            $cliente = $em->getRepository('Application\Entity\Usuario')->find($data['cliente']);
            $sql->andWhere('a.cliente = :cliente')->setParameter('cliente', $cliente);
        }
        
        if ($data['turma']) {
            $turma = $em->getRepository('Application\Entity\Turma')->find($data['turma']);
            $sql->andWhere('a.turma = :turma')->setParameter('turma', $turma);
        }
        
        if ($data['tipoServico']) {
            $tipoServico = $em->getRepository('Application\Entity\TipoServico')->find($data['tipoServico']);
            $sql->andWhere('a.tipoServico = :tipoServico')->setParameter('tipoServico', $tipoServico);
        }
        
        if ($data['dataPrevisao']) {
            $sql->andWhere('a.dataPrevisao = :dataPrevisao')->setParameter('dataPrevisao', $data['dataPrevisao']);
        }
        
        if ($data['statusAtendimento']) {
            $sql->andWhere('a.statusAtendimento = :statusAtendimento')->setParameter('statusAtendimento', $data['statusAtendimento']);
        }

        $sql->AddOrderBy('a.cliente', 'ASC');
        $atendimentos = $sql->getQuery()->getResult();
        
        $form = new LocalizarAtendimentoForm();
        
        $pageAdapter = new ArrayAdapter($atendimentos);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('cliente')->setValue($data['cliente']);
        $form->get('turma')->setValue($data['turma']);
        $form->get('tipoServico')->setValue($data['tipoServico']);
        $form->get('dataPrevisao')->setValue($data['dataPrevisao']);
        $form->get('statusAtendimento')->setValue($data['statusAtendimento']);

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
            return $this->redirect()->toRoute('atendimento', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new AtendimentoForm($em);
        $model = new Atendimento();
        
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
            return $this->redirect()->toRoute('atendimento', array('action' => 'acesso-negado'));
        }

        $em = $GLOBALS['entityManager'];

        $model = $em->getRepository($this->modelClass)->find($key);
        if ($model) {
            $form = new AtendimentoForm($em);
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
            return $this->redirect()->toRoute('atendimento', array('action' => 'acesso-negado'));
        }
        return array(
            'form' => $form,
        );
    }
    
    public function excelAction() {
        
        require_once ($_SERVER["DOCUMENT_ROOT"] . '/estecZend/vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
        require_once ($_SERVER["DOCUMENT_ROOT"] . '/estecZend/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Autor do Documento")
                ->setLastModifiedBy("Modificado por...")
                ->setTitle("O Título")
                ->setSubject("O Assunto")
                ->setDescription("A Descrição")
                ->setKeywords("As Palavras Chave")
                ->setCategory("A Categoria");

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Cliente')
                ->setCellValue('B1', 'Turma')
                ->setCellValue('C1', 'Serviço')
                ->setCellValue('D1', 'Status')
                ->setCellValue('E1', 'Data Criação')
                ->setCellValue('F1', 'Data Atualização');

        $linha = 2;

        $data = $this->getRequest()->getPost();

        $em = $GLOBALS['entityManager'];

        $sql = $em->createQueryBuilder();
        $sql->select('a')->from($this->modelClass, 'a');

        if ($data['cliente']) {
            $cliente = $em->getRepository('Application\Entity\Usuario')->find($data['cliente']);
            $sql->andWhere('a.cliente = :cliente')->setParameter('cliente', $cliente);
        }
        
        if ($data['turma']) {
            $turma = $em->getRepository('Application\Entity\Turma')->find($data['turma']);
            $sql->andWhere('a.turma = :turma')->setParameter('turma', $turma);
        }
        
        if ($data['tipoServico']) {
            $tipoServico = $em->getRepository('Application\Entity\TipoServico')->find($data['tipoServico']);
            $sql->andWhere('a.tipoServico = :tipoServico')->setParameter('tipoServico', $tipoServico);
        }
        
        if ($data['dataPrevisao']) {
            $sql->andWhere('a.dataPrevisao = :dataPrevisao')->setParameter('dataPrevisao', $data['dataPrevisao']);
        }
        
        if ($data['statusAtendimento']) {
            $sql->andWhere('a.statusAtendimento = :statusAtendimento')->setParameter('statusAtendimento', $data['statusAtendimento']);
        }
        
        $sql->AddOrderBy('a.cliente', 'ASC');
        $atendimentos = $sql->getQuery()->getResult();
        
        foreach ($atendimentos as $data) {

            if ($data->statusAtendimento == "A") {
                $statusAtendimento = "Ativo";
            } else if($data->statusAtendimento == "F") {
                $statusAtendimento = "Finalizado";
            } else {
                $statusAtendimento = "Inativo";
            }

            if ($data->dataAtualizacao) $dataAtualizacao = $data->dataAtualizacao->format('d/m/Y H:i:s');

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $linha, $data->cliente->nome)
                    ->setCellValue('B' . $linha, $data->turma->nome)
                    ->setCellValue('C' . $linha, $data->tipoServico->nome)
                    ->setCellValue('D' . $linha, $statusAtendimento)
                    ->setCellValue('E' . $linha, $data->dataInsercao->format('d/m/Y H:i:s'))
                    ->setCellValue('F' . $linha, $dataAtualizacao);
            $linha++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="atendimento.xlsx"');
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}
