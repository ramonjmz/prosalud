<?php
class Application_Model_Specialties extends Zend_Db_Table_Abstract
{

	protected $_name = 'specialties';
	protected $_primary = 'id';

	public function getAsKeyValue()
	{

		$rowset = $this->fetchAll();

		$data = array();

		foreach( $rowset as $row ){
			$data[$row->id] = $row->name ;
		}


		return $data;

	}
	 
	public function getAll()
	{
		return $this->fetchAll();

	}

	public function getRow( $id )
	{

		$id = (int) $id;
		$row = $this->find( $id )->current();
		return $row;
	}

	public function save( $bind, $id = null )
	{
		if( is_null( $id )){
			$row = $this->createRow();
			$row->date_entered        = new Zend_Db_Expr('NOW()');
			 
		}else{
			$row = $this->getRow( $id );
		}

		$row->setFromArray( $bind );
		return $row->save();
	}
}
