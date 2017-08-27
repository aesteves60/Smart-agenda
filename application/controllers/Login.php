<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	//Controlleur gérant la connexion au dashboard

	public function __construct(){

		parent::__construct();

	}

	public function index(){
		if ($this->input->post('mail') && $this->input->post('password')) {

			$email		= $this->input->post('mail');
			$password 	= $this->input->post('password');
			$password 	= hash('sha256', $this->config->item('password_key').$password);
			
			$this->db->select('*');
			$this->db->from('utilisateur');
			$this->db->where('email', $email);
			//$this->db->where('pwd', $password);
			$data = $this->db->get();

			if ($data->result() == NULL)
				redirect_error('login/index', 'error_connection');
			else {

				//Enregistrement des infos en session
				$this->session->set_userdata('Login', $data->row_array());

				//Enregistrement de l'agenda de base en session
				$this->load->model("Agenda_model");
				$this->session->set_userdata("Agenda", $this->Agenda_model->getByUser());

				//Si url défini pour la redirection après le login
				if($this->input->get('url') != NULL){
					redirect_error(urldecode($this->input->get('url')), 'good_connection');
				} else {
					redirect_error('index', 'good_connection');
				}
			}

		} else {
			$data = array(
				'notification' 	=> verificationNotifications($this->session->flashdata('notification')), //Gestion des notifications
				'datas' 		=> ''
			);

			$this->load->view('templates/header', $data);
			$this->load->view('login', $data);
			$this->load->view('templates/footer');

		}

	}

	public function disconnect(){

		$this->session->unset_userdata('Login');
		redirect_error('login/index', 'good_deconnection');

	}
	
}
