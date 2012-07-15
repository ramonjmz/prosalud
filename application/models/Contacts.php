<?php
class Application_Model_Contacts extends Zend_Db_Table_Abstract
{
	protected $_name = 'contacts';
	protected $_primary = 'id';
	
	public function getAll()
	{
		return $this->fetchAll($this->select()
			->order('title ASC')			
			);
	}
	
	public function getAllNew()
	{
		return $this->fetchAll(
			$this->select()
			->order('date_entered DESC')
			->limit(5)
		);
	}	
	
	public function save( $bind, $id = null )
	{
	    if( is_null( $id )){
	        $row = $this->createRow();
	    }else{
	        $row = $this->getRow( $id );
	    }
	
		$row->setFromArray( $bind );
		return $row->save();
	}
	
	public function getRow( $id )
	{
	
	    $id = (int) $id;
	    $row = $this->find( $id )->current();
	    return $row;
	}
}
