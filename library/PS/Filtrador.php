<?php
class PS_Filtrador{

	protected $_filtros = array();

	protected $_model = null;


	public function __construct($model, $filtros)
	{
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
			echo nl2br(print_r($key, true)).'\n';
			$campoFiltro = new PS_CampoFiltro($this->_model, $key, $value);
			if($campoFiltro->inModel()){
				$where[$campoFiltro->getKey()] = $campoFiltro->getValue();
			}
		}
		echo nl2br(print_r($where, true));
	}





	/*public GetComparation($field){

	}*/

}
