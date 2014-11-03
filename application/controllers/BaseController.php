<?php
class BaseController extends CI_Controller{
	protected $request;
	private $nextRequest;
	
	function __construct(){
		parent::__construct();

		$data = json_decode(file_get_contents('php://input'));
		if(!isset($data))
			$data = $_POST;
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(is_array($data) && !(empty($data))){
				$object = $this->array_to_object($data);				
				$data = $object;
			}
			
			if(isset($data->nextRequest)){
				$this->nextRequest = $data->nextRequest;
				unset($data->nextRequest); 
			}
			
			$this->request = $data;
		}else if($_SERVER['REQUEST_METHOD'] == 'GET' && $data = $this->session->userdata('nextRequest')){
			$this->request = json_decode($data);
			$this->session->unset_userdata('nextRequest');
		}
	}
	
	function returnJSON($response, $cod = 200){
		header('Content-Type: application/json');
		header('HTTP/1.1 '.$cod);
		echo json_encode($response);
	}
	
	function returnOK($response){
		$this->returnJSON($response);
	}
	
	function returnError($response){
		$this->returnJSON($response, 500);
	}
	
	function saveNextRequest(){
		$this->session->set_userdata('nextRequest', json_encode($this->nextRequest));
		$this->returnJSON("ok");	
	}
	
	function getSiteUrl(){
		$this->returnJSON(site_url());
	}
	
	function array_to_object($array){
		$object = new stdClass();
		foreach ($array as $key => $value){
			if($key != '$$hashKey')
				if(is_object($value))
					$object->$key = $this->array_to_object($value);
				else
					$object->$key = $value;
		}
		return $object;
	}
	
}
