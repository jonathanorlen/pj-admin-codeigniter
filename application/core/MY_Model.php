<?php

if(!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class MY_Model extends CI_Model
{        
    function __construct()
    {
        parent::__construct();
    }

    function protect($str)
    {
        return "'".$this->db->escape_str($str)."'";
    }

    function protectLike($str)
    {
        return "'%".$this->db->escape_str($str)."%'";
    }

    function protectLikeAwal($str)
    {
        return "'%".$this->db->escape_str($str)."'";
    }

    function protectLikeAkhir($str)
    {
        return "'".$this->db->escape_str($str)."%'";
    }

    //Fungsi yang digunakan untuk mencari total row sebuah tabel, sering digunakan untuk paging
	function total($table,$where=null,$like=null,$field=null)
	{
		if(empty($field))
		{
			if(!empty($where))
			{
				$this->db->where($where);
			}
			if(!empty($like))
			{
				if(is_array($like))
				{
					//$val_1	= $like[0];
					//$val_2	= $like[1];
					//$val_3	= $like[2];
					$this->db->like($like);
				}
			}
			$query = $this->db->get($table);
                     
			return $query->num_rows();
		}
		else
		{
			$this->db->select($field);
			if(!empty($where))
			{
				$this->db->where($where);
			}
			if(!empty($like))
			{
				if(is_array($like))
				{
					//$val_1	= $like[0];
					//$val_2	= $like[1];
					//$val_3	= $like[2];
					$this->db->like($like);
				}
			}
			$query = $this->db->get($table);
			return $query->num_rows();
		}
	}

	function max($table,$field=null,$where=null)
	{
		$this->db->select_max($field);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		return $query->result();
	}
        
	//Fungsi yg digunakan untuk query select di database
	function find($table, $where = NULL , $field = NULL, $limit = NULL, $orderby = NULL, $join = FALSE, $like = FALSE)
	{
		if(!empty($join))
		{
                    
			if(is_array($join))
			{
				foreach($join as $row)
				{
					$val_1    = $row[0];
					$val_2    = $row[1];
					$val_3    = $row[2];
					$this->db->join($val_1,$val_2,$val_3);
				}
			}
			else
			{
				return FALSE;
			}
		}
		if(!empty($like))
		{
			if(is_array($like))
			{
				//$val_1	= $like[0];
				//$val_2	= $like[1];
				//$val_3	= $like[2];
				$this->db->like($like);
			}
		}
		if(!empty($orderby))
		{
			if(is_array($orderby))
			{
				$val_1	= $orderby[0];
				$val_2	= $orderby[1];
				$this->db->order_by($val_1,$val_2);
			}
			else
			{
				$this->db->order_by($orderby);
			}
		}
		if (! empty($limit))
		{
			if(is_array($limit))
			{
				$this->db->limit($limit[1],$limit[0]);
			}
			else
			{
				$this->db->limit($limit);
			}
		}
		if ( empty($field))
		{ 
			if (! empty($where))
			{
				$this->db->where($where);
			}
			$query = $this->db->get($table);
			if ($query->num_rows() < 1)
			{
				$query->free_result();
				return FALSE;
			}
			else
			{
				$ret = $query;
				return $ret;
			}
		}
		else
		{ 
			$this->db->select($field);
			if (! empty($where))
			{
				$this->db->where($where);
			}
			$query = $this->db->get($table);
			if ($query->num_rows() < 1)
			{
				$query->free_result();
				return FALSE;
			}
			else
			{
				$ret = $query;
				return $ret;
			}
		}
	}
        
	//Fungsi u/ Simpan record ke tabel
	function write($table,$data)
	{
		if($table == FALSE || $data == FALSE)
		{
			return FALSE;
		}
		else
		{
			if(!is_array($data))
			{
				return FALSE;
			}
			else
			{
				$insert = $this->db->insert($table, $data);
				
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}
	}

	function write_id($table,$data)
	{
		if($table == FALSE || $data == FALSE)
		{
			return FALSE;
		}
		else
		{
			if(!is_array($data))
			{
				return FALSE;
			}
			else
			{
				$insert = $this->db->insert($table, $data);
				
				return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : FALSE;
			}
		}
	}

	function write_batch($table,$data){
    	if($table == FALSE || $data == FALSE)
		{
			return FALSE;
		}
		else
		{
			if(!is_array($data))
			{
				return FALSE;
			}
			else
			{
				$insert = $this->db->insert_batch($table, $data);
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}
    }
        
	//Fungsi yg bisa dipakai untuk update record pada tabel
	function replace($table,$data,$where)
	{
		if($table == FALSE || $data == FALSE || $where == FALSE)
		{
			return FALSE;
		}
		else
		{
			if(!is_array($data)){
				return FALSE;
			}
			else
			{
				$this->db->where($where);
				$update = $this->db->update($table, $data);
				return TRUE;
			}
		}
	}
        
	//Fungsi yg dipakai untuk mendelete sebuah record dari tabel
	public function delete($table,$where=null)
	{
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($table))
		{
			$this->db->delete($table); 
            return $this->db->affected_rows();
		}
		else
		{
			return 0;
		}
	}

	public function where_between($field, $min, $max)
	{
		return $this->db->where("($field BETWEEN '$min' AND '$max')");
	}
}