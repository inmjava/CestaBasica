<?php

/**
 * Gateway de dados da tabela Paroquia
 *
 
 Ivan Nicoli Man!!!!!!
 
 * @uses       Zend_Db_Table_Abstract
 * @subpackage Model
 */
class Default_Model_DbTable_Paroquia extends Zend_Db_Table_Abstract{

    /**
     * @var string do banco de dados
     */
	protected $_schema = "cesta";
    
    /**
     * @var string nome da tabela no banco de dados
     */
    protected $_name = "tb_paroquia";
    
    /**
     * @var int correspondente a PK da tabela
     */
    protected $_primary = 'id';
}
