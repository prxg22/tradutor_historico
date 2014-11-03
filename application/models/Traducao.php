<?php
class Traducao extends CI_Model{
	
	public function get($traducao = false){
		if($traducao && is_object($traducao)){
			foreach($traducao as $col => $val){
				$this->db->where($col, $val);
			}
		}else if($traducao){
			return false;
		}
	
		$response = $this->db->get('traducoes');
		$response = $response->result();
		
		if(!isset($response) || (is_array($response) && empty($response)))
			$response = false;
	
		return ($response);
	}
	
	function insert($materia_id, $trad, &$error = false){
		if(!isset($materia_id)){
			//error
			return false;
		}
		if(!isset($trad) || !is_object($trad))
			return false;
		else if(isset($trad->id))
			unset($trad->id);
		
		$this->db->where('materia_id', $materia_id);
		return $this->db->insert('traducoes', $trad);
	}
	
	function update($traducao){
		if(!isset($traducao) || !is_object($traducao))
			return false;
		else if(!isset($traducao->id))
			return false;
		
		$this->db->where('id', $traducao->id);
		unset($traducao->id);
		foreach($traducao as $col => $val){
				$this->db->set($col, $val);
		}
		
		return $this->db->update('Traducoes');
	}
}