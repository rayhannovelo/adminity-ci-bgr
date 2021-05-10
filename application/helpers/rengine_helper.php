<?php
if(!function_exists('delete_image'))
{
    function delete_image($path,$filename)
	{
		if (!empty($filename) && file_exists(FCPATH."$path/$filename"))
		{
			$filename = explode(".", $filename);
			return array_map('unlink', glob(FCPATH."$path/$filename[0].*"));
		}else{
			return true;
		}
	}
}

function get_browser_using(){
	$CI=get_instance();

	if ($CI->agent->is_browser())
	{
			$agent = $CI->agent->browser().' '.$CI->agent->version();
	}
	elseif ($CI->agent->is_robot())
	{
			$agent = $CI->agent->robot();
	}
	elseif ($CI->agent->is_mobile())
	{
			$agent = $CI->agent->mobile();
	}
	else
	{
			$agent = 'Unidentified User Agent';
	}
	return $agent;
}

function getRomawi($bln)
{
    switch ($bln) {
        case 1:
            return "I";
            break;
        case 2:
            return "II";
            break;
        case 3:
            return "III";
            break;
        case 4:
            return "IV";
            break;
        case 5:
            return "V";
            break;
        case 6:
            return "VI";
            break;
        case 7:
            return "VII";
            break;
        case 8:
            return "VIII";
            break;
        case 9:
            return "IX";
            break;
        case 10:
            return "X";
            break;
        case 11:
            return "XI";
            break;
        case 12:
            return "XII";
            break;
    }
}

function dd($data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

function ppnType($ppn, $account_group, $harga)
{
	if ($ppn == 'PPN 0%') {
		return 'A0';
	} elseif ($ppn == 'PPN 10%' AND $harga < 10000000 AND $account_group == 'CBMN') {
		return 'A1';
	} elseif ($ppn == 'PPN 10%' AND $harga >= 10000000 AND $account_group == 'CBMN') {
		return 'A2';
	} elseif ($ppn == 'PPN 10%') {
		return 'A3';
	} elseif ($ppn == 'PPN 0%') {
		return 'A4';
	} elseif ($ppn == 'PPN 1%' AND $account_group != 'CBMN') {
		return 'A5';
	} elseif ($ppn == 'PPN 1%' AND $account_group == 'CBMN') {
		return 'A6';
	} else {
		return 'A0';
	}
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}