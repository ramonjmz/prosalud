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

	public function BySpecialties(){

		/*
		 * mysql> select  i.test_id  as te, t.name as name from results as r inner join ite
		 ms as i on r.item_id = i.id inner join tests as t on t.id = i.test_id where anal
		 ysis_id = 23 group by te;
		 */

	}

}
