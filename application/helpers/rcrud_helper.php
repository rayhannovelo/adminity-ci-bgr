<?php
/**
*@category Internal Helpers
*@author Riyan S.I (riyansaputrai007@gmail.com)
*Dynamic basic crud for any params
*/

function rcrud_get($table_name="",$params=array())
{
    $CI=get_instance();
    $table_attr=$CI->db->list_fields($table_name);

    //Custom Select
    if(isset($params['rcrud_select']))
    { 
        $CI->db->select($params['rcrud_select']);
    }

    //Joining
    if(isset($params['rcrud_join']))
    { 
        foreach($params['rcrud_join'] as $join)
        {
            $join[2]=isset($join[2])?$join[2]:'inner';
            if( isset($join[0]) && isset($join[1]) && isset($join[2]) )
            {
                $CI->db->join($join[0],$join[1],$join[2]);
            }
        }
    }
   
    //Direct Where
    if(isset($params['rcrud_direct_where']))
    { 
        foreach($params['rcrud_direct_where'] as $where)
        {
            $CI->db->where($where);
        }
    }

    //Default Table Fields Where
    foreach($table_attr as $key)
    {
        $val=isset($params[$key])?$params[$key]:$CI->input->get($key);
        if($val!=NULL)
        {
            $CI->db->where($key,$val);
        }
    }

    // Ordering
    if(isset($params['rcrud_order']))
    { 
        foreach($params['rcrud_order'] as $order)
        {
            $CI->db->order_by($order);
        }
    }

    //Limit
    if(isset($params['rcrud_limit']))
    { 
        $CI->db->limit($params['rcrud_limit']);
    }

    $data=$CI->db->get($table_name)->result_array();
    return $data;
}

function rcrud_add($table_name="",$params=array(), $insert_id = false)
{
    
    $CI=get_instance();
    $table_attr=$CI->db->list_fields($table_name);
    $data=array();
    foreach($table_attr as $key)
    {
        $val=isset($params[$key])?$params[$key]:$CI->input->post($key);
        if($val!=NULL)
        {
            if ($val == md5('!@#$%')) {
                $val = ''; // string
            } elseif ($val == md5('!@#$%&')) {
                $val = 0; // integer
            }
            $data+=array($key=>$val);
        }
    }
    $CI->db->trans_start();
    $CI->db->insert($table_name,$data);

    if($insert_id) {
        $id = $CI->db->insert_id();
    }

    $CI->db->trans_complete();
    if($CI->db->trans_status()===TRUE)
    {
        $CI->db->trans_commit();

        if ($insert_id) {
            return array('success' => false, 'id' => $id);
        } else {
            return true;
        }
    }
    else
    {
        $CI->db->trans_rollback();
        return false;
    }
}

function rcrud_edit($table_name="",$params=array(),$conditions=array()){

    $CI=get_instance();
    $table_attr=$CI->db->list_fields($table_name);

    $data=array();
    foreach($table_attr as $key)
    {
        $val=isset($params[$key])? $params[$key] :$CI->input->post($key);

        if($val!=NULL)
        {
            if($key!=$table_attr[0])
            {
                if ($val == md5('!@#$%')) {
                    $val = ''; // string
                } elseif ($val == md5('!@#$%&')) {
                    $val = 0; // integer
                }
                $data+=array($key=>$val);
            }
        }
    }
    // //$data['keterangan'] = '';
    // print_r($data);
    // exit();
    
    $key=$table_attr[0];
    $id=$CI->input->post($key);
    if($id!=NULL)
    {
        $conditions=array($key=>$id);
    }

    $condition=array();
    foreach($table_attr as $key)
    {
        $val=isset($conditions[$key])?$conditions[$key]:NULL;
        if($val!=NULL)
        {
            $condition+=array($key=>$val);
        }
    }

    if (count($condition)>0){
        $CI->db->trans_start();
        $CI->db->where($condition);
        $CI->db->update($table_name,$data);
        $CI->db->trans_complete();
        if($CI->db->trans_status()===TRUE)
        {
            $CI->db->trans_commit();
            return true;
        }
        else
        {
            $CI->db->trans_rollback();
            return false;

        }
    }else{
        return false;
    }
}

function rcrud_delete($table_name="",$params=array())
{
    $CI=get_instance();
    $table_attr=$CI->db->list_fields($table_name);
    $CI->db->trans_start();
    
    foreach($table_attr as $key)
    {
        $val=isset($params[$key])?$params[$key]:$CI->input->get($key);
        if($val!=NULL)
        {
            $CI->db->where($key,$val);
        }
    }
    
    $CI->db->delete($table_name);

    $CI->db->trans_complete();
    if($CI->db->trans_status()===TRUE)
    {
        $CI->db->trans_commit();
        return true;
    }
    else
    {
        $CI->db->trans_rollback();
        return false;

    }
}