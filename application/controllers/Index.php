<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct(){

		parent::__construct();

		if(!isConnected() && ($this->uri->segment(1) != 'index' &&  $this->uri->segment(2) != '') && $this->uri->segment(2) != 'index' && $this->uri->segment(2) != 'verificationNotifications'){
			redirect_error('/login', 'error_not_connected');
		}
	}

	public function index()
	{

		if(isConnected()){
			redirect('index/agenda');
		}

		$datas = NULL;
    
		$data = array(

			'notification' 	=> verificationNotifications($this->session->flashdata('notification')), //Gestion des notifications

			'links_ariane' 	=> array(
				//array('link' => 'index', 'title' => 'Mon Agenda')
			),

			'popups' 		=> array( 
			),

			'datas' 		=> ''

		);

		$this->load->view('templates/header', $data);
		$this->load->view('index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function agenda(){

		date_default_timezone_set('Europe/Paris');

		$events = $this->Event_model->getByUser();

		$datas['events'] = [];
		$i = 0;
		//Convertion des champs de la BDD vers les champs attendus par le plugin JS
		foreach ($events as $event) {
			$datas['events'][$i]['id'] 		= $event['id_evenement'];
			$datas['events'][$i]['title'] 	= $event['nom_evenement'];
			$datas['events'][$i]['start']	= date('Y-m-d', $event['date_deb']);
			$datas['events'][$i]['end']		= date('Y-m-d', $event['date_fin']);
			$datas['events'][$i]['start']	.= 'T'.date('H:i:s', $event['date_deb']);
			$datas['events'][$i]['end']		.= 'T'.date('H:i:s', $event['date_fin']);
			$i++;
		}

		$datas['events'] = json_encode($datas['events']);
		$datas['agendas'] = $this->Agenda_model->getListByUser($this->session->Login['id_utilisateur']);

		$data = array(

			'notification' 	=> verificationNotifications($this->session->flashdata('notification')), //Gestion des notifications

			'links_ariane' 	=> array(
				array('link' => 'index', 'title' => 'Mon Agenda')
			),

			'popups' 		=> array( 
				1 => $this->load->view('add_event', $datas, TRUE),
				2 => $this->load->view('accept_event', $datas, TRUE),
				3 => $this->load->view('accept_todo', $datas, TRUE)
			),

			'datas' 		=> $datas

		);

		$this->load->view('templates/header', $data);
		$this->load->view('agenda', $data);
		$this->load->view('templates/footer', $data);
	}

	public function addAgenda(){
		$notif = NULL;

		if($this->input->post('datas') != NULL){

			$params = array();
			parse_str($this->input->post_get('datas'), $params);
			$params['id_utilisateur'] = $this->session->userdata("Login")["id_utilisateur"];

			$this->Agenda_model->Add($params);
			return TRUE;
		} else return NULL;
	}

	public function changeAgenda(){

		if($this->input->post_get('id_agenda') != NULL){

			$this->session->set_userdata('Agenda', $this->Agenda_model->getByUser($this->input->post_get('id_agenda')));
			return TRUE;
		} else return NULL;
	}

	//Permet la vérification des notifications en AJAX
	public function verificationNotifications(){
		$notif = verificationNotifications($this->input->post_get('erreur'));
		echo $notif;
	}

}
