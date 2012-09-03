<?php
class Application_Model_Payments extends Zend_Db_Table_Abstract
{
	protected $_name = 'payments';
	protected $_primary = 'id';

	public function save( $bind, $id= null )
	{
			/*
		if( is_null( $id )){
			$row = $this->createRow();
			$row->date_entered        = new Zend_Db_Expr('NOW()');
			
			//$row->analysis_id = $this->_hasParam('id');
			//$row->subtotal = $monto;
			$row->discount_c = 0;
			$row->iva = 0;
			//$row->amount = $monto;
			$row->deleted = 0;
			$row->status = 'NEW';
					 
		}else{
			$row = $this->getRow( $id );
		}

		$row->setFromArray( $bind );
		return $row->save();
		 */
	}


}