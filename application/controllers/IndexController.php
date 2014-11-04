<?php
include 'application/controllers/BaseController.php';
include 'application/controllers/simple_html_dom.php';
		
class IndexController extends BaseController{
	function __construct(){
		parent::__construct();	
	}
	
	function index(){
		$this->load->view('index');	
	}
	

	function GetHistorico(){
		$aluno = $this->request->aluno;
		
		//TODO: $historico = pegar e stripar historico do matriculaweb
		$historico=new stdClass();	
		$semestres = array();
		
		//$json = '{"semestres":[{"materias":[{"cod": 1, "orig": "Computação Básica", "nota": "MS"},{"cod": 5, "orig": "Organização e Arquitetura de Computadores", "nota": "MS"},{"cod": 2, "orig": "Cálculo 1","nota": "MS"},{"cod": 3, "orig": "Variável Complexa 1", "nota":"SS"}]},{"materias": [{"cod": 1, "orig": "Computação Básica","nota": "MS"},{"cod": 2, "orig": "Cálculo 1", "nota": "MS"},{"cod": 3, "orig": "Variável Complexa 1","nota": "MS"}]}]}';
		$historico = $this->get_historico_aluno($aluno->matricula, $aluno->senha);
		
		$this->returnOK($historico);
	}
	
	/*
	 * Descrição da estrutura do objeto "$historico"
	
	 -historico
	 -aluno_nome
	 -curso
	 -habilitacao
	 -grau
	 -ingresso_na_unb
	 -forma_de_ingresso
	 -decreto
	 -matricula
	 -data_emissao
	 -aluno_pai
	 -aluno_mae
	 -dt_nascimento
	 -pais_nascimento
	 -cred_exigidos
	 -cred_obtidos
	 -cred_obter
	 -semestres
	 {
	 -periodo
	 -materias
	 {
	 -cod
	 -nome
	 -mencao
	 -area_con_obr
	 -area_con_opt
	 -dom_con_obr
	 -dom_con_opt
	 -mod_livre
	 -outros
	 }
	 }
	
	 */
	function get_historico_aluno($matricula, $senha) {
	
		//$matricula = "090012020";
		//$senha = "yoys8875";
	
		$url="https://wwwsec.serverweb.unb.br/matriculaweb/graduacao/sec/login.aspx";
		$url_historico = "https://wwwsec.serverweb.unb.br/matriculaweb/graduacao/sec/he.aspx";
		$cookie="cookie.txt";
	
		$postdata = "inputMatricula=".$matricula."&inputSenha=".$senha;
	
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt ($ch, CURLOPT_REFERER, $url);
	
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt ($ch, CURLOPT_POST, 1);
		$result = curl_exec ($ch);
	
	
		curl_setopt ($ch, CURLOPT_URL, $url_historico);
		curl_setopt ($ch, CURLOPT_POST, 0);
		$result = curl_exec ($ch);
	
		////echo $result;
		curl_close($ch);
	
	
	
		$dom = new simple_html_dom();
		$dom->load($result);
	
	
	
		//$dom = file_get_html('c:/users/fernando/desktop/mw.html');
	
		$historico = new stdClass();
		$historico->semestres = array();
	
		//echo "---";
		//echo $dom->find("//span[id='alunome']")[0];
		$historico->aluno_nome = $dom->find("//span[id='alunome']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='curdenominacao']")[0];
		$historico->curso = $dom->find("//span[id='curdenominacao']")[0];
	
	
		//echo "---";
		//echo $dom->find("//span[id='opcdenominacao']")[0];
		$historico->habilitacao = $dom->find("//span[id='opcdenominacao']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='opcgrau']")[0];
		$historico->grau = $dom->find("//span[id='opcgrau']")[0];
	
	
		//echo "---";
		//echo $dom->find("//span[id='dadperingunb']")[0];
		$historico->ingresso_na_unb = $dom->find("//span[id='dadperingunb']")[0];
	
	
		//echo "---";
		//echo $dom->find("//span[id='dadforingunb']")[0];
		$historico->forma_de_ingresso = $dom->find("//span[id='dadforingunb']")[0];
	
	
	
		//echo "---";
		//echo $dom->find("//span[id='opcnroresolucao']")[0];
		$historico->decreto = $dom->find("//span[id='opcnroresolucao']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='alumatricula']")[0];
		$historico->matricula = $dom->find("//span[id='alumatricula']")[0];
	
	
		//echo "---";
		//echo $dom->find("//span[id='dataemissao']")[0];
		$historico->data_emissao = $dom->find("//span[id='dataemissao']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='alupai']")[0];
		$historico->aluno_pai = $dom->find("//span[id='alupai']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='alumae']")[0];
		$historico->aluno_mae = $dom->find("//span[id='alumae']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='aludtnasc']")[0];
		$historico->dt_nascimento = $dom->find("//span[id='aludtnasc']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='alupaisnasc']")[0];
		$historico->pais_nascimento = $dom->find("//span[id='alupaisnasc']")[0];
	
	
		//echo "---";
		//echo $dom->find("//span[id='OpcCredFormat']")[0];
		$historico->cred_exigidos = $dom->find("//span[id='OpcCredFormat']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='CredCurObtido']")[0];
		$historico->cred_obtidos = $dom->find("//span[id='CredCurObtido']")[0];
	
		//echo "---";
		//echo $dom->find("//span[id='CredCurObter']")[0];
		$historico->cred_obter = $dom->find("//span[id='CredCurObter']")[0];
	
	
	
		$linhas = $dom->find("//tr");
		$iniciou_semestre = false;
		foreach($linhas as $linha) {
			//echo "<div>";
	
			$materias = new stdClass();
			$periodo = "";
			//Significa que é uma linha de materia
			if (count($linha->children) == 9 and $iniciou_semestre == true) {
				//echo $linha->children[0]->innertext;
				$materias->cod = $linha->children[0]->innertext;
				//echo " --- ";
				//echo $linha->children[1]->children[0]->innertext;
				$materias->nome = $linha->children[1]->children[0]->innertext;
				//echo " --- ";
				//echo $linha->children[2]->children[0]->innertext;
				$materias->mencao = $linha->children[2]->children[0]->innertext;
				//echo " --- ";
				//echo $linha->children[3]->innertext;
				$materias->area_con_obr = $linha->children[3]->innertext;
				//echo " --- ";
				//echo $linha->children[4]->innertext;
				$materias->area_con_opt =$linha->children[4]->innertext;
				//echo " --- ";
				//echo $linha->children[5]->children[0]->innertext;
				$materias->dom_con_obr = $linha->children[5]->children[0]->innertext;
				//echo " --- ";
				//echo $linha->children[6]->innertext;
				$materias->dom_con_opt = $linha->children[6]->innertext;
				//echo " --- ";
				//echo $linha->children[7]->innertext;
				$materias->mod_livre = $linha->children[7]->innertext;
				//echo " --- ";
				//echo $linha->children[8]->innertext;
				$materias->outros = $linha->children[8]->innertext;
	
				$semestre = new stdClass();
				$semestre->materias = $materias;
				$semestre->periodo = $periodo;
	
				$historico->semestres[] = $semestre;
			}
	
			//Significa que é uma linha de inicio de semestre
			if (preg_match('/Per.*odo:/', $linha->innertext)) {
				$iniciou_semestre = true;
				//echo $linha->children[0]->children[0]->innertext;
				$periodo = $linha->children[0]->children[0]->innertext;
			}
			//echo "</div>";
		}
	
	
		return $historico;
	}
}