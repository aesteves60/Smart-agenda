<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account extends CI_Controller {

	//Controlleur gérant la connexion au dashboard
	public $data;

	public function __construct(){

		parent::__construct();

		if(!isConnected() && $this->uri->segment(2) != 'inscription' && $this->uri->segment(2) != 'mailNotExist'){
			redirect_error('/login', 'error_not_connected');
		}

		$this->data = array(
			'notification' 	=> verificationNotifications($this->session->flashdata('notification')), //Gestion des notifications
			'user'			=> $this->session->userdata('Login'),

			'popups' 		=> array( 1 => $this->load->view('add_event', NULL, TRUE) ),

		); 

	}
	public function index(){
				
	}
	public function inscription(){


		if ($this->input->post('mail') && $this->input->post('password') && $this->input->post('surname')){
			
			$this->load->model('Utilisateur_model');

			$email = $this->input->post('mail');

			if(verifierAdresseMail($email) === TRUE){

				$password 	= $this->input->post('password');
				$password 	= hash('sha256', $this->config->item('password_key').$password);

				$this->Utilisateur_model->Add($email,$password,$this->input->post('surname'));
				echo'ok';
			} else {
				redirect_error('Account/inscription', 'error_email_address');
			}

			
		} else {

			$this->load->view('templates/header', $this->data);
			$this->load->view('inscription', $this->data);
			$this->load->view('templates/footer', $this->data);	
		}
	}
    public function mailNotExist(){
    	if($this->input->post('mail')){
        	$this->load->model('Utilisateur_model');
        	$mail = $this->input->post('mail');
       		echo ($this->Utilisateur_model->mailNotExist($mail));
       	}
    }
	
	public function modif_user(){

		if ($this->input->post('email_modif') && $this->input->post('surnom_modif') && $this->input->post('password_modif')) {

			$email_modif = $this->input->post('email_modif');

			if(verifierAdresseMail($email_modif) === TRUE){

				$surnom_modif	= $this->input->post('surnom_modif');
				$password 		= $this->input->post('password_modif');
				$password_modif = hash('sha256', $this->config->item('password_key').$password);

				$this->load->model('Utilisateur_model');

				if($this->Utilisateur_model->Update($email_modif, $password_modif, $surnom_modif, $this->data['user']['email']))
				{
					//TODO bug modif une fois tu peux plus modifier
					$newdata = array(
						'id_utilisateur' => $this->session->userdata('Login')['id_utilisateur'],
						'email'  	=> $email_modif,
						'password'	=> $password_modif,
						'surnom'	=> $surnom_modif
					);

					$this->session->set_userdata('Login', $newdata);
					$this->data['user'] = $newdata;

				} else {
					echo ('Modifcation NOK1');
					echo ($email_modif);
					echo ($this->data['user']['email']);
				}

			} else {
				echo ('Modifcation NOK2');
			}
		} else {
			$this->load->view('templates/header', $this->data);
			$this->load->view('modif_user', $this->data);
			$this->load->view('templates/footer', $this->data);
		}

	}

	public function choix_group(){

		$this->load->model('Group_model'); 


		//est ce que je casse tout la ? 
		$this->data['groupes'] = $this->Group_model->Get_Group_User();

		$this->load->view('templates/header', $this->data);
		$this->load->view('choix_group', $this->data);
		$this->load->view('templates/footer', $this->data);
	}

	public function modif_group(){
		
		if ($this->input->post('id_groupe') != NULL) {
			$this->load->model('Group_model');
			$this->load->model('Utilisateur_model');


			$idGroupSelect = $this->input->post('id_groupe'); 
			$UsersGroup=$this->Group_model->Get_UserOfGroup($idGroupSelect);
			$data = array(
				'id_group'		=> $idGroupSelect,
				'UsersGroup' 	=> $UsersGroup,
				'UsersNotGroup' => $this->Utilisateur_model->Get_All_User()
			);	

			$this->load->view('templates/header');
			$this->load->view('modif_group', $data);
			$this->load->view('templates/footer');
		}		
	}

	public function delete_group(){

		$this->load->model('Group_model'); 

		if ($this->input->post('id_groupe')) {
			$id_groupe = $this->input->post('id_groupe');
			if($this->Group_model->delete_group($id_groupe)){
				redirect_error('Account/choix_group', 'good_delete_group');	
			}
		}

	}

	public function modif_groupFamille(){

		$this->load->model('Group_model');
		$this->load->model('Utilisateur_model');


		$groupFamille=$this->Group_model->Get_Group_Famille();

		$UsersGroup=$this->Group_model->Get_UserOfGroup($groupFamille[0]['id_groupe']);
		$data = array(
				'id_group'		=> $groupFamille[0]['id_groupe'],
				'UsersGroup' 	=> $UsersGroup,
				'UsersNotGroup' => $this->Utilisateur_model->Get_All_User()
			);	

			$this->load->view('templates/header', $data);
			$this->load->view('modif_groupSelect', $data);
			$this->load->view('templates/footer', $data);
	}


	public function valid_modifGroup()
	{	
		//seulement quand validation 
		if ($this->input->post('utilisateurSelect') != NULL && $this->input->post('id_groupeSelect') != NULL) {
			$utilisateurSelect=$this->input->post('utilisateurSelect');
			$id_groupeSelect=$this->input->post('id_groupeSelect');

			$this->load->model('Utilisateur_model');
			$this->load->model('Group_model');
			$this->Group_model->Delete_User_Group($id_groupeSelect);

			for ($i=0;$i<count($utilisateurSelect); $i++)
			{
				//$this->Group_model->Add_User_Group(,$id_groupeSelect)
				$user=$this->Utilisateur_model->Find_UserByEmail($utilisateurSelect[$i]);
				$this->Group_model->Add_User_Group($user['id_utilisateur'],$id_groupeSelect);
			}					
		}
	}

	public function add_group(){
		$this->load->model('Utilisateur_model');
		$this->load->model('Group_model');

		if ($this->input->post('group_name') && $this->input->post('utilisateurSelect')){
			$nom_group			= $this->input->post('group_name'); 
			$utilisateurSelect	= $this->input->post('utilisateurSelect');
			$famille 			= $this->input->post('famille');

			$id_group=$this->Group_model->Add_Group($nom_group,$famille);

			for($i = 0 ; $i < count($utilisateurSelect); $i++)
			{
				$user = $this->Utilisateur_model->Find_UserByEmail($utilisateurSelect[$i]);
				$this->Group_model->Add_User_Group($user['id_utilisateur'],$id_group);
			}
			//TODO comment retourné a l'index en load les view ? 
		}else{
			//prise de toute les utilisateur appartenant a un groupe dans lequel d'appartient
			$data['users'] = $this->Utilisateur_model->Get_All_User();

			if ($data == NULL) 
			{
				redirect_error('Account/add_group', 'error_connection');
			}
			else {
				$this->load->view('templates/header', $data);
				$this->load->view('add_group', $data);
				$this->load->view('templates/footer', $data);
			}
		}
	}


	public function delete_user(){
		$this->load->model('Utilisateur_Model');
		if($this->Utilisateur_Model->delete_user())
			redirect_error('Index/index', 'good_delete_user');
	}
}
?>