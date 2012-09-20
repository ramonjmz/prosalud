<?php
class Application_Model_Tests extends Zend_Db_Table_Abstract
{
	protected $_name = 'tests';
	protected $_primary = 'id';

 

	protected $_aliasDB = 'tests';


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

	public function getAll($wheres = array(), $order = array())
	{

		$query = $this->select()
		->from( array( 'p'=>'tests' ), array('*'))
		->join(array( 'c' =>'specialties'), 'c.id = specialty_id',
		array('cname' => 'name' ) )

		->setIntegrityCheck(false);

		if(count($wheres)){
			foreach ($wheres as $key => $value) {
				$query->where($key, $value);
			}

		}

		if(count($order)){
			$query->order($order);
		}

		return $this->fetchAll( $query );

	}

	public function getAllNew()
	{
		return $this->fetchAll(
		$this->select()
		->order('id DESC')
		->limit(5)
		);
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

	public function getRow( $id )
	{

		$id = (int) $id;
		$row = $this->find( $id )->current();
		return $row;
	}

	public function getAllNewsBySpecialtyId( $id )
	{
		$query = $this->select()
		->from( array( 'p'=>'tests' ), array('*'))
		->join(array( 'c' =>'specialties'), 'c.id = p.specialty_id',
		array('cname' => 'name' ) )
		->where('c.id = ?' , $id )
		->order('id ASC')

		->setIntegrityCheck(false);


		return $this->fetchAll( $query );
	}

	public function getBy($wheres = array(), $order = array())
	{
		$query = $this->select();

		if(count($wheres)){
			foreach ($wheres as $key => $value) {
				$query->where($key, $value);
			}

		}

		if(count($order)){
			$query->order($order);
		}
		//echo print_r($query->__toString());
		return $this->fetchAll($query);
	}

	public function getByResult($wheres = array(), $order = array())
	{
		$query = $this->select()
			->distinct()
			->from( array( 't'=>'tests' ), array('*'))
			->join(array( 'i' =>'items'), 't.id = i.test_id', array())
			->join(array( 'r' =>'results'), 'i.id = r.item_id', array())
			->setIntegrityCheck(false);

		if(count($wheres)){
			foreach ($wheres as $key => $value) {
				$query->where($key, $value);
			}
		}

		if(count($order)){
			$query->order($order);
		}

		//echo print_r($query->__toString());
		return $this->fetchAll($query);
	}
}
