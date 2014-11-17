<?php

/**
 * Fun��es utilit�rias relacionadas a formul�rio
 */
class Zend_Controller_Action_Helper_Form extends Zend_Controller_Action_Helper_Abstract {
	
	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Controller/Action/Helper/Zend_Controller_Action_Helper_Abstract#init()
	 */
	public function init(){
	}
	
	/**
	 * @var Zend_Controller_Action_Helper_Seg
	 */
	var $_seg;
	
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
	 * Getter da propriedade Seg
	 * @return Zend_Controller_Action_Helper_Seg
	 */
	public function getSeg(){
		if(!isset($this->_set)){
			$this->_seg = $this->getActionController()->getHelper('Seg');
		}
		return $this->_seg;
	}
	
	/**
	 * Cria objeto da classe $class e associa seus atributos com par�metos obtidos $request com s mesmos nomes
	 * dos atributos das classes em letras min�sculas.
	 * @param $class tipo da classe do objeto de modelo relacionado.
	 * @param $request vari�vel de request, para obten��o dos par�metros.
	 * @param $ucs vari�veis de string q devem ser utlizado o m�todo ucwords do helper Util, para os casos 
	 * em que os usu�rios digitam tudo em caixa alta.
	 * @return objeto do tipo $class
	 */
	public function setAtts($request, $class, $ucs=null){
		$obj = new $class();
		$ucs = !$ucs ? array() : $ucs;
		foreach (get_class_methods($class) as $setAtt) {
			if($this->getUtil()->strStartsWith($setAtt, 'set')){
				if($setAtt !== 'setMapper' && $setAtt !== 'setPk' && $setAtt !== 'setOptions'){
					$param = substr($setAtt, 3, strlen($setAtt));
					$param = strtolower($param);
					$val = $request->getParam($param);
					$val = $val === "" || $val === "null" ? null : $val;
					if($val == null){
						unset($val);
					}
					if(isset($val)){
						$val = $val === 'on' ? 'S' : $val;
						$val = in_array($param, $ucs) ? $this->getUtil()->ucwords($val) : $val;
						$obj->$setAtt($val);
					}
//					echo $setAtt. '(' . $request->getParam($param) . ')';
//					echo '<br>';
//					echo $param;
//					echo '<br>';
				}
			}
		}
		return $obj;
	}
	
	/**
	 * Cria objeto da classe $class e associa seus atributos com par�metos obtidos $request com s mesmos nomes
	 * dos atributos das classes em letras min�sculas. Ap�s a cria��o, chama o m�todo insert() do objeto.
	 * @param $class tipo da classe do objeto de modelo relacionado
	 * @param $request vari�vel de request, para obten��o dos par�metros
	 * @return objeto do tipo $class
	 */
	public function insert($request, $class){
		$obj = $this->setAtts($request, $class);
		$obj->insert();
		return $obj;
	}
	
	/**
	 * Cria objeto da classe $class e associa seus atributos com par�metos obtidos $request com s mesmos nomes
	 * dos atributos das classes em letras min�sculas. Ap�s a cria��o, chama o m�todo update() do objeto.
	 * @param $class tipo da classe do objeto de modelo relacionado
	 * @param $request vari�vel de request, para obten��o dos par�metros
	 * @return objeto do tipo $class
	 */
	public function update($request, $class){
		$obj = $this->setAtts($request, $class);
		$obj->update();
		return $obj;
	}
	
	/**
	 * 
	 * Verifica se todos os campos foram preechidos.
	 * 
	 * @param $request requisi��o que armazena os par�metros
	 * @param $params Parametros que n�o ser�o verificados.
	 * @return mensagem de erro|null 
	 */
	public function validateParamNull(Zend_Controller_Request_Abstract $request, $nullParams = null){
		if($nullParams == null){
			$nullParams = array();
		}
		
		$params = $request->getParams();
		unset($params['controller']);
		unset($params['action']);
		unset($params['module']);
		
		foreach ($nullParams as $value) {
			unset($params[$value]);
		}  
		
		foreach ($params as $i => $value) {
			if($value === ""){
				return "O campo $i � obrigat�rio!";
			}
		}
		return null;
	}
}
