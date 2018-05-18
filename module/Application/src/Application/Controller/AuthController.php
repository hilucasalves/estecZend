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

    public function indexAction() {

        $form = new LoginForm();

        $resquest = $this->getRequest();

        $messages = '';

        if ($resquest->isPost()) {

            $form->setData($resquest->getPost());
            
            $validator = new \Zend\Validator\EmailAddress();
            
            if ($form->isValid() && $validator->isValid($form->getData()['email'])) {
                
                //Criando o armazem para gravar sessão da autenticação
                $sessionStorage = new Session("usuario");
                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage);
                
                $authAdpter = $this->getServiceLocator()->get('Application\Auth\DoctrineAdpter');
                $authAdpter->setEmail($form->getData()['email']);
                $authAdpter->setSenha($form->getData()['senha']);

                $result = $auth->authenticate($authAdpter);
                
                if ($result->isValid()) {
                    $login = $auth->getIdentity();
                    $login = $login['usuario'];
                    $sessionStorage->write($login, null);
                    $time = 7200;
                    $sessionManager = new \Zend\Session\SessionManager();
                    $sessionManager->rememberMe($time);
                    
                    return $this->redirect()->toRoute('turma', array('controller' => 'index'));
                } else {
                    $messages = "Email ou Senha ínválido(s).";
                }
            } else {
                $messages = "Email ou Senha incorreto(s).";
            }
        }



        return new ViewModel(array(
            'form' => $form,
            'messages' => $messages
        ));
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
        $sessionStorage = new Session('usuario');
        $this->authService = new AuthenticationService;
        $this->authService->setStorage($sessionStorage);

        if ($this->getAuthService()->hasIdentity()) {
            $em = $GLOBALS['entityManager'];
            $usuario = $em->getRepository('Application\Entity\Usuario')->findOneBy(array('email' => $this->getAuthService()->getIdentity()->email));

            return array(
                'usuario' => $usuario
            );
        } else {
            return false;
        }
    }

}
