<?php
class Application_Model_Tests extends Zend_Db_Table_Abstract
{
	protected $_name = 'tests';
	protected $_primary = 'id';
	
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
		
        $query = $this->select()
                ->from( array( 'p'=>'tests' ), array('*'))
                ->join(array( 'c' =>'specialties'), 'c.id = specialty_id', 
                        array('cname' => 'name' ) )
                
                ->setIntegrityCheck(false);
        
        
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
