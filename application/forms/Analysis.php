<?php
class Application_Form_Analysis extends Zend_Form {

	public function init(){
		
		$this->addElement(
		'text','id',array(
		'label'=>'No Analsis',
            'required' => true
				)
		);
		
				$this->addElement(
		'text','date_entered',array(
		'label'=>'Fecha',
            'required' => true
				)
		);
		$this->addElement(
		'text','applicant_id',array(
				'label'=>'Solicitante',
            'required' => true
				)
		); 
        
				$this->addElement(
		'text','medic_id',array(
				'label'=>'Medico',
            'required' => true
				)
		); 
 
			 
		$this->addElement(
		'submit','Guardar',array()
		);
		
	}
}