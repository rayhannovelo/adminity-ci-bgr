<?php
/**
*@category Internal Helpers
*@author Riyan S.I (riyansaputrai007@gmail.com)
*/

if(!function_exists('dashboard_view'))
{
    function dashboard_view($page=null,$data=null)
	{
		$CI = get_instance();
		if($page!=null)
		{

			$CI->db->from("tbl_notifikasi")
			->where('status','0')
			->where('nik',$CI->session->userdata("nik"))
			;

			$data['_count_notif'] = $CI->db->count_all_results();

			$data['_contents']=$CI->load->view($page,$data,true);
		}
		else
		{
			$data['_contents']=null;
		}
		return $CI->load->view('template/dashboard',$data);
    }
}

if(!function_exists('template_view'))
{
    function template_view($template,$page,$data=null)
	{
		$CI = get_instance();
		$data['_contents']=$CI->load->view($page,$data,true);
		return $CI->load->view($template,$data);
	}
}


function sessionTimeout(){
}