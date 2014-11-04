<?php	
include 'application/controllers/BaseController.php';
class HistoricoController extends BaseController{
	function index(){
		$this->load->model("Materia");
		$this->load->model("Traducao");
		$data = new stdClass();
		$historico = $this->request;
		
		foreach ($historico->semestres as $semestre){
			foreach ($semestre->materias as $materia){
				$m = new stdClass();
				$m->cod = $materia->cod;
				
				if($mt = $this->Materia->get($m)){
					$mt->trad = new stdClass();
					$mid = new stdClass();
					$mid->materias_id = $mt->id;
				
					$trad = $this->Traducao->get($mid);
					if(is_array($trad))
						$materia->trad = $trad;
					
				}else{
					$m = new stdClass();
					$m->orig = $materia->orig;
					$m->cod = $materia->cod;
					if(!$this->Materia->insert($m)){
						$alert = new stdClass();
						$alert->msg = "A materia não foi inserida corretamente";
						$data->alerts[] = $alert;
					}
					
					$this->TranslateMateria($materia);
				}
			}
		}
		
		$data->historico = $historico;
		
		$this->session->set_userdata('config', json_encode($data));
		$this->load->view('historico');
	}
	
	public function GetHistorico(){
		$response  = new stdClass;
		if(!$config = $this->session->userdata('config')){
			$alert->msg = "Sua sessão expirou";
			$error = "expired_session";
			
			$response->alerts[] = $alert;
			$response->error[] = $error;
			$this->returnError($response);	
		}
		$config = json_decode($config);
		$this->returnOK($config);
		
	}
	
	private function insertTraducoes($materia, $trads, &$error = false){
		$this->load->model('Materia');
		$this->load->model('Traducao');
		
		$m = new stdClass();
		if(!isset($materia->cod))
			return false;
		$m->cod = $materia->cod;	
			
		if(!($m = $this->Materia->get($m)))
			return false;
		
		foreach($trads as $trad){
			if (!is_object($trad))
				$trad = new stdClass();
			$trad->materias_id = $m->id;
			$query = new stdClass();
			$query->materias_id = $m->id;
			
			if(!isset($trad->txt) || $trad->txt == 'NULL')
				return false;
			
			$query->txt = $trad->txt;
			if(!$t = $this->Traducao->get($query))
				return $this->Traducao->insert($m->id, $trad);
			else{
				$t = $t[0];
				$t->choosen++;
				return $this->Traducao->update($t);
			}
			return false;
		}
	}
	
	public function DownloadPDF(){
		$historico = $this->request;
		foreach($historico->semestres as $semestre){
			foreach($semestre->materias as $materia){
				$response = $this->insertTraducoes($materia, $materia->trad);
			}
		}
		
		if($response)
			$this->returnOK($response);
		else
			$this->returnOK($response);
	}
	
	public function TranslateMateria(&$materia){
		$this->load->model('Traducao');
		$this->load->model('Materia');
		$text = $materia->orig;
		//$request = new HTTP_Request2("https://www.googleapis.com/language/translate/v2?key=AIzaSyDmDkz5NwFo9wcR5ZF9Uc8XPNZZt3Su6mA&q=hello%20world&source=pt&target=en", HTTP_Request2::METHOD_GET);
		$ch = curl_init("https://www.googleapis.com/language/translate/v2?key=AIzaSyDmDkz5NwFo9wcR5ZF9Uc8XPNZZt3Su6mA&q=".rawurlencode($text)."&source=pt&target=en");
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// execute the HTTP request
		if (($json = curl_exec($ch)) === FALSE) {
			echo curl_error($ch);
			exit();
		}
		
		$result = json_decode($json);
		//{ "data": { "translations": [ { "translatedText": "horse" } ] } }
		$translated = $result->data->translations[0]->translatedText;
		
		$trad = new stdClass();
		$trad->txt = $translated;
		$trad->type = "gt";
		$trad->choosen = 0;
		$mat = new stdClass();
		$mat->cod = $materia->cod;
		if($mat = $this->Materia->get($mat)){
			$trad->materias_id = $mat->id;
			if($this->Traducao->insert($mat->id, $trad)){
				$trad = $this->Traducao->get($trad);
				$materia->trad[] = $trad;
			}
		}
		
		
	}
	
	
	
}