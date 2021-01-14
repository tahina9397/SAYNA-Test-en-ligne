<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'user_model' => 'Users'
			,'global_model' => 'Global'
			,'utils_model' => 'Utils'
		)) ;

		if ($this->Users->getData()) {
			redirect(BASE_URL."/");
		}
	}

	public function index()
	{
		$this->layout->set('title', 'Se connecter');
		$this->layout->load('login', 'contents' , 'login', array(
				"Utils"=>$this->Utils,
			)
		);
	}

	public function check()
	{	
		$res = array() ;

		$pseudo = $this->input->post('pseudo') ;
		$password = $this->input->post('password') ;
		$md5_password = md5($password) ;
		$rememberme = (int)$this->input->post('rememberme',0) ;

		if (empty($pseudo) && empty($password)) {
			$res['state'] = 'empty_field' ;
			$res['msg'] = "Tous les champs sont obligatoires" ;
		}
		else if (empty($pseudo) && !empty($password)) {
			$res['state'] = 'empty_pseudo' ;
			$res['msg'] = "Votre pseudo" ;
		}
		else if (!empty($pseudo) && empty($password)) {
			$res['state'] = 'empty_password' ;
			$res['msg'] = "Votre mot de passe" ;
		}
		else{
			/*check from DB*/
			$where = "username ='$pseudo' AND password='$md5_password' " ;
			$check = $this->Global->selectRow("users",'id,username,password,role,profile_picture',$where);

			if (!empty($check)) {
				$sess_array = array(
					'id'    => (int)$check->id,
					'username'    => $check->username,
					'password' => $check->password,
					'role' => $check->role,
					'profile_picture' => UPLOAD_URL."images/profile/".$check->profile_picture
				);

				$user_id = (int)$check->id;

				$COOKIE_DOMAIN = $this->config->item('cookie_domain') ;

				if($rememberme == 1){
				    setcookie("pseudo_user", $pseudo, time() + 60 * 60 * 24 * 100, "/", $COOKIE_DOMAIN );
				    setcookie("password_user", $password, time() + 60 * 60 * 24 * 100, "/", $COOKIE_DOMAIN );
				    setcookie("rememberme_user",1, time()+60*60*24*100,"/", $COOKIE_DOMAIN );
				}else{
				    setcookie("pseudo_user", "", NULL, "/", $COOKIE_DOMAIN);
				    setcookie("password_user", "", NULL, "/", $COOKIE_DOMAIN);
				    setcookie("rememberme_user",0, time()+60*60*24*100,"/", $COOKIE_DOMAIN);
				}

				/*create session*/
				$this->session->set_userdata('logged_in', $sess_array);

				/*update last_activity*/
				$this->Global->update("users",array('last_activity'=>$this->Utils->now()),'id='.$check->id);
				
				$res['redirection'] = "/infos" ;
				$res['state'] = 'success' ;
				$res['msg'] = "Login avec succès" ;
			}
			else{
				$res['state'] = 'user_not_found' ;
				$res['msg'] = "Login et/ou mot de passe incorrect" ;
			}
		}

		echo json_encode($res) ;
	}
}
