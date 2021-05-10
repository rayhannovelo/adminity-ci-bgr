<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Role extends MY_Controller {

    //Tabel Config
    var $table_name='tbl_usr_roles';

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->main();
    }

    public function main(){
        $data['page_head_title']='User Roles List';
        $data['page_head_desc']='List user roles on this system';
        $data['breadcrumb_map']=array(
            array(
                'title'=>null,
                'icon'=>'<i class="feather icon-home"></i>',
                'link'=>site_url('dashboard')
            ),
            array(
                'title'=>'User',
                'icon'=>null,
                'link'=>null
            ),
            array(
                'title'=>'Roles',
                'icon'=>null,
                'link'=>site_url('user_role')
            )
        );
        dashboard_view('content/user_role/main',$data);
    }

    public function get()
    {
        echo json_encode(rcrud_get(
            $this->table_name
            ,array('rcrud_direct_where'=>array('deleted_at is null')
        )));
    }

    public function add()
    {
        if(rcrud_add($this->table_name)==true)
        {
            ob_end_clean();
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function edit()
    {
        if(rcrud_edit($this->table_name))
        {
            ob_end_clean();
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function delete()
    {
        $params=array(
            'id_usr_role'=>$this->input->post('id_user_role'),
            'deleted_at'=>current_datetime()
        );
        if(rcrud_edit($this->table_name,$params))
        {
            ob_end_clean();
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }

        // if($this->user_role->delete())
        // {
        //     echo json_encode(array('success'=>true));
        // }
        // else
        // {
        //     echo json_encode(array('success'=>false));
        // }
    }
}