<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TODO extends CI_Controller {

	//Controlleur gérant la connexion au dashboard

	public function __construct(){

		parent::__construct();
 
		if(!isConnected()){
			redirect_error('/login', 'error_not_connected');
		}

		$this->load->model('Todo_model');

	}

	public function index(){
		

		$datas['todo']=$this->Todo_model->Get_All_Todo();
		$datas['popups'] = array( 
			1 => $this->load->view('add_event', $datas, TRUE),
			2 => $this->load->view('accept_todo', $datas, TRUE) 
		);

		$this->load->view('templates/header');
		$this->load->view('add_todo',$datas);
		$this->load->view('templates/footer',$datas);

	}

	public function add_todo(){

		if ($this->input->post('todo_name') && $this->input->post('todo_description')){
			$todo_name = $this->input->post('todo_name');
			$todo_description = $this->input->post('todo_description');

			$data_return=$this->Todo_model->add_todo($todo_name, $todo_description, 0);

			$return = $data_return['id_todo'].'_'.$data_return['id_element_todo'];
			echo $return;

			return TRUE;
		
		} else {
			echo 'nok';
			return FALSE;
		}

	}

	public function update_todo(){

		if ($this->input->post('todo_name') && $this->input->post('todo_description') && $this->input->post('id_element_todo')){

			$todo_name 			= $this->input->post('todo_name');
			$todo_description 	= $this->input->post('todo_description');
			$id_element_todo 	= $this->input->post('id_element_todo');

			$this->Todo_model->update_todo($todo_name, $todo_description, $id_element_todo);

			return TRUE;
		
		} else {
			echo 'nok';
			return FALSE;
		}

	}

	public function delete_todo(){
		if ($this->input->post('id_todo') && $this->input->post('id_element_todo')){
			$id_todo = $this->input->post('id_todo');
			$id_element_todo = $this->input->post('id_element_todo');

			$this->Todo_model->Delete_Todo($id_element_todo, $id_todo);

			return TRUE;
		
		} else {
			echo 'nok';
			return FALSE;
		}

	}

	public function valide_todo(){

		if ($this->input->post('todo_valide') != NULL && $this->input->post('id_element_todo')){

			$valide 			= $this->input->post('todo_valide');
			$id_element_todo 	= $this->input->post('id_element_todo');

			$this->Todo_model->Valide_Todo($valide, $id_element_todo);

			return TRUE;
		
		} else {
			echo 'nok';
			return FALSE;
		}

	}

	public function favori_todo(){

		if ($this->input->post('todo_favori') != NULL && $this->input->post('id_todo')){

			$favori 	= $this->input->post('todo_favori');
			$id_todo 	= $this->input->post('id_todo');

			$this->Todo_model->Favori_Todo($favori, $id_todo);

			return TRUE;
		
		} else {
			echo 'nok';
			return FALSE;
		}

	}

	public function chercheSimilaire(){
		if($this->input->post('name')){
			$name = $this->input->post('name');
			$iaDetected = $this->Todo_model->rechercheSimilaire($name);
			if($iaDetected != null){
				$return = $iaDetected['score'].'_'.$iaDetected['id_element_todo'].'_'.$iaDetected['titre'].'_'.$iaDetected['description'];
				echo $return;
			} else {
				echo 'nok';
			}
		} else {
			echo 'nok';
		}
	}

	public function Update_ia_todo(){
		if($this->input->post('id_element_todo')){
			$id_element_todo 	= $this->input->post('id_element_todo');
			$accept 			= $this->input->post('accept');

			$this->Todo_model->Update_ia_todo($id_element_todo, $accept);

			return TRUE;
		} else {
			echo 'nok';
			return FALSE;
		}
	}

}