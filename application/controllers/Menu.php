<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {
    public function __construct(){
        parent::__construct();
            $this->load->model('Menu_Model','menu');
    }

    public function index(){
        $this->main();
    }

    public function main(){
        $data['page_head_title']='Menu Management';
        $data['page_head_desc']='List Menu On This System';
        $data['breadcrumb_map']=array(
            array(
                'title'=>'Dashboard',
                'icon'=>'<i class="feather icon-home"></i>',
                'link'=>site_url('dashboard')
            ),
            array(
                'title'=>'Manage System Menu',
                'icon'=>null,
                'link'=>null
            )
        );
        dashboard_view('content/menu/main',$data);
    }

    public function get(){
        $params=array(
            'id_menu'=>$this->input->get('id_menu'),
            'id_role'=>$this->input->get('id_role')
        );
        echo json_encode($this->menu->get_menu($params));
    }

    public function add(){
        if($this->menu->add()==true)
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function edit(){
        if($this->menu->edit())
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function delete(){
        if($this->menu->delete())
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function get_role_privilege(){
        $data=$this->menu->get_menu_role_privilege();
        echo json_encode($this->map_menu_role($data,0));
    }

    function map_menu_role($menus,$parent_id)
    {
        $mapMenu=array();
        foreach($menus as $menu)
        {
            if($menu['parent']==$parent_id)
            {
                $act_create=($menu['act_create']==1)?' checked ':'';
                $act_update=($menu['act_update']==1)?' checked ':'';
                $act_delete=($menu['act_delete']==1)?' checked ':'';
                $act_detail=($menu['act_detail']==1)?' checked ':'';

                $mapMenu[]=array(
                    'id'=>$menu['id_menu'],
                    'text'=>$menu['label'],
                    'data'=>array('addHTML'=>($menu['have_crud']==1) ? 
                    'Action :<span style="font-size:13px;" class="border-checkbox-section">
                    <div style="font-size:13px;" class="border-checkbox-group border-checkbox-group-primary">
                        <input '.$act_create.' class="border-checkbox" type="checkbox" id="'.$menu['id_menu'].'-create">
                        <label class="border-checkbox-label" for="'.$menu['id_menu'].'-create">Create</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-primary">
                        <input '.$act_update.' class="border-checkbox" type="checkbox" id="'.$menu['id_menu'].'-update">
                        <label class="border-checkbox-label" for="'.$menu['id_menu'].'-update">Update</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-primary">
                        <input '.$act_delete.' class="border-checkbox" type="checkbox" id="'.$menu['id_menu'].'-delete">
                        <label class="border-checkbox-label" for="'.$menu['id_menu'].'-delete">Delete</label>
                    </div>
                    <div class="border-checkbox-group border-checkbox-group-primary">
                        <input '.$act_detail.' class="border-checkbox" type="checkbox" id="'.$menu['id_menu'].'-detail">
                        <label class="border-checkbox-label" for="'.$menu['id_menu'].'-detail">Detail</label>
                    </div>
                    </span>
                    ':''),
                    
                    'type'=>($menu['count_child']>0)?"default":"file",
                    'state'=>array( 'opened'=>true,'checked'=>($menu['is_checked']==0)?false:true),
                    'children'=>$this->map_menu_role($menus,$menu['id_menu'])
                );
            }
        }

        return $mapMenu;
    }

    function save_map_menu_role()
    {
        $menu_data=$this->input->post('menu_data');
        $id_role=$this->input->post('id_role');

        $this->db->where('id_usr_role',$id_role)
        ->delete('tbl_menu_privileges');
        $task=true;
        
        if($menu_data!=null){
            if(count($menu_data)>0)
            {
                $sql="INSERT INTO tbl_menu_privileges(id_usr_role,id_menu,act_create,act_update,act_delete,act_detail) VALUES ";
                $is_need_comma=false;
                for($i=0; $i<count($menu_data); $i++ )
                {
                    $menu=$menu_data[$i];
                    
                    if($is_need_comma)
                    {
                        $sql.=", ";
                    }
                    $sql.=" (".$id_role.",".$menu['id_menu'].",".$menu['act_create'].",".$menu['act_update'].",".$menu['act_delete'].",".$menu['act_detail'].")";
                    $is_need_comma=true;
                }
                $task=$this->db->query($sql);

            }
        }

        
        if($task)
        {
            echo json_encode(array('status'=>true,'success'=>true));
        }
        else{
            echo json_encode(array('status'=>false,'success'=>false));
        }

    }

    function save_map_menu()
    {
        $menu_data=$this->input->post('menu_data');
        $task=$this->menu->save_map_menu($menu_data);
        if($task)
        {
            echo json_encode(array('status'=>true,'success'=>true));
        }
        else{
            echo json_encode(array('status'=>false,'success'=>false));
        }
    }

    function map_menu($menus,$parent_id){
        $map=array();
        $menu_parent=array();
        $children=array();
        foreach($menus as $menu)
        {
            if(isset($menu->children)==true){
                $children=$this->map_menu($menu->children,$menu->id);
            }
            $menu_parent[]=array('id'=>$menu->id,'parent_id'=>$parent_id);
            $map=array_merge($menu_parent,$children);
        }
        return $map;
    }
}