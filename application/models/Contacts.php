<?php
class Application_Model_Contacts extends Zend_Db_Table_Abstract
{
	protected $_name = 'contacts';
	protected $_primary = 'id';

	protected $_aliasDB = 'c';

	protected $_colsCustom = array(
		'contact_full_name' => array(
			'name' => 'applicant_full_name',
			'where' => "concat_ws(' ',first_name,last_name) LIKE (?)",
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
					$row->date_entered        = new Zend_Db_Expr('NOW()');

				}else{
					$row = $this->getRow( $id );
				}

				$row->setFromArray( $bind );
		 
				$config = array('auth' => 'login',
                'username' => 'ramonjmx@gmail.com',
                'password' => 'Kremlin1304');

				$transport = new Zend_Mail_Transport_Smtp('imap.gmail.com', $config);

				$mail = new Zend_Mail();
				$mail->setBodyText('This is the text of the mail.');
				$mail->setFrom('ramonjmx@gmail.com', 'Some Sender');
				$mail->addTo('ramonjmx@gmail.com', 'Some Recipient');
				$mail->setSubject('TestSubject');
				$mail->send($transport);
				return $row->save();
			}

			public function getRow( $id )
			{

				$id = (int) $id;
				$row = $this->find( $id )->current();
				return $row;
			}


			public function getAsKeyValue()
			{

				$rowset = $this->fetchAll();

				$data = array();

				foreach( $rowset as $row ){
					$data[$row->id] = $row->first_name . ' ' . $row->last_name;
				}


				return $data;

			}


			public function getBy($wheres = array(), $orWheres = array())
			{
				$query = $this->select();

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