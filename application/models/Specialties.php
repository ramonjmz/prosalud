<?php
class Application_Model_Specialties extends Zend_Db_Table_Abstract
{

	protected $_name = 'specialties';
	protected $_primary = 'id';

	protected $_aliasDB = 'specialties';


	protected $_colsCustom = array(	'like_name' => array(
			'name' => 'name',
			'where' => "name LIKE (?)",
			'type' => 'string'
		));

	public function getAliasDB(){
		return $this->_aliasDB;
	}

	public function getColsCustom(){
		return $this->_colsCustom;
	}


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

	public function getBy($wheres = array())
	{
		$query = $this->select();

		if(count($wheres)){
			foreach ($wheres as $key => $value) {
				 $query->where($key, $value);
			}

		}
		return $this->fetchAll($query);
	}
}
