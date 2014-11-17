<?php

/**
 * Funções utilitárias trabalhar com o Lucene
 */
class Zend_Controller_Action_Helper_LuceneUtil extends Zend_Controller_Action_Helper_Abstract {
	
	var $_path = '/home/virtual/apucarana/novo/html/data/lucene/index2';
	
	public function criarNovoIndice(){
		$index = new Zend_Search_Lucene($this->_path, true);
		$index->commit();
		echo 'Indice criado com sucesso!';
	}
	
public function cargaLuceneNoticia($i){

		$index = Zend_Search_Lucene::open($this->_path);
		
		$dao = new Default_Model_Noticia();
		
		// de 2000 em 2000
		$entries = $dao->fetchAllPg(1000, 1000 * ($i - 1));
		
		foreach ($entries as $entry) {
			
			// novo documento
			$doc = new Zend_Search_Lucene_Document();
		
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('classe', 'Default_Model_Noticia'));
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', $entry->getId()));
			
			$doc->addField(Zend_Search_Lucene_Field::text('assunto', $entry->getAssunto()));

			$doc->addField(Zend_Search_Lucene_Field::text('titulo', $entry->getTitulo()));
			
			$doc->addField(Zend_Search_Lucene_Field::text('linhafina', $entry->getLinhaFina()));
			
			$doc->addField(Zend_Search_Lucene_Field::text('autor', $entry->getAutor()));
			
			$doc->addField(Zend_Search_Lucene_Field::text('tags', $entry->getTags()));

			$doc->addField(Zend_Search_Lucene_Field::text('descricao', $entry->getDescricao()));
			
			// Add document to the index.
			$index->addDocument($doc);
		}
		// Write changes to the index.
		$index->commit();
		
		echo "Indice $i Default_Model_Noticia atualizado com sucesso!";
	}
	
	public function cargaLuceneExemplo(){

		$index = Zend_Search_Lucene::open($this->_path, true);
		
		$dao = new Default_Model_Noticia();
		
		// de 2000 em 2000
		$entries = array($dao->find(5416));
		
		foreach ($entries as $entry) {
			
			// novo documento
			$doc = new Zend_Search_Lucene_Document();
		
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('classe', 'Default_Model_Noticia'));
			
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', $entry->getId()));

			$doc->addField(Zend_Search_Lucene_Field::text('descricao', $entry->getDescricao()));
			
			// Add document to the index.
			$index->addDocument($doc);
		}
		// Write changes to the index.
		$index->commit();
	}
	
	public function getObj($hit){
		$classe = $hit->classe;
		$obj = new $classe();
		return $obj->find($hit->id);
	}
	
	public function optimize(){
		$index = Zend_Search_Lucene::open($this->_path);
		$index->optimize();
		echo $index->count().'documentos.';
		echo 'Indice otmizado com sucesso!';
		
	}
	
	public function find($query){
		$index = new Zend_Search_Lucene($this->_path);
		return $index->find($query);
	}
}