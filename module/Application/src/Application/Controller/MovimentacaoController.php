<?php

namespace Application\Controller;

use Uaitec\Controller\AbstractCrudController;
use Application\Form\LocalizarMovimentacaoForm;
use Application\Form\MovimentacaoForm;
use Application\Entity\Movimentacao;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use PHPExcel;
use PHPExcel_IOFactory;

class MovimentacaoController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Application\Form\MovimentacaoForm';
        $this->modelClass = 'Application\Entity\Movimentacao';
        $this->route = 'movimentacao';
        $this->title = 'Movimentação de produtos';
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

        if ($data['produto']) {
            $produto = $em->getRepository('Application\Entity\Produto')->find($data['produto']);
            $sql->andWhere('m.produto = :produto')->setParameter('produto', $produto);
        }

        if ($data['tipoMovimentacao']) {
            $sql->andWhere('m.tipoMovimentacao = :tipoMovimentacao')->setParameter('tipoMovimentacao', $data['tipoMovimentacao']);
        }

        if ($data['statusMovimentacao']) {
            $sql->andWhere('m.statusMovimentacao = :statusMovimentacao')->setParameter('statusMovimentacao', $data['statusMovimentacao']);
        }

        $sql->AddOrderBy('m.dataInsercao', 'ASC');
        $movimentacoes = $sql->getQuery()->getResult();

        $form = new LocalizarMovimentacaoForm();

        $pageAdapter = new ArrayAdapter($movimentacoes);
        $paginator = new Paginator($pageAdapter);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
        $paginator->setItemCountPerPage(5);

        $form->get('produto')->setValue($data['produto']);
        $form->get('tipoMovimentacao')->setValue($data['tipoMovimentacao']);
        $form->get('statusMovimentacao')->setValue($data['statusMovimentacao']);

        return array(
            'result' => $movimentacoes,
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
            return $this->redirect()->toRoute('movimentacao', array('action' => 'acesso-negado'));
        }
    }

    public function addAction() {

        $em = $GLOBALS['entityManager'];

        $form = new MovimentacaoForm($em);
        $model = new Movimentacao();

        $form->get('enviar')->setValue('Cadastrar');
        $form->bind($model);

        if ($this->getRequest()->isPost()) {

            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $em->persist($model);

                $produto = $em->getRepository('Application\Entity\Produto')->find($model->produto->idProduto);
                if ($model->tipoMovimentacao == "E") {
                    $quantidade = $produto->__get('qtd') + $model->qtd;
                } else {
                    $quantidade = $produto->__get('qtd') - $model->qtd;
                }
                    
                if($model->tipoMovimentacao == "S" && $model->qtd > $produto->__get('qtd')) {
                    $this->flashMessenger()->addErrorMessage('Erro. Não é possível cadastrar saída com quantidade maior ao do estoque.'); 
                } else {
                    $produto->__set('qtd', $quantidade);
                    $em->persist($produto);

                    $em->flush();
                    $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso.');
                }
                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar.');
        }
        return array(
            'form' => $form
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
                ->setCellValue('A1', 'Produto')
                ->setCellValue('B1', 'Movimentação')
                ->setCellValue('C1', 'Quantidade')
                ->setCellValue('D1', 'Status')
                ->setCellValue('E1', 'Data Criação')
                ->setCellValue('F1', 'Data Atualização');

        $linha = 2;

        $data = $this->getRequest()->getPost();

        $em = $GLOBALS['entityManager'];

        $sql = $em->createQueryBuilder();
        $sql->select('m')->from($this->modelClass, 'm');

        if ($data['produto']) {
            $produto = $em->getRepository('Application\Entity\Produto')->find($data['produto']);
            $sql->andWhere('m.produto = :produto')->setParameter('produto', $produto);
        }

        if ($data['tipoMovimentacao']) {
            $sql->andWhere('m.tipoMovimentacao = :tipoMovimentacao')->setParameter('tipoMovimentacao', $data['tipoMovimentacao']);
        }

        if ($data['statusMovimentacao']) {
            $sql->andWhere('m.statusMovimentacao = :statusMovimentacao')->setParameter('statusMovimentacao', $data['statusMovimentacao']);
        }

        $sql->AddOrderBy('m.dataInsercao', 'ASC');
        $movimentacoes = $sql->getQuery()->getResult();

        foreach ($movimentacoes as $data) {

            if ($data->tipoMovimentacao == "E")
                $tipoMovimentacao = "Entrada";
            else
                $tipoMovimentacao = "Saída";

            if ($data->statusMovimentacao == "A")
                $statusMovimentacao = "Ativo";
            else
                $statusMovimentacao = "Inativo";

            if ($data->dataAtualizacao)
                $dataAtualizacao = $data->dataAtualizacao->format('d/m/Y H:i:s');

            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $linha, $data->produto->nome)
                    ->setCellValue('B' . $linha, $tipoMovimentacao)
                    ->setCellValue('C' . $linha, $data->qtd)
                    ->setCellValue('D' . $linha, $statusMovimentacao)
                    ->setCellValue('E' . $linha, $data->dataInsercao->format('d/m/Y H:i:s'))
                    ->setCellValue('F' . $linha, $dataAtualizacao);
            $linha++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="movimentacao.xlsx"');
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}
