<?php

/**
 *
 * @uses       Zend_Controller_Action
 * @subpackage Controller
 */
class EntregaController extends Zend_Controller_Action{

	/**
	 * @var Zend_Session_Namespace
	 */
	var $_session;

	/**
	 * @var Zend_Controller_Action_Helper_Seg
	 */
	var $_seg;

	/**
	 * @var Zend_Controller_Action_Helper_Form
	 */
	var $_form;

	/**
	 * @var Zend_Controller_Action_Helper_Util
	 */
	var $_util;

	/**
	 * Método inicial do controller, chamado sempre que uma requisição for solicitada ao controller.
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Zend_Controller_Action#init()
	 */
	public function init(){

		// Obtendo helper de segurança
		$this->_seg = $this->_helper->Seg;
		$this->view->seg = $this->_helper->Seg;

		// Obtendo helper de formulário
		$this->_form = $this->_helper->Form;
		$this->view->form = $this->_helper->Form;

		// Obtendo helper utilitário
		$this->_util = $this->_helper->Util;
		$this->view->util = $this->_helper->Util;
		
		//$this->view->charset="iso-8859-1";
		$this->view->charset="utf8";

		// construindo sessão
		$this->_session = new Zend_Session_Namespace('/entrega');
		// definindo tempo de sessão
		// $this->_session->setExpirationSeconds(10 * 60);

		// verifica se o login da sessão está ativa
		if(!isset($this->_session->usuario)){
			$this->login();
		}else{
			$this->carregaUsuario();
		}
	}

	public function login(){
		$login = $this->getRequest()->getParam('usuario');
		$senha = $this->getRequest()->getParam('senha');

		// primeiro acesso
		if(!$login){ $this->_forward("login"); return;}

		$usuario = new Default_Model_SegUsuario(array('login' => $login, 'senha' => md5($senha)));
		$usuario = $usuario->findFirstByExample();

		if(!$usuario){
			$this->view->erro = 'Usuário e senha incorretos.';
			$this->_forward("login");
			return;
		}
		$this->_session->usuario = $usuario;
		$this->carregaUsuario();
	}

	public function carregaUsuario(){
		$this->view->sessionUsuario = $this->_session->usuario;
		$this->view->saudacao = date('H') < 12 ? "Bom dia" : (date('H') < 19 ? "Boa tarde" : "Boa noite");
		$this->view->saudacao .= "! Seja bem vindo, " . $this->view->sessionUsuario->getNome();
	}

	public function homeAction(){
		$this->view->infoTela = "A Paz Esteja Contigo!";

		// remove o render
		$this->_helper->viewRenderer->setNoRender(true);
	}

	public function indexAction(){
		$this->_forward('home');
	}

	public function loginAction(){
		// configura Layout branco
		$this->_helper->layout->setLayout('blank');
	}

	public function logoutAction(){
		foreach ($this->_session as $i => $val) {
			unset($this->_session->$i);
		}
		$this->_redirect('entrega/');
	}

	public function cadastroAction(){
		$this->view->infoTela = "Cadastro de Usuários";

		$paroquias = new Default_Model_Paroquia();
		$this->view->paroquias = $paroquias = $paroquias->fetchAll();
		
		if(!$this->view->acao){
			$this->view->acao = 'cadastrar';
		}
	}
	
	public function excluirAction(){
		$qual = $this->_getParam('qual');
		if(!$qual){
			$this->_forward('consulta');
			return;
		}
		
		$usuario = new Default_Model_Usuario(array('id' => $qual));
		$this->view->obj = $usuario = $this->view->obj ? $this->view->obj : $usuario->findFirstByExample();
		
		if($usuario->getParoquia()->getId() != $this->_session->usuario->getParoquia()->getId()){
			$paroquiaUsuario = $usuario->getParoquia()->getNome();
			$paroquiaSegUsuario = $this->_session->usuario->getParoquia()->getNome();
			$this->view->erro = "Desculpe, mas só é permitido excluir usuários pertencentes a paróquia \"$paroquiaSegUsuario\". Este usuário pertence a paróquia \"$paroquiaUsuario\".";
			$this->_forward('consulta');
			return;
		}
		$usuario->deleteAllEntrega();
		$usuario->delete();
		
		$this->view->msg = "Usuário excluído com sucesso.";
		$this->_forward('consulta');
	}
	
	public function editaAction(){
		$qual = $this->_getParam('qual');
		if(!$qual){
			$this->_forward('cadastro');
			return;
		}
		
		$this->view->isUpdate = true;
		
		$this->view->acao = 'atualizar';
		
		$usuario = new Default_Model_Usuario(array('id' => $qual));
		$this->view->obj = $usuario = $this->view->obj ? $this->view->obj : $usuario->findFirstByExample();
		
		if($usuario->getParoquia()->getId() != $this->_session->usuario->getParoquia()->getId()){
			$paroquiaUsuario = $usuario->getParoquia()->getNome();
			$paroquiaSegUsuario = $this->_session->usuario->getParoquia()->getNome();
			$this->view->erro = "Desculpe, mas só é permitido alterar usuários pertencentes a paróquia \"$paroquiaSegUsuario\". Este usuário pertence a paróquia \"$paroquiaUsuario\".";
			$this->_forward('consulta');
			return;
		}
		
		$this->_forward('cadastro');
	}

	public function cadastrarAction(){

		$this->view->erro = $this->_form->validateParamNull($this->getRequest(), array('rg', 'cpf', 'telefone', 'datanasc', 'endereco', 'certnasc'));
		$this->view->obj = $this->_form->setAtts($this->getRequest(), Default_Model_Usuario, array('nome', 'nomemae', 'nomepai', 'endereco'));
		
		$this->validateSaveUsuario();
		
		if(!isset($this->view->erro)){
			$this->view->obj->insert();
			$this->view->msg = 'Usuário cadastrado com sucesso';
			$this->_forward('consulta');
		}else{
			$this->_forward('cadastro');
		}
	}

	public function atualizarAction(){

		$this->view->erro = $this->_form->validateParamNull($this->getRequest(), array('rg', 'cpf', 'telefone', 'datanasc', 'endereco', 'certnasc'));
		$this->view->obj = $this->_form->setAtts($this->getRequest(), Default_Model_Usuario, array('nome', 'nomemae', 'nomepai', 'endereco'));
		
		$this->validateSaveUsuario($this->view->obj->getId());
		
		if(!isset($this->view->erro)){
			$this->view->obj->update();
			$this->view->msg = 'Usuário atualizado com sucesso';
			$this->_forward('consulta');
		}else{
			$this->_forward('edita', null, null, array('qual' => $this->view->obj->getId()));
		}
	}
	
	public function validateSaveUsuario($id=null){
		$where = $id ? array("id <> ?" => $id) : null;
		if(!$this->view->erro){
			if($this->view->obj->getCpf()){
				$usuario = new Default_Model_Usuario(array('cpf' => $this->view->obj->getCpf()));
				$usuario = $usuario->fetchListByExample($usuario, null, null, null, $where);
				if($usuario){
					$this->view->erro = 'Já existe outro usuário cadastrado com este CPF';
				}
			}
				
			if($this->view->obj->getRg()){
				$usuario = new Default_Model_Usuario(array('rg' => $this->view->obj->getRg()));
				$usuario = $usuario->fetchListByExample($usuario, null, null, null, $where);
				if(!$this->view->erro && $usuario){
					$this->view->erro = 'Já existe outro usuário cadastrado com este Rg';
				}
			}
				
			if($this->view->obj->getCertNasc()){
				$usuario = new Default_Model_Usuario(array('certnasc' => $this->view->obj->getCertNasc()));
				$usuario = $usuario->fetchListByExample($usuario, null, null, null, $where);
				if(!$this->view->erro && $usuario){
					$this->view->erro = 'Já existe outro usuário cadastrado com esta Certidão de Nascimento';
				}
			}
				
			$usuario = new Default_Model_Usuario();
			$usuario->setNome($this->view->obj->getNome())
					->setNomeMae($this->view->obj->getNomeMae());
			$usuario = $usuario->fetchListByExample($usuario, null, null, null, $where);
			if(!$this->view->erro && $usuario){
				$this->view->erro = 'Já existe outro ' . $this->view->obj->getNome() . ' com a mãe chamada ' . $this->view->obj->getNomeMae();
			}
			
			$usuario = new Default_Model_Usuario();
			$usuario->setNome($this->view->obj->getNome())
					->setNomePai($this->view->obj->getNomePai());
			$usuario = $usuario->fetchListByExample($usuario, null, null, null, $where);
			if(!$this->view->erro && $usuario){
				$this->view->erro = 'Já existe outro ' . $this->view->obj->getNome() . ' com o pai chamado ' . $this->view->obj->getNomePai();
			}
		}
	}

	public function consultaAction(){
		$this->view->infoTela = "Consulta de Usuários";
		
		$this->view->strWhere = $this->view->strWhere ? $this->view->strWhere : null;
		
		$usuarios = new Default_Model_Usuario();
		$this->view->usuarios = $usuarios = $usuarios->fetchList($this->view->strWhere);
		
	}
	
	public function pesquisarAction(){
		$this->view->query = $query = $this->_getParam('query');
		
		$this->view->strWhere = $strWhere = 
					"(SELECT nome FROM `tb_paroquia` a where a.id = cd_paroquia) like '%$query%' or
					 nome like '%$query%' or 
					 rg like '%$query%' or 
					 cpf like '%$query%' or 
					 telefone like '%$query%' or 
					 data_nasc like '%$query%' or
					 endereco like '%$query%' or
					 cert_nasc like '%$query%' or
					 nome_mae like '%$query%' or 
					 nome_pai like '%$query%'";
		
		$this->_forward('consulta');		
	}	

	public function entregarAction(){
		$qual = $this->_getParam('qual');
		if(!$qual){
			$this->_forward('home');
			return;
		}		
		
		$this->view->infoTela = "Controle de Entrega";

		$usuario = new Default_Model_Usuario();
		$this->view->usuario = $usuario = $usuario->find($qual);
		
		$this->view->entregas = $usuario->listEntrega(null, null, 'data_entrega desc');
	}
	
	public function entregaAction(){
		$qual = $this->_getParam('qual');
		if(!$qual){
			$this->_forward('home');
			return;
		}
		
		$usuario = new Default_Model_Usuario();
		$usuario->find($qual);
		/*if($usuario->getParoquia()->getId() != $this->_session->usuario->getParoquia()->getId()){
			$paroquiaUsuario = $usuario->getParoquia()->getNome();
			$paroquiaSegUsuario = $this->_session->usuario->getParoquia()->getNome();
			$this->view->erro = "Desculpe, você só pode efetivar entregas a pertencentes da paróquia \"$paroquiaSegUsuario\". Este usuário pertence a paróquia \"$paroquiaUsuario\".";
			$this->_forward('entregar');
			return;
		}*/
		
		$params = $this->getRequest()->getParams();
		$dataentrega = $params['dataentrega']; 
		
		if($dataentrega === ''){
			$this->view->erro = "Desculpe, mas é obrigatório informar a data de entrega";
			$this->_forward('entregar');
			return;
		}
		
		$entrega = new Default_Model_Entrega();
		$entrega->setDataEntrega($dataentrega)
				->setSegUsuario($this->_session->usuario)
				->setUsuario($usuario);
				
		$entrega->insert();

		$this->view->erro = "Sua entrega foi efetivada. O alimento pode ser entregue com segurança a este(a) abençoado. Que Deus lhe abençoe.";
		
		$this->_forward('entregar');
	}	
}