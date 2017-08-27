<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

	public function __construct(){

		parent::__construct();

	}
 
	public function Get_Group_User(){

		$sql ="SELECT G.* FROM Utilisateur U, Groupe G, appartenir A 
				WHERE U.id_utilisateur = A.id_utilisateur 
				AND G.id_groupe= A.id_groupe 
				AND U.email='".$this->session->userdata('Login')['email']."'"; //lecture email avec la session

		if ($query=$this->db->query($sql))
		{
			return $query->result_array(); 
        }
		else
		{
			return false;
		}
	}

	public function Get_Group_Famille(){
		$sql ="SELECT G.* FROM Utilisateur U, Groupe G, appartenir A 
				WHERE U.id_utilisateur = A.id_utilisateur 
				AND G.id_groupe= A.id_groupe 
				AND U.email='".$this->session->userdata('Login')['email']."'
				AND G.id_Famille = 1"; //lecture email avec la session

		if ($query=$this->db->query($sql))
		{
			return $query->result_array(); 
        }
		else
		{
			return false;
		}
	}

	public function Get_UserOfGroup($id_Groupe){

		$sql ="SELECT U.*, G.* FROM Utilisateur U, Groupe G, appartenir A 
				WHERE U.id_utilisateur = A.id_utilisateur 
				AND G.id_groupe = A.id_groupe 
				AND G.id_groupe ='".$id_Groupe."'"; //lecture email avec la session

		if ($query=$this->db->query($sql))
		{
			return $query->result_array(); 

        }
		else
		{
			return false;
		}

	}

	public function Get_Users_BelongsGroup_User(){

		$sql ="SELECT * FROM Utilisateur U, appartenir A 
			WHERE A.id_Utilisateur=U.id_utilisateur 
			AND A.id_Groupe 
				IN( SELECT G.id_Groupe FROM Utilisateur U, Groupe G, appartenir A 
					WHERE G.id_groupe=A.id_Groupe 
					AND A.id_Utilisateur=U.id_utilisateur 
					AND U.id_Utilisateur='".$this->session->userdata('Login')['id_utilisateur']."') 
				AND U.id_utilisateur<>'".$this->session->userdata('Login')['id_utilisateur']."'	
				GROUP BY email"; //lecture id_ut avec la session
				//exclusion de nous(utilisateur) pour ne pas avoir a filtré plus tard

		if ($query=$this->db->query($sql))
		{
			return $query->result_array();
        }
		else
		{
			return false;
		}
	}

	public function Add_Group($nom, $famille){

		if($nom != NULL && $famille != NULL)
		{
			$data = array(
				'nom'		=> $nom,
				'id_famille' 	=> $famille
			);

			$this->db->insert('Groupe',$data);
			$id_groupe = $this->db->insert_id();
			return $id_groupe;
		}
	}

	public function Add_User_Group($id_utilisateur,$id_groupe){

		$data = array(
			'id_utilisateur' => $id_utilisateur,
			'id_groupe' => $id_groupe
		);
		$this->db->insert('appartenir',$data);
	}

	public function Delete_User_Group($id_groupe){
		$this->db->where('id_groupe', $id_groupe);
		$this->db->delete('appartenir');

	}
}

?>