<?php
class Application_Model_Results extends Zend_Db_Table_Abstract
{
	protected $_name = 'results';
	protected $_primary = 'id';

	public function getAll()
	{
		return $this->fetchAll($this->select()
		->order('title ASC')
		);
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

	public function getBy($wheres = array(), $orWheres = array())
	{
		$query = $this->select()
			->from( array( 'r'=>'results' ), array('*'))
			->join(array( 'i' =>'items'), 'r.item_id = i.id',
				array('item_name' => 'name' ))
			->setIntegrityCheck(false);

		if(count($wheres)){
			foreach ($wheres as $key => $value) {
				$query->where($key, $value);
			}

		}
		if(count($orWheres)){
			foreach ($orWheres as $key => $value) {
				$query->orWhere($key, $value);
			}

		}
		//echo print_r($query->__toString(), true);
		return $this->fetchAll($query);
	}


}