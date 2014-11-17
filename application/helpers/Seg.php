<?php

/**
 * Helper da action Admin, apoia as funções de segurança
 */
class Zend_Controller_Action_Helper_Seg extends Zend_Controller_Action_Helper_Abstract {
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Action/Helper/Zend_Controller_Action_Helper_Abstract#init()
	 */
	public function init(){
	}
	
	/**
	 * @var Zend_Controller_Action_Helper_Util
	 */
	var $_util;
	
	/**
	 * Getter da propriedade Util
	 * @return Zend_Controller_Action_Helper_Util
	 */
	public function getUtil(){
		if(!isset($this->_util)){
			$this->_util = $this->getActionController()->getHelper('Util');
		}
		return $this->_util;
	}
	
	/**
	 * @var Default_Model_SegGrupo
	 */
	var $_admin;
	
	/**
	 * Getter da propriedade Admin
	 * @return Default_Model_SegGrupo
	 */
	public function getAdmin(){
		if(!isset($this->_admin)){
			$this->_admin = new Default_Model_SegGrupo(array('nome' => 'admin'));
			$this->_admin = $this->_admin->findFirstByExample();
		}
		return $this->_util;
	}
	
	/**
	 * 
	 * Verifica se $strOrObj é string e transforma em $classObj
	 * 
	 * @param $usuario string ou $classObj
	 * @return $classObj
	 */	
	public function strToSegObj($strOrObj, $classObj){
		if(!($strOrObj instanceof $classObj)){
			$strOrObj = new $classObj(array('nome' => $strOrObj));
			$strOrObj = $strOrObj->findFirstByExample();
		}
		return $strOrObj;
	}
	
	/**
	 * 
	 * Verifica se o grupo é string e transforma em Default_Model_SegGrupo
	 * 
	 * @param $grupo string ou Default_Model_SegGrupo
	 * @return Default_Model_SegGrupo
	 */	
	public function strToSegGrupo($grupo){
		return $this->strToSegObj($grupo, Default_Model_SegGrupo);
	}

	/**
	 * 
	 * Verifica se o grupo é string e transforma em Default_Model_SegFuncao
	 * 
	 * @param $funcao string ou Default_Model_SegFuncao
	 * @return Default_Model_SegFuncao
	 */	
	public function strToSegFuncao($funcao){
		return $this->strToSegObj($funcao, Default_Model_SegFuncao);
	}

	/**
	 * 
	 * Verifica se o grupo é string e transforma em Default_Model_SegUsuario
	 * 
	 * @param $usuario string ou Default_Model_SegUsuario
	 * @return Default_Model_SegUsuario
	 */	
	public function strToSegUsuario($usuario){
		return $this->strToSegObj($usuario, Default_Model_SegUsuario);
	}
	
	/**
	 * Verifica se usuário pertence ao grupo
	 * 
	 * @param Default_Model_SegUsuario $usuario
	 * @param $grupo string ou Default_Model_SegGrupo
	 * @return boolean pertence?
	 */
	public function hasGrupo(Default_Model_SegUsuario $usuario, $grupo){
		// é administrador ?
		$grupoUsuario = new Default_Model_SegGrupoUsuario();
		$grupoUsuario->setSegGrupo($this->getAdmin())
		             ->setSegUsuario($usuario);
		if($grupoUsuario->findFirstByExample() != null){
			return true;
		}
		
		// garante que variável é grupo
		$grupo = $this->strToSegGrupo($grupo);
		
		// verifica se possui grupo
		$grupoUsuario = new Default_Model_SegGrupoUsuario();
		$grupoUsuario->setSegGrupo($grupo)
		             ->setSegUsuario($usuario);
		return ($grupoUsuario->findFirstByExample() != null);
	}
	
	/**
	 * Verifica se usuário possui a função em questão associada a um de seus grupos
	 * 
	 * @param Default_Model_SegUsuario $usuario
	 * @param $funcao string ou Default_Model_SegFuncao
	 * @param $moduloUrl string 
	 * @return boolean
	 */
	public function hasFuncao(Default_Model_SegUsuario $usuario, $funcao, $moduloUrl){
		
		// verifica se é administrador
		if($this->hasGrupo($usuario, 'admin')){
			return true;
		}
		
		// verifica se é uma função do grupo geral
		$grupo = $this->strToSegGrupo('geral');
		
		if($this->grupoHasFuncao($grupo, $funcao)){
			return true;
		}
		
		if($funcao instanceof Default_Model_SegFuncao){
			$funcao = $funcao->getNome();
		}

		$funcaoFullName = $funcao;
		
		$funcao = str_ireplace('list', '', $funcao);
		$funcao = str_ireplace('delete', '', $funcao);
		$funcao = str_ireplace('insertreg', '', $funcao);
		$funcao = str_ireplace('insert', '', $funcao);
		$funcao = str_ireplace('updatereg', '', $funcao);
		$funcao = str_ireplace('update', '', $funcao);
		$funcao = str_ireplace('responderreg', '', $funcao);
		$funcao = str_ireplace('responder', '', $funcao);
		$funcao = str_ireplace('save', '', $funcao);
		
		$funcao = str_ireplace('list', '', $funcao);
		$funcao = str_ireplace('delete', '', $funcao);
		$funcao = str_ireplace('insertreg', '', $funcao);
		$funcao = str_ireplace('insert', '', $funcao);
		$funcao = str_ireplace('updatereg', '', $funcao);
		$funcao = str_ireplace('update', '', $funcao);
		$funcao = str_ireplace('responderreg', '', $funcao);
		$funcao = str_ireplace('responder', '', $funcao);
		$funcao = str_ireplace('save', '', $funcao);
		
		$funcao = $moduloUrl.$funcao;
		$funcaoFullName = $moduloUrl.$funcaoFullName;
		
		// verifica se o usuário possui algum grupo associado a função 
		// específica
		$grupoFuncao = new Default_Model_SegGrupoFuncao();
		
		$select = $grupoFuncao->select()
			   ->setIntegrityCheck(false)
			   ->from(array('gf' => 'tb_seg_grupo_funcao'))
		       ->join(array('gu' => 'tb_seg_grupo_usuario'), 'gu.cd_seg_grupo = gf.cd_seg_grupo')
		       ->join(array('f' => 'tb_seg_funcao'), 'gf.cd_seg_funcao = f.id')
		       ->where('gu.cd_seg_usuario = ?', $usuario->getId())
		       ->where("(f.nome = '$funcaoFullName' or f.nome = '$funcao')")
		       ->limit(1);
		       
		// verificando se encontra
		return count($grupoFuncao->fetchList($select)) > 0;
	}
	
	public function hasModulo(Default_Model_SegUsuario $usuario, $modulo){
		
		// verifica se é administrador
		if($this->hasGrupo($usuario, 'admin')){
			return true;
		}
		
		$grupoUsuario = new Default_Model_SegGrupoUsuario();

		$select = $grupoUsuario->select()
			   ->setIntegrityCheck(false)
			   ->from(array('gu' => 'tb_seg_grupo_usuario'))
		       ->join(array('gf' => 'tb_seg_grupo_funcao'), 'gu.cd_seg_grupo = gf.cd_seg_grupo')
		       ->join(array('f' => 'tb_seg_funcao'), 'gf.cd_seg_funcao = f.id')
		       ->where('gu.cd_seg_usuario = ?', $usuario->getId())
		       ->where('f.nome like ?', "$modulo%")
		       ->limit(1);
		       
		return count($grupoUsuario->fetchList($select)) > 0;
	}
	
	/**
	 * Verifica se a função pertence ao grupo
	 * 
	 * @param Default_Model_SegGrupo $grupo
	 * @param $funcao string ou Default_Model_SegFuncao
	 * @return unknown_type
	 */
	public function grupoHasFuncao($grupo, $funcao){
		
		$grupo = $this->strToSegGrupo($grupo);
		
		// verifica se é administrador
		if($grupo->getNome() === 'admin'){
			return true;
		}
		
		// verifica se possui a função
		$funcao = $this->strToSegFuncao($funcao);
		
		$grupoFuncao = new Default_Model_SegGrupoFuncao();
		$grupoFuncao->setSegFuncao($funcao)
		            ->setSegGrupo($grupo);
		return ($grupoFuncao->findFirstByExample() != null);
	}

	/**
	 * Cria um registro na tabela de auditoria, este método pode ser chamado sempre
	 * que uma página for acessada 
	 * 
	 * @param $usuario Default_Model_SegUsuario 
	 * @param $params array
	 */
	public function criaAudicao($usuario, array $params){
		$auditoria = new Default_Model_Auditoria();
		
		// Usuário em questão
		if($usuario != null && isset($usuario)){
			$auditoria->setUsr($usuario->getLogin());
		}else{
			$auditoria->setUsr("Usuário não logado");
		}
		
		// Parâmetros em questão
		$strParams = '';
		foreach ($params as $k => $v) {
			if($k === 'senha'){
				$v=md5($v);
			}
			$strParams .= "$k=>$v;";
		}
		$auditoria->setParams($strParams);
		
		// Obtendo url
		/*** check for https ***/
	    $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	    /*** return the full address ***/
	    $auditoria->setUrl($protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		
	    // obtendo ip
	    $auditoria->setIp($_SERVER['REMOTE_ADDR']);
	    
	    // registra data
	    $auditoria->setDtReg($this->getUtil()->getFullDate());
	    
	    // inserindo
	    $auditoria->insert();
		
	}
	
	/**
	 * 
	 * Retorna o nome completo do usuário, fazendo referência 
	 * ao modelo Default_Model_SegUsuario
	 * 
	 * @param $login login do usuário em questão
	 * @return string nome do usuário
	 */
	public function getNomeByLogin($login){
		$usuario = new Default_Model_SegUsuario(array('login' => $login));
		return $usuario->findFirstByExample()->getNome();
	}

}