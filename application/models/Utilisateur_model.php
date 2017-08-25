<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur_model extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function Add($email, $password, $surnom){
		$data = array(
			'email'		=> $email,
			'pwd'		=> $password,
			'surnom'	=> $surnom
		);

		$this->db->insert('Utilisateur',$data);
		$id_utilisateur = $this->db->insert_id();

		//Ajout d'un agenda par défaut
		$this->load->model("Agenda_model");
		$champsAgenda = array("nom"=>"Mon Agenda",
            "description"=>"mon Agenda",
            "public"=>"0",
            "id_utilisateur"=>$id_utilisateur);
		$this->Agenda_model->Add($champsAgenda);
	}
	public  function mailNotExist($mail){
		$this->db->select('email');
		$this->db->from('Utilisateur');
		$this->db->where('email', $mail);

       	$data =$this->db->get();
        return $data->num_rows();
    }

	public function Update($email = NULL, $password = NULL, $surnom = NULL, $old_email = NULL){
		
		if($email != NULL && $password != NULL && $surnom != NULL){

			$data = array(
				'email' 	=> $email,
				'pwd'		=> $password,
				'surnom'	=> $surnom
			);

			$this->db->where('email', $old_email);
			$this->db->update('Utilisateur',$data);

			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function Find_UserByEmail($email){
		
		if($email != NULL){
			$this->db->select('*');
			$this->db->from('Utilisateur');
			$this->db->where('email', $email);
			$data = $this->db->get();
 
			$data =$data->row_array();

			return $data;
		} else {
			return FALSE;
		}
	}

	public function Get_All_User(){

		$sql ="SELECT * FROM Utilisateur U 
				WHERE  U.email<>'".$this->session->userdata('Login')['email']."'"; //lecture email avec la session

		if ($query=$this->db->query($sql))
		{
			return $query->result_array(); 
        }
		else
		{
			return false;
		}
	}

	public function delete_user(){

		if($this->session->userdata("Login")["id_utilisateur"] != NULL){
			$this->db->where('id_utilisateur', $this->session->userdata("Login")["id_utilisateur"]);
			$this->db->delete('Utilisateur');

			$this->db->where('id_utilisateur', $this->session->userdata("Login")["id_utilisateur"]);
			$this->db->delete('Agenda');

			$this->session->unset_userdata('Login');

			return TRUE;
		} else {
			return FALSE;
		}

	}

}