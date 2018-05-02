<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Application\Form\LoginForm;
use Usuario\Entity\UsuarioLogin;
use Application\Entity\Usuario;

class AuthController extends AbstractActionController {

    public function validarDocumentoAction() {

        $form = new \Application\Form\ValidarDocumentoForm();

        $em = $GLOBALS['entityManager'];
        $resquest = $this->getRequest();
        $param_get = $resquest->getQuery()->toArray();

        if ($resquest->isPost()) {

            $form->setData($resquest->getPost());

            if ($form->isValid()) {

                $em = $GLOBALS['entityManager'];
                $codVerificador = $form->getData()['codVerificador'];
                $documento = $em->getRepository('Usuario\Entity\Documento')->findOneBy(array('codVerificador' => $codVerificador));
                $assinaturas = $em->getRepository('Usuario\Entity\AssinaturasDocumento')->findBy(array('documento' => $documento->idDocumento));
            }
        } else if ($param_get['codVerif']) {
            $codVerificador = $param_get['codVerif'];
        }

        return array(
            'form' => $form,
            'documento' => $documento,
            'assinaturas' => $assinaturas,
            'codVerificador' => $codVerificador
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

    public function indexAction() {
        $form = new LoginForm();

        $resquest = $this->getRequest();

        $messages = '';

        if ($resquest->isPost()) {

            $form->setData($resquest->getPost());


            if ($form->isValid()) {
                $data = $resquest->getPost()->toArray();

                //Criando o armazem para gravar sessão da autenticação
                $sessionStorage = new Session("login");
                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage);

                $authAdpter = $this->getServiceLocator()->get('Application\Auth\DoctrineAdpter');
                $authAdpter->setCpf($form->getData()['cpf']);
                $authAdpter->setSenha($form->getData()['senha']);

                $em = $GLOBALS['entityManager'];
                $verificaFlg = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('cpf' => $form->getData()['cpf']));


                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

                $ipTratado = explode('.', $ip);
                $ipOctetoAluno = $ipTratado[0] . '.' . $ipTratado[1];

                $result = $auth->authenticate($authAdpter);


                if ($verificaFlg->status->idLoginStatus != 2) {
                    if ($verificaFlg->flgExterno == 'I') {
                        if ($ipOctetoAluno == '10.3' || $ipOctetoAluno == '10.181' || $ipOctetoAluno == '127.0') {

                            if ($result->isValid()) {
                                $login = $auth->getIdentity();
                                $login = $login['login'];

                                $sessionStorage->write($login, null);
                                $time = 7200;
                                $sessionManager = new \Zend\Session\SessionManager();
                                $sessionManager->rememberMe($time);

                                return $this->redirect()->toRoute('usuario', array('controller' => 'index'));
                            } else {
                                $messages = "CPF ou SENHA ínválido(s)!";
                            }
                        } else {
                            $messages = "Você não pode acessar essa aplicação de fora da CA.";
                        }
                    } else {

                        if ($result->isValid()) {

                            $login = $auth->getIdentity();
                            $login = $login['login'];

                            $sessionStorage->write($login, null);
                            $time = 7200;
                            $sessionManager = new \Zend\Session\SessionManager();
                            $sessionManager->rememberMe($time);

                            return $this->redirect()->toRoute('usuario', array('controller' => 'index'));
                        } else {
                            $messages = "CPF ou SENHA ínválido(s)!";
                        }
                    }
                } else {
                    $messages = "Usuario Inativo";
                }
            }
        }



        return new ViewModel(array(
            'form' => $form,
            'messages' => $messages
        ));
    }

    public function wsInserirDocumentoAction() {

        $recebendo = $this->request->getPost()->toArray();

        if ($recebendo['authLogin'] != 'SGERPs') {
            return $this->getResponse()->setContent('Error: Autenticação Inválida');
        }
        if ($recebendo['authSenha'] != 'PREGS@2017') {
            return $this->getResponse()->setContent('Error: Autenticação Inválida');
        }

        $recebendo['usuarios'] = explode("|", $recebendo['usuarios']);
        $em = $GLOBALS['entityManager'];

        if (!$recebendo['usuarios']) {
            return $this->getResponse()->setContent('Error: Usuários inválidos');
            //echo 'Error: Usuários inválidos';die;
        } else if (!$recebendo['hash']) {
            return $this->getResponse()->setContent('Error: Hash inválida');
            //echo 'Error: Hash inválida';die;
        } else if (!$recebendo['documento']) {
            return $this->getResponse()->setContent('Error: Documento inválido');
            //echo 'Error: Documento inválido';die;
        } else if (!$recebendo['documentoTipo']) {
            return $this->getResponse()->setContent('Error: Documento tipo inválido');
            //echo 'Error: Documento inválido';die;
        }

        //Criando o Documento
        $documento = $em->getRepository('Usuario\Entity\Documento')->findOneBy(array('hashAuth' => $recebendo['hash']));

        //Verifica se já existe aquele documento salvo, se não existir, salva o doc.
        if (!$documento) {

            $documento = new \Usuario\Entity\Documento();

            $codigoVerificador = (new \DateTime())->format('YmdHis');
            $documentoTipo = $em->getRepository('Usuario\Entity\DocumentoTipo')->find($recebendo['documentoTipo']);

            $documento->__set('codVerificador', $codigoVerificador);
            $documento->__set('hashAuth', $recebendo['hash']);
            $documento->__set('documentoHtml', $recebendo['documento']);
            $documento->__set('documentoTipo', $documentoTipo);

            $em->persist($documento);
            $em->flush();

            $status = "true";
        } else {
            $codigoVerificador = $documento->codVerificador;
            $status = "false";
        }

        foreach ($recebendo['usuarios'] as $key => $cpf) {
            $login = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('cpf' => $cpf));

            if ($login) {

                $assinatura = $em->getRepository('Usuario\Entity\AssinaturasDocumento')->findOneBy(array('usuario' => $login->usuario, 'documento' => $documento));

                //Verifica se já existe aquela assinatura salva, se não existir, salva o ass.
                if (!$assinatura) {

                    $assinatura = new \Usuario\Entity\AssinaturasDocumento();

                    $assinatura->__set('usuario', $login->usuario);
                    $assinatura->__set('documento', $documento);

                    $em->persist($assinatura);
                    $em->flush();
                }
            } else {
                return $this->getResponse()->setContent('Error: Usuário de CPF ' . $cpf . ' inválido!');
            }
        }

        return $this->getResponse()->setContent($codigoVerificador . " | " . $status);
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



                $this->emailConfirmacaoCadastro($model);

                $this->flashMessenger()->addSuccessMessage('<h3>Cadastro realizado com sucesso.</h3>
                                                    <p>Acesse o seu email para validar seu cadastro.</p>
                        <p>Caso a mensagem não apareça na caixa de entrada, veirifque se a mesma se encontra no lixo eletroônico</p>
                ');

                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'cadastrar-login'));
            }
            //$this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar!');
        }

        return array(
            'form' => $form,
        );
    }

    public function validarLoginAction() {

        /// Verificar e valida se o usuario possui login
        $hash = null;
        if (!$this->params('hash') != null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'cadastrar'));
        }

        $hash = $this->params('hash');
        $cpf = base64_decode($hash);

        $em = $GLOBALS['entityManager'];

        $login = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('cpf' => $cpf));

        if (!$login != null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'cadastrar'));
        }
        if ($login->status->__get('idLoginStatus') != 3) {
            $this->flashMessenger()->addSuccessMessage('Você já estacadastro. Acesse o sistema digitando seu CPF e senha.');
            $this->redirect()->toRoute('application', array('controller' => 'auth', 'action' => 'index'));
        }

        $form = new \Application\Form\ConfirmarCadastroForm();

        $usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find(6);
        $form->get('usuarioTipo')->setValue($usuarioTipo->__get('idUsuarioTipo'));
        $form->get('enviar')->setValue('Confirmar');
        $form->get('login')->setValue($login->__get('idLogin'));


        return array(
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => 'Formulário de cadastro',
        );
    }

    public function cadastrarUsuarioAction() {

        $form = new \Application\Form\ConfirmarCadastroForm();
        $model = new \Usuario\Entity\Usuario();

        $em = $GLOBALS['entityManager'];

        $form->get('enviar')->setValue('Confirmar');

        $form->bind($model);

        if ($this->request->isPost()) {

            $form->setData($this->request->getPost());


            if ($form->isValid()) {
                // var_dump($this->request->getPost()["usuarioTipo"]);die;      
                $usuarioTipo = $em->getRepository('Usuario\Entity\UsuarioTipo')->find(6);
                $usuarioLogin = $em->getRepository('Usuario\Entity\Usuariologin')->find($this->request->getPost()["login"]);

                $model->__set('login', $usuarioLogin->__get('idLogin'));
                $model->__set('usuarioTipo', $usuarioTipo->__get('idUsuarioTipo'));

                //var_dump($model);die;
                $em->persist($model);

                if (!$objectManager->flush()) {
                    $login = $em->getRepository('Application\Entity\Login')->find($model->__get('login')->__get('idLogin'));

                    $this->setStatusLogin($login, 1);
                }

                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');

                return $this->redirect()->toRoute($this->route);
            }

            $this->flashMessenger()->addErrorMessage('Erro. Não foi possível cadastrar!');
        }
        return array(
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => 'Formulário de cadastro',
            'urlView' => '$this->back()',
        );
    }

    //Altera o status do login para ativo
    public function setStatusLogin($login, $status) {
        $em = $GLOBALS['entityManager'];

        $statusLogin = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find($status);

        // var_dump($login);die;

        $login->__set('status', $statusLogin);

        $em->persist($login);
        $em->flush();
    }

    private function getLogin($cpf) {
        $em = $GLOBALS['entityManager'];
        $login = $em->getRepository('Application\Entity\Login')->findOneBy(array('cpf' => $cpf));

        return $login;
    }

    public function logoutAction() {

        $auth = new AuthenticationService;
        $auth->setStorage(new Session('login'));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('home');
    }

    public function lembrarAcessoAction() {
        $form = new \Application\Form\LembrarAcessoForm();

        if ($this->request->isPost()) {

            $em = $GLOBALS['entityManager'];

            $login = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('email' => $this->request->getPost()->email));

            //Entra no if se o email estiver em branco ou não existir na base
            if (!$login) {
                $this->flashMessenger()
                        ->addErrorMessage('Email não encontrado! Faça o <a href="' . $this->url()->fromRoute('application/default', array('controller' => 'auth', 'action' => 'cadastrar-login')) . '">cadastro</a>.');
                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'lembrar-acesso'));
            }

            /// Verifica o status do login
            if ($login->status->idLoginStatus == 3) {
                // O usuario cadastrou o login, mas não confirmou o email e está querendo reemitir a senha
                // reenviou o email novamente para o usuario
                $this->enviaEmail($login, 1);


                $this->flashMessenger()
                        ->addSuccessMessage('Foi enviado um novo email de confirmação para você <p>Acesse o seu email.</p>
                        <p>Caso a mensagem não apareça na caixa de entrada, verifique se a mesma se encontra no lixo eletrônico</p>');
                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'lembrar-acesso'));
            } elseif ($login->status->idLoginStatus == 4) {

                $this->migracaoUaiteAntigo($login);
                $chave = $login->idLogin . '|' . $login->chave;
                $hash = base64_encode($chave);

                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'alterar-acesso', 'hash' => $hash));
            } elseif ($login->status->idLoginStatus == 5 ||
                    $login->status->idLoginStatus == 6 ||
                    $login->status->idLoginStatus == 7) {
                $chave = $login->idLogin . '|' . $login->chave;
                $hash = base64_encode($chave);

                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'alterar-acesso', 'hash' => $hash));
            }


            $chave = $login->email . date('YmdHis');
            $login->__set('chave', md5($chave));
            $status = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find(7);
            $login->__set('status', $status);

            $em->persist($login);

            if (!$em->flush()) {
                $this->enviaEmail($login, 2);
                $this->flashMessenger()->addSuccessMessage('Email enviado com sucesso! <p>Acesse o seu email.</p>
                        <p>Caso a mensagem não apareça na caixa de entrada, verifique se a mesma se encontra no lixo eletrônico</p>');

                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'lembrar-acesso'));
            } else {
                $this->flashMessenger()
                        ->addErrorMessage('Ocorreu um erro! Caso persista , envie uma mensagem no <a href="' . $this->url()->fromRoute('application/default', array('controller' => 'auth', 'action' => 'lembrar-acesso')) . '"> Fale conoco</a>');
                return $this->redirect()->toRoute('application/default', array('controller' => 'auth', 'action' => 'lembrar-acesso'));
            }
        }

        return array(
            'form' => $form
        );
    }

    public function alterarAcessoAction() {

        /// Verificar e valida p hash
        $hash = null;
        if (!$this->params('hash') != null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index'));
        }

        $hash = base64_decode($this->params('hash'));
        $chaveHash = explode('|', $hash);

        $idLogin = $chaveHash[0];
        $chave = $chaveHash[1];

        $em = $GLOBALS['entityManager'];

        $login = $em->getRepository('Usuario\Entity\UsuarioLogin')->findOneBy(array('idLogin' => $idLogin));

        if ($login == null) {
            return $this->redirect()->toRoute('application', array('controller' => 'index', 'action' => 'cadastrar'));
        }



        if (!($login->status->idLoginStatus == 5 || $login->status->idLoginStatus == 6 || $login->status->idLoginStatus == 7)) {
            return $this->redirect()->toRoute('application', array('controller' => 'index'));
        }

        $form = new \Application\Form\AlterarSenhaForm();

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $status = $em->getRepository('Usuario\Entity\UsuarioLoginStatus')->find(1);
                $login->__set('status', $status);
                $bcrypt = new \Zend\Crypt\Password\Bcrypt();
                $login->__set('senha', $bcrypt->create($this->request->getPost()['senha']));

                $login->__set('chave', null);
                $em->persist($login);

                if (!$em->flush()) {
                    //Criando o armazem para gravar sessão da autenticação
                    $sessionStorage = new Session("login");
                    $auth = new AuthenticationService;
                    $auth->setStorage($sessionStorage);

                    $authAdpter = $this->getServiceLocator()->get('Application\Auth\DoctrineAdpter');
                    $authAdpter->setCpf($login->cpf);
                    $authAdpter->setSenha($this->request->getPost()['senha']);

                    $result = $auth->authenticate($authAdpter);

                    //var_dump($result->isValid());die;

                    $loginAuth = $auth->getIdentity();

                    $loginAuth = $loginAuth['login'];
                    $sessionStorage->write($loginAuth, null);
                    return $this->redirect()->toRoute('usuario/default', array('controller' => 'usuario', 'action' => 'edit', 'key' => $login->idLogin));
                } else {
                    return $this->redirect()->toRoute('home');
                }
            }
        }


        return array(
            'form' => $form,
            'urlAction' => $urlAction,
            'title' => 'Formulário de cadastro',
            'hash' => $this->params('hash')
        );
    }

    private function formtDate($date) {
        if (strpbrk($date, '/')) {

            $dados = explode('/', $date);

            $data = $dados[2] . "-" . $dados[1] . "-" . $dados[0];

            return $data;
        } else {
            return $date;
        }
    }

    ///// Retorna usuario autenticado
    protected $authService;

    public function getAuthService() {

        return $this->authService;
    }

    public function usuarioAutenticado() {
        $sessionStorage = new Session('login');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            $em = $GLOBALS['entityManager'];
            $usuario = $em->getRepository('Usuario\Entity\Usuario')->findOneBy(array('login' => $this->getAuthService()->getIdentity()->idLogin));

            return array(
                'nome' => $this->getAuthService()->getIdentity()->nome,
                'idLogin' => $this->getAuthService()->getIdentity()->idLogin,
                'usuario' => $usuario
            );
        } else {
            return false;
        }
    }

    public function wsArquivosEmMassaAction() {

        $recebendo = $this->request->getPost()->toArray();

        if ($recebendo['1'] != 'SGERPs') {
            return $this->getResponse()->setContent('Error: Autenticação Inválida');
        }
        if ($recebendo['2'] != 'PREGS@2017') {
            return $this->getResponse()->setContent('Error: Autenticação Inválida');
        }

        if (!($recebendo['inicio'])) {
            return $this->getResponse()->setContent('Error: Data Inválida');
        }
        if (!$recebendo['fim']) {
            return $this->getResponse()->setContent('Error: Data Inválida');
        }
        
        $em = $GLOBALS['entityManager'];
        
        $sql = $em->createQueryBuilder();
        $sql->select('d')
                ->from('Usuario\Entity\Documento', 'd')
                ->innerJoin('d.documentoTipo', 'dt');
        
        /*$sql->andWhere('d.dataInsercao between :dataInicio and :dataFim');
        $sql->setParameter('dataInicio', $recebendo['inicio']);
        $sql->setParameter('dataFim', $recebendo['fim']);*/
        
        $sql->andWhere("d.documentoHtml like '%".$recebendo['inicio']." a ".$recebendo['fim']."%' ");
        
        $sql->andWhere('dt.idDocumentoTipo = 1');
        
        $documentos = $sql->getQuery()->getResult();
        
        foreach($documentos as $key =>$documento){
            $assinaturas[$key] = $em->getRepository('Usuario\Entity\AssinaturasDocumento')->findBy(array('documento' => $documento->idDocumento));
        }
        
        if(!$documentos){
            echo 'Não foram encontrados documentos neste período!';die;
        }
        
        return array(
            'documentos' => $documentos,
            'assinaturas' => $assinaturas,
        );
        
    }

}
