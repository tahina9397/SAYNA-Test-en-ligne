<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Categorie_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
            ,'utils_model' => 'Utils'
        )) ;
    }


    public function getAllCategories(){
        if(!empty($this->input->get("search"))){
          $this->db->like('title', $this->input->get("search"));
          $this->db->or_like('description', $this->input->get("search")); 
        }
        $query = $this->db->get("categories");
        return $query->result();
    }


    public function insert($data)
    {    
        $data = array(
            'nom_categorie' => $data['nom_categorie']
            ,'uniqid' => $this->Utils->getNewUniqid(8,'categories')
            ,'commentaire_categorie' => $data['commentaire_categorie']
            ,'ordre_categorie' => $data['ordre_categorie']
        );
        return $this->db->insert('categories', $data);
    }


    public function update($data,$id) 
    {
        $data = array(
            'nom_categorie' => $data['nom_categorie']
            ,'commentaire_categorie' => $data['commentaire_categorie']
            ,'ordre_categorie' => $data['ordre_categorie']
        );
        
        $this->db->where('id_categorie',$id);
        return $this->db->update('categories',$data);   
    }


    public function find($id)
    {
        return $this->db->get_where('categories', array('id_categorie' => $id))->row();
    }


    public function delete($id)
    {
        return $this->db->delete('categories', array('id_categorie' => $id));
    }

    public function optionsOrderItem($options)
    {
        $atend_value = $this->Global->getMaxOrderItem($options['tablename']) + 1;

        $return = '<option value="">Ne pas changer</option>';
        $return .= '<option value="'.$options['atfirst']['value'].'">'.$options['atfirst']['title'].'</option>';
        $return .= '<option value="'.$atend_value.'">'.$options['atend']['title'].'</option>';

        return $return;
    }
}
?>