
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function get($id = NULL){

		if($id != NULL){

			$this->db->from('Evenement E');
			$this->db->where('E.id_evenement', $id);
			$this->db->join('constituer C', 'C.id_evenement = E.id_evenement');
			$query = $this->db->get();

			return $query->row();

		} else return NULL;

	}

 	public function Add($tabChamps){

 		//Récupération id_agenda puis id_evenement pour table "constituer"
 		$id_agenda = $tabChamps['id_agenda'];
 		unset($tabChamps['id_agenda']); //Unset de la ligne car non présente dans table Evenement
        unset($tabChamps['nb_recurrence']);
        unset($tabChamps['type_recurrence']);
        unset($tabChamps['lieu_cp']);
        unset($tabChamps['lieu_ville']);


  		$this->db->insert('Evenement',$tabChamps);
  		$id_evenement = $this->db->insert_id();

  		//On ajoute dans "constituer" le nouvel évènement en fonction de l'agenda.
  		$this->db->insert("constituer", array('id_agenda' => $id_agenda, 'id_evenement' => $id_evenement));

        /*if(isset($tabChamps['id_recurrence'])){
            $this->db->where('id_recurrence', $tabChamps['id_recurrence']);
            $this->db->update('recurrence',array('id_evenement'=>$id_evenement));
        }*/

  		//On ajout la récurrence si besoin
        /*if($tabChamps['reccurence']==1){
            $this->db->insert("recurrence", array('id_evenement' => $id_evenement, 'id_evenement' => $id_evenement));
        }*/

        return $id_evenement;
	}

    public function Delete($id = NULL){

        if($id != NULL){

            $tables = array('recurrence','constituer', 'Evenement');
            $this->db->where('id_evenement', $id);
            $this->db->delete($tables);

        } else return NULL;

    }

    public function add_recurrence($nb_recurrence,$type_recurrence ){
        $data = array(
            'nb_recurrence'     => $nb_recurrence,
            'type_recurrence'   => $type_recurrence
        );
        $this->db->insert('recurrence',$data);
        $id_recurrence = $this->db->insert_id();
        return $id_recurrence;
    }

	public function Update($tabChamps){
		unset($tabChamps['id_agenda']);
        unset($tabChamps['nb_recurrence']);
        unset($tabChamps['type_recurrence']);
        unset($tabChamps['lieu_cp']);
        unset($tabChamps['lieu_ville']);

		$this->db->where('id_evenement', $tabChamps['id_evenement']);
 	    $this->db->update('Evenement',$tabChamps);
    }

    public function rechercheSimilaire($laRecherche = NULL){

        $this->db->select("E.*, E.nom AS nom_evenement");
        $this->db->from("Evenement E");
        $this->db->join("constituer", "E.id_evenement = constituer.id_evenement", "LEFT");
        $this->db->join("Agenda", "Agenda.id_agenda = constituer.id_agenda", "LEFT");
        $this->db->where("Agenda.id_utilisateur", $this->session->userdata("Login")["id_utilisateur"]);
        $this->db->like('E.nom', $laRecherche, 'after');

        $query = $this->db->get();

        return $query->result_array();


	    /*//recherche des evenement potentiellement recherchble
        $dateDuJour = new DateTime();


           //on récupère les évnements potentiellement en double déja proposé
           $sql = "SELECT * FROM proposition_evenement_ia WHERE id_utilisateur=".$this->session->userdata("Login")["id_utilisateur"]." 
               AND date_proposition < ".$dateDuJour->getTimestamp()." AND accepte/nb_demande > 0.3";
            $query = $this->db->query($sql);

            //Si aucune proposittion déja fait on recherche un événément similaire dan ceux de l'utilisateur
        // on recupere uniquement la meilleur soluce
            //on insert la proposition


            $evenements = $query->result_array();

            //pour tous les évenements potentiel
        $iaDetected = null;
            foreach ($evenements as $evenement) {
                $idEvenement = $evenement['id_evenement'];
                //on check le nom
                $sql = "SELECT `smartagenda`.ressemble((SELECT nom FROM `smart-agenda`.Evenement WHERE id_evenement = " . $idEvenement . "),'" . $laRecherche . "') as score";
                $query = ($this->db->query($sql));

                $result = $query->result();

                if (count($result) <= 1) {
                    if ($result[0]->score > 30) {
                        $iaDetected['score'] = ($result[0]->score);
                        $iaDetected['id'] = $idEvenement;
                    }
                }
            }

        if($iaDetected==null){
            //On récupére les Evenement de l'utilisateur
            $sql = "SELECT * FROM `smartagenda`.Agenda where id_utilisateur = ".$this->session->userdata("Login")["id_utilisateur"];
            $query = $this->db->query($sql);
            $agendas = $query->result_array();
            $compteurEvenement = 0;
            foreach ($agendas as  $agenda){
               $sql = "SELECT * FROM `smartagenda`.constituer where id_agenda=".$agenda['id_agenda'];
               $query = $this->db->query($sql);
               $lesEvenements[$compteurEvenement]=$query->result_array();
               $compteurEvenement++;
            }

            //On vérifie la ressemblance avec la saisie de l'utilisateur
            foreach ($lesEvenements as $evenements) {
                foreach ($evenements as $evenement) {
                    $idEvenement = $evenement['id_evenement'];
                    //on check le nom
                    $sql = "SELECT `smartagenda`.ressemble((SELECT ".$leType." FROM `smart-agenda`.Evenement WHERE id_evenement = " . $idEvenement . "),'" . $laRecherche . "') as score ORDER BY score";
                    $query = ($this->db->query($sql));
                    $result = $query->result();
                    if (count($result) <= 1) {
                        if ($result[0]->score > 40) {
                            $iaDetected['score'] = ($result[0]->score);
                            $iaDetected['id'] = $idEvenement;
                        }
                    }
                }
            }
        }
        return $iaDetected;*/
    }

    public function acceptEvent($event_id){
        $id_utilisateur = $this->session->userdata("Login")["id_utilisateur"];
        $dateDuJour = new DateTime();
        $sql = "INSERT INTO `smartagenda`.proposition_evenement_ia (nb_demande, accepte, id_utilisateur, id_evenement, date_proposition)
        VALUES (1, 1, ".$id_utilisateur.", ".$event_id.", ".$dateDuJour->getTimestamp().")
        ON DUPLICATE KEY UPDATE 
            nb_demande =nb_demande+1, 
            accepte=accepte+1, 
            date_proposition=".$dateDuJour->getTimestamp();
        $query = $this->db->query($sql);

        return $this->get($event_id);
    }
    public function  refuseEvent($event_id){
        $id_utilisateur = $this->session->userdata("Login")["id_utilisateur"];
        $dateDuJour = new DateTime();
        $sql ="INSERT INTO `smartagenda`.proposition_evenement_ia (nb_demande, accepte, id_utilisateur, id_evenement, date_proposition)
        VALUES (1, 1, ".$id_utilisateur.", ".$event_id.",".$dateDuJour->getTimestamp().")
        ON DUPLICATE KEY UPDATE 
            nb_demande =nb_demande+1";
        $this->db->query($sql);
    }
	public function getByUser($id_agenda = NULL, $id_user = NULL){

		$this->db->select("*, E.nom AS nom_evenement");
		$this->db->from("Evenement E");
		$this->db->join("constituer", "E.id_evenement = constituer.id_evenement", "LEFT");
		$this->db->join("Agenda", "Agenda.id_agenda = constituer.id_agenda", "LEFT");
		
		if($id_agenda != NULL){
			$this->db->where("Agenda.id_agenda", $id_agenda);
		} elseif($this->session->userdata("Agenda")["id_agenda"] != NULL) {
			//$this->db->where("Agenda.id_agenda", $this->session->userdata("Agenda")["id_agenda"]);
		}

		if($id_user != NULL){
			$this->db->where("Agenda.id_utilisateur", $id_user);
		} elseif($this->session->userdata("Login")["id_utilisateur"] != NULL) {
			$this->db->where("Agenda.id_utilisateur", $this->session->userdata("Login")["id_utilisateur"]);
		}

        $this->db->where("Agenda.afficher = 1");
		$this->db->order_by("Agenda.id_agenda", "ASC");

		$query = $this->db->get();

		return $query->result_array();

	}

    public function getByNom($nom = NULL){

        if($nom != NULL){

            $this->db->select('E.*');
            $this->db->from('Evenement E');
            $this->db->where('E.nom', $nom);
            $this->db->join('constituer C', 'C.id_evenement = E.id_evenement');
            $query = $this->db->get();

            return $query->row();

        } else return NULL;

    }


}