<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Status extends MY_Controller {

    //Tabel Config
    var $table_name='tbl_usr_status';

    public function __construct(){
        parent::__construct();
    }

    public function get(){
        echo json_encode(rcrud_get(
            $this->table_name
            ,array('rcrud_direct_where'=>array('deleted_at is null'))
        ));
    }

    public function index(){
        $this->main();
    }

    public function main(){
        $data['page_head_title']='User Status List';
        $data['page_head_desc']='List User Status On This System';
        $data['breadcrumb_map']=array(
            array(
                'title'=>'Dashboard',
                'icon'=>'<i class="feather icon-home"></i>',
                'link'=>site_url('dashboard')
            ),
            array(
                'title'=>'Manage User Status',
                'icon'=>null,
                'link'=>null
            )
        );
        dashboard_view('content/user_status/main',$data);
    }

    public function add(){
        if(rcrud_add($this->table_name)==true)
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function edit(){
        if(rcrud_edit($this->table_name))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function delete(){
        $params=array(
            'id_usr_status'=>$this->input->post('id_usr_status'),
            'deleted_at'=>current_datetime()
        );
        if(rcrud_edit($this->table_name,$params))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
        // if(delete())
        // {
        //     echo json_encode(array('success'=>true));
        // }
        // else
        // {
        //     echo json_encode(array('success'=>false));
        // }
    }
}