<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_controller {

    //Tabel Config
    var $table_name='tbl_notifikasi';

    var $action_cek='';

    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $param["rcrud_order"]=array('id desc');
        $param["rcrud_direct_where"][]='nik="'.$this->session->userdata("nik") .'"';
        if ($this->input->post("status")!=null){
            $param["rcrud_direct_where"][]='status='.$this->input->post("status");
        }
        if ($this->input->post("limit")){
            $param["rcrud_limit"]=$this->input->post("limit");
        }

        $data = json_encode(rcrud_get($this->table_name,$param));
        echo $data;
    }

    public function getAuth(){
        echo json_encode($this->action_cek);
    }


    public function index(){
        $this->main();
    }

    public function main(){
        $data['page_head_title']='Notifikasi';
        $data['page_head_desc']='';
        $data['action_cek'] = $this->action_cek;
        $data['breadcrumb_map']=array(
            array(
                'title'=>'Dashboard',
                'icon'=>'<i class="feather icon-home"></i>',
                'link'=>site_url('dashboard')
            ),
            array(
                'title'=>'Notifikasi',
                'icon'=>null,
                'link'=>null
            )
        );
        $data["render_table"] = $this->render_table(
                                        "notifikasi",  
                                        array("No","Tanggal","Title","Detail","Open")
                                );
        $data["render_table_js"] = $this->render_table_js(
                                        "Notifikasi",
                                        "notifikasi",
                                        "_notifikasi",   
                                        array("_no","created_at","_title_notif","detail","_link_notif"),
                                        array("","","","px40p","")                                ,
                                        array("","","","","")                                           
                                );
      
        dashboard_view('content/master/main',$data);
    }

    public function link_notif($id){
        $param["rcrud_direct_where"][]='id='.$id;
        $param["rcrud_direct_where"][]='nik="'.$this->session->userdata("nik").'"';
        $get_detail = rcrud_get($this->table_name,$param)[0];
        if (!empty($get_detail)){
            rcrud_edit($this->table_name, array("status" => "1"), array("id" => $get_detail["id"]));

            if ($get_detail["link_type"]==1){
                redirect(site_url($get_detail["link"]));
            }else{
                redirect($get_detail["link"]);
            }
        }else{
            redirect(site_url("notifikasi"));
        }
    }
}