<?php

/**
  * Usuario model
  *
  * Utiliza o padrão Data Mapper para persistir dados.
  * 
  * @uses       Default_Model_Mapper_UsuarioMapper
  * @subpackage Model
  */
class Default_Model_Usuario  {
	
	/**
	 * @var int
	 * Primay Key
	 */
	protected $_id;
	
	/**
	 * @var Default_Model_Mapper_UsuarioMapper
	 */
	protected $_mapper;
	
	/**
	 * @var string
	 */
	protected $_nome;
	
	/**
	 * @var string
	 */
	protected $_rg;
	
	/**
	 * @var string
	 */
	protected $_cpf;
	
	/**
	 * @var string
	 */
	protected $_telefone;
	
	/**
	 * @var date
	 */
	protected $_dataNasc;
	
	/**
	 * @var string
	 */
	protected $_endereco;
	
	/**
	 * @var string
	 */
	protected $_certNasc;
	
	/**
	 * @var string
	 */
	protected $_nomeMae;
	
	/**
	 * @var string
	 */
	protected $_nomePai;
	
	/**
	 * @var date
	 */
	protected $_dataCadastro;
	
	
	/**
	 * @var Default_Model_Paroquia
	 */
	protected $_paroquia;
	
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
	 * @return Default_Model_Usuario
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
	 * Código identificador da entidade Default_Model_Usuario
	 * 
	 * @param int primary
	 * @return Default_Model_Usuario
	 */
	public function setPk($pk){
		
		return $this->setId($pk);
		
	}
	
	/**
	 * Get primary (Não possui variável como atributo)
	 * Código identificador da entidade Default_Model_Usuario
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
	 * @return Default_Model_Usuario
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
	 * @return Default_Model_Usuario
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
	 * Setter da propriedade rg
	 * 
	 * @param string $rg
	 * @return Default_Model_Usuario
	 */
	public function setRg($rg){
		$this->_rg = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $rg));
		return $this;
	}
	
	/**
	 * Getter da propriedade rg
	 * 
	 * @return null|string
	 */
	public function getRg() {
		return $this->_rg;
	}
	
	/**
	 * Setter da propriedade cpf
	 * 
	 * @param string $cpf
	 * @return Default_Model_Usuario
	 */
	public function setCpf($cpf){
		$this->_cpf = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $cpf));
		return $this;
	}
	
	/**
	 * Getter da propriedade cpf
	 * 
	 * @return null|string
	 */
	public function getCpf() {
		return $this->_cpf;
	}
	
	/**
	 * Setter da propriedade telefone
	 * 
	 * @param string $telefone
	 * @return Default_Model_Usuario
	 */
	public function setTelefone($telefone){
		$this->_telefone = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $telefone));
		return $this;
	}
	
	/**
	 * Getter da propriedade telefone
	 * 
	 * @return null|string
	 */
	public function getTelefone() {
		return $this->_telefone;
	}
	
	/**
	 * Setter da propriedade dataNasc
	 * 
	 * @param date $dataNasc
	 * @return Default_Model_Usuario
	 */
	public function setDataNasc($dataNasc){
		
			
		// Verifica o formato da data em questão 
		// se for brasileiro (dd/mm/yyyy ou dd/mm/yyyy hh:ii ou dd/mm/yyyy hh:ii:ss)
		// converte em datetime (yyyy-mm-dd hh:ii:ss) 
		// caso contrÃ¡rio
		// considera que foi passado um datetime e associa a variÃ¡vel
		
		list($d, $m, $a, $h, $i, $s) = split( '[/ :]', $dataNasc);
    	if(($d && $m && $a && (strlen($dataNasc) == 10) || ($d && $m && $a && $h && $i && strlen($dataNasc) == 16) || ($d && $m && $a && $h && $i && $s && strlen($dataNasc) == 19))){
    		if(!$h){$h = $i = $s = '00';}
    		if(!$s){$s = '00';}
			$dataNasc = "$a-$m-$d $h:$i:$s";
    	}
    	
		$this->_dataNasc = date($dataNasc);
		return $this;
	}
	
	/**
	 * Getter da propriedade dataNasc
	 * 
	 * @return null|date
	 */
	public function getDataNasc() {
		return $this->_dataNasc;
	}
	
	/**
	 * Setter da propriedade endereco
	 * 
	 * @param string $endereco
	 * @return Default_Model_Usuario
	 */
	public function setEndereco($endereco){
		$this->_endereco = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $endereco));
		return $this;
	}
	
	/**
	 * Getter da propriedade endereco
	 * 
	 * @return null|string
	 */
	public function getEndereco() {
		return $this->_endereco;
	}
	
	/**
	 * Setter da propriedade certNasc
	 * 
	 * @param string $certNasc
	 * @return Default_Model_Usuario
	 */
	public function setCertNasc($certNasc){
		$this->_certNasc = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $certNasc));
		return $this;
	}
	
	/**
	 * Getter da propriedade certNasc
	 * 
	 * @return null|string
	 */
	public function getCertNasc() {
		return $this->_certNasc;
	}
	
	/**
	 * Setter da propriedade nomeMae
	 * 
	 * @param string $nomeMae
	 * @return Default_Model_Usuario
	 */
	public function setNomeMae($nomeMae){
		$this->_nomeMae = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $nomeMae));
		return $this;
	}
	
	/**
	 * Getter da propriedade nomeMae
	 * 
	 * @return null|string
	 */
	public function getNomeMae() {
		return $this->_nomeMae;
	}
	
	/**
	 * Setter da propriedade nomePai
	 * 
	 * @param string $nomePai
	 * @return Default_Model_Usuario
	 */
	public function setNomePai($nomePai){
		$this->_nomePai = str_replace("\\\\", "\\", str_replace("\\\"", "\"", $nomePai));
		return $this;
	}
	
	/**
	 * Getter da propriedade nomePai
	 * 
	 * @return null|string
	 */
	public function getNomePai() {
		return $this->_nomePai;
	}
	
	/**
	 * Setter da propriedade dataCadastro
	 * 
	 * @param date $dataCadastro
	 * @return Default_Model_Usuario
	 */
	public function setDataCadastro($dataCadastro){
		
			
		// Verifica o formato da data em questão 
		// se for brasileiro (dd/mm/yyyy ou dd/mm/yyyy hh:ii ou dd/mm/yyyy hh:ii:ss)
		// converte em datetime (yyyy-mm-dd hh:ii:ss) 
		// caso contrÃ¡rio
		// considera que foi passado um datetime e associa a variÃ¡vel
		
		list($d, $m, $a, $h, $i, $s) = split( '[/ :]', $dataCadastro);
    	if(($d && $m && $a && (strlen($dataCadastro) == 10) || ($d && $m && $a && $h && $i && strlen($dataCadastro) == 16) || ($d && $m && $a && $h && $i && $s && strlen($dataCadastro) == 19))){
    		if(!$h){$h = $i = $s = '00';}
    		if(!$s){$s = '00';}
			$dataCadastro = "$a-$m-$d $h:$i:$s";
    	}
    	
		$this->_dataCadastro = date($dataCadastro);
		return $this;
	}
	
	/**
	 * Getter da propriedade dataCadastro
	 * 
	 * @return null|date
	 */
	public function getDataCadastro() {
		return $this->_dataCadastro;
	}
	
	/**
	 * Setter da propriedade paroquia
	 * 
	 * @param Default_Model_Paroquia $paroquia
	 * @return Default_Model_Usuario
	 */
	public function setParoquia($paroquia){
		if (!$paroquia instanceof Default_Model_Paroquia) {
            $paroquia = new Default_Model_Paroquia(array("id" => $paroquia));
            $paroquia = $paroquia->findFirstByExample();
        }
		
		$this->_paroquia = $paroquia;
		return $this;
	}
	
	/**
	 * Getter da propriedade paroquia
	 * 
	 * @return null|Default_Model_Paroquia
	 */
	public function getParoquia() {
		return $this->_paroquia;
	}
	
	/**
	 * Set data mapper
	 * 
	 * @param  mixed $mapper 
	 * @return Default_Model_Mapper_UsuarioMapper
	 */
	public function setMapper($mapper) {
		$this->_mapper = $mapper;
		return $this;
	}
	
	/**
	 * Get data mapper
	 *
	 * Instancia Default_Model_Mapper_UsuarioMapper apenas se ainda n�o foi instanciada (Lazy Load).
	 * 
	 * @return Default_Model_Mapper_UsuarioMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper || !$this->_mapper instanceof Default_Model_Mapper_UsuarioMapper) {
			$this->setMapper(new Default_Model_Mapper_UsuarioMapper());
		}
		return $this->_mapper;
	}
		
	/**
	 * Lista instâncias Default_Model_Entrega associadas a 
	 * Default_Model_Usuario
	 * 
	 * @param $count Número máximo de registros
	 * @param $offset Começa busca a partir do registro de número especificado 
	 * @return array
	 */
	public function listEntrega($count=null, $offset=null, $order=null){
		$entrega = new Default_Model_Entrega();
		$entrega->setUsuario($this);
		return $entrega->fetchListByExample($entrega, $order, $count, $offset);
	}	
	
	/**
	 * Obtem o primeiro registro Default_Model_Entrega associado a 
	 * Default_Model_Usuario
	 * 
	 * @return Default_Model_Entrega
	 */
	public function findFirstEntrega($offset=null, $order=null) {
		$aux = $this->listEntrega(1, $offset, $order);
		if($aux == null)
			return null;
		return $aux[0];
	}	
	
	/**
	 * Exclui instâncias Default_Model_Entrega associadas a 
	 * Default_Model_Usuario
	 * 
	 * @param $entries um array de objetos Default_Model_Entrega ou 
	 * apenas um objeto Default_Model_Entrega
	 * @return Default_Model_Usuario
	 */
	public function deleteEntrega($entries){
		if($entries instanceof Default_Model_Entrega){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setUsuario($this);
			$entry->delete();
		}
		return $this;
	}
	
	/**
	 * Exclui instâncias Default_Model_Entrega associadas a 
	 * Default_Model_Usuario
	 * 
	 * @return Default_Model_Usuario
	 */
	public function deleteAllEntrega(){
		$this->deleteEntrega($this->listEntrega());
		return $this;
	}
	
	/**
	 * Insere instâncias Default_Model_Entrega associadas a 
	 * Default_Model_Usuario
	 * 
	 * @param $entries um array de objetos Default_Model_Entrega ou 
	 * apenas um objeto Default_Model_Entrega
	 * @return Default_Model_Usuario
	 */
	public function insertEntrega($entries){
		if($entries instanceof Default_Model_Entrega){
			$entries = array($entries);
		}
		foreach($entries as $entry){
			$entry->setUsuario($this);
			$entry->insert();
		}
		return $this;
	}
	
	/**
	 * Atualiza instâncias Default_Model_Entrega associadas a 
	 * Default_Model_Usuario
	 * 
	 * @param $entries um array de objetos Default_Model_Entrega ou 
	 * apenas um objeto Default_Model_Entrega
	 * @return Default_Model_Usuario
	 */
	public function updateEntrega($entries){
		$this->deleteAllEntrega();
		$this->insertEntrega($entries);
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
	 * @return Default_Model_Usuario
	 */
	public function find( $id) {
		$this->getMapper()->find($id, $this);
		return $this;
	}

	/**
	 * Obtem o primeiro registro da tabela
	 * 
	 * @return Default_Model_Usuario
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
	public function fetchListByExample(Default_Model_Usuario $example=null, $order=null, $count=null, $offset=null, $additionalWhere=null) {
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
	 * @return Default_Model_Usuario ou null se não encontrar nada.
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
 		$out = "$Usuario{";
 		
		$out .= "id => ";
		$out .= $this->getId();
 		$out .= " | ";
		
 		$out .= "}";
		return $out;
    }
}
