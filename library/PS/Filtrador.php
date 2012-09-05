<?php
class PS_Filtrador{

	protected $_filtros = array();

	protected $_model = null;


	public function __construct($model, $filtros)
	{
		//include_once('PS/CampoFiltro.php');
		
		$this->_model = $model;
		$this->_filtros = $filtros;
	}

	public function filtrar(){

		$model->getBy();
	}

	public function addCampoFiltro($campoFiltro){		
		$this->_fields[] = $campoFiltro;
	}

	public function getFiltros()
	{
		$where = array();
		foreach ($this->_filtros as $key => $value) {
			//echo nl2br(print_r($key, true)).'<br>';
			$campoFiltro = new PS_CampoFiltro($this->_model, $key, $value);
			if($campoFiltro->inModel() &&  !$this->valueIsEmpty($value)){
				$where[$campoFiltro->getKey()] = $campoFiltro->getValue();
			}
		}
		//echo nl2br(print_r($where, true));
		return $where;
	}

	public function valueIsEmpty($value){
		$result = false;
		switch (gettype($value)) {
			case 'string':
			case 'int':
			case 'boolean':
				$result = $value;
				break;
			case 'array':
				$result = count( array_filter($value));
			default:
				# code...
				break;
		}
		return !$result;
	}



	/*public GetComparation($field){

	}*/

}
