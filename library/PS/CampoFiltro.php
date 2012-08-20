<?php
class PS_CampoFiltro{
	
	public $_model = null;

	public $_key = "";

	public $_fieldName = "";

	public $_value = "";

	public $_operatorName = "";

	public $_operator = "";

	private $_colsModel = array();

	private $_colsCustomModel = array();

	public function getKey(){
		return $this->_key;
	}

	public function getValue(){
		return $this->_value;
	}

	public function __construct($modelo, $filtro, $value){
		$this->_model = $modelo;
		$this->_value = $value;
		$this->_colsModel = $this->_model->info(Zend_Db_Table_Abstract::COLS);
		$this->_colsCustomModel = $this->_model->getColsCustom();
		$this->getProperties($filtro);
	}

	private function getProperties($cadena){
		$tokens = $this->obtenTokens($cadena);

		if(in_array($tokens[0], $this->_colsModel) || in_array($tokens[0], $this->_model->getColsCustom())){
			$this->_fieldName = $tokens[0];
			switch (count($tokens)) {
				case 1:
				//$this->_operatorName = "equal";
				$this->_operator = "= ?";
				break;
				case 2:
				//$operatorName = $this->get;
				$this->_operator = $this->traduceOperador($tokens[1]);				
				break;
				default:
				# code...
				break;
			}
			$this->getType();			
			if(in_array($this->_fieldName, $this->_model->getColsCustom()){
				$this->_key = ; 
			}
			else{
				$this->_key = $this->_fieldName;
			}
			$this->_key .= ' ' . $this->_operator;
		}
	}

	private function obtenTokens($cadena){
		$arrayToken = array();
		$arrayToken = explode("__", $cadena);
		return $arrayToken;
	}

	private function traduceOperador($operatorToken)
	{
		$operator = '= ?';
		// TODO obtener el tipo de campo a compara para convertir el campo
		//$this->getType();
		switch ($operatorToken) {
			case 'contains':
			$operator = "LIKE ?";
			$this->_value = '%'.$this->_value.'%';
				# code...
			break;
			case 'in':
			$operator = 'IN (?)';
			break;
			default:
			$operator = '= ?';
			break;
		}
		return $operator;
	}

	private function getType()
	{
		$metadata = $this->_model->info('metadata');
		$typeDB = $metadata[$this->_fieldName]['DATA_TYPE'];
	}

	public function inModel(){
		//return true;
		return in_array($this->_fieldName, $this->_colsModel) || in_array($this->_fieldName, $this->_colsModel);
	}


}