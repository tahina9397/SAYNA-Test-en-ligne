<?php
if ( ! defined('BASEPATH')) exit('No direct script access
allowed');

class Options_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'global_model' => 'Global'
        )) ;
    }

    public function getAllOptions()
    {
        $query = "SELECT meta_key,meta_value FROM options" ;

        $t = $this->Global->query($query) ;

        $tabFinal = array() ;

        if (!empty($t)) {
            foreach ($t as $item) {
                $meta_key[] = $item->meta_key ;
                $meta_value[] = $item->meta_value ;

                $tabFinal = array_combine($meta_key,$meta_value) ;
            }
        }

        return $tabFinal ;
    }

    public function updateOptions($meta_key, $meta_value)
    {
        /*delete meta_key*/
        $this->Global->delete('options',"meta_key='".$meta_key."'") ;

        $data = array(
            "meta_key" => $meta_key
            ,"meta_value" => $meta_value
        ) ;

        $result = $this->Global->insert('options',$data) ;
        
        return $result;
    }
}
?>