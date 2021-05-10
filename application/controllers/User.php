<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    //Tabel Config
    public $table_name = 'tbl_user';

    var $upload_path = 'upload/profil';

    public function __construct()
    {
        parent::__construct();
        $config['upload_path']="./".$this->upload_path;
        $config['allowed_types']='jpg|png|gif';
        $config['encrypt_name'] = TRUE;
         
        $this->load->library('upload',$config);
        //Secure controller for direct access from url
        $this->load->model('User_Model', 'user');
        $this->load->model('Auth_Model', 'auth');
        $this->load->helper('string');
    }

    public function get_temp(){
        $data_array = rcrud_get(
            "tbl_emp_temp"
            ,array(
                'rcrud_direct_where'=>array(
                                        'deleted_at is null',
                                        'nik='.$this->session->userdata("nik")
                                    ),
                'rcrud_order'=>array('id desc')
            )
        );

        $arr_gender = $this->arr_gender();
        $arr_agama = $this->arr_agama();
        $arr_status_nikah = $this->arr_status_nikah();

        $data_show = array();
        foreach ($data_array as $key => $value) {

            $value["gender"] = $arr_gender[$value["emp_sex"]];
            $value["ttl"] = $value["emp_bop"].", ".$value["emp_dob"];
            $value["agama"] = $arr_agama[$value["emp_religi"]];
            $value["status_nikah"] = $arr_status_nikah[$value["emp_mrd"]];

            if ($value["approval_status"]==0){
                $approval_status = "<label class=\"label label-warning\">Menunggu Persetujuan</label>";
            }else if ($value["approval_status"]==1){
                $approval_status = "<label class=\"label label-success\">Diterima</label>";
            }else if ($value["approval_status"]==2){
                $approval_status = "<label class=\"label label-danger\">Ditolak</label>";
            }

            if (!empty($value["approval_by"])){
                $approval_status.= "<br>
                <span class=\"text-primary f-12\">Oleh: ".$this->user->get_name($value["approval_by"])."</span>";
            }
            $value["approval_status_label"] = $approval_status;
            $data_show[] = $value;
        }

        $data = json_encode($data_show);
        echo $data;
    }

    public function profile()
    {
        $data['page_head_title'] = 'Personal Data';
        $data['page_head_desc'] = '';
        $data['breadcrumb_map'] = array(
            array(
                'title' => '',
                'icon' => '<i class="feather icon-home"></i>',
                'link' => site_url('dashboard'),
            ),
            array(
                'title' => 'User',
                'icon' => null,
                'link' => null,
            ),
            array(
                'title' => 'Personal Data',
                'icon' => null,
                'link' => site_url('user/profile'),
            ),
        );

 
        $data['user'] = $this->user->get($this->session->userdata('id_user'))[0];

        $this->session->set_userdata(
            array(
                'name' => $data['user']['full_name'],
                'email' => $data['user']['email'],
                'nik' => $data['user']['nik'],
            )
        );

        $data["render_form_modal"] = $this->render_form_modal(
                                    "Foto Profil",
                                    "user",
                                    "",
                                    array("Foto"),
                                    array("foto"),
                                    array("file_image/*"),
                                    array(true)
                                );
                    
        dashboard_view('content/user/profile', $data);
    }

    public function update_profile()
    {
        $this->db->set('grand_segment', $this->input->post('grand_segment') == '' ? NULL : $this->input->post('grand_segment'))
                 ->where('id_user', $this->session->userdata('id_user'))
                 ->update('tbl_user');

        $this->session->set_userdata('grand_segment', $this->input->post('grand_segment') == '' ? NULL : $this->input->post('grand_segment'));

        echo json_encode(array('success' => TRUE));
    }

    public function index()
    {
        if (in_array($this->session->userdata('id_usr_role'), [1, 27])) {
            $this->main();
        } else {
            redirect('dashboard');
        }
    }

    public function main()
    {
        $data['page_head_title'] = 'Users List';
        $data['page_head_desc'] = 'List Users On This System';
        $data['breadcrumb_map'] = array(
            array(
                'title' => 'Dashboard',
                'icon' => '<i class="feather icon-home"></i>',
                'link' => site_url('dashboard'),
            ),
            array(
                'title' => 'Manage Users',
                'icon' => null,
                'link' => null,
            ),
        );
        dashboard_view('content/user/main', $data);
    }

    public function update_user()
    {
        $id_user = $this->input->post('id_user');
        $nik = $this->input->post('nik');
        $full_name = $this->input->post('full_name');
        $user_area = $this->input->post('user_area');
        $user_area_old = $this->input->post('user_area_old');
        $id_usr_role = $this->input->post('id_usr_role');
        $id_usr_role_old = $this->input->post('id_usr_role_old');
        $id_usr_status = $this->input->post('id_usr_status');

        $data = array(
            'user_area' => $user_area,
            'id_usr_role' => $id_usr_role,
            'id_usr_status' => $id_usr_status
        );

        $this->db->where('id_user', $id_user)->update('tbl_user', $data);

        echo json_encode(array('status' => TRUE));
    }

    public function get()
    {
        $id = $this->input->get('id_user');
        $data_array = $this->user->get($id);
        $data = array();
        foreach ($data_array as $key => $value) {
            if ($this->session->userdata('id_usr_role') == 1) {
                $value['action'] = '
                <a href="#;" onclick="reset_password(\''.$value["nik"].'\')" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Reset Password</a>
                <a href="#;" onclick="edit_data(\''.$value["id_user"].'\')" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit User</a>';
            } else {
                $value['action'] = '
                <a href="#;" onclick="reset_password(\''.$value["nik"].'\')" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i> Reset Password</a>';
            }
            
            $data[]=$value;
        }
        echo json_encode($data);
    }

    public function get_min_active()
    {
        $id = $this->input->get('id_user');
        $data = $this->user->get_min($id,"1");
        echo json_encode($data);
    }

    public function get_min_all()
    {
        $id = $this->input->get('id_user');
        $data = $this->user->get_min($id);
        echo json_encode($data);
    }

	public function reset_device(){
        $response["success"] = false;
        if ($this->input->post("nik")){
            if ($this->user->reset_device($this->input->post("nik"))){
                $response["success"] = true;
            }
        }
        echo json_encode($response);
    }

	public function reset_password(){
        $response["success"] = false;
        if ($this->input->post("nik")){
            $new_pass = random_string('alnum', 8);
            $new_pass = 'StdpwdBgr77!';
            if (rcrud_edit('tbl_user' 
                            ,array(
                                'id_usr_status' => '2',
                                'user_limit' => '0',
                                'user_pass'=>password_hash('StdpwdBgr77!', PASSWORD_BCRYPT, ['cost' => 7])
                                )
                            ,array('nik'=>$this->input->post("nik"))
                            )
                ){
                $response["success"] = true;
                $response["message"] = "Password berhasil direset, password baru: ".$new_pass;
            }
        }
        echo json_encode($response);
    }

    function upload_foto(){
        $response['success'] = false;
        $imgOld = $this->input->post('foto_old');

        if($this->upload->do_upload("foto")){
            $data = array('upload_data' => $this->upload->data());
            $image = $data['upload_data']['file_name']; 

            $params = array("foto" => $image);
            $where = array("nik" => $this->session->userdata("nik"));

            if(rcrud_edit($this->table_name, $params, $where))
            {
                if ($imgOld!="99999999.jpg"){
                    delete_image($this->upload_path, $imgOld);
                }
                $response['success'] = true;
                $response['foto_new'] = $image;
                $user['foto'] = $image;
                $this->session->set_userdata($user);
            }          
        }
        echo json_encode($response);
    }

    public function add()
    {
        $response['success'] = false;
        $user_pass = $this->input->post('user_pass');
        $nik = $this->input->post('nik');

        $params = array(
            'nik' => $nik,
            'id_usr_status' => '2',
            'user_limit' => '0',
            'user_pass' => password_hash('StdpwdBgr77!', PASSWORD_BCRYPT, ['cost' => 7]), //$user_pass,
            'forgot_pass_token' => hash_md5('forgotpass!@#' . $nik, 5),
        );
        
        $cek_data = rcrud_get($this->table_name,array(
            "rcrud_direct_where" => array("nik=".$nik)
        ));

        if (count($cek_data)<=0){
            $add1 = rcrud_add($this->table_name, $params);
            if ($add1) {
                $id_user = 0;
                $users = rcrud_get($this->table_name, array(
                    'rcrud_order' => array('id_user DESC')
                    , 'rcrud_limit' => 1,
                ));
                foreach ($users as $user) {
                    $id_user = $user['id_user'];
                }

                if ($id_user != 0) {
                    $params = array(
                        'id_user' => $id_user,
                    );
                    $add2 = rcrud_add('tbl_usr_sessions', $params);
                    if ($add2) {
                        $response['success'] = true;
                    } else {
                        rcrud_delete($this->table_name, array(
                            'id_user' => $id_user,
                        ));
                    }
                } 
            } 
        }else{
            $response['message'] = "User sudah ditambahkan sebelumnya!";
        }
        
        echo json_encode($response);
    }

    public function edit_to_temp(){
        $cek_count_temp = $this->user->count_on_temp();
        if ($cek_count_temp<=0){
            $this->add_save();
        }else{
            $this->edit_save();
        }
    }
    
    function add_save(){
        $this->add_to_db_temp();
    }
    
    function edit_save(){
        $this->edit_to_db_temp();
    }

    function add_to_db_temp($params=array()){
        $params["nik"] = $this->session->userdata("nik");
        $params["emp_cob"] = "ID";
        $params["emp_nat"] = "ID";
        if(rcrud_add("tbl_emp_temp", $params))
        {
            $this->save_notif_permintaan_pd("pd_personal_data","Personal Data");
            echo json_encode(array('success'=>true,'message'=>'111'));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }                
    }

    function edit_to_db_temp($params=array()){
        $params["nik"] = $this->session->userdata("nik");
        $params["emp_cob"] = "ID";
        $params["emp_nat"] = "ID";
        $where = array("nik" => $this->session->userdata("nik"), "approval_status"=>"0");
        if(rcrud_edit("tbl_emp_temp", $params))
        {
            echo json_encode(array('success'=>true,'message'=>'222'));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }                
    }


    public function change_password(){
       echo json_encode($this->auth->change_password());
    }

    // public function edit()
    // {

    //     $password = $this->input->post('password');
    //     $params = array();
    //     if ($password != null) {
    //         $params += array('password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]));
    //     }

    //     if (rcrud_edit($this->table_name, $params)) {
    //         echo json_encode(array('success' => true));
    //     } else {
    //         echo json_encode(array('success' => false));
    //     }
    // }

    public function delete()
    {
        $is_edit_valid=false;
        $edit1=rcrud_edit('tbl_usr_sessions', array(
            'deleted_at' => current_datetime()
            ),
            array(
            'id_user'=>$this->input->post('id_user')
            )
        );
        if($edit1)
        {
            $edit2=rcrud_edit($this->table_name, array(
                'deleted_at' => current_datetime(),
                'id_usr_status' => 4,
            ));
            if($edit2)
            {
                $is_edit_valid=true;
            }
            else
            {
                $is_edit_valid=false;
            }
        }
        else{
            $is_edit_valid=false;
        }

        if ($is_edit_valid) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
        // if(rcrud_delete($this->table_name))
        // {
        //     echo json_encode(array('success'=>true));
        // }
        // else
        // {
        //     echo json_encode(array('success'=>false));
        // }
    }


    public function delete_temp(){
        $is_hard_delete = $this->input->post('is_hard_delete');
        if ($is_hard_delete==1){
            $this->hard_delete();
        }else{
            $this->soft_delete();
        }
    }

    function soft_delete(){
        $params=array(
            'id'=>$this->input->post('id'),
            'deleted_at'=>current_datetime()
        );
        if(rcrud_edit("tbl_emp_temp",$params))
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
            'id'=>$this->input->post('id')
        );
        if(rcrud_delete("tbl_emp_temp",$params))
        {
            echo json_encode(array('success'=>true));
        }
        else
        {
            echo json_encode(array('success'=>false));
        }
    }
    
    function add_player_id(){
        $params["nik"] = $this->session->userdata("nik");
        $params["player_id"] = $this->input->post("player_id");

        $get_id = rcrud_get(
            "tbl_device"
            ,array(
                'rcrud_direct_where'=>array("player_id='".$this->input->post("player_id")."'"),
                'rcrud_order'=>array('id desc')
            )
        );

        if (!isset($get_id[0]) && $this->input->post("player_id")){
            if(rcrud_add("tbl_device", $params))
            {
                echo json_encode(array('success'=>true));
            }
            else
            {
                echo json_encode(array('success'=>false));
            }                
        }else{
            echo json_encode(array('success'=>false));
        }
    }

    function get_user_siska($nik="0"){
        echo json_encode([]);
    }
}