<?php
class Application_Form_Analysis extends Zend_Form {

	public function init(){
		
		$this->addElement(
		'text','id',array(
		'label'=>'No Analsis',
            'required' => true
				)
		);
		
	 	  $this->addElement( 'select', 'applicant_id',array(
            'label' => 'Solicitante'
            
        )
                
        );
        
        $solicitante = new Application_Model_Contacts();
        
        $this->applicant_id->addMultiOptions( 
                $solicitante->getAsKeyValue()
        );			 
		
		  
          $this->addElement( 'select', 'medic_id',array(
            'label' => 'Medico'
            
        )
                
        );
        
        $medico = new Application_Model_Contacts();
        
        $this->medic_id->addMultiOptions( 
                $medico->getAsKeyValue()
        );			 
		
    
		
		$this->addElement( 'select', 'status', array(
		'label' => 'Status',
		 'required' => true,
		'multiOptions' => array('Pendiente'=>'Pendiente','Firmado'=> 'Firmado','Completado'=> 'Completado','Entregado'=> 'Entregado')
		)
		);
 
			 
		$this->addElement(
		'submit','Guardar',array()
		);
		
	}
}