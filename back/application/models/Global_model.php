<?php if ( ! defined('BASEPATH')) exit('No direct script access
allowed');
 
class Global_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database('default',TRUE);	
	}
	
	public function selectRow($table_name, $champs, $where = 1)
	{
		$this->db->select($champs);
		$this->db->from($table_name);
		$this->db->where($where);

		$query = $this->db->get();
		$data = $query->row();
		return $data;
	}

	public function select($table_name, $champs, $where = 1)
	{
		$this->db->select($champs);
		$this->db->from($table_name);
		$this->db->where($where);

		$query = $this->db->get();
		$data = $query->result();
		return $data;
	}

	public function insert($table_name, $data)
	{
		return $this->db->insert($table_name, $data);
	}

	public function lastId(){
		return $this->db->insert_id();
	}

	public function update($table_name, $data, $where)
	{
		$this->db->set($data);	
		$this->db->where($where);
		return $this->db->update($table_name);
	}

	public function delete($table_name, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table_name);
	}

	public function query($req){
		$query = $this->db->query($req) ;
		$data = $query->result();
		return $data;
	}

 	public function getMaxOrderItem($table_name)
    { 
        $sql  = "SELECT max(ordre_categorie) AS max FROM $table_name WHERE 1";
        $query = $this->db->query($sql) ;
		$data = $query->row();
        return (int)$data->max ;  
    }

    public function updateOrderItem($table_name, $order_item)
    { 
        $sql  = "SELECT id_categorie, ordre_categorie FROM $table_name WHERE ordre_categorie >=$order_item";
     	$query = $this->db->query($sql) ;
		$data = $query->result();

        if(!empty($data)){ 
            foreach ($data as $k => $item) {
                $id_categorie = $item->id_categorie;
                $where = " id_categorie=$id_categorie ";
               	$this->update($table_name, array('ordre_categorie'=>$item->ordre_categorie+1), $where);           
            }   
        }
    }


}