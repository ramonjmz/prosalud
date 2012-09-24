<?php
class Application_Form_Analysis extends Zend_Form {

	public function init(){

		$this->setAttrib('enctype', 'multipart/form-data');

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
		'multiOptions' => array('Pendiente'=>'Pendiente','Liberado'=> 'Liberado')
            )
            );

            
            		$this->addElement('textarea', 'note', array(
            'label'      => 'Nota:',
         		'rows' => '5', 
             'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 100))
                )
        ));
            $this->addElement('file', 'archivo', array(
            'class' => 'sf'
            ));
            $this->archivo->addValidator( 'Extension', false, 'pdf' );
            $this->archivo->addValidator( 'Size', false, '10024000' );
            $this->archivo
            ->setDestination( APPLICATION_PATH . '/../public/files/' )
            ->setValueDisabled( true );
            
            $this->addElement(
		'text','discount',array(
				'label'=>'Descuento',
			 'required' => false
		)
		);
      
          $this->addElement( 'checkbox', 'name', array(
		'label' => 'Pdf sin encabezado',
		 'required' => false
            )
            );
        
            $this->addElement(
		'submit','Guardar',array()
            );

	}
}