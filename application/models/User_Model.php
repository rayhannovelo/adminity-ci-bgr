<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model{

	var $table = 'tbl_user';
	var $column_order = array('tbl_user.nik', 'tbl_emp.emp_fullname', null, 'tbl_datespec.tanggal_masuk', 'tbl_datespec.tanggal_pensiun', null, null);
    var $column_search = array('tbl_user.nik',
                                'tbl_emp.emp_fullname',
                                'tbl_posisi.pos_objnm',
                                'tbl_datespec.tanggal_masuk',
                                'tbl_datespec.tanggal_pensiun',
                                'tbl_subarea.subarea_ket',
                                'concat(tbl_emp.emp_bop,\', \',DATE_FORMAT(tbl_emp.emp_dob, "%d-%m-%Y"))'
                            );
	var $order = array('tbl_emp.emp_fullname' => 'asc');

    public function get($id=null, $or_perssubarea=null)
    {
        //if ($this->session->userdata('id_usr_role') != 1) $this->db->where('tbl_user.id_usr_role !=', 1);
        if($id!=null) $this->db->where('tbl_user.id_user',$id);
        if($or_perssubarea!=null) $this->db->where('tbl_user.user_area',$or_perssubarea);
        $data=$this->db
        ->select('tbl_user.*
            ,tbl_usr_status.status_name
            ,tbl_usr_status.id_usr_status
            ,tbl_usr_status.status_desc
            ,tbl_usr_roles.id_usr_role
            ,tbl_usr_roles.role_name
            ,tbl_usr_roles.role_desc
            ,tbl_usr_roles.can_finish
            ,tbl_branch.profit_center
            ,tbl_branch.name
            ')
        ->from('tbl_user')
        ->join('tbl_usr_status','tbl_usr_status.id_usr_status=tbl_user.id_usr_status')
        ->join('tbl_usr_roles','tbl_usr_roles.id_usr_role=tbl_user.id_usr_role')
        ->join('tbl_branch','tbl_branch.id=tbl_user.user_area')
        //->where('tbl_user.id_usr_status!=4')
        ->where('tbl_user.deleted_at is null')
        ->get()
        ->result_array();
        return $data;
    }



    public function get_min($id=null,$status=null)
    {
        if($id!=null) $this->db->where('tbl_user.id_user',$id);
        if($status!=null) $this->db->where('tbl_user.id_usr_status!=4');
        $data=$this->db
        ->select('tbl_user.nik
            ,tbl_emp.emp_fullname
            ')
        ->from('tbl_user')
        ->join('tbl_emp','tbl_user.nik=tbl_emp.nik')
        ->where('tbl_user.deleted_at is null')
        ->group_by(array("tbl_emp.emp_fullname", "tbl_emp.nik"))
        ->get()
        ->result_array();
        return $data;
    }

    public function get_emp($nik){
        $data=$this->db
        ->select('tbl_emp.*')
        ->select('tbl_user.foto')
        ->from('tbl_emp')
        ->from('tbl_user')
        ->where('tbl_emp.nik=tbl_user.nik')
        ->where('tbl_emp.nik',$nik)
        ->get()
        ->row_array();
        return $data;
    }   
    

    public function get_org($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_organizational')
        ->where('nik',$nik)
        ->get()
        ->row_array();
        return $data;
    }   

    public function get_name($nik){
        $data=$this->db
        ->select('full_name')
        ->from('tbl_user')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data->full_name;
    }

    public function get_role($nik){
        $data = $this->db
        ->select('role_name')
        ->from('tbl_user')
        ->join('tbl_usr_roles', 'tbl_usr_roles.id_usr_role = tbl_user.id_usr_role')
        ->where('tbl_user.nik', $nik)
        ->get()
        ->row();
        return $data->role_name;
    }

    public function get_id_usr_role($nik){
        $data = $this->db
        ->select('id_usr_role')
        ->from('tbl_user')
        ->where('tbl_user.nik', $nik)
        ->get()
        ->row();
        return $data->id_usr_role;
    }
  
    public function get_address($nik, $type){
        $data=$this->db
        ->select('*')
        ->from('tbl_address')
        ->where('nik',$nik)
        ->where('add_type',$type)
        ->get()
        ->row_array();
        return $data;
    }   

    public function get_com($nik,$type){
        $data=$this->db
        ->select('com_num')
        ->from('tbl_communication')
        ->where('nik',$nik)
        ->where('com_type',$type)
        ->get()
        ->row();
        return (!empty($data->com_num)?$data->com_num:"");
    }

    public function get_posisi($nik){
        $data=$this->db
        ->select('tbl_emp.emp_fullname
            ,tbl_emp.nik
            ,tbl_posisi.pos_objnm
            ')
        ->from('tbl_organizational,tbl_emp,tbl_posisi')
        ->where('tbl_organizational.nik=tbl_emp.nik')
        ->where('tbl_organizational.or_position=tbl_posisi.pos_id')
        ->where('tbl_organizational.nik',$nik)
        ->get()
        ->row();
        return $data->pos_objnm;
    }


    public function get_pay($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_pay')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }
    public function get_datespec($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_datespec')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }

    public function get_tax($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_tax')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }

    public function get_bpjstk($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_bpjstk')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }
    public function get_bpjskes($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_bpjskes')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }
    public function get_bank($nik){
        $data=$this->db
        ->select('*')
        ->from('tbl_bank')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data;
    }
    
    public function get_unit($nik){
        $data=$this->db
        ->select('tbl_emp.emp_fullname
            ,tbl_emp.nik
            ,tbl_unit.unit_objnm
            ')
        ->from('tbl_organizational,tbl_emp,tbl_unit')
        ->where('tbl_organizational.nik=tbl_emp.nik')
        ->where('tbl_organizational.or_unit=tbl_unit.unit_id')
        ->where('tbl_organizational.nik',$nik)
        ->get()
        ->row();
        return $data->unit_objnm;
    }

    public function get_area_code($nik){
        $data=$this->db
        ->select('or_perssubarea')
        ->from('tbl_organizational')
        ->where('nik',$nik)
        ->get()
        ->row();
        return $data->or_perssubarea;
    }

    public function get_pejabat_area($nik,$subarea)
    {
        $data=$this->db
        ->select('tbl_emp.emp_fullname
            ,tbl_emp.nik
            ,tbl_posisi.pos_objnm
            ')
        ->from('tbl_organizational,tbl_emp,tbl_posisi')
        ->where('tbl_organizational.nik=tbl_emp.nik')
        ->where('tbl_organizational.or_position=tbl_posisi.pos_id')
        ->where('tbl_organizational.nik!=',$nik)
        ->where("
            (
        
                (
                    (tbl_posisi.pos_objnm like '%vp%' or tbl_posisi.pos_objnm like '%manager%' or tbl_posisi.pos_objnm like '%supervisor%') 	
                    and tbl_organizational.or_perssubarea='".$subarea."'
                )
                or 
                (tbl_posisi.pos_objnm like '%director%' and tbl_posisi.pos_objnm not like '%secretary%')
            
            )
        ")        
        ->group_by(array("tbl_posisi.pos_objnm", "tbl_emp.emp_fullname", "tbl_emp.nik"))
        ->order_by('tbl_emp.emp_fullname', 'asc')
        ->get()
        ->result();
        return $data;
    }
	public function get_device($nik){
		$this->db->where('nik', $nik);
		$this->db->from('tbl_device');
		$query = $this->db->get();
		return $query->row();
	}

	public function reset_device($nik){
		return $this->db->delete('tbl_device', array('nik' => $nik));
	}

	private function _get_datatables_query($filter_only_active)
	{
		if ($filter_only_active){
			$this->db->where('tbl_user.id_usr_status!=', '4');
        }

		
		if($this->session->userdata("id_usr_role")!=1 
			&& $this->session->userdata("id_usr_role")!=4
			&& $this->session->userdata("id_usr_role")!=6
		)
        {
			$this->db->where('tbl_organizational.or_perssubarea=', $this->session->userdata('or_perssubarea'));
        }
        
        if($this->input->post('id_usr_status'))
        {
			$this->db->where('tbl_user.id_usr_status=', $this->input->post('id_usr_status'));
        }

        if($this->input->post('nik'))
        {
			$this->db->where('tbl_user.nik=', $this->input->post('nik'));
        }

        if($this->input->post('user_area'))
        {
			$this->db->where('tbl_organizational.or_perssubarea=', $this->input->post('user_area'));
        }

        if($this->input->post('filter_posisi')==1)
        {
            $this->db->like("tbl_posisi.pos_objnm", "supervisor");
            $this->db->not_like("tbl_posisi.pos_objnm", "senior");
        }
        else if($this->input->post('filter_posisi')==2)
        {
            $this->db->like("tbl_posisi.pos_objnm", "senior supervisor");
        }
        else if($this->input->post('filter_posisi')==3)
        {
            $this->db->like("tbl_posisi.pos_objnm", "manager");
            $this->db->not_like("tbl_posisi.pos_objnm", "senior");
            $this->db->not_like("tbl_posisi.pos_objnm", "general");
        }
        else if($this->input->post('filter_posisi')==4)
        {
            $this->db->like("tbl_posisi.pos_objnm", "senior manager");
        }
        else if($this->input->post('filter_posisi')==5)
        {
            $this->db->like("tbl_posisi.pos_objnm", "general manager");
        }
        else if($this->input->post('filter_posisi')==6)
        {
            $this->db->like("tbl_posisi.pos_objnm", "vp");
            $this->db->or_like("tbl_posisi.pos_objnm", "vice president");
        }


		$this->db->from($this->table);
        $this->db->select('
            tbl_user.nik
            ,tbl_usr_status.status_name
            ,tbl_organizational.or_perssubarea
            ,tbl_emp.emp_fullname
            ,tbl_emp.emp_dob
            ,tbl_emp.emp_bop
            ,tbl_emp.emp_cob
            ,tbl_datespec.tanggal_masuk
            ,tbl_datespec.tanggal_pensiun
            ,tbl_posisi.pos_objnm
            ,tbl_subarea.subarea_ket
            ,tbl_organizational.or_position
        ')  
        ->join('tbl_usr_status','tbl_usr_status.id_usr_status=tbl_user.id_usr_status','left')
        ->join('tbl_organizational','tbl_user.nik=tbl_organizational.nik','left')
        ->join('tbl_emp','tbl_user.nik=tbl_emp.nik','left')
        ->join('tbl_datespec','tbl_user.nik=tbl_datespec.nik','left')
        ->join('tbl_posisi',"tbl_organizational.or_position=tbl_posisi.pos_id",'left')
        ->join('tbl_subarea',"tbl_organizational.or_perssubarea=tbl_subarea.subarea_id",'left')
        ->where('tbl_user.deleted_at is null');        
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if(isset($_POST['search']) && $_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->group_by(array("tbl_emp.emp_fullname", "tbl_emp.nik"));
	}

	function get_datatables($filter_only_active=false)
	{
		$this->_get_datatables_query($filter_only_active);
		if(isset($_POST['length']) && $_POST['length'] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}else{
			$this->db->limit(10, 0);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_data($filter_only_active=false)
	{
		$this->_get_datatables_query($filter_only_active);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($filter_only_active=false)
	{
		$this->_get_datatables_query($filter_only_active);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

    public function count_user_active(){

        if ($this->input->post("or_perssubarea")){
            $this->db->join('tbl_organizational','tbl_user.nik=tbl_organizational.nik')
            ->where('tbl_organizational.or_perssubarea',$this->input->post("or_perssubarea"));
        }
        $this->db->from($this->table)
        ->where($this->table.'.id_usr_status<4');
		return $this->db->count_all_results();
    }



	public function count_on_temp()
	{
        $this->db->from("tbl_emp_temp")
        ->where('deleted_at is null')
        ->where('approval_status', "0")
        ->where('nik',$this->session->userdata("nik"))
        ;
		return $this->db->count_all_results();
    }

    

}