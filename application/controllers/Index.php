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
		$datas['events'] = [];
		$j = 0;
		$c = array(
             '0' => 'red',
             '1' => 'blue',
             '2' => 'green',
             '3' => 'yellow'
 		);
 		$datas['color'] = $c;

		$datas['agendas'] = $this->Agenda_model->getListByUser($this->session->Login['id_utilisateur']);
		for($i=0;$i<count($datas['agendas']); $i++)
		{
			$events = $this->Event_model->getByUser($datas['agendas'][$i]['id_agenda']);

			//Convertion des champs de la BDD vers les champs attendus par le plugin JS
			foreach ($events as $event) {
				if(date('H:i:s', $event['date_deb'])=="00:00:00"){
					$datas['events'][$j]['id'] 			= $event['id_evenement'];
					$datas['events'][$j]['id_agenda'] 	= $event['id_agenda'];
					$datas['events'][$j]['title'] 		= $event['nom_evenement'];
					$datas['events'][$j]['start']		= date('Y-m-d', $event['date_deb']);
					$datas['events'][$j]['end']			= date('Y-m-d', $event['date_fin']);
					$datas['events'][$j]['allDay']		= true;
					$datas['events'][$j]['backgroundColor'] = $c[$i];
					$datas['events'][$j]['borderColor'] = $c[$i];
				}else{
					$datas['events'][$j]['id'] 			= $event['id_evenement'];
					$datas['events'][$j]['id_agenda'] 	= $event['id_agenda'];
					$datas['events'][$j]['title'] 		= $event['nom_evenement'];
					$datas['events'][$j]['start']		= date('Y-m-d', $event['date_deb']);
					$datas['events'][$j]['end']			= date('Y-m-d', $event['date_fin']);
					$datas['events'][$j]['start']		.= 'T'.date('H:i:s', $event['date_deb']);
					$datas['events'][$j]['end']			.= 'T'.date('H:i:s', $event['date_fin']);
					$datas['events'][$j]['backgroundColor'] = $c[$i];
					$datas['events'][$j]['borderColor'] = $c[$i];
				}
				$j++;
			}
		}

		$datas['events'] 		= json_encode($datas['events']);
		$datas['nb_agendas'] 	= count($datas['agendas']);

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

	public function setAgendaAfficher(){
		if($this->input->post_get('id_agenda') != NULL && $this->input->post_get('affiche') != NULL){
			$id_agenda=$this->input->post_get('id_agenda');
			$affiche=$this->input->post_get('affiche');
			$this->Agenda_model->setAfficher($id_agenda, $affiche);
			
			return TRUE;
		} else return NULL;
	}

}
