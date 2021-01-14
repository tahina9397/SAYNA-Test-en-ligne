<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Historique_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
        )) ;
    }

    public function delete($id)
    {
        return $this->db->delete('factures', array('id_facture' => $id));
    }

    public function getArticleByFactureId($facture_id)
    { 
        $sql  = "
            SELECT 
                a.nom_article
                ,v.vente_quantite
                ,a.prix_article 
            FROM ventes v 
            LEFT JOIN articles a ON (v.article_id = a.id_article) 
            WHERE v.facture_id = $facture_id
        ";
        
        $query = $this->db->query($sql) ;
        $data = $query->result();
        return $data ;
    }

    public function Get_facture($id)
    {
        return $this->db->select('*')
                        ->from('factures')
                        ->where('id_facture',$id)
                        ->get()
                        ->row();
    }

}
?>