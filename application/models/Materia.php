<?php
class Materia extends CI_Model{
	public $materia;
	
	public function get($materia = false){
		if($materia && is_object($materia)){
			foreach($materia as $col => $val){
				$this->db->where("$col", "$val");
			}
		}else if($materia){
			return false;
		}
		
		$response = $this->db->get('materias');
		if(isset($materia))
			$response = $response->row(); 
		else
			$response = $response->result();
		
		if(!isset($response) || (is_array($response) && empty($response)))
			$response = false;
		
		return ($response);
	}
	
	public function insert($materia = false){
		if(!$materia || !is_object($materia) || !isset($materia->cod))
			return false;
		if($this->db->insert('materias', $materia))
			return true;
		else
			return false;
		
	}
}