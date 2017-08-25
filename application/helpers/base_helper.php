<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Petites fonctions utiles pour le développement du site
 *
 * @author Roman ROBERT 
 *
 **/


	/**
	 * URL dossier "Assets" (CSS/JS/libs/...)
	 * @return string
	 **/
	function asset_url(){
	   return base_url().'assets/';
	}

	/**
	 * Retrait espaces chaine caractères
	 * @return string
	 **/
	function no_spaces($str) {
		return preg_replace('/\s+/', '', $str);
	}

	/**
	 * Nettoyage chaine caractères
	 * @return string
	 **/
	function sanitizing($chaine){
		//$chaine = addslashes($chaine);
		$caracteres = array(
		'À' => 'a', 'a', 'Á' => 'a', 'Â' => 'a', 'Ä' => 'a', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ä' => 'a',
		'È' => 'e', 'É' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
		'Ì' => 'i', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
		'Ò' => 'o', 'Ó' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'ö' => 'o',
		'Ù' => 'u', 'Ú' => 'u', 'Û' => 'u', 'Ü' => 'u', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
		'Œ' => 'oe', 'œ' => 'oe');

		$chaine = strtr($chaine, $caracteres);
		//$chaine = preg_replace('#[^A-Za-z0-9]+#', '', $chaine);
		$chaine = htmlspecialchars($chaine);
		$chaine = strtolower($chaine);
		return $chaine;
	}


	/**
	 * Verification de validité adresse email
	 * @return boolean
	 **/
	function verifierAdresseMail($adresse){
		//Adresse mail trop longue (100 octets max)
		if(strlen($adresse)>100){
		  return 'email_too_long';
		}
		//Caractères non-ASCII autorisés dans un nom de domaine .eu :
		$nonASCII='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
		$nonASCII.='ďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőoeŕŗřśŝsťŧ';
		$nonASCII.='ũūŭůűųŵŷźżztșțΐάέήίΰαβγδεζηθικλμνξοπρςστυφ';
		$nonASCII.='χψωϊϋόύώабвгдежзийклмнопрстуфхцчшщъыьэюяt';
		$nonASCII.='ἀἁἂἃἄἅἆἇἐἑἒἓἔἕἠἡἢἣἤἥἦἧἰἱἲἳἴἵἶἷὀὁὂὃὄὅὐὑὒὓὔ';
		$nonASCII.='ὕὖὗὠὡὢὣὤὥὦὧὰάὲέὴήὶίὸόὺύὼώᾀᾁᾂᾃᾄᾅᾆᾇᾐᾑᾒᾓᾔᾕᾖᾗ';
		$nonASCII.='ᾠᾡᾢᾣᾤᾥᾦᾧᾰᾱᾲᾳᾴᾶᾷῂῃῄῆῇῐῑῒΐῖῗῠῡῢΰῤῥῦῧῲῳῴῶῷ';
		// note : 1 caractète non-ASCII vos 2 octets en UTF-8
		$syntaxe="#^[[:alnum:][:punct:]]{1,64}@[[:alnum:]-.$nonASCII]{2,100}\.[[:alpha:].]{2,6}$#";
		if(preg_match($syntaxe,$adresse)){
		  return true;
		} else {
		  return false;
		}
	}

	/* Infos sur la connexion */
	function isConnected(){
		if(get_instance()->session->userdata('Login') != NULL)
			return TRUE;
		else
			return FALSE;
	}

	/* Gestion des notifications */
	function verificationNotifications($notification = NULL){

		$ajax_call = FALSE;

		if(isset($_GET) && isset($_GET['erreur']) ){
			$notification = $_GET['erreur'];
			$ajax_call = TRUE;
		}

		if($notification == NULL){
				return NULL; exit();
		}
		
		get_instance()->load->model('notification_model');
		$array = get_instance()->notification_model->get($notification);
			
				
		if($ajax_call == TRUE)
			echo json_encode($array);
		else
			return $array;		

	}


	/*Gestion des accès aux pages */
	function verificationAcces($type = NULL, $redirect = TRUE){
		$CI =& get_instance();

		if($type == NULL){
			if($CI->session->flashdata('redirection') != 'OK') redirect('Index', 'location');
		}
		else {
			$return = NULL;
			switch ($type) {
				//Pour accès aux pages
				case 'connected':
					if($CI->uri->segment(1) != 'index'){
						if( empty($_SESSION['hordes_player']) ) {
							$return = base_url().'index';
						}
					}
					break;
				default:
					# code...
					break;
			}

			if($redirect == TRUE && $return != NULL){
				redirect($return);
			} else {
				//Si "redirect == FALSE" on retourne en PHP l'autorisation ou non
				if($return != NULL)
					return FALSE;
				else 
				return TRUE;
			}


		}
	}

	//Fonction de redirection suite à une erreur, avec lien de page et notification à afficher
	function redirect_error($page, $notification, $ajax_call = NULL){

		if($ajax_call == TRUE){

			$array = array('page' => $page, 'notification' => $notification );

			ob_clean();

			echo json_encode($array);

			exit;

		}
		else {

			$CI =& get_instance();
     		$CI->load->library('session');

			$CI->session->set_flashdata('notification', $notification);

			redirect($page, 'location');

		}

	}