<?php
class Application_Model_Analysis extends Zend_Db_Table_Abstract
{
	protected $_name = 'analysis';
	protected $_primary = 'id';

	protected $_aliasDB = 'a';

	protected $_colsCustom = array(
		'applicant_full_name' => array(
			'name' => 'applicant_full_name',
			'where' => "concat_ws(' ',p.first_name,p.last_name) LIKE (?)",
			'type' => 'string'
			),
		'medic_full_name' => array(
			'name' => 'medic_full_name',
			'where' => "concat_ws(' ',m.first_name,m.last_name) LIKE (?)",
			'type' => 'string'
			)
			);

			public function getAliasDB(){
				return $this->_aliasDB;
			}

			public function getColsCustom(){
				return $this->_colsCustom;
			}
			public function getAll()
			{
				$query = $this->select()
				->from( array( $this->_aliasDB=>'analysis' ), array('*'))
				->join(array( 'p' =>'contacts'), 'p.id = a.applicant_id',
				array('pfname' => 'first_name','plname' => 'last_name' ) )
				->join(array( 'm' =>'contacts'), 'm.id = a.medic_id',
				array('mfname' => 'first_name','mlname' => 'last_name' ) )

				->order('id desc')

				->setIntegrityCheck(false);


				return $this->fetchAll( $query );

			}

			public function getBy($wheres = array())
			{
				$query = $this->select()
				->from( array( $this->_aliasDB=>'analysis' ), array('*'))
				->join(array( 'p' =>'contacts'), 'p.id = a.applicant_id',
				array('pfname' => 'first_name','plname' => 'last_name' ) )
				->join(array( 'm' =>'contacts'), 'm.id = a.medic_id',
				array('mfname' => 'first_name','mlname' => 'last_name' ) )
				->order('id desc')
				->setIntegrityCheck(false);

				if(count($wheres)){
					foreach ($wheres as $key => $value) {
						$query->where($key, $value);
					}

				}
				//echo print_r($query->__toString(), true);
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
		  ->join(array( 'a' =>'analysis'), 'a.id = r.analysis_id',
		 	array('aanalysis_id' => 'id') )
		 	->join(array( 'i' =>'items'), 'i.id = r.item_id',
		 	array('itest_id' => 'test_id' ) )
		 	->join(array( 't' =>'tests'), 't.id = i.test_id',
		 	array('*') )
		 	->where('analysis_id = ?' , $id )
			 ->group('itest_id')
			 	

			 ->setIntegrityCheck(false);

			 error_log($query);
			 return $this->fetchAll( $query );
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

			public function actualiza_total(array $data){
					
				if( is_null( $data->id )){
						
					return false;
						
				}else{
					
					$row = $this->getRow( $data->id );
					$row->subtotal = $data->subtotal;
					$row->discount = $data->discount;
					$row->total     = $data->total;
					//save or update row
					return $row->save();
				}
			}

}
