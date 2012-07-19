<?php
class Application_Model_Items extends Zend_Db_Table_Abstract
{
	protected $_name = 'items';
	protected $_primary = 'id';
	
	public function getAll()
	{
		
        $query = $this->select()
                ->from( array( 'p'=>'items' ), array('*'))
                ->join(array( 'c' =>'tests'), 'c.id = test_id', 
                        array('cname' => 'name' ) )
                
                ->setIntegrityCheck(false);
        
        
        return $this->fetchAll( $query );
        
	}
	
	public function getAllNew()
	{
		return $this->fetchAll(
			$this->select()
			->order('name DESC')
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
	
	public function getAllNewsGroupById($id ){
		
		$query = $this->select()
                ->from( array( 'p'=>'items' ), array('*'))
                ->join(array( 'c' =>'tests'), 'c.id = p.test_id', 
                        array('cname' => 'name' ) )
                ->where('c.id = ?' , $id )
                ->setIntegrityCheck(false);
         
        return $this->fetchAll( $query );
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
