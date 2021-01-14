<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Taille_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
        )) ;
    }


    public function getAllSize(){
        if(!empty($this->input->get("search"))){
          $this->db->like('title', $this->input->get("search"));
          $this->db->or_like('description', $this->input->get("search")); 
        }
        $query = $this->db->get("taille");
        return $query->result();
    }


    public function insert($data)
    {    
        $data = array(
            'nom_taille' => $data['nom_taille']
        );
        return $this->db->insert('taille', $data);
    }


    public function update($data,$id) 
    {
        $data = array(
            'nom_taille' => $data['nom_taille']
        );
        
        $this->db->where('id_taille',$id);
        return $this->db->update('taille',$data);   
    }


    public function find($id)
    {
        return $this->db->get_where('taille', array('id_taille' => $id))->row();
    }


    public function delete($id)
    {
        return $this->db->delete('taille', array('id_taille' => $id));
    }
   
}
?>