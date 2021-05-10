<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_Model extends CI_Model{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('User_Model','user');
    }
    
    public function validate_login(){
        $nik=$this->input->post('nik');
        $password=$this->input->post('password');
        $params=array(
            'nik'=>$nik
        );

        $validate=$this->db
        ->where($params)
        ->where('deleted_at is null')
        ->get('tbl_user')
        ->row_array();

        if ($validate == '') {
            $validate = [];
        }

        $data=array('login'=>false);
        $is_valid=false;
        $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'Wrong nik or password!');

        if(count($validate)>=1 && $validate["user_limit"]<3 && $validate["id_usr_status"]==2)
        {
            $password_encrypt=$validate['user_pass'];
            if(password_verify($password,$password_encrypt))
            {    
                $users=$this->user->get($validate['id_user']);
                $user=array();
                foreach($users as $usr)
                {
                    if($usr['id_usr_status']==2)
                    {
                        // if($usr['is_logged']==0)
                        // {
                            $usr['password']=null;
                            $usr['login']=true;
                            $usr['login_token']=password_hash($usr['id_user'].'&&'.Date('Y-m-d H:i:s'),PASSWORD_DEFAULT);
                            $usr['nama']=$usr['full_name'];
                            $usr['user_area']=$usr['user_area'];
                            $usr['profit_center']=$usr['profit_center'];
                            $usr['grand_segment']=$usr['grand_segment'];
                            $user=$usr;
                            $this->session->set_userdata($user);
                            $is_valid=true;
                            $return=array('succces'=>true,'login_state'=>true,'login_msg'=>'Login berhasil!');
                            //$this->update_session($usr['id_user'],'login');
                            $this->clear_limit($nik);
                        // }
                        // else
                        // {
                        //     $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'Your account still logged in at other device!');
                        // }
                    }
                }
            }else{
                $count_salah = $validate['user_limit'] + 1;
                $this->update_limit($nik, ($count_salah<3?false:true));
                if ($count_salah<3){
                    $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'Anda telah salah memasukan password sebanyak '.$count_salah);
                }else{
                    $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'Akun anda telah terblokir!');
                }
            }
        }else{
            if (count($validate)>=1){
                $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'Akun anda telah terblokir!');
            }else{
                $return=array('succces'=>true,'login_state'=>false,'login_msg'=>'NIK tidak terdaftar!');
            }
        }

        if ($this->agent->is_browser()){
            $agent = $this->agent->browser().' '.$this->agent->version();
        }elseif ($this->agent->is_mobile()){
            $agent = $this->agent->mobile();
        }else{
            $agent = 'Data user gagal di dapatkan';
        }

        $log_data = [
            'captcha' => $this->input->post('captcha_words'),
            'user_id' => $nik,
            'company_id' => '',
            'login_at' => date('Y-m-d H:i:s'),
            'logout_at' => '',
            'browser' => $agent,
            'platform' => $this->agent->platform(),
            'ip' => $this->input->ip_address(),
        ];

        $this->db->insert('tbl_log_login', $log_data);

        return $return;
    }

    public function update_session($id_user,$state)
    {

        if($state=='login')
        {
            $data=array(
                'login_time'=>current_datetime(),
                //'is_logged'=>1,
                'is_logged'=>0,
                'usr_login_ip'=>get_client_ip_env()
            );
        }
        else
        {
            $data=array(
                'logout_time'=>current_datetime(),
                'is_logged'=>0,
                'usr_logout_ip'=>get_client_ip_env()
            );
        }

        $this->db
        ->where('id_user',$id_user)
        ->update('tbl_usr_sessions',$data);
    }

    public function update_limit($nik, $block=false)
    {
        if ($block){
            $this->db->set('id_usr_status', '3', FALSE);
        }
        $this->db->set('user_limit', 'user_limit + ' . (int) 1, FALSE)
        ->where('nik',$nik)
        ->update('tbl_user');
    }    
    public function clear_limit($nik)
    {
        $this->db->set('user_limit', '0', FALSE)
        ->where('nik',$nik)
        ->update('tbl_user');
    }    
    
    public function change_password(){
        $nik=$this->session->userdata('nik');
        $password=$this->input->post('password_old');
        $password_new=$this->input->post('password_new');
        $params=array(
            'nik'=>$nik
        );

        $validate=$this->db
        ->where($params)
        ->where('deleted_at is null')
        ->get('tbl_user')
        ->row_array();

        $return=array('succces'=>false,'message'=>'Password lama yang anda masukan salah!');
        if(count($validate)>=1)
        {
            $password_encrypt=$validate['user_pass'];
            if(password_verify($password,$password_encrypt))
            {   
                $data=array(
                    'user_pass'=>password_hash($password_new, PASSWORD_BCRYPT, ['cost' => 7])
                );    
                $this->db
                ->where('nik',$nik)
                ->update('tbl_user',$data);
                $return=array('succces'=>true,'message'=>'Password berhasil diubah, silahkan login ulang dengan password yang baru!');
            }
        }

        return $return;
    }
}