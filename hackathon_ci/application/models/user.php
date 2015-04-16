<?php

class User extends CI_Model
{

    /*

    ==========TABLE COLUMN REFERENCE===========
     ["id","email","password","status","created_datetime"]

    */

    function User_model()
    {
        parent::Model();
        $this->load->database();
    }

    function create($data)
    {

        $params = array_keys($data);
        $fields = $this->db->list_fields('user');
        foreach ($fields as $param){
            if (isset($data[$param])){
                $this->db->set($param, $data[$param]);
            }
        }

        if (in_array("created_datetime",$fields)){
            $this->db->set("created_datetime", "NOW()",FALSE);
        }
        $this->db->insert('user');
        return $this->db->insert_id();

    }
	
	function checkValueExist($col,$value){
        $this->db->select("id");
        $this->db->where($col, $value);
        $query = $this->db->get('user');
        $result=$query->row_array();
        if (sizeof($result)>0){
            return true;
        }else{
            return false;
        }
    }


    function read($id,$query)
    {
        $fields = $this->db->list_fields('user');
        $this->db->where('id', $id);

        if (!empty($query)){
            foreach ($query as $key=>$item){
                if (in_array($key,$fields)){
                    $this->db->where($key, $item); //only add to query if column exists
                }
            }
        }

        $query = $this->db->get('user');
        $output=$query->row_array();
        if (empty($output)){
            throw new Exception("Resource not found!");
        }
        //$this->mapToUnixTimestamp($output);
        return $output;

    }

    function find($query){
        //retrieve list
        $fields = $this->db->list_fields('user');
        if (!empty($query)){
            foreach ($query as $key=>$item){
                if (in_array($key,$fields)){
                    $this->db->where($key, $item); //only add to query if column exists
                }
            }
        }

        $query = $this->db->get('user');
        $output=$query->row_array();
        if (empty($output)){
            throw new Exception("Resources not found!");
        }
        return $output;
    }
	
	function findAll($query){
        //retrieve list
        $fields = $this->db->list_fields('user');
        if (!empty($query)){
            foreach ($query as $key=>$item){
                if (in_array($key,$fields)){
                    $this->db->where($key, $item); //only add to query if column exists
                }
            }
        }

        $query = $this->db->get('user');
        $output=$query->result_array();
        if (empty($output)){
            throw new Exception("Resources not found!");
        }
        return $output;
    }
	
	function getAll() {
        $query = $this->db->get('user');
        $output=$query->result_array();
        if (empty($output)){
            throw new Exception("Resources not found!");
        }
        return $output;
    }
	
	function deleteRow($id) {
		$this->db->where('id',$id);
		$this->db->delete('user');
	}


    function update($id,$query,$data){ //do an update if the said key exist in this table


        $keys = array_keys($data);

        $db_keys=  $this->db->list_fields("user");

        $updated=false;
        foreach ($keys as $key){ //only set to update if the key exists
            if (in_array($key,$db_keys)){
                $updated=true;
                $this->db->set($key, $data[$key]);
            }
        }
        if ($updated){
            $this->db->where('id',$id);
            if (!empty($query)){
                foreach ($query as $key=>$item){
                    if (in_array($key,$keys)){
                        $this->db->where($key, $item); //only add to query if column exists
                    }
                }
            }
            $this->db->update('user');
            return $this->db->affected_rows();

        }else{
            throw new Exception ("Nothing to update");
        }
    }
}
?>