<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divre extends MY_controller {

    //Tabel Config
    var $table_name='tbl_subarea';

    var $action_cek='';


    public function __construct(){
        parent::__construct();
    }

    public function get(){

        $where = array();
        if ($this->input->get("id")){
            $where[]='subarea_id='.$this->input->get("id");
        }

        $data = json_encode(rcrud_get(
            $this->table_name
            ,array(
                'rcrud_direct_where'=>$where,
                'rcrud_order'=>array('subarea_ket asc')
            )
        ));
        echo $data;
    }

    public function getAuth(){
        echo json_encode($this->action_cek);
    }


    public function index(){
        $this->main();
    }

    public function main(){
        $data['page_head_title']='Divre';
        $data['page_head_desc']='';
        $data['action_cek'] = $this->action_cek;
        $data['breadcrumb_map']=array(
            array(
                'title'=>'Dashboard',
                'icon'=>'<i class="feather icon-home"></i>',
                'link'=>site_url('dashboard')
            ),
            array(
                'title'=>'Divre',
                'icon'=>null,
                'link'=>null
            )
        );
        $data["render_table"] = $this->render_table(
                                        "divre",  
                                        array("No","ID","Nama Area","Timezone","Action")
                                );
        $data["render_table_js"] = $this->render_table_js(
                                        "Divre",
                                        "divre",
                                        "",   
                                        array("_no","subarea_id","subarea_ket","subarea_timezone","_action"),
                                        array(), 
                                        array(),
                                        false,
                                        false,
                                        array(),
                                        "",
                                        "",
                                        "subarea_id"
                                );
        if ($this->act_create || $this->act_update || $this->act_delete){
            $data["render_form_modal"] = $this->render_form_modal(
                "Divre",
                "divre",
                "",
                array("ID","Nama Area","Timezone"),
                array("subarea_id","subarea_ket","subarea_timezone"),
                array("text","text","text"),
                array(true,true,true),
                "",
                "",
                false,
                false,
                array('subarea_id')
            );
        }
        dashboard_view('content/master/main',$data);
    }

    public function add(){
        $this->add_to_db();
    }

    function add_to_db($params=array()){
        if(rcrud_add($this->table_name, $params))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }                
    }
    
    public function edit(){
        $this->edit_to_db();
    }

    function edit_to_db($params=array()){
        if(rcrud_edit($this->table_name, $params, array('subarea_id'=>$this->input->post("subarea_id"))))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }

    public function delete(){
        $this->hard_delete();
    }

    function soft_delete(){
        $params=array(
            'id_info_sdm'=>$this->input->post('id_info_sdm'),
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
    }

    function hard_delete(){
        $params=array(
            'subarea_id'=>$this->input->post('id')
        );
        if(rcrud_delete($this->table_name,$params))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }


}