<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Model extends CI_Model{

    //Tabel Config
    var $table_name='tbl_menus';
    var $table_attr=array(
        'id'=>'id_menu',
        '1'=>'label',
        '2'=>'link',
        '3'=>'icon',
        '4'=>'have_crud',
        '5'=>'parent',
        '6'=>'is_head_section',
        '7'=>'sort',
        '8'=>'create_date'
    );

    public function get_menu($params=array())
    {
        $this->db
        ->select('a.*, (SELECT COUNT(*) FROM tbl_menus WHERE tbl_menus.parent=a.id_menu) as count_child, 
        (SELECT tbl_menus.is_head_section FROM tbl_menus WHERE tbl_menus.id_menu=a.parent) as parent_head_section')
        ->from('tbl_menus a');
        if(isset($params['id_role'])){
            if($params['id_role']!=null) $this->db->join('tbl_menu_privileges b','b.id_menu=a.id_menu');
        }
        if(isset($params['id_role']))
        {
            if($params['id_role']!=null) $this->db->where('b.id_usr_role',$params['id_role']);
        }
        if(isset($params['id_menu']))
        {
            if($params['id_menu']!=null) $this->db->where('a.id_menu',$params['id_menu']);
        }
        return $this->db->order_by('sort ASC')
        ->get()
        ->result_array();
    }

    public function get_menu_privilege($id_role=null)
    {
        $this->db->select('a.*,b.*')
        ->from('tbl_menus a')
        ->join('tbl_menu_privileges b','a.id_menu=b.id_menu');
        return ($id_role!=null)?$this->db->where('b.id_usr_role',$id_role)->get()->result_array():$this->db->get()->result_array();
    }

    public function get_menu_role_privilege()
    {
        $id_role=$this->input->get('id_role');
        $sql="SELECT a.*, (SELECT COUNT(*) FROM tbl_menus WHERE tbl_menus.parent=a.id_menu) as count_child, 
		( IF ( (SELECT tbl_menu_privileges.id FROM tbl_menu_privileges 
        WHERE tbl_menu_privileges.id_usr_role=".$id_role."
                AND tbl_menu_privileges.id_menu=a.id_menu)is null,0,1) ) as is_checked
                , ( IF ( (SELECT act_create FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) is null,0,(SELECT act_create FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) ) ) as act_create 

        , ( IF ( (SELECT act_update FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) is null,0,(SELECT act_update FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) ) ) as act_update 
        
        , ( IF ( (SELECT act_delete FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) is null,0,(SELECT act_delete FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) ) ) as act_delete 
        
        , ( IF ( (SELECT act_detail FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) is null,0,(SELECT act_detail FROM tbl_menu_privileges WHERE tbl_menu_privileges.id_usr_role=".$id_role."
        AND tbl_menu_privileges.id_menu=a.id_menu) ) ) as act_detail 
                FROM tbl_menus a
                ORDER BY a.sort ASC";
                return $this->db->query($sql)->result_array();
    }

    public function add(){

        $data=array(
            $this->table_attr['1']=>$this->input->post($this->table_attr['1']),
            $this->table_attr['2']=>($this->input->post($this->table_attr['2'])!=NULL)?$this->input->post($this->table_attr['2']):'',
            $this->table_attr['3']=>($this->input->post($this->table_attr['3'])!=NULL) ?$this->input->post($this->table_attr['3']):'feather icon-list',
            $this->table_attr['4']=>$this->input->post($this->table_attr['4']),
            $this->table_attr['6']=>$this->input->post($this->table_attr['6'])
        );

        $this->db->trans_start();
        $this->db->insert($this->table_name,$data);
        $this->db->trans_complete();
        if($this->db->trans_status()===TRUE)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }
    }

    public function edit(){
        $id=$this->input->post('id');
        
        $data=array(
            $this->table_attr['1']=>$this->input->post($this->table_attr['1']),
            $this->table_attr['2']=>($this->input->post($this->table_attr['2'])!=NULL)?$this->input->post($this->table_attr['2']):'',
            $this->table_attr['3']=>($this->input->post($this->table_attr['3'])!=NULL) ?$this->input->post($this->table_attr['3']):'feather icon-list',
            $this->table_attr['4']=>$this->input->post($this->table_attr['4']),
            $this->table_attr['6']=>$this->input->post($this->table_attr['6'])
        );

        $this->db->trans_start();
        $this->db
        ->where($this->table_attr['id'],$id)
        ->update($this->table_name,$data);
        $this->db->trans_complete();
        if($this->db->trans_status()===TRUE)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;

        }
    }

    public function delete(){
        $this->db->trans_start();

        //find child
        $children=$this->db
        ->where($this->table_attr['5'],$this->input->post('id'))
        ->get($this->table_name)
        ->result_array();

        foreach($children as $child)
        {
            $this->db->where($this->table_attr['id'],$child[$this->table_attr['id']])
            ->delete('tbl_menu_privileges');
        }
        
        $this->db->where($this->table_attr['id'],$this->input->post('id'))
        ->delete('tbl_menu_privileges');
        
        $this->db->where($this->table_attr['5'],$this->input->post('id'))
        ->delete($this->table_name);

        $this->db->where($this->table_attr['id'],$this->input->post('id'))
        ->delete($this->table_name);

        $this->db->trans_complete();
        if($this->db->trans_status()===TRUE)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;

        }
    }

    public function save_map_menu($data)
    {
        $this->db->trans_start();
        for($i=1;$i<=count($data);$i++)
        {
            $update=array(
                $this->table_attr['5']=>$data[$i-1]['parent'],
                $this->table_attr['7']=>$i
            );
            $this->db
            ->where($this->table_attr['id'],$data[$i-1]['id'])
            ->update($this->table_name,$update);   
        }
        $this->db->trans_complete();
        if($this->db->trans_status()===TRUE)
        {
            $this->db->trans_commit();
            return true;
        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }   
    }
    

    public function get_user_by_menu($url, $user_area=null){

        if ($user_area!=null){
           $this->db->where("tbl_user.user_area",$user_area);
        }

        $this->db->select("
        tbl_menus.id_menu,
        tbl_menu_privileges.id_usr_role,
        tbl_user.nik
        ")        
        ->from("tbl_menus")
        ->from("tbl_menu_privileges")
        ->from("tbl_user")
        ->where("tbl_menus.id_menu=tbl_menu_privileges.id_menu")
        ->where("tbl_user.id_usr_role=tbl_menu_privileges.id_usr_role")
        ->where("tbl_user.nik!=",$this->session->userdata("nik"))
        ->where("tbl_menus.link",$url)
        ->group_by(array("tbl_user.nik"))
        ;
        $query = $this->db->get();
		return $query->result_array();
    }

}