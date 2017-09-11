<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {

	public function __construct(){

		parent::__construct();

		if(!isConnected()){
			redirect_error('/login', 'error_not_connected');
		}
	}

	public function index(){

		$this->load->model('Agenda_model');
        $data['popups'] = array( 1 => $this->load->view('accept_event', null, TRUE) );
		$data["agenda"]=$this->Agenda_model->getListByUser($this->session->Login['id_utilisateur']);
		$this->load->view('templates/header');
		$this->load->view('add_event',$data);
		$this->load->view('templates/footer', $data);
	}

	public function addEvent(){ 

		$id_event = NULL;
		$data = $this->input->post('tab');

		if(isset($data['type_recurrence']) && ($data['type_recurrence']!=null && $data['nb_recurrence']!=null)){
			$id_recurrence=$this->Event_model->add_recurrence($data['nb_recurrence'],$data['type_recurrence']);
			$data['id_recurrence']=$id_recurrence;
			for($i=0; $i<$data['nb_recurrence']-1; $i++){
				if($data['type_recurrence']=='allJours' && $i!=0)//tous les jours
				{
					$data['date_deb'] = strtotime('+1 days', $data['date_deb']); // ajour un jour
					$data['date_fin'] = strtotime('+1 days', $data['date_fin']); // ajour un jour

				} else if ($data['type_recurrence']=='Semaine' && $i!=0)//toutes les semaines
				{
					$data['date_deb'] = strtotime('+7 days', $data['date_deb']); // ajour un semaine
					$data['date_fin'] = strtotime('+7 days', $data['date_fin']); // ajour un semaine

				}else if($data['type_recurrence']=='Mois' && $i!=0){//tous les mois{
					$data['date_deb'] = strtotime('+1 month', $data['date_deb']); // ajour un semaine
					$data['date_fin'] = strtotime('+1 month', $data['date_fin']); // ajour un semaine
				}
				$id_event = $this->Event_model->Add($data);
			}
		} else {
			$id_event = $this->Event_model->Add($data);
		}

		echo json_encode(array('id_event' => $id_event));
		return $id_event;
	}

	public function editEvent(){
		
		$data = $this->input->post('tab');
		$this->Event_model->Update($data);
	}

    public function getEvent(){
        echo json_encode($this->Event_model->get($this->input->post_get('id_event')));
    }

    public function getEventByNom(){
    	if($this->input->post_get('event_nom')){
        	echo json_encode($this->Event_model->getByNom($this->input->post_get('event_nom')));
        	//var_dump($this->Event_model->getByNom($this->input->post_get('event_nom')));
    	}
    }

    public function acceptEvent(){
        $event_id = $this->input->post('id_event');
        $evenement = $this->Event_model->acceptEvent($event_id);
        echo json_encode($evenement);
    }

    public function refuseEvent(){
        $event_id = $this->input->post('id_event');
        $evenement = $this->Event_model->refuseEvent($event_id);
    }

    public function deleteEvent(){
        $event_id = $this->input->post('id_event');
        $evenement = $this->Event_model->delete($event_id);
    }

	public function chercheSimilaire(){
		$titre = $this->input->post('titre');
		if($titre){
			$iaDetected = $this->Event_model->rechercheSimilaire($titre);
		}
		echo json_encode($iaDetected);
	}
}
