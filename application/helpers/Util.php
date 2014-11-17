<?php

/**
 * Funções utilitárias gerais
 */
class Zend_Controller_Action_Helper_Util extends Zend_Controller_Action_Helper_Abstract {
	
	// ACTIONS UTILS
	
	/**
	 * Verifica se a String começa com o valor em questão
	 * 
	 * @param $string String fonte
	 * @param $search Valor em questão
	 * @return boolean
	 */
	function strStartsWith($string, $search) {
	    return (strncmp($string, $search, strlen($search)) == 0);
	}
	
	// VIEW UTILS
	
	/**
	 * Adiciona o name e o value da propriedade.
	 * 
	 * @param $obj Objeto que possui o método get da propriedade
	 * @param $nome 
	 * @return unknown_type
	 */
	function textParam($obj, $nome){
		$getNome = 'get'.ucfirst($nome);
		$value = isset($obj) ? $obj->$getNome() : ''; 
		return "name=\"$nome\" value=\"$value\"";
	}
	
	/**
	 * Adiciona o name e o value da propriedade data.
	 * 
	 * @param $obj Objeto que possui o método get da propriedade
	 * @param $nome 
	 * @param $formato formato para data
	 * @return unknown_type
	 */
	function dateFormatParam($obj, $nome, $formato){
		$getNome = 'get'.ucfirst($nome);
		$value = $obj && $obj->$getNome() && $obj->$getNome() !== '' ? $this->formataData($formato, $obj->$getNome()) : ''; 
		return "name=\"$nome\" value=\"$value\"";
	}
	
	/**
	 * Adiciona o name e o value da propriedade, se for nulo, adiciona
	 * a datetime.
	 * 
	 * @param $obj Objeto que possui o método get da propriedade
	 * @param $nome 
	 * @return unknown_type
	 */
	function dateParam($obj, $nome){
		$getNome = 'get'.ucfirst($nome);
		$value = isset($obj) && $obj->$getNome() != null ? $obj->$getNome() : $this->getFullDate(); 
		return "name=\"$nome\" value=\"$value\"";
	}
	
	/**
	 * Verifica se o valor selecionado na entidade é igual
	 * ao valor da opção.
	 * 
	 * @param $entityValue Valor selecionado na entidade
	 * @param $optionValue Valor da opção corrente
	 * @return string
	 */
	function selectSelected($entityValue, $optionValue){
		return $entityValue == $optionValue ? 'selected="selected"' : '';
	}
	
	/**
	 * Verifica se o valor selecionado na entidade é igual
	 * ao valor da opção, verifica níveis em cascata.
	 * 
	 * @param $entityValue Valor selecionado na entidade
	 * @param $entityProperties Propriedades da entidade
	 * @param $optionValue Valor da opção corrente
	 * @param $optionProperties Propriedades da Opção
	 * @return string
	 */
	function selectSelected2($entityValue, $entityProperties, $optionValue, $optionProperties){
		if(!isset($entityValue) || !isset($optionValue)){
			return '';
		}
		
		foreach($entityProperties as $property){
			$getProperty = 'get'.$property;
			if(($entityValue = $entityValue->$getProperty()) == null){
				return "";
			}
		}
	
		foreach($optionProperties as $property){
			$getProperty = 'get'.$property;
			if(($optionValue = $optionValue->$getProperty()) == null){
				return "";
			}
		}
		return $entityValue === $optionValue ? 'selected="selected"' : '';
	}
	
	/**
	 * Método que obtem os valores do jquery uploadify e 
	 * grava o arquivo no servidor.
	 * 
	 * @return string
	 */
	function uploadify(){
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

			$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			$fileTypes  = str_replace(';','|',$fileTypes);
			$typesArray = split('\|',$fileTypes);
			$fileParts  = pathinfo($_FILES['Filedata']['name']);

			if (in_array($fileParts['extension'],$typesArray)) {
				// mkdir(str_replace('//','/',$targetPath), 0755, true);
				move_uploaded_file($tempFile,$targetFile);
				echo "1";
			} else {
				echo 'Invalid file type.';
			}
		}
	}
	
	/**
	 * Função que retorna o tempo em milisegundo.
	 * 
	 * @return string
	 */
	function currentTimeMillis(){
		list($usec, $sec) = explode(" ", microtime());
	    $time = ((float)$usec + (float)$sec);
	    $time  = str_replace(array('.'), '', $time);
	    $time = str_pad($time, 12 , "0");
	    return $time;
	}
	
	/**
	 * Transforma um Array valorado em um Array da classe tipada com o valor no atributo passado por parâmetro
	 * 
	 * @param $array array ponto de partida 
	 * @param $class tipo dos elementos do array
	 * @param $setAtt metodo set do objeto para que receberá os valores.
	 * @param $defaultOptions valores de atributos padrão para objetos do array
	 * @return array
	 */
	public function arrayToClassArray($array, $class, $setAtt, array $defaultOptions=null){
		$newArray = array();
		if(!isset($array)){
			$array = array();
		}
		foreach ($array as $reg) {
			$obj = new $class();
			$obj->$setAtt($reg);
			if(isset($defaultOptions)){
				$obj->setOptions($defaultOptions);
			}
			$newArray[] = $obj;
		}
		return $newArray;
	}
	
	/**
	 * Chama a função setOptions de todos os objetos do array
	 * 
	 * @param $array array em questão
	 * @param $options valor a ser passado no método setOptions
	 * @return array
	 */
	public function arraySetOptions($array, $options){
		$newArray = array();
		if(!isset($array)){
			$array = array();
		}
		foreach ($array as $reg) {
			$reg->setOptions($options);
			$newArray[] = $reg;
		}
		return $newArray;
	}
	
	/**
	 * Obtém string com data no formato datetime mysql
	 * 
	 * @return date('Y-m-d H:i:s')
	 */
	public function getFullDate(){
		return date('Y-m-d H:i:s');
	}
	
	/**
	 * Procura caractere após espaço e apaga string até 
	 * o próximo caractere.
	 * 
	 * @param $texto texto em questão
	 * @param $offset caractere a começar a pesquisa
	 * @return string cortada.
	 */
	public function limitaCaracteresPorEspaco($texto, $offset=null){
		
		if($offset == null){
			$offset = 0;
		}
		
		if(strlen($texto) <= $offset || strpos(ltrim($texto), ' ', $offset) == 0){
			return $texto;
		}
		
		return substr(ltrim($texto),0,strpos(ltrim($texto), ' ', $offset));
	}
	
	public function toDate($datetime){
		list ($ano, $mes, $dia, $hor, $min, $seg) = split('[-. .:]', $datetime);
		return mktime($hor, $min, $seg, $mes, $dia, $ano);
	}
	
	/**
	 * 
	 * Retorna o nome do dia da semana por extenso, quando passado um datetime
	 * 
	 * @param $dateTime Variável data
	 * @return string dia da semana por extenso, ex: Segunda
	 */
	public function getDiaDaSemanaPorExtenso($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		$i = date('N', $this->toDate($dateTime));
		if($i == 1){
			return 'Segunda';
		}elseif($i == 2){
			return 'Terça';
		}elseif($i == 3){
			return 'Quarta';
		}elseif($i == 4){
			return 'Quinta';
		}elseif($i == 5){
			return 'Sexta';
		}elseif($i == 6){
			return 'Sábado';
		}elseif($i == 7){
			return 'Domingo';
		}
	}
	
	/**
	 * 
	 * Retorna o nome do mes por extenso, quando passado um datetime
	 * 
	 * @param $dateTime Variável data
	 * @return string mes por extenso, ex: Janeiro
	 */
	public function getMesPorExtenso($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		$i = date('m', $this->toDate($dateTime));
		return $this->getMesPorExtensoPeloNumero($i);
	}
	
	/**
	 * 
	 * Retorna o nome do mes por extenso, quando passado um número
	 * 
	 * @param $mes Variável numérica
	 * @return string mes por extenso, ex: Janeiro
	 */
	public function getMesPorExtensoPeloNumero($mes=null){
		if($mes < 1 || $mes > 12 ){
			return "Mês Inválido";
		}
		if($mes == 1){
			return 'Janeiro';
		}elseif($mes == 2){
			return 'Fevereiro';
		}elseif($mes == 3){
			return 'Março';
		}elseif($mes == 4){
			return 'Abril';
		}elseif($mes == 5){
			return 'Maio';
		}elseif($mes == 6){
			return 'Junho';
		}elseif($mes == 7){
			return 'Julho';
		}elseif($mes == 8){
			return 'Agosto';
		}elseif($mes == 9){
			return 'Setembro';
		}elseif($mes == 10){
			return 'Outubro';
		}elseif($mes == 11){
			return 'Novembro';
		}elseif($mes == 12){
			return 'Dezembro';
		}
	}
	
	/**
	 * 
	 * Retorna o nome do dia da semana por extenso (em 3 caracteres), quando passado um datetime
	 * 
	 * @param $dateTime Variável data
	 * @return string dia da semana por extenso, ex: Seg
	 */
	public function getDiaDaSemanaPorExtenso3Carc($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return substr($this->getDiaDaSemanaPorExtenso($dateTime), 0, 3); 
	}
		
	/**
	 * 
	 * Retorna o mes por extenso (em 3 caracteres), quando passado um datetime
	 * 
	 * @param $dateTime Variável data
	 * @return string dia da semana por extenso, ex: Seg
	 */
	public function getMesPorExtenso3Carc($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return substr($this->getMesPorExtenso($dateTime), 0, 3); 
	}
		
	/**
	 * 
	 * Retorna a data no formato yy
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato yy
	 */
	public function formataDataYY($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('y', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato yyyy
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato yyyy
	 */
	public function formataDataYYYY($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('Y', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato dd
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato dd
	 */
	public function formataDataDD($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('d', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato dd/mm
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato dd/mm
	 */
	public function formataDataDDMM($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('d/m', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato dd/mm/yy
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato dd/mm/yy
	 */
	public function formataDataDDMMYY($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('d/m/y', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato mm/yy
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato mm/yy
	 */
	public function formataDataMMYY($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('m/y', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a data no formato mm
	 * 
	 * @param $dateTime Variável data
	 * @return string data no formato mm
	 */
	public function formataDataMM($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('m', $this->toDate($dateTime));
	}
		
	/**
	 * 
	 * Retorna a hora no formato 99h99
	 * 
	 * @param $dateTime Variável data
	 * @return string hora no formato 99h99
	 */
	public function formataHora99h99($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		$out = date('H\hi', $this->toDate($dateTime));
		return $out == '00h00' ? '' : $out;
	}

	/**
	 * 
	 * Retorna a hora no formato 99:99
	 * 
	 * @param $dateTime Variável data
	 * @return string hora no formato 99:99
	 */
	public function formataHoraHHMM($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		$out = date('H:i', $this->toDate($dateTime));
		return $out == '00:00' ? '' : $out;
	}
	
	/**
	 * 
	 * Retorna a hora no formato 201001260905 -> 26/01/2010 09:05
	 * 
	 * @param $dateTime Variável data
	 * @return string hora no formato 201001260905 -> 26/01/2010 09:05
	 */
	public function formataHoraYYYYMMAADDHHMM($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('YmdHi', $this->toDate($dateTime));
	}
	
	public function formataHoraRss($dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date('D, d M Y H:i:s O', $this->toDate($dateTime));
	}
	
	public function formataData($formato, $dateTime=null){
		if($dateTime == null){
			$dateTime = $this->getFullDate();
		}
		return date($formato, $this->toDate($dateTime));
	}
	
	public function adicionarEstiloPalavra($texto, $palavra, $estilo){
		return str_ireplace($palavra, "<span style='$estilo'>$palavra</span>", $texto);
	}
	
	public function contruirCodigosIn($ids){
		$out = '';
		foreach($ids as $id){
			$out .= "$id ,";
		}
		return substr($out,0,  -2);
	}
	
	function enviaEmail($remetente, $destinatario, $titulo, $email){

		$headers = "From: ".$remetente."\nContent-type: text/html; charset=utf-8";
		
		return mail($destinatario, $titulo, $email, $headers);
	}
	
    function utf8_strtolower($string) {
        return mb_strtolower($string, 'utf8');
    }

    function contruirResenhaNoticia($id){
    	$id = (int) $id;
    	$noticia = new Default_Model_Noticia(array('id' => $id));
    	$texto = $noticia->findFirstByExample()->getTitulo();
		return "$id-".$this->utf8_strtolower($this->normalize($texto)); 
    }
    
    function contruirResenhaVideo($id){
    	$id = (int) $id;
    	$video = new Default_Model_Video(array('id' => $id));
    	$texto = $video->findFirstByExample()->getTitulo();
		return "$id-".$this->utf8_strtolower($this->normalize($texto)); 
    }
    
    function contruirResenhaLink($link){
    	if($this->strStartsWith($link, '/noticia/')){
    		return '/noticia/' . $this->contruirResenhaNoticia(str_ireplace('/noticia/', '', $link)). '/';
    	}else if($this->strStartsWith($link, '/tv/')){
    		return '/tv/' . $this->contruirResenhaVideo(str_ireplace('/tv/', '', $link)). '/';
    	}
    	return $link;
    }
    
    function emptyToValue($var, $value){
    	return !empty($var) ? $var : $value;
    }
    
	function ucwords($str){
    	return ucwords($this->utf8_strtolower($str));
    }
    
    function isData($dataVerificar){
    	if(strlen($dataVerificar) != 10 || strlen($dataVerificar) != 19){
    		return false;
    	}
    	list($d, $m, $a, $h, $m, $s) = split( '[: /]', $dataaformatar);
    	if(!$d || !$m || !$a){
    		return false;
    	}else{
    		return "$a-$m-$d $h:$m:$s";
    	}
    }
    
    function validaData($dia, $mes, $ano){
    	if(!$dia || !$mes || !$ano){
    		return false;
    	}
    	if (($ano > 1900) && ($ano < 2100)) {
    		switch ($mes) {
    			case 1: case 3: case 5: case 7: case 8: case 10: case 12:
    				if  ($dia <= 31) {
    					return true;
    				}
    				break;
    			case 4: case 6: case 9: case 11:
    				if  ($dia <= 30) {
    					return true;
    				}
    				break;
    			case 2:
    				/* Validando ano Bissexto / fevereiro / dia */
    				if (($ano % 4 == 0) || ($ano % 100 == 0) || ($ano % 400 == 0)) {
    					$bissexto = 1;
    				}
    				if (($bissexto == 1) && ($dia <= 29)) {
    					return true;
    				}
    				if (($bissexto != 1) && ($dia <= 28)) {
    					return true;
    				}
    		}
    	}
    	return false;
    }
    
    /**
     * Verifica se a data ja passou
     * 
     * @param $dataExpiracao date
     * @return unknown_type
     */
 	function verificaExpirou($dataExpiracao){
 		return $this->getFullDate() > $dataExpiracao;
 	}

 	function setVarApp($chave, $valor){
		$appVar	= new Default_Model_AppVars(array('chave' => $chave));
		$appVar = $appVar->findFirstByExample();
		if($appVar){
			$appVar->setValor($valor);
			$appVar->update();
		}else{
			$appVar	= new Default_Model_AppVars(array('chave' => $chave, 'valor' => $valor));
			$appVar->insert();
		}
 	}
 	
 	function getVarApp($chave){
 		$appVar	= new Default_Model_AppVars(array('chave' => $chave));
		$appVar = $appVar->findFirstByExample();
		return $appVar ? $appVar->getValor() : $appVar;
 	}
}