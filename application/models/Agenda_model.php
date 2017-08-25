<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

 	public function Add($tabChamps){      
  		$this->db->insert('Agenda',$tabChamps);
	}

	public function getListByUser($id_user = NULL){

		$this->db->select("*");
		$this->db->from("Agenda");

		if($id_user != NULL){
			$this->db->where("id_utilisateur", $id_user);
		} elseif($this->session->userdata("Login")["id_utilisateur"]) {
			$this->db->where("id_utilisateur", $this->session->userdata("Login")["id_utilisateur"]);
		} else return NULL;

		$this->db->order_by("id_agenda", "ASC");

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getByUser($id_agenda = NULL, $id_user = NULL){

		$this->db->select("*");
		$this->db->from("Agenda");

		if($id_agenda != NULL){
			$this->db->where("id_agenda", $id_agenda);
		} elseif($this->session->userdata("Agenda")["id_agenda"] != NULL) {
			$this->db->where("id_agenda", $this->session->userdata("Agenda")["id_agenda"]);
		}

		if($id_user != NULL){
			$this->db->where("id_utilisateur", $id_user);
		} elseif($this->session->userdata("Login")["id_utilisateur"]) {
			$this->db->where("id_utilisateur", $this->session->userdata("Login")["id_utilisateur"]);
		}

		$this->db->order_by("id_agenda", "ASC");
		$this->db->limit(1);

		$query = $this->db->get();

		return $query->row_array();
	}

	public function delete($id_agenda = NULL, $id_utilisateur = NULL){

		if($id_agenda != NULL){
			$this->db->where('id_agenda', $id_agenda);
		}

		if($id_user != NULL){
			$this->db->where('id_utilisateur', $id_utilisateur);
		}

		if($id_agenda != NULL || $id_user != NULL){
			$this->db->delete('Agenda');
		}

	}


}