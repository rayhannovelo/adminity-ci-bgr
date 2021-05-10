<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    var $captcha_sess_key = 'BGR_SECURITY_CAPTCHA';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_Model','auth');
    }

    public function index()
    {
        if($this->verify_login())
        {
            redirect(site_url('/dashboard'));
        }
        else
        {
            $this->load->view('content/auth/login');
        }
    }

    public function login()
    {
        if ($this->captcha_validate()){
            echo json_encode($this->auth->validate_login());
        }else{
             echo json_encode(array('captcha_wrong' => true));
        }
    }

    function generate_captcha()
    {
        // load codeigniter captcha helper
        $this->load->helper('captcha');

        $words = array_merge(range('1', '9'), range('A', 'Z'));
        shuffle($words);
        $max_length = 5;
        $words = substr(implode($words), 0, $max_length);

        $vals = array(
            'word' => $words,
            'img_path'     => './captcha/',
            'img_url'     => base_url() . 'captcha/',
            'img_width'     => '160',
            'img_height'    => 50,
            'expiration'    => 7200,
            'font_size'     => 20,
            'font_path'  => FCPATH . '/assets/fonts/Verdana.ttf',
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        // create captcha image
        $cap = create_captcha($vals);

        // store the captcha word in a session
        $this->session->set_userdata($this->captcha_sess_key, $cap['word']);
        echo $cap['image'];
    }

    function captcha_validate()
    {
        $is_valid = false;
        $words = $this->input->post('captcha_words');
        if ($this->session->userdata($this->captcha_sess_key) == $words) {
            $is_valid = true;
        }

        return $is_valid;
        //echo json_encode(array('is_valid' => $is_valid));
    }

    public function logout()
    {
        $login_token=$this->input->post('login_token');
        $token=$this->session->userdata('login_token');

        if($login_token!=null)
        {
            if($login_token==$token)
            {    
                $this->auth->update_session($this->session->userdata('id_user'),'logout');
                $this->session->sess_destroy();
                echo json_encode(array('success'=>true,'logout_state'=>true,'logout_msg'=>'Logout successfull!'));
            }
            else
            {
                echo json_encode(array('success'=>true,'logout_state'=>false,'logout_msg'=>'Login token not valid!'));
            }
        }
        else
        {
            echo json_encode(array('success'=>true,'logout_state'=>false,'logout_msg'=>'Login token not valid!'));
        }
    }
}