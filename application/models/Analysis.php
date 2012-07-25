<?php
class Application_Model_Analysis extends Zend_Db_Table_Abstract
{
	protected $_name = 'analysis';
	protected $_primary = 'id';

	public function getAll()
	{
		$query = $this->select()
		->from( array( 'a'=>'analysis' ), array('*'))
		->join(array( 'p' =>'contacts'), 'p.id = a.applicant_id',
		array('pfname' => 'first_name','plname' => 'last_name' ) )
		->join(array( 'm' =>'contacts'), 'm.id = a.applicant_id',
		array('mfname' => 'first_name','mlname' => 'last_name' ) )

		->order('id ASC')

		->setIntegrityCheck(false);


		return $this->fetchAll( $query );

	}

	public function getRow( $id )
	{

		$id = (int) $id;
		$row = $this->find( $id )->current();
		return $row;
	}


	public function getRowc( $id )
	{

		$id = (int) $id;
		$row = $this->find( $id )->current();
		return $row;
	}

	public function BySpecialties($id){

		/*
		 select  i.test_id  as te, t.name as name from results as r
		 inner join items as i on r.item_id = i.id
		 inner join tests as t on t.id = i.test_id
		 where analysis_id = 23 group by t;
		 */

		$query = $this->select()
		->from( array( 'r'=>'results' ), array('*'))
		->join(array( 'a' =>'analysis'), 'i.id = r.analysis_id',
		array('aanalysis_id' => 'analysis_id') )
		->join(array( 'i' =>'items'), 'i.id = r.item_id',
		array('itest_id' => 'test_id' ) )
		->join(array( 't' =>'tests'), 't.id = i.test_id',
		array('tname' => 'name' ) )
		->where('r.id = ?' , $id )

		->group('itest_id')

		->setIntegrityCheck(false);

		error_log($query);
		return $this->fetchAll( $query );
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

}
