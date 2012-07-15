<?php
class Application_Model_Analysis extends Zend_Db_Table_Abstract
{
	protected $_name = 'analysis';
	protected $_primary = 'id';
	
	public function getAll()
	{
		return $this->fetchAll($this->select()
			->order('id ASC')			
			);
	}
	
	public function getRow( $id )
	{
	
	    $id = (int) $id;
	    $row = $this->find( $id )->current();
	    return $row;
	}
	

}
