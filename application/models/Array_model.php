<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Array_model extends CI_Model{
     
    public function get_city($id=null)
    {
        if($id!=null) $this->db->where('tbl_city.id',$id);
        $data=$this->db
        ->from('tbl_city')
        ->get()
        ->result_array();
        return $data;
    }
 
    public function get_subarea($id=null)
    {
        if($id!=null) $this->db->where('tbl_subarea.subarea_id',$id);
        $data=$this->db
        ->from('tbl_subarea')
        ->get()
        ->result_array();
        return $data;
    }

    public function get_jurusan($id=null)
    {
        if($id!=null) $this->db->where('tbl_jurusan.jurusan_id',$id);
        $data=$this->db
        ->from('tbl_jurusan')
        ->get()
        ->result_array();
        return $data;
    }

    public function get_jam_kerja()
    {
        $data=$this->db
        ->from('tbl_jam_kerja')
        ->get()
        ->result_array();
        return $data;
    }

}