<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
 
class User_model extends CI_Model
{
	protected $table = 'users';
	public function __construct()
	{
		// Obligatoire
		parent::__construct();
		$this->load->database('default',TRUE);	
		$this->load->library(array('session'));
		$this->load->model(array(
            'global_model' => 'Global'
        )) ;
	}
	
	public function check_user($email,$password)
	{
		//$query = $this->db->query("SELECT * FROM at_user WHERE user_login='".$login."' AND user_mdp='".$mdp."' LIMIT 0,1");
		$array = array('email' => $email, 'password' => $password);
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where($array);
		$this->db->limit(1);

		$query = $this->db->get();
		$row=$query->result();
		return $row;
	}	

	public function getData(){
		if (!empty($this->session->userdata['logged_in'])) {
			return $this->session->userdata['logged_in'] ;
		}
 	}

 	public function getId(){
 		if (!empty($this->session->userdata['logged_in'])) {
			return (int)$data['id'] ;
		}
 	}

 	public function logOut(){
 		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect(BASE_URL."/login");
 	}

 	public function getAllUsers(){

        /*if(!empty($this->input->get("search")))
        {
          $this->db->like('title', $this->input->get("search"));
          $this->db->or_like('description', $this->input->get("search")); 
        }*/
        $query = $this->db->get("users");
        return $query->result();
    }

    public function insert($data)
    {    
        $data = array(
            'username' => $data['username']
            ,'email' => $data['email']
            ,'password' => $data['password']
            ,'role' => $data['role']
            ,'activate' => '1'
            ,'create_time' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('users', $data);
    }

    public function update($data,$id) 
    {
        $data = array(
            'username' => $data['username']
            ,'email' => $data['email']
            ,'password' => $data['password']
            ,'role' => $data['role']
            ,'update_time' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('id',$id);
        return $this->db->update('users',$data);   
    }

    public function find($id)
    {
        return $this->db->get_where('users', array('id' => $id))->row();
    }


    public function delete($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }

    public function getProfilePicture($id)
    {
        $t = $this->Global->selectRow("users","*","id=".$id) ;

        if (!empty($t)) {
            $profile_picture_path  = UPLOAD_PATH."images/profile/".$t->profile_picture;

            if(file_exists($profile_picture_path) && is_file($profile_picture_path)){
                $t->profile_picture = UPLOAD_URL."images/profile/".$t->profile_picture;
            }
            else{
                $t->profile_picture = THEMES_URL."img/avatar/6.jpg" ;
            }
        }

        return $t ;
    }



}