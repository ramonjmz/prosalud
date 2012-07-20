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

	public function getBy($data)
	{
		/* select title,concat(first_name,' ',last_name) as name, first_name,last_name id
		 * from contacts
		 * where title ='paciente'
		 * having concat(first_name,' ',last_name) like '%naye%';
		 */
		 
		
		 $query = $this->select()
		 ->from('contacts',
		 array('id','concat(first_name," ",last_name) as value'))
		 ->where('title = ?','paciente')
		 ->where('first_name like ?','%'.$data.'%')
		 ->orwhere('last_name like ?','%'.$data.'%');
		 
		 error_log("model query-> ".$query);

		 return $this->fetchAll($query);
				
        
	}

}
