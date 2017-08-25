<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_model extends CI_Model {

	public function __construct(){

		parent::__construct();

	} 

	public function Get_All_Todo(){

		$sql="SELECT *, C.id_todo AS id_todo, case when FT.id_todo is null then 0 else 1 end as favori FROM contenir C , element_todo ET,todo T Left JOIN favoris_todo FT ON (FT.id_todo=T.id_todo) WHERE (C.id_todo=T.id_todo) AND (ET.id_element_todo=C.id_element_todo) and T.id_utilisateur =".$this->session->userdata('Login')['id_utilisateur']." ORDER BY favori DESC, ET.id_element_todo DESC, valide ASC";


		if ($query=$this->db->query($sql)){
			return $query->result_array(); 
		} else {
			return false;
		}

	}

	public function Add_Todo($nom, $description, $valide){
		//select le max ID pour savoir l'id de l'element_todo crée
		$this->db->select_max('id_element_todo');
		$this->db->from('element_todo');
		$data_element = $this->db->get();
		$data_element = $data_element->row();

		if($nom != NULL && $data_element != NULL && $description!=NULL)
		{
			$data_element = array(
			'id_element_todo' 	=> $data_element->id_element_todo+1,
			'titre'				=> $nom,
			'description' 		=> $description
		);

			$this->db->insert('element_todo',$data_element);
		}

		$this->db->select_max('id_todo');
		$this->db->from('todo');
		$data = $this->db->get();
		$data = $data->row();
		
		if($nom != NULL && $data != NULL)
		{
			$data = array(
			'id_todo'			=> $data->id_todo+1,
			'id_utilisateur'	=> $this->session->userdata('Login')['id_utilisateur']
		);

			$this->db->insert('todo',$data);
		}

		$data_contenir = array(
			'valide'			=> $valide,
			'id_todo' 			=> $data['id_todo'],
			'id_element_todo' 	=> $data_element['id_element_todo']
		);

		$this->db->insert('contenir',$data_contenir);

		$data_return = array(
			'id_todo' 			=> $data['id_todo'],
			'id_element_todo' 	=> $data_element['id_element_todo']
		);

		return $data_return;

	}

	public function Update_Todo($nom, $description, $id_element_todo){
		$data = array(
		'titre' => $nom,
		'description'  => $description
		);

		$this->db->set($data);
		$this->db->where('id_element_todo', $id_element_todo);
		$this->db->update('element_todo');
	}

	public function Delete_Todo($id_element_todo, $id_todo){
		$this->db->delete('contenir', array("id_todo"=>$id_todo,"id_element_todo"=>$id_element_todo));

		$this->db->where('id_todo', $id_todo);
		$this->db->delete('todo');
	}

	public function Valide_Todo($valide, $id_element_todo){

		$data = array(
			'valide' => $valide
		);
		$this->db->set($data);
		$this->db->where('id_element_todo', $id_element_todo);
		$this->db->update('contenir');

	}

	public function Favori_Todo($favori, $id_todo){

		if($favori == 1){

			$data = array(
				'id_todo'		 => $id_todo,
				'id_utilisateur' => $this->session->userdata('Login')['id_utilisateur']
			);
			$this->db->insert('favoris_todo',$data);

		} else {
			$this->db->where('id_utilisateur', $this->session->userdata('Login')['id_utilisateur']);
			$this->db->where('id_todo', $id_todo);
			$this->db->delete('favoris_todo');
		}

	}

	public function rechercheSimilaire($name = NULL){
		//recherche des evenement potentiellement recherchble
		$dateDuJour = new DateTime();

		//oné recupère tout les ia todos
		$sql = "SELECT * FROM proposition_element_todo_ia iaET, element_todo ET WHERE ET.id_element_todo=iaET.id_element_todo AND id_utilisateur=".$this->session->userdata("Login")["id_utilisateur"]." AND date_proposition < ".$dateDuJour->getTimestamp();
		$query = $this->db->query($sql);
		$todos = $query->result_array();
	   
		$iaDetected = null;
		//si rien dans la table ia_element_todo
		if($todos!=null){
			//pour tous les évenements potentiel
			foreach ($todos as $todo){

				if($todo['accepte'] != 0 && (($todo['nb_demande']/$todo['accepte']) > 0.3 || $todo['date_proposition'] < $dateDuJour->modify('-1 month'))){
					$id_element_todo = $todo['id_element_todo'];
					//on check le nom si il y a une correspondance
					$sql = "SELECT `smart-agenda`.ressemble((SELECT titre FROM element_todo WHERE id_element_todo = ".$id_element_todo."),'".$name."') as score";
					$query = ($this->db->query($sql));
					$result = $query->result();
					if(count($result)<=1) {
						if($result[0]->score>30) {
							$iaDetected['score'] 			= $result[0]->score;
							$iaDetected['id_element_todo'] 	= $todo['id_element_todo'];
							$iaDetected['titre'] 			= $todo['titre'];
							$iaDetected['description'] 		=  $todo['description'];
						}
					} else {
						$sql="SELECT ET.*, T.* FROM element_todo ET, todo T, contenir C WHERE C.id_todo=T.id_todo AND C.id_element_todo=ET.id_element_todo AND T.id_utilisateur=".$this->session->userdata("Login")["id_utilisateur"]." AND ET.Titre LIKE '".$name."%'";
						$query = ($this->db->query($sql));
						$todos = $query->result_array();

						foreach ($todos as $todo){
						$id_element_todo = $todo['id_element_todo'];
						//on check le nom
						$sql = "SELECT ressemble((SELECT titre FROM element_todo WHERE id_element_todo = ".$id_element_todo."),'".$name."') as score";
						$query = $this->db->query($sql);
						$result = $query->result();
							if(count($result)<=1) {
								if($result[0]->score>30) {
									$iaDetected['score'] 			= ($result[0]->score);
									$iaDetected['id_element_todo'] 	= $todo['id_element_todo'];
									$iaDetected['titre'] 			= $todo['titre'];
									$iaDetected['description'] 		= $todo['description'];
								}
								$this->Insert_ia_todo($id_element_todo);
							}
						}	
					}
				}
			}	
			return $iaDetected;
		} 
	}
	public function Insert_ia_todo($id_element_todo){
		$dateDuJour = new DateTime();
		$data = array(
				'nb_demande'		=> '1',
				'accepte'		 	=> '1',
				'id_utilisateur'	=> $this->session->userdata('Login')['id_utilisateur'],
				'id_element_todo'	=> $id_element_todo,
				'date_proposition'  => $dateDuJour->getTimestamp()
			);
		$this->db->insert('proposition_element_todo_ia', $data);
	}

	public function Update_ia_todo($id_element_todo, $accept){
		$dateDuJour = new DateTime();
		if($accept == 1){
			$data = array(
				'accepte'		 	=> 'accepte+1',
				'date_proposition'  => $dateDuJour->getTimestamp()
			);
		} else {
			$data = array(
				'date_proposition'  => $dateDuJour->getTimestamp()
			);
		}
		$this->db->set('nb_demande', 'nb_demande + 1', FALSE);

		$this->db->set($data);
		$this->db->where('id_element_todo', $id_element_todo);
		$this->db->where('id_utilisateur', $this->session->userdata('Login')['id_utilisateur']);
		$this->db->update('proposition_element_todo_ia');

	}
}