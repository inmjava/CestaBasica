<?php

/**
  * Entrega model
  *
  * Utiliza o padrão Data Mapper para persistir dados.
  * 
  * @uses       Default_Model_Mapper_EntregaMapper
  * @subpackage Model
  */
class Default_Model_Entrega  {
	
	/**
	 * @var int
	 * Primay Key
	 */
	protected $_id;
	
	/**
	 * @var Default_Model_Mapper_EntregaMapper
	 */
	protected $_mapper;
	
	/**
	 * @var date
	 */
	protected $_dataEntrega;
	
	
	/**
	 * @var Default_Model_Usuario
	 */
	protected $_usuario;
	
	/**
	 * @var Default_Model_SegUsuario
	 */
	protected $_segUsuario;
	
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
	 * @return Default_Model_Entrega
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
	 * Código identificador da entidade Default_Model_Entrega
	 * 
	 * @param int primary
	 * @return Default_Model_Entrega
	 */
	public function setPk($pk){
		
		return $this->setId($pk);
		
	}
	
	/**
	 * Get primary (Não possui variável como atributo)
	 * Código identificador da entidade Default_Model_Entrega
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
	 * @return Default_Model_Entrega
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
	 * Setter da propriedade dataEntrega
	 * 
	 * @param date $dataEntrega
	 * @return Default_Model_Entrega
	 */
	public function setDataEntrega($dataEntrega){
		
			
		// Verifica o formato da data em questão 
		// se for brasileiro (dd/mm/yyyy ou dd/mm/yyyy hh:ii ou dd/mm/yyyy hh:ii:ss)
		// converte em datetime (yyyy-mm-dd hh:ii:ss) 
		// caso contrÃ¡rio
		// considera que foi passado um datetime e associa a variÃ¡vel
		
		list($d, $m, $a, $h, $i, $s) = split( '[/ :]', $dataEntrega);
    	if(($d && $m && $a && (strlen($dataEntrega) == 10) || ($d && $m && $a && $h && $i && strlen($dataEntrega) == 16) || ($d && $m && $a && $h && $i && $s && strlen($dataEntrega) == 19))){
    		if(!$h){$h = $i = $s = '00';}
    		if(!$s){$s = '00';}
			$dataEntrega = "$a-$m-$d $h:$i:$s";
    	}
    	
		$this->_dataEntrega = date($dataEntrega);
		return $this;
	}
	
	/**
	 * Getter da propriedade dataEntrega
	 * 
	 * @return null|date
	 */
	public function getDataEntrega() {
		return $this->_dataEntrega;
	}
	
	/**
	 * Setter da propriedade usuario
	 * 
	 * @param Default_Model_Usuario $usuario
	 * @return Default_Model_Entrega
	 */
	public function setUsuario($usuario){
		if (!$usuario instanceof Default_Model_Usuario) {
            $usuario = new Default_Model_Usuario(array("id" => $usuario));
            $usuario = $usuario->findFirstByExample();
        }
		
		$this->_usuario = $usuario;
		return $this;
	}
	
	/**
	 * Getter da propriedade usuario
	 * 
	 * @return null|Default_Model_Usuario
	 */
	public function getUsuario() {
		return $this->_usuario;
	}
	
	/**
	 * Setter da propriedade segUsuario
	 * 
	 * @param Default_Model_SegUsuario $segUsuario
	 * @return Default_Model_Entrega
	 */
	public function setSegUsuario($segUsuario){
		if (!$segUsuario instanceof Default_Model_SegUsuario) {
            $segUsuario = new Default_Model_SegUsuario(array("id" => $segUsuario));
            $segUsuario = $segUsuario->findFirstByExample();
        }
		
		$this->_segUsuario = $segUsuario;
		return $this;
	}
	
	/**
	 * Getter da propriedade segUsuario
	 * 
	 * @return null|Default_Model_SegUsuario
	 */
	public function getSegUsuario() {
		return $this->_segUsuario;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param  mixed $mapper 
	 * @return Default_Model_Mapper_EntregaMapper
	 */
	public function setMapper($mapper) {
		$this->_mapper = $mapper;
		return $this;
	}
	
	/**
	 * Get data mapper
	 *
	 * Instancia Default_Model_Mapper_EntregaMapper apenas se ainda n�o foi instanciada (Lazy Load).
	 * 
	 * @return Default_Model_Mapper_EntregaMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper || !$this->_mapper instanceof Default_Model_Mapper_EntregaMapper) {
			$this->setMapper(new Default_Model_Mapper_EntregaMapper());
		}
		return $this->_mapper;
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
	 * @return Default_Model_Entrega
	 */
	public function find( $id) {
		$this->getMapper()->find($id, $this);
		return $this;
	}

	/**
	 * Obtem o primeiro registro da tabela
	 * 
	 * @return Default_Model_Entrega
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
	public function fetchListByExample(Default_Model_Entrega $example=null, $order=null, $count=null, $offset=null, $additionalWhere=null) {
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
	 * @return Default_Model_Entrega ou null se não encontrar nada.
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
 		$out = "$Entrega{";
 		
		$out .= "id => ";
		$out .= $this->getId();
 		$out .= " | ";
		
 		$out .= "}";
		return $out;
    }
}
