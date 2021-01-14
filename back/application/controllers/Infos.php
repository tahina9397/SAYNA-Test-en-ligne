<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'user_model' => 'Users'
			,'categorie_model' => 'Categories'
			,'global_model' => 'Global'
		)) ;
		
		if (!$this->Users->getData()) {
			redirect(BASE_URL."/login");
		}
		else{
            $this->data = $data = $this->Users->getData() ;
		}
	}

	public function index()
	{	
		$this->layout->set('title', 'Informations de connexion');
		$this->layout->set('headLink', '');
		$this->layout->set('headScript', array(THEMES_URL."js/scripts/infos/index.js"));
		$this->layout->load('default', 'contents' , 'infos/index');

        /*load model*/
        // $data['model_obj'] = $this->Users; 
	}

	public function update()
	{
        $data = $this->data ;

		$pseudo = $this->input->post('pseudo') ;

        if (empty($pseudo)) {
            $ret["state"] = "empty_pseudo" ;
            $ret["msg"] = "Le champ pseudo est obligatoire" ;
            echo json_encode($ret);
            die() ;
        }

        if (!empty($_FILES["file"]["name"])) {
            $this->updateAvatar() ;
        }

        $this->Global->update("users",array("username" => $pseudo),"id=".$data["id"]) ;

        $ret["state"] = "success" ;
        $ret["msg"] = "Profil à jour avec succès" ;

        echo json_encode($ret);
	}

    function updateAvatar()
    {
        $data = $this->data ;

        /*name of the input[type=file]*/
        $file_element_name = "file";

        $randomstring = sha1(uniqid('', true));
        $extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

        $tmp_filename = 'profile_' . $data["id"] . '_' . $randomstring . '-source.' . $extension;

        $config['upload_path'] = UPLOAD_PATH."images/profile/" ;
        $config['allowed_types'] = 'gif|jpg|png|doc|txt';
        $config['max_size'] = 1024 * 8;
        // $config['encrypt_name'] = TRUE;
        $config['file_name'] = $tmp_filename;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file_element_name))
        {   
            return false ;
            // $msg = $this->upload->display_errors('', '');
        }
        else
        {
            $this->Global->update("users",array("profile_picture" => $tmp_filename),"id=".$data["id"]) ;
            return $this->upload->data();
        }
    }

}
