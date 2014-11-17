<?php
/**
 * version 1.0
 */
 
/**
 * Entrega data mapper
 *
 * Implementa o design pattern Data Mapper:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Model_DbTable_Entrega
 * @subpackage Model
 */
class Default_Model_Mapper_EntregaMapper {
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * Especifica uma instância Zend_Db_Table, ela será utilizada nas operações com dados
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Default_Model_Mapper_EntregaMapper
     */
    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Gateway Inválido");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Obtem a instância de um Zend_Db_Table registrada
     *
     * Carrega uma instância Default_Model_DbTable_Entrega se não existir uma registrada (Lazy Load)
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable("Default_Model_DbTable_Entrega");
        }
        return $this->_dbTable;
    }
    
    /**
     * Insere uma instância de Entrega
     * 
     * @param  Default_Model_Entrega $object
     * @return void
     */
    public function insert(Default_Model_Entrega $object) {
        $data = array(
        	
				"id" => $object->getId(),
			
				"data_entrega" => $object->getDataEntrega(),
			
				"cd_usuario" => ($object->getUsuario() == null) ? null : $object->getUsuario()->getId(), 
			
				"cd_seg_usuario" => ($object->getSegUsuario() == null) ? null : $object->getSegUsuario()->getId(), 
			
        );
        $object->setPk($this->getDbTable()->insert($data));
    }
    
	/**
     * Atualiza uma instância de Entrega
     * 
     * @param  Default_Model_Entrega $object
     * @return void
     */
    public function update(Default_Model_Entrega $object) {
        $data = array(
        	
				"data_entrega" => $object->getDataEntrega(),
			
				"cd_usuario" => ($object->getUsuario() == null) ? null : $object->getUsuario()->getId(), 
			
				"cd_seg_usuario" => ($object->getSegUsuario() == null) ? null : $object->getSegUsuario()->getId(), 
			
        );
      	$this->getDbTable()->update($data, array(
	    	
	  		"id = ?" => $object->getId(),
			
        ));
    }
    
	/**
	* Deleta uma instância de Entrega
	* @param Default_Model_Entrega $object
	* @return void
	*/
	public function delete(Default_Model_Entrega $object) {
    	$this->getDbTable()->delete(array(
	    	
	  		"id = ?" => $object->getId(),
			
        ));
	}

	/**
	* Deleta um grupo de instância instância de Entrega de acordo com 
	* a cláusula where.
	* 
	* @param $where
	* @return void
	*/
	public function deleteWhere($where) {
    	$this->getDbTable()->delete($where);
	}

    /**
     * Procura uma instância de Entrega pelo id
     * 
     * @param  int $id  
     * @return Default_Model_Entrega
     */
    public function find($id, Default_Model_Entrega $object) {
    	$result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return ;
        }
        $row = $result->current();
        $this->tableRow2ModelObject($row, $object);
    }

	/**
	* Traz todos os registros
	* 
	* @return array
	*/
	public function fetchAll() {
		return $this->fetchList(null, null, null, null);
	}
	
	/**
	* Traz todos os registros, método utilizado para realizar paginação
	* 
	* @param $count Número máximo de registros
	* @param $offset Começa busca a partir do registro de número especificado 
	* @return array
	*/
	public function fetchAllPg($count=null, $offset=null) {
		return $this->fetchList(null, null, $count, $offset);
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
		$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Model_Entrega();
			$entry->setMapper($this);
			$this->tableRow2ModelObject($row, $entry);
			$entries[] = $entry;
		}
		return $entries;
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
		$where = $this->exampleToWhere($example);
		if($additionalWhere){
			$where = array_merge($additionalWhere, $where);
		}
		return $this->fetchList($where, $order, $count, $offset);
	}
	
	/**
	 * Transforma o Objeto em um array where
	 * 
	 * @param Default_Model_Entrega $example
	 * @return array
	 */
	public function exampleToWhere(Default_Model_Entrega $example=null){
		$where = array(
			
			(($example->getId() != null) ? "id = ?" : "1 = ?") => (($example->getId() != null) ? $example->getId() : "1"),
			
			(($example->getDataEntrega() != null) ? "data_entrega = ?" : "1 = ?") => (($example->getDataEntrega() != null) ? $example->getDataEntrega() : "1"),
			
			(($example->getUsuario() != null) ? "cd_usuario = ?" : "1 = ?") => (($example->getUsuario() != null) ? $example->getUsuario()->getId() : "1"),
			
			(($example->getSegUsuario() != null) ? "cd_seg_usuario = ?" : "1 = ?") => (($example->getSegUsuario() != null) ? $example->getSegUsuario()->getId() : "1"),
			
			);
		return $where;
	}
	
	/**
	 * Conta o número de registros da tabela de acordo com a cláusula where.
	 * 
	 * @param $where condição de contagem
	 * @return int resultado da contagem
	 */
	public function count($where=null){
		if($where == null){
			$where = array();
		}else if(!is_array($where)){
			$where = array($where);
		}
		$select = $this->getDbTable()->select();
        $select->from('catedralapucarana.tb_entrega', 'COUNT(*) AS num');
        foreach ($where as $k => $v) {
        	// apenas números
        	if(is_int($k)){ 
        		$select->where($v);
        	}else{
        		$select->where($k, $v);
        	}
        }
        return $this->getDbTable()->fetchRow($select)->num;
	}
	
	/**
	 * Conta o número de registros, leva em conta os atributos
	 * especificados no parametro $example
	 * 
	 * @param Default_Model_Entrega $example
	 * @param $additionalWhere parâmetros especificados, utilizado para busca, adicionais aos 
	 *                         especificados no objeto. Valores especificados neste parâmetro 
	 *                         prevalecem.
	 * @return int resultado da contagem
	 */
	public function countByExample(Default_Model_Entrega $example=null, $additionalWhere=null) {
		$where = $this->exampleToWhere($example);
		if($additionalWhere){
			$where = array_merge($additionalWhere, $where);
		}
		return $this->count($where);
	}
	
	/**
     * Returns an instance of a Zend_Db_Table_Select object.
     *
     * @param bool $withFromPart Whether or not to include the from part of the select based on the table
     * @return Zend_Db_Table_Select
     */
	public function select($withFromPart=null){
		return $this->getDbTable()->select($withFromPart);
	}
	
	/**
     * Faz o mapeamento entre um objeto Zend_Db_Table_Row e 
     * popula os valores correspondentes num objeto 
     * Default_Model_Entrega.
     * 
     * @param  Zend_Db_Table_Row $row  
     * @param  Default_Model_Entrega $object
	 * @return Default_Model_Entrega
     */
    private function tableRow2ModelObject($row, $object){
		
		$usuario = new Default_Model_Usuario();
		$usuario->find($row->cd_usuario);
		
		$segUsuario = new Default_Model_SegUsuario();
		$segUsuario->find($row->cd_seg_usuario);
		
		$object
			   ->setId($row->id)
			   ->setDataEntrega($row->data_entrega)
			   ->setUsuario($usuario)
			   ->setSegUsuario($segUsuario);
	}
}
