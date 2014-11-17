<?php

/**
  * Paroquia model
  *
  * Utiliza o padrão Data Mapper para persistir dados.
  * 
  * @uses       Default_Model_Mapper_ParoquiaMapper
  * @subpackage Model
  */
class Default_Model_Paroquia  {
	
	/**
	 * @var int
	 * Primay Key
	 */
	protected $_id;
	
	/**
	 * @var Default_Model_Mapper_ParoquiaMapper
	 */
	protected $_mapper;
	
	/**
	 * @var string
	 */
	protected $_nome;
	
	
	/**
	 * Constructor
	 * 
	 * @param  array|null $options 
	 * @return void
	 */
	public function __construct(array $options = null) {
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}
	
	/**
	 * Overloading: allow property access
	 * 
	 * @param  string $name 
	 * @param  mixed $value 
	 * @return void
	 */
	public function __set($name, $value) {
		$method = "set" . $name;
		if ("mapper" == $name || !method_exists($this, $method)) {
			throw new Exception("Invalid property specified");
		}
		$this->$method($value);
	}

	/**
	 * Overloading: allow property access
	 * 
	 * @param  string $name 
	 * @return mixed
	 */
	public function __get($name) {
		$method = "get" . $name;
		if ("mapper" == $name || !method_exists($this, $method)) {
			throw new Exception("Invalid property specified");
		}
		return $this->$method();
	}
	
	/**
	 * Set object state
	 * 
	 * @param  array $options 
	 * @return Default_Model_Paroquia
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = "set" . ucfirst($key);
			if (in_array($method, $methods)) {
			    $this->$method($value);
			}
		}
		return $this;
	}
    
    /**
	 * Set primary (Não possui variável como atributo)
	 * Código identificador da entidade Default_Model_Paroquia
	 * 
	 * @param int primary
	 * @return Default_Model_Paroquia
	 */
	public function setPk($pk){
		
		return $this->setId($pk);
		
	}
	
	/**
	 * Get primary (Não possui variável como atributo)
	 * Código identificador da entidade Default_Model_Paroquia
	 * Primary Key
	 * 
	 * @return null|int
	 */
	public function getPk(){
		
		return $this->getId();
		
	}
	
	/**
	 * Setter da propriedade id
	 * Primary Key
	 * 
	 * @param int $id
	 * @return Default_Model_Paroquia
	 */
	public function setId($id){	
		$this->_id = (int) $id;
		return $this;
	}
	
	/**
	 * Getter da propriedade id
	 * Primary Key
	 * 
	 * @return null|int
	 */
	public function getId() {
		return $this->_id;
	}
	
	/**
	 * Setter da propriedade nome
	 * 
	 * @param string $nome
	 * @return Default_Model_Paroquia
	 */
	public function setNome($nome){
		$this->_nome = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $nome));
		return $this;
	}
	
	/**
	 * Getter da propriedade nome
	 * 
	 * @return null|string
	 */
	public function getNome() {
		return $this->_nome;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param  mixed $mapper 
	 * @return Default_Model_Mapper_ParoquiaMapper
	 */
	public function setMapper($mapper) {
		$this->_mapper = $mapper;
		return $this;
	}
	
	/**
	 * Get data mapper
	 *
	 * Instancia Default_Model_Mapper_ParoquiaMapper apenas se ainda n�o foi instanciada (Lazy Load).
	 * 
	 * @return Default_Model_Mapper_ParoquiaMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper || !$this->_mapper instanceof Default_Model_Mapper_ParoquiaMapper) {
			$this->setMapper(new Default_Model_Mapper_ParoquiaMapper());
		}
		return $this->_mapper;
	}
		
	/**
	 * Lista instâncias Default_Model_Usuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @return array
	 */
	public function listUsuario($count=null, $offset=null, $order=null){
		$usuario = new Default_Model_Usuario();
		$usuario->setParoquia($this);
		return $usuario->fetchListByExample($usuario, $order, $count, $offset);
	}	
	
	/**
	 * Obtem o primeiro registro Default_Model_Usuario associado a 
	 * Default_Model_Paroquia
	 * 
	 * @return Default_Model_Usuario
	 */
	public function findFirstUsuario($offset=null, $order=null) {
		$aux = $this->listUsuario(1, $offset, $order);
		if($aux == null)
			return null;
		return $aux[0];
	}	
	
	/**
	 * Exclui instâncias Default_Model_Usuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_Usuario ou 
	 * apenas um objeto Default_Model_Usuario
	 * @return Default_Model_Paroquia
	 */
	public function deleteUsuario($entries){
		if($entries instanceof Default_Model_Usuario){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setParoquia($this);
			$entry->delete();
		}
		return $this;
	}
	
	/**
	 * Exclui instâncias Default_Model_Usuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @return Default_Model_Paroquia
	 */
	public function deleteAllUsuario(){
		$this->deleteUsuario($this->listUsuario());
		return $this;
	}
	
	/**
	 * Insere instâncias Default_Model_Usuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_Usuario ou 
	 * apenas um objeto Default_Model_Usuario
	 * @return Default_Model_Paroquia
	 */
	public function insertUsuario($entries){
		if($entries instanceof Default_Model_Usuario){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setParoquia($this);
			$entry->insert();
		}
		return $this;
	}
	
	/**
	 * Atualiza instâncias Default_Model_Usuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_Usuario ou 
	 * apenas um objeto Default_Model_Usuario
	 * @return Default_Model_Paroquia
	 */
	public function updateUsuario($entries){
		$this->deleteAllUsuario();
		$this->insertUsuario($entries);
		return $this;
	}	
	/**
	 * Lista instâncias Default_Model_SegUsuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @return array
	 */
	public function listSegUsuario($count=null, $offset=null, $order=null){
		$segUsuario = new Default_Model_SegUsuario();
		$segUsuario->setParoquia($this);
		return $segUsuario->fetchListByExample($segUsuario, $order, $count, $offset);
	}	
	
	/**
	 * Obtem o primeiro registro Default_Model_SegUsuario associado a 
	 * Default_Model_Paroquia
	 * 
	 * @return Default_Model_SegUsuario
	 */
	public function findFirstSegUsuario($offset=null, $order=null) {
		$aux = $this->listSegUsuario(1, $offset, $order);
		if($aux == null)
			return null;
		return $aux[0];
	}	
	
	/**
	 * Exclui instâncias Default_Model_SegUsuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_SegUsuario ou 
	 * apenas um objeto Default_Model_SegUsuario
	 * @return Default_Model_Paroquia
	 */
	public function deleteSegUsuario($entries){
		if($entries instanceof Default_Model_SegUsuario){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setParoquia($this);
			$entry->delete();
		}
		return $this;
	}
	
	/**
	 * Exclui instâncias Default_Model_SegUsuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @return Default_Model_Paroquia
	 */
	public function deleteAllSegUsuario(){
		$this->deleteSegUsuario($this->listSegUsuario());
		return $this;
	}
	
	/**
	 * Insere instâncias Default_Model_SegUsuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_SegUsuario ou 
	 * apenas um objeto Default_Model_SegUsuario
	 * @return Default_Model_Paroquia
	 */
	public function insertSegUsuario($entries){
		if($entries instanceof Default_Model_SegUsuario){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setParoquia($this);
			$entry->insert();
		}
		return $this;
	}
	
	/**
	 * Atualiza instâncias Default_Model_SegUsuario associadas a 
	 * Default_Model_Paroquia
	 * 
	 * @param $entries um array de objetos Default_Model_SegUsuario ou 
	 * apenas um objeto Default_Model_SegUsuario
	 * @return Default_Model_Paroquia
	 */
	public function updateSegUsuario($entries){
		$this->deleteAllSegUsuario();
		$this->insertSegUsuario($entries);
		return $this;
	}	
	/**
	 * Insere o registro corrente
	 * 
	 * @return void
	 */
	public function insert() {
		$this->getMapper()->insert($this);
	}
	
	/**
	 * Atualiza o registro corrente
	 * 
	 * @return void
	 */
	public function update() {
		$this->getMapper()->update($this);
	}
	
	/**
	 * Deleta o registro corrente
	 * @return void
	 */
	public function delete() {
		$this->getMapper()->delete($this);
	}
	
	/**
	 * Deleta um conjunto de registros de acordo 
	 * com a cláusula where
	 * 
	 * @param $where 
	 * @return void
	 */
	public function deleteWhere($where) {
		$this->getMapper()->deleteWhere($where);
	}

	/**
	 * Procura um registro
	 *
	 * Reinicia o estado da instância se encontrado pelo id
	 * 
	 * @param  int $id 
	 * @return Default_Model_Paroquia
	 */
	public function find( $id) {
		$this->getMapper()->find($id, $this);
		return $this;
	}

	/**
	 * Obtem o primeiro registro da tabela
	 * 
	 * @return Default_Model_Paroquia
	 */
	public function findFirst() {
		$aux = $this->fetchAllPg(1);
		if($aux == null)
			return null;
		return $aux[0];
	}

	/**
	 * Traz todos os registros
	 * 
	 * @return array
	 */
	public function fetchAll() {
		return $this->getMapper()->fetchAll();
		
	}
	
	/**
	 * Traz todos os registros, método utilizado para realizar paginação
	 * 
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @return array
	 */
	public function fetchAllPg($count=null, $offset=null) {
		return $this->getMapper()->fetchAllPg($count, $offset);
		
	}
	
	/**
	 * Traz todos os registros que satisfazem os parametros.
	 * 
	 * @param $example Objeto com parâmetros especificados, utilizado para busca
	 * @param $order Ordenação dos objetos, nome da coluna no banco
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @return array
	 */
	public function fetchList($where=null, $order=null, $count=null, $offset=null) {
		return $this->getMapper()->fetchList($where, $order, $count, $offset);
		
	}

	/**
	 * Traz todos os registros que satisfazem os parametros, leva em conta os atributos
	 * especificados no parametro $example
	 * 
	 * @param $example Objeto com parâmetros especificados, utilizado para busca
	 * @param $order Ordenação dos objetos, nome da coluna no banco
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado
	 * @param $additionalWhere parâmetros especificados, utilizado para busca, adicionais aos 
	 *                         especificados no objeto. Valores especificados neste parâmetro 
	 *                         prevalecem. 
	 * @return array
	 */
	public function fetchListByExample(Default_Model_Paroquia $example=null, $order=null, $count=null, $offset=null, $additionalWhere=null) {
		return $this->getMapper()->fetchListByExample($example, $order, $count, $offset, $additionalWhere);
		
	}
	
	/**
	 *  Retorna o primeiro registro que encontrar com os dados do objeto corrente.
	 *  
	 * @param $order Ordenação dos objetos, nome da coluna no banco
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @param $additionalWhere parâmetros especificados, utilizado para busca, adicionais aos 
	 *                         especificados no objeto. Valores especificados neste parâmetro 
	 *                         prevalecem. 
	 * @return Default_Model_Paroquia ou null se não encontrar nada.
	 */
	public function findFirstByExample($order=null, $offset=null) {
		$result = $this->fetchListByExample($this, $order, 1, $offset, $additionalWhere=null);
		if(count($result) <= 0)
			return null;
		$result = $result[0];
		return $result;
	}
	
	/**
	 * Conta o número de registros da tabela de acordo com a cláusula where.
	 * 
	 * @param $where condição de contagem
	 * @return int resultado da contagem
	 */
	public function count($where=null){
		return $this->getMapper()->count($where);
	}
	
	/**
	 * Conta o número de registros de acordo com os atributos do objeto.
	 * @param $additionalWhere parâmetros especificados, utilizado para busca, adicionais aos 
	 *                         especificados no objeto. Valores especificados neste parâmetro 
	 *                         prevalecem. 
	 * @return int resultado da contagem
	 */
	public function countByExample($additionalWhere=null){
		return $this->getMapper()->countByExample($this, $additionalWhere);
	}
	
	/**
     * Returns an instance of a Zend_Db_Table_Select object.
     *
     * @param bool $withFromPart Whether or not to include the from part of the select based on the table
     * @return Zend_Db_Table_Select
     */
	public function select($withFromPart=null){
		return $this->getMapper()->select($withFromPart);
	}
	
	/**
	 * Retorna uma string que identifica o objeto
	 * 
	 * @return string
	 */
 	public function __toString() {
 		$out = "$Paroquia{";
 		
		$out .= "id => ";
		$out .= $this->getId();
 		$out .= " | ";
		
 		$out .= "}";
		return $out;
    }
}
