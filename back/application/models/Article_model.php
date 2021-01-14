<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Article_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
            ,'utils_model' => 'Utils'
        )) ;
    }


    public function getAllArticles(){

        /*if(!empty($this->input->get("search")))
        {
          $this->db->like('title', $this->input->get("search"));
          $this->db->or_like('description', $this->input->get("search")); 
        }*/
        $query = $this->db->get("articles");
        return $query->result();
    }

    public function getArticleByCodeBarre($code)
    {
        $sql  = "
            SELECT 
                a.nom_article
                ,a.uniqid
                ,a.codebarre_article
                ,a.prix_article
                ,a.prix_achat
                ,a.pourcentage
                ,a.nbre_stock_article
                ,a.article_commentaire
                ,c.nom_categorie
                ,t.nom_taille
            FROM articles a
            LEFT JOIN categories c ON (a.id_categorie = c.id_categorie)
            LEFT JOIN taille t ON (a.id_taille = t.id_taille)
            WHERE a.codebarre_article = '$code'
        ";

        $query = $this->db->query($sql) ;
        $data = $query->row();

        return $data ;
    }


    public function insert($data)
    {    
        $data = array(
            'id_categorie' => $data['id_categorie']
            ,'id_taille' => $data['id_taille']
            ,'uniqid' => $this->Utils->getNewUniqid(8,'articles')
            ,'nom_article' => $data['nom_article']
            ,'codebarre_article' => $data['codebarre_article']
            ,'prix_article' => $data['prix_article']
            ,'prix_achat' => $data['prix_achat']
            ,'pourcentage' => $data['pourcentage']
            ,'nbre_stock_article' => $data['nbre_stock_article']
            ,'article_commentaire' => $data['article_commentaire']
        );
        return $this->db->insert('articles', $data);
    }


    public function update($data,$id) 
    {
        $data = array(
            'id_categorie' => $data['id_categorie']
            ,'id_taille' => $data['id_taille']
            ,'nom_article' => $data['nom_article']
            ,'codebarre_article' => $data['codebarre_article']
            ,'prix_article' => $data['prix_article']
            ,'prix_achat' => $data['prix_achat']
            ,'pourcentage' => $data['pourcentage']
            ,'nbre_stock_article' => $data['nbre_stock_article']
            ,'article_commentaire' => $data['article_commentaire']
        );
        
        $this->db->where('id_article',$id);
        return $this->db->update('articles',$data);   
    }

    public function updateStock($data,$id) 
    {
        /*insert into historique*/
        $data_historique = array(
            "article_id" => $id
            ,"quantite" => $data['nbre_stock_article'] 
        ) ;

        $this->Global->insert('historique',$data_historique) ;

        $get = self::find($id) ;
        $stockInitial = (int)$get->nbre_stock_article ;

        $data = array(
            'nbre_stock_article' => $data['nbre_stock_article'] + $stockInitial
        );
        
        $this->db->where('id_article',$id);
        $this->db->update('articles',$data);

        return 1 ;
    }


    public function find($id)
    {
        return $this->db->get_where('articles', array('id_article' => $id))->row();
    }


    public function delete($id)
    {
        return $this->db->delete('articles', array('id_article' => $id));
    }

    public function optionsOrderItem($options)
    {
        $atend_value = $this->Global->getMaxOrderItem($options['tablename']) + 1;

        $return = '<option value="">Ne pas changer</option>';
        $return .= '<option value="'.$options['atfirst']['value'].'">'.$options['atfirst']['title'].'</option>';
        $return .= '<option value="'.$atend_value.'">'.$options['atend']['title'].'</option>';

        return $return;
    }

    public function getArticleByCategoryId($category_id)
    {
        $sql  = "
            SELECT 
                a.*
            FROM articles a
            WHERE a.id_categorie = $category_id 
        ";

        $query = $this->db->query($sql) ;
        $data = $query->result();

        return $data ;
    }

    public function getArticleAndCategory()
    {
        $sql  = "
            SELECT 
                c.nom_categorie
                ,c.id_categorie
            FROM categories c
        ";

        $query = $this->db->query($sql) ;
        $dataCategorie = $query->result();

        if (!empty($dataCategorie)) {
            foreach ($dataCategorie as $k => $item) {
                $data[$k]['nom_categorie'] = $item->nom_categorie ;
                $data[$k]['id_categorie'] = $item->id_categorie ;

                $getArticleByCategoryId = self::getArticleByCategoryId($item->id_categorie) ;
                $data[$k]['article'] = $getArticleByCategoryId ;
            }
        }

        return $data ;
    }
}
?>