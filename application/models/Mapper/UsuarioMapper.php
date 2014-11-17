<?php
/**
 * version 1.0
 */
 
/**
 * Usuario data mapper
 *
 * Implementa o design pattern Data Mapper:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Default_Model_DbTable_Usuario
 * @subpackage Model
 */
class Default_Model_Mapper_UsuarioMapper {
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * Especifica uma instância Zend_Db_Table, ela será utilizada nas operações com dados
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Default_Model_Mapper_UsuarioMapper
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
     * Carrega uma instância Default_Model_DbTable_Usuario se não existir uma registrada (Lazy Load)
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable("Default_Model_DbTable_Usuario");
        }
        return $this->_dbTable;
    }
    
    /**
     * Insere uma instância de Usuario
     * 
     * @param  Default_Model_Usuario $object
     * @return void
     */
    public function insert(Default_Model_Usuario $object) {
        $data = array(
        	
				"id" => $object->getId(),
			
				"nome" => $object->getNome(),
			
				"rg" => $object->getRg(),
			
				"cpf" => $object->getCpf(),
			
				"telefone" => $object->getTelefone(),
			
				"data_nasc" => $object->getDataNasc(),
			
				"endereco" => $object->getEndereco(),
			
				"cert_nasc" => $object->getCertNasc(),
			
				"nome_mae" => $object->getNomeMae(),
			
				"nome_pai" => $object->getNomePai(),
			
				"data_cadastro" => $object->getDataCadastro(),
			
				"cd_paroquia" => ($object->getParoquia() == null) ? null : $object->getParoquia()->getId(), 
			
        );
        $object->setPk($this->getDbTable()->insert($data));
    }
    
	/**
     * Atualiza uma instância de Usuario
     * 
     * @param  Default_Model_Usuario $object
     * @return void
     */
    public function update(Default_Model_Usuario $object) {
        $data = array(
        	
				"nome" => $object->getNome(),
			
				"rg" => $object->getRg(),
			
				"cpf" => $object->getCpf(),
			
				"telefone" => $object->getTelefone(),
			
				"data_nasc" => $object->getDataNasc(),
			
				"endereco" => $object->getEndereco(),
			
				"cert_nasc" => $object->getCertNasc(),
			
				"nome_mae" => $object->getNomeMae(),
			
				"nome_pai" => $object->getNomePai(),
			
				"data_cadastro" => $object->getDataCadastro(),
			
				"cd_paroquia" => ($object->getParoquia() == null) ? null : $object->getParoquia()->getId(), 
			
        );
      	$this->getDbTable()->update($data, array(
	    	
	  		"id = ?" => $object->getId(),
			
        ));
    }
    
	/**
	* Deleta uma instância de Usuario
	* @param Default_Model_Usuario $object
	* @return void
	*/
	public function delete(Default_Model_Usuario $object) {
    	$this->getDbTable()->delete(array(
	    	
	  		"id = ?" => $object->getId(),
			
        ));
	}

	/**
	* Deleta um grupo de instância instância de Usuario de acordo com 
	* a cláusula where.
	* 
	* @param $where
	* @return void
	*/
	public function deleteWhere($where) {
    	$this->getDbTable()->delete($where);
	}

    /**
     * Procura uma instância de Usuario pelo id
     * 
     * @param  int $id  
     * @return Default_Model_Usuario
     */
    public function find($id, Default_Model_Usuario $object) {
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
			$entry = new Default_Model_Usuario();
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
	public function fetchListByExample(Default_Model_Usuario $example=null, $order=null, $count=null, $offset=null, $additionalWhere=null) {
		$where = $this->exampleToWhere($example);
		if($additionalWhere){
			$where = array_merge($additionalWhere, $where);
		}
		return $this->fetchList($where, $order, $count, $offset);
	}
	
	/**
	 * Transforma o Objeto em um array where
	 * 
	 * @param Default_Model_Usuario $example
	 * @return array
	 */
	public function exampleToWhere(Default_Model_Usuario $example=null){
		$where = array(
			
			(($example->getId() != null) ? "id = ?" : "1 = ?") => (($example->getId() != null) ? $example->getId() : "1"),
			
			(($example->getNome() != null) ? "nome like ?" : "1 = ?") => (($example->getNome() != null) ? $example->getNome() : "1"),
			
			(($example->getRg() != null) ? "rg like ?" : "1 = ?") => (($example->getRg() != null) ? $example->getRg() : "1"),
			
			(($example->getCpf() != null) ? "cpf like ?" : "1 = ?") => (($example->getCpf() != null) ? $example->getCpf() : "1"),
			
			(($example->getTelefone() != null) ? "telefone like ?" : "1 = ?") => (($example->getTelefone() != null) ? $example->getTelefone() : "1"),
			
			(($example->getDataNasc() != null) ? "data_nasc = ?" : "1 = ?") => (($example->getDataNasc() != null) ? $example->getDataNasc() : "1"),
			
			(($example->getEndereco() != null) ? "endereco like ?" : "1 = ?") => (($example->getEndereco() != null) ? $example->getEndereco() : "1"),
			
			(($example->getCertNasc() != null) ? "cert_nasc like ?" : "1 = ?") => (($example->getCertNasc() != null) ? $example->getCertNasc() : "1"),
			
			(($example->getNomeMae() != null) ? "nome_mae like ?" : "1 = ?") => (($example->getNomeMae() != null) ? $example->getNomeMae() : "1"),
			
			(($example->getNomePai() != null) ? "nome_pai like ?" : "1 = ?") => (($example->getNomePai() != null) ? $example->getNomePai() : "1"),
			
			(($example->getDataCadastro() != null) ? "data_cadastro = ?" : "1 = ?") => (($example->getDataCadastro() != null) ? $example->getDataCadastro() : "1"),
			
			(($example->getParoquia() != null) ? "cd_paroquia = ?" : "1 = ?") => (($example->getParoquia() != null) ? $example->getParoquia()->getId() : "1"),
			
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
        $select->from('catedralapucarana.tb_usuario', 'COUNT(*) AS num');
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
	 * @param Default_Model_Usuario $example
	 * @param $additionalWhere parâmetros especificados, utilizado para busca, adicionais aos 
	 *                         especificados no objeto. Valores especificados neste parâmetro 
	 *                         prevalecem.
	 * @return int resultado da contagem
	 */
	public function countByExample(Default_Model_Usuario $example=null, $additionalWhere=null) {
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
     * Default_Model_Usuario.
     * 
     * @param  Zend_Db_Table_Row $row  
     * @param  Default_Model_Usuario $object
	 * @return Default_Model_Usuario
     */
    private function tableRow2ModelObject($row, $object){
		
		$paroquia = new Default_Model_Paroquia();
		$paroquia->find($row->cd_paroquia);
		
		$object
			   ->setId($row->id)
			   ->setNome($row->nome)
			   ->setRg($row->rg)
			   ->setCpf($row->cpf)
			   ->setTelefone($row->telefone)
			   ->setDataNasc($row->data_nasc)
			   ->setEndereco($row->endereco)
			   ->setCertNasc($row->cert_nasc)
			   ->setNomeMae($row->nome_mae)
			   ->setNomePai($row->nome_pai)
			   ->setDataCadastro($row->data_cadastro)
			   ->setParoquia($paroquia);
	}
}
