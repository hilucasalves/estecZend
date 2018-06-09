<?php

namespace Usuario\Controller;

use Uaitec\Controller\AbstractCrudController;
use Usuario\Form\UsuarioForm;
use Usuario\Entity\Usuario;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use PHPExcel_IOFactory;
use Zend\Json\Json;

class UsuarioController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Usuario\Form\UsuarioForm';
        $this->modelClass = 'Usuario\Entity\Usuario';
        $this->route = 'usuario/default';
        $this->title = 'Usuario';
        $this->label['yes'] = 'Sim';
        $this->label['no'] = 'N�o';
        $this->label['add'] = 'Cadastrar';
        $this->label['edit'] = 'Alterar';
        $this->label['view'] = 'Ver';
        $this->label['delete'] = 'Excluir';
    }

    public function viewAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        // Busca pelo login
        $model = $em->getRepository('Usuario\Entity\Usuario')->find($this->usuarioAutenticado()['usuario']->idUsuario);

        return array(
            'model' => $model
        );
    }
    
    
    public function documentoAction() {

        $em = $GLOBALS['entityManager'];
        $resquest = $this->getRequest();
         $idDocumento = $resquest->getPost()['idDocumento'];               

        if ($resquest->isPost()) {
            $em = $GLOBALS['entityManager'];           
            $documento = $em->getRepository('Usuario\Entity\Documento')->find($idDocumento);   
            $assinaturas = $em->getRepository('Usuario\Entity\AssinaturasDocumento')->findBy(array('documento' => $documento->idDocumento));   
        }

        return array(
            'documento' => $documento,
            'assinaturas' => $assinaturas
        );
    }
    
    public function deleteFeriadoAction() {

        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute($this->route);
        }

        $em = $GLOBALS['entityManager'];
        $model = $em->getRepository('Usuario\Entity\Feriados')->find($key);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', $this->label['no']);

            if ($del == $this->label['yes']) {

                $usuariosRegistros = $em->getRepository('Usuario\Entity\UsuarioRegistro')->findBy(array('dataInsercao' => $model->dataFeriado));

                foreach ($usuariosRegistros as $usuarioRegistro) {
                    $em->remove($usuarioRegistro);
                    $em->flush();
                }

                $em->remove($model);
                $em->flush();
            } else {
                return $this->redirect()->toUrl('/usuario/usuario/gerenciar-feriado');
            }
            $this->flashMessenger()->addSuccessMessage('Removido com sucesso!');
            return $this->redirect()->toUrl('/usuario/usuario/gerenciar-feriados');
        }

        return array(
            'form' => $this->getDeleteForm($key),
            'model' => $model
        );
    }
    private function getIpUsuario() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
    public function indexAction() {
        
        echo "Usuário";

        $em = $GLOBALS['entityManager'];
        
        
   
        return array(
            'infoDia' => $infoDia,
            'resultado' => $resultado
        );
    }
    public function addAction() {

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new UsuarioForm($objectManager);
        $model = new Usuario();
        $form->get('enviar')->setValue($this->label['add']);
        $form->bind($model);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $bcrypt = new \Zend\Crypt\Password\Bcrypt();
                $model->login->senha = '123456';
                $model->login->__set('senha', $bcrypt->create($model->login->senha));
                $model->login->__set('nome', $model->nome);
                $objectManager->persist($model);
                $objectManager->flush();
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');

                return $this->redirect()->toRoute($this->route);
            }
            $this->flashMessenger()->addErrorMessage('Erro. N�o foi poss�vel cadastrar!');
        }
        return array(
            'form' => $form,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back(),
        );
    }
    public function localizarUsuarioAction() {



        $em = $GLOBALS['entityManager'];

        $form = new \Usuario\Form\LocalizarUsuariosForm();
        $form->get('enviar')->setValue('Localizar');

        $filtro = new \Zend\Filter\Digits();
        $data = $this->getRequest()->getQuery();
        $cpf = $filtro->filter($data['cpf']);
        $email = $data['email'];
        $usuario = $data['usuario'];
        $orgaoLotacao = $data['orgaoLotacao'];

        if ($_REQUEST) {

            $result = array();

            if ($data['orgaoLotacao'] || $data['email'] || $data['cpf'] || $data['usuario']) {

                $sql = $em->createQueryBuilder();
                $sql->select('ul')->from('Usuario\Entity\UsuarioLogin', 'ul')
                        ->innerJoin('ul.usuario', 'u');


                /*if ($orgaoLotacao) {
                    $sql->andWhere('u.orgaoLotacao = :orgaoLotacao');
                    $sql->setParameter('orgaoLotacao', $orgaoLotacao);
                }*/

                if ($cpf) {

                    $sql->andWhere($sql->expr()->like('ul.cpf', ':cpf'));
                    $sql->setParameter('cpf', '%' . $cpf . '%');
                }

                if ($usuario) {
                    $sql->andWhere('u.idUsuario = :usuario');
                    $sql->setParameter('usuario', $usuario);
                }

                if ($email) {

                    $sql->andWhere($sql->expr()->like('ul.email', ':email'));
                    $sql->setParameter('email', '%' . $email . '%');
                }

                $sql->AddOrderBy('u.nome', 'ASC');
                $result = $sql->getQuery()->getResult();
            } else {

                $sql = $em->createQueryBuilder();
                $sql->select('ul')->from('Usuario\Entity\UsuarioLogin', 'ul')
                        ->innerJoin('ul.usuario', 'u');

                $sql->AddOrderBy('u.nome', 'ASC');

                $result = $sql->getQuery()->getResult();
                // echo '<pre>';var_dump($result);die;
            }

            //Configura o paginador 
            $pageAdapter = new ArrayAdapter($result);
            $paginator = new Paginator($pageAdapter);
            $paginator->setCurrentPageNumber($this->params()->fromRoute('page', 1));
            $paginator->setItemCountPerPage(1000);

            $form->get('cpf')->setValue($data['cpf']);
            $form->get('email')->setValue($data['email']);
            $form->get('usuario')->setValue($data['usuario']);
            $form->get('orgaoLotacao')->setValue($data['orgaoLotacao']);
        }
        return array(
            'form' => $form,
            'paginator' => $paginator,
            'result' => $result,
        );
    } 
    public function editAction() {
        //Mensagem de erro caso o formulario foi preenchido incorretamente
        $message = "";

        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

//ID do login (idLogin)
        $key = (int) $this->params()->fromRoute('key', null);

        if (is_null($key)) {
            return $this->redirect()->toRoute('usuario/default', array('action' => 'acesso-negado'));
        }

        $model = $objectManager->getRepository('Usuario\Entity\Usuario')->find($key);

        //echo '<pre>';var_dump($model->idUsuario);die;
        $form = new UsuarioForm($objectManager);
        $form->bind($model);
        $form->get('enviar')->setValue('Salvar');

        $urlAction = $this->url()->fromRoute($this->route, array(
            'action' => 'edit',
            'key' => $key
                )
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
             $dados = $this->request->getPost();

            if ($form->isValid()) {
                $objectManager->_set('uaitec', $dados['uaitec']);
                $objectManager->persist($model);
                $objectManager->flush();
                $this->flashMessenger()->addSuccessMessage('Alterado com sucesso!');
                return $this->redirect()->toRoute($this->route, array('action' => 'edit', 'key' => $key));
               
            } else {
                $message = 'Erro. Verifique se todos os campos foram preenchidos corretamente!';
            }

            $this->flashMessenger()->addErrorMessage('Erro. N�o foi poss�vel alterar!');
        }
        return array(
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => $this->setAndGetTitle(),
            'urlView' => $this->back(),
            'mensagem' => $message
        );
    }
    public function cadastrarLoginAction() {
        $model = new UsuarioLogin();
        $form = new \Application\Form\CadastrarLoginForm();

        $bcrypt = new \Zend\Crypt\Password\Bcrypt();


        $form->get('enviar')->setValue('Cadastrar');

        $form->bind($model);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $em = $GLOBALS['entityManager'];

                $status = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find(3);

                $model->__set('status', $status);
                $model->__set('dataCriacao', new \DateTime());
                $model->__set('senha', $bcrypt->create($model->senha));

                $model->getArrayCopy($form->getData());

                $em->persist($model);
                $em->flush();



                $this->enviaEmail($model, 1);

                $this->flashMessenger()->addSuccessMessage('<h3>Cadastro realizado com sucesso.</h3>
                                                    <p>Acesse o seu email para validar seu cadastro.</p>
                        <p>Caso a mensagem n�o apare�a na caixa de entrada, verifique se ela est� no lixo eletr�nico.</p>
                ');

                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'cadastrar-login'));
            }
            //$this->flashMessenger()->addErrorMessage('Erro. N�o foi poss�vel cadastrar!');
        }

        return array(
            'form' => $form,
        );
    }

    public function permissaoAction() {

        $form = new \Usuario\Form\PermissaoForm();

        $arrayPerfilControle = array();

        $dql = "select s from Usuario\Entity\PerfilControle s order by s.nome";
        $emm = $GLOBALS['entityManager'];
        $query = $emm->createQuery($dql);
        $permic = $query->getResult();


        foreach ($permic as $p) {

            array_push($arrayPerfilControle, $p->__get('nome'));
        }
        $arrayPerfilControleJson = json_encode($arrayPerfilControle);
        $dominio = $_SERVER['HTTP_HOST'];
        if ($dominio == 'uaitec') {
            $emProducao = $this->getServiceLocator()->get('doctrine.entitymanager.orm_seventh');
            $emLocal = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

            // Pesquisa de permiss�es Local  --------------------
            $sql = $emLocal->createQueryBuilder();

            $sql->select('a.nome Endereco', 'a.apelido Apelido', 'c.nome Controle', 'c.idPerfilControle idControle', 'ut.idUsuarioTipo usuarioTipo')
                    ->from('Usuario\Entity\PerfilPermissao', 'pp')
                    ->innerJoin('pp.recurso', 'pr')
                    ->innerJoin('pp.usuarioTipo', 'ut')
                    ->innerJoin('pr.controle', 'c')
                    ->innerJoin('pr.acao', 'a');

            $retornoLocal = $sql->getQuery()->getResult();

            // --------------------------------------------------
            // Pesquisa de permiss�es Em produ��o  
            $sql2 = $emProducao->createQueryBuilder();

            $sql2->select('a.nome Endereco', 'a.apelido Apelido', 'c.nome Controle', 'c.idPerfilControle idControle', 'ut.idUsuarioTipo usuarioTipo')
                    ->from('Usuario\Entity\PerfilPermissao', 'pp')
                    ->innerJoin('pp.recurso', 'pr')
                    ->innerJoin('pp.usuarioTipo', 'ut')
                    ->innerJoin('pr.controle', 'c')
                    ->innerJoin('pr.acao', 'a');

            $retornoProducao = $sql2->getQuery()->getResult();

            // --------------------------------------------------

            $retorno = array();
            foreach ($retornoProducao as $rProd) {

                if (!in_array($rProd, $retornoLocal)) {
                    array_push($retorno, $rProd);
                }
            }
        }
        if ($this->request->isPost()) {

            $request = $this->getRequest();
            $dados = $request->getPost()->toArray();

            //Se for para atualizar o banco em rela��o a produ��o, entra neste la�o
            if (!$dados['enviar']) {

                //--------------------
                $em = $GLOBALS['entityManager'];
                for ($i = 0; $i < count($dados['apelido']); $i++) {
                    $validaPerfilAcao = $em->getRepository('Usuario\Entity\PerfilAcao')->findOneBy(array('nome' => $dados['endereco'][$i], 'apelido' => $dados['apelido'][$i]));
                    if (!$validaPerfilAcao) {
                        $pAcao = new \Usuario\Entity\PerfilAcao();

                        $pAcao->__set('nome', $dados['endereco'][$i]);
                        $pAcao->__set('apelido', $dados['apelido'][$i]);

                        $em->persist($pAcao);
                        $em->flush();
                    }
                    $perfilAcao = $em->getRepository('Usuario\Entity\PerfilAcao')->findOneBy(array('nome' => $dados['endereco'][$i], 'apelido' => $dados['apelido'][$i]));

                    //---Fim parte perfilA��o-----------
                    //--Inicio perfilControle------------
                    $perfilControle = $em->getRepository('Usuario\Entity\PerfilControle')->findOneBy(array('nome' => $dados['controle'][$i]));
                    if (!$perfilControle) {
                        $perfilControle = new \Usuario\Entity\PerfilControle();

                        $perfilControle->__set('nome', $dados['controle'][$i]);
                        $perfilControle->__set('apelido', $dados['controle'][$i]);

                        $em->persist($perfilControle);
                        $em->flush();
                    }
                    //---Fim parte perfilControle-----------
                    //--Inicio perfilRecurso------------
                    $validaPerfilRecurso = $em->getRepository('Usuario\Entity\PerfilRecurso')->findOneBy(array('controle' => $perfilControle, 'acao' => $perfilAcao));
                    if (!$validaPerfilRecurso) {
                        $pRecurso = new \Usuario\Entity\PerfilRecurso();

                        $pRecurso->__set('controle', $perfilControle);
                        $pRecurso->__set('acao', $perfilAcao);

                        $em->persist($pRecurso);
                        $em->flush();
                    }
                    $perfilRecurso = $em->getRepository('Usuario\Entity\PerfilRecurso')->findOneBy(array('controle' => $perfilControle, 'acao' => $perfilAcao));

                    //---Fim parte perfilRecurso--------
                    //--Inicio perfilPermissao----------

                    $usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find($dados['usuarioTipoAtualizar'][$i]);

                    $pPermissao = new \Usuario\Entity\PerfilPermissao();

                    $pPermissao->__set('permitido', 1);
                    $pPermissao->__set('recurso', $perfilRecurso);
                    $pPermissao->__set('usuarioTipo', $usuarioTipo);

                    $em->persist($pPermissao);
                    $em->flush();

                    $perfilPermissao = $em->getRepository('Usuario\Entity\PerfilPermissao')->findOneBy(array('recurso' => $perfilRecurso, 'usuarioTipo' => $usuarioTipo));

                    //---Fim parte perfilPermissao--------

                    if (!$perfilPermissao) {
                        $this->flashMessenger()->addErrorMessage('Ocorreu um erro e n�o foi poss�vel cadastrar permiss�o no banco local');
                        return $this->redirect()->toUrl("/usuario/usuario/permissao");
                    }
                }
                $this->flashMessenger()->addSuccessMessage('Permiss�o cadastrada com sucesso!');
                return $this->redirect()->toUrl("/usuario/usuario/permissao");

                //--------------------
            } else {
                //Se n�o for selecionado um banco
                if (!$dados['banco']) {
                    $this->flashMessenger()->addErrorMessage('Selecione um Banco para inserir a permiss�o');
                    return $this->redirect()->toUrl("/usuario/usuario/permissao");
                }
                //Se algum dos campos estiver em branco
                if (!$dados['perfilAcaoNome'] || !$dados['perfilAcaoApelido'] || !$dados['perfilControle'] || !$dados['usuarioTipo']) {
                    $this->flashMessenger()->addErrorMessage('Insira os dados corretamente');
                    return $this->redirect()->toUrl("/usuario/usuario/permissao");
                }
                //para cada banco selecionado abre uma conex�o para inserir os arquivos
                foreach ($dados['banco'] as $banco) {

                    if ($banco == 'local' and $dominio == 'uaitec') {
                        //Abre a conex�o com o banco local
                        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                    } elseif ($banco == 'homologacao' and $dominio == 'uaitec') {
                        //Abre a conex�o com o banco de homologacao
                        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_sixth');
                    } elseif ($banco == 'producao' and $dominio == 'uaitec') {
                        //Abre a conex�o com o banco de produ��o
                        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_seventh');
                    } elseif ($banco == 'homologacao' and $dominio == 'homologacao.uaitec.mg.gov.br') {
                        //Abre a conex�o com o banco de homologacao
                        $em = $GLOBALS['entityManager'];
                    } elseif ($banco == 'producao' and $dominio == 'uaitec.mg.gov.br') {
                        //Abre a conex�o com o banco de produ��o
                        $em = $GLOBALS['entityManager'];
                    }

                    //--Inicio perfilAcao -------------
                    $perfilAcao = $em->getRepository('Usuario\Entity\PerfilAcao')->findOneBy(array('nome' => $dados['perfilAcaoNome'], 'apelido' => $dados['perfilAcaoApelido']));
                    if (!$perfilAcao) {
                        $perfilAcao = new \Usuario\Entity\PerfilAcao();

                        $perfilAcao->__set('nome', $dados['perfilAcaoNome']);
                        $perfilAcao->__set('apelido', $dados['perfilAcaoApelido']);

                        $em->persist($perfilAcao);
                        $em->flush();
                    }
                    //---Fim parte perfilA��o-----------
                    //--Inicio perfilControle------------
                    $perfilControle = $em->getRepository('Usuario\Entity\PerfilControle')->findOneBy(array('nome' => $dados['perfilControle']));
                    if (!$perfilControle) {
                        $perfilControle = new \Usuario\Entity\PerfilControle();

                        $perfilControle->__set('nome', $dados['perfilControle']);
                        $perfilControle->__set('apelido', $dados['perfilControle']);

                        $em->persist($perfilControle);
                        $em->flush();
                    }
                    //---Fim parte perfilControle-----------
                    //--Inicio perfilRecurso------------
                    $perfilRecurso = $em->getRepository('Usuario\Entity\PerfilRecurso')->findOneBy(array('controle' => $perfilControle, 'acao' => $perfilAcao));
                    if (!$perfilRecurso) {
                        $perfilRecurso = new \Usuario\Entity\PerfilRecurso();

                        $perfilRecurso->__set('controle', $perfilControle);
                        $perfilRecurso->__set('acao', $perfilAcao);

                        $em->persist($perfilRecurso);
                        $em->flush();
                    }
                    //---Fim parte perfilRecurso--------
                    //--Inicio perfilPermissao----------

                    $usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find($dados['usuarioTipo']);

                    $perfilPermissao = new \Usuario\Entity\PerfilPermissao();

                    $perfilPermissao->__set('permitido', 1);
                    $perfilPermissao->__set('recurso', $perfilRecurso);
                    $perfilPermissao->__set('usuarioTipo', $usuarioTipo);

                    $em->persist($perfilPermissao);
                    $em->flush();

                    //---Fim parte perfilPermissao--------

                    if ($dados['banco'] == 'local') {
                        if (!$perfilPermissao) {
                            $this->flashMessenger()->addErrorMessage('Ocorreu um erro e n�o foi poss�vel cadastrar permiss�o no banco local');
                            return $this->redirect()->toUrl("/usuario/usuario/permissao");
                        }
                    } elseif ($dados['banco'] == 'homologacao') {
                        if (!$perfilPermissao) {
                            $this->flashMessenger()->addErrorMessage('Ocorreu um erro e n�o foi poss�vel cadastrar permiss�o no banco de homologa��o');
                            return $this->redirect()->toUrl("/usuario/usuario/permissao");
                        }
                    } elseif ($dados['banco'] == 'producao') {
                        if (!$perfilPermissao) {
                            $this->flashMessenger()->addErrorMessage('Ocorreu um erro e n�o foi poss�vel cadastrar permiss�o no banco de produ��o');
                            return $this->redirect()->toUrl("/usuario/usuario/permissao");
                        }
                    }
                }

                $this->flashMessenger()->addSuccessMessage('Permiss�o cadastrada com sucesso!');
                return $this->redirect()->toUrl("/usuario/usuario/permissao");
            }
        }
        return array(
            'form' => $form,
            'retorno' => $retorno,
            'arrayPerfilControle' => $arrayPerfilControleJson,
        );
    }
    public function buscarPermissoesCadastradasAction() {

        $em = $GLOBALS['entityManager'];

        $dominio = $_SERVER['HTTP_HOST'];

        $perfilPermissoes = $em->getRepository('Usuario\Entity\PerfilPermissao')->findBy(array('permitido' => 1), array('idPerfilPermissao' => 'DESC'));

        if ($perfilPermissoes) {

            foreach ($perfilPermissoes as $key => $permissao) {

                $perfilAcaoEndereco = $permissao->recurso->acao->nome;
                $perfilAcaoApelido = $permissao->recurso->acao->apelido;
                $perfilControle = $permissao->recurso->controle->nome;
                $usuarioTipo = $permissao->usuarioTipo->nome;

                $permissoes[$permissao->idPerfilPermissao] = $perfilAcaoApelido .
                        '/-/' .
                        $perfilAcaoEndereco .
                        '/-/' .
                        $perfilControle .
                        '/-/' .
                        $usuarioTipo .
                        '/-/' .
                        $permissao->idPerfilPermissao .
                        '/-/' .
                        ($key + 1) .
                        '/-/' .
                        $dominio;
            }
        }

        return $this->getResponse()->setContent(Json::encode($permissoes));
    }
    public function desativaPermissaoAction() {
        $idPermissao = $this->params()->fromPost('idPermissao');
        //$idPermissao = 1348;

        $em = $GLOBALS['entityManager'];
        $perfilPermissao = $em->getRepository('Usuario\Entity\PerfilPermissao')->find($idPermissao);

        $em->remove($perfilPermissao);
        $em->flush();

        $dados = array();

        $dados['deletado'] = 'S';


        return $this->getResponse()->setContent(Json::encode($dados));
    }

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }
    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    public function buscarColaboradorAction() {
        $xml = simplexml_load_file('http://dados/view/XmlSgerpColaborador/ver.php');

        $var = json_encode($xml);
        $varcu = json_decode($var);
    }

}
