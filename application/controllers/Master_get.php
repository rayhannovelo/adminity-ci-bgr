<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_get extends MY_controller {

    public function __construct(){
        parent::__construct();
    }

    public function branch(){
        $data = json_encode(rcrud_get(
            "tbl_branch"
            ,array(
                'rcrud_order'=>array('name asc')
            )
        ));
        echo $data;
    }
}