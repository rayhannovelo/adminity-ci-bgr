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

function send_to_sap($url, $data){
    $CI = get_instance();
    
    if ($CI->config->item('env') == 'PROD') {
        $action_to = 'prod';
    } else {
        $action_to = 'dev';
    }

	$sap['username'] = 'it_dev';
	$sap['password'] = 'BGR2020oke';
	$sap['action_to'] = $action_to;
	$sap['url'] = 'EPROPOSAL/'.$url;
	$sap['data']['data'] = $data['data'];

	$url = 'http://36.91.23.156/SAP/integrasi.php';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sap));

	$result = curl_exec($ch);
	curl_close($ch);  
	
	$arr_result = json_decode($result);
	if (!empty($arr_result)){
		return $arr_result;
	}else{
		return strip_tags($result);
	}
}

// function send_to_sap($url, $data){
// 	$login = 'siska_po';
// 	$password = 'P@ssw0rd';
// 	$url = 'http://10.66.64.13:51500/RESTAdapter/EPROPOSAL/'.$url;
// 	//$url = 'http://10.66.63.44:51500/RESTAdapter/EPROPOSAL/'.$url;
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL,$url);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// 	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
// 	curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
// 	curl_setopt($ch, CURLOPT_POST, true);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));

// 	$result = curl_exec($ch);
// 	curl_close($ch);  
// 	$arr_result = json_decode($result);
// 	if (!empty($arr_result)){
// 		return $arr_result;
// 	}else{
// 		return strip_tags($result);
// 	}
// }

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

function send_to_sap_invoice($action = 'I', $invoice_id) {
	$CI = get_instance();

	$get_step_id = rcrud_get(
        "tbl_step_invoice"
        ,array(
            'rcrud_direct_where'=>array('invoice_id="'.$invoice_id.'"'),
            'rcrud_order'=>array('id desc')
        )
    )[0];

	$invoice = $CI->db->join('tbl_branch', 'tbl_branch.id = tbl_invoices.branch')
                                    ->join('tbl_customer', 'tbl_customer.kd_plg = tbl_invoices.customer_id')
                                    ->where('tbl_invoices.id', $invoice_id)
                                    ->select('tbl_invoices.*, tbl_branch.profit_center, tbl_customer.account_group')
                                    ->get('tbl_invoices')->row_array();
                
    $data["INV_HEADER"]["item"][] = array(
        "ID_INVOICE"        => $invoice['id'],// primary key 
        "NO_INVOICE"        => $invoice['no_invoice'],
        "CREATE_DATE"       => date('Ymd', strtotime($invoice['created_at'])), // tgl pembuatan
        "UPDATE_DATE"       => date('Ymd', strtotime($invoice['updated_at'])),
        "INVOICE_DATE"      => date('Ymd', strtotime($invoice['periode_tagihan'])), // tgl invoice
        "BASE_DAY"          => $invoice['jumlah_hari'], // jeda hari dari tgl invoice
        "CURR"              => 'IDR', // kurensi
        "KUNNR"             => $invoice['customer_id'],// kode customer '10000251'
        "PROFIT_CENTER"     => $invoice['profit_center'],// kode customer 'RG11001'
     	"COMPANY"           => $invoice['document_company'], // 1977
	    "DOC_NO"            => $invoice['document_number'], // '1800000015'
	    "DOC_YEAR"          => $invoice['document_year'], // 2021
        "CUST_NAME"         => substr(trim($invoice['customer']), 0, 35),
        "STREET"            => substr(trim(strip_tags($invoice['alamat'])), 0, 35),
        "CITY"              => '.',
        "HEADER_TEXT"       => substr(trim($invoice['header_text']), 0, 25), // 2021
        "ACT"               => $action // action I = insert, U = Update, D = Delete
    );

    $invoice_details = $CI->db->join('tbl_invoice_io_ps as a', 'a.proposal_id = tbl_invoice_details.proposal_id', 'left')
                               ->join('tbl_invoice_io_ps as b', 'b.io_ps_manual_id = tbl_invoice_details.io_ps_manual_id', 'left')
                               ->join('tbl_coa', 'tbl_coa.id = tbl_invoice_details.coa_id', 'left')
                               ->where('tbl_invoice_details.step_invoice_id', $get_step_id["id"])
                               ->group_start()
                                    ->where('a.invoice_id', $invoice_id)
                                    ->or_where('b.invoice_id', $invoice_id)
                               ->group_end()
                   			   ->where('tbl_invoice_details.tipe_tagihan', 1)
                               ->select('tbl_invoice_details.*, a.no_io_ps, b.no_io_ps as no_io_ps_manual, tbl_coa.name as coa_name')
                               //->select_sum('harga')
                               //->group_by('tbl_invoice_details.coa_id')
                               ->order_by('a.no_io_ps, b.no_io_ps, tbl_invoice_details.coa_id')
                               ->get('tbl_invoice_details')
                               ->result_array();

    $ppn = $CI->db->where('tbl_invoice_details.step_invoice_id', $get_step_id["id"])
                   ->where('tbl_invoice_details.invoice_id', $invoice_id)
       			   ->where('tbl_invoice_details.tipe_tagihan', 2)
       			   ->where('tbl_invoice_details.tipe_pajak', 1)
                   ->select('tbl_invoice_details.*')
                   ->get('tbl_invoice_details')
                   ->result_array();

    // dd($invoice_details);
    // dd($ppn);

    $index = 1;
    foreach ($invoice_details as $key => $value) {

        $order = $value['no_io_ps'] . $value['no_io_ps_manual'];
        $order = (strlen($order) == 12 ? $order : '');

        $notFound = TRUE;
        foreach ($ppn as $key => $value1) {
            if ($value1['parent_id'] == $value['id']) {

                // PPN
                $data["INV_ITEM"]["item"][] = array( //untuk list pendapatan
                	"INDEX"				=> $index,
                    "ID_INVOICE"        => $invoice['id'], //  primary key
                    "GL"                => $value['coa_id'], // coa pendapatan
                    "AMOUNT"            => $value['harga'], // nilai
                    "PPN"               => ppnType($value1['tagihan'], $invoice['account_group'], $value1['harga']), // jenis PPN
                    "PROFIT_CENTER"     => $invoice['profit_center'], // profit center
                    "ORDER"             => $order, // IO '000610000036'
                    "PROJECT"           => $value['wbs_id'], // Project
                    "DESC"              => $value['coa_name'] //keterangan
                );

                $notFound = FALSE;

                $index++;
            }
        }

        if ($notFound) {

        	// PPN
            $data["INV_ITEM"]["item"][] = array( //untuk list pendapatan
            	"INDEX"				=> $index,
                "ID_INVOICE"        => $invoice['id'], //  primary key
                "GL"                => $value['coa_id'], // coa pendapatan
                "AMOUNT"            => $value['harga'], // nilai
                "PPN"               => 'A0', // jenis PPN
                "PROFIT_CENTER"     => $invoice['profit_center'], // profit center
                "ORDER"             => $order, // IO '000610000036'
                "PROJECT"           => $value['wbs_id'], // Project
                "DESC"              => $value['coa_name'], //keterangan
            );

            $index++;
        }
    }

    $pph = $CI->db->join('tbl_pph', 'tbl_pph.pph_desc = tbl_invoice_details.tagihan', 'left')
                   ->where('tbl_invoice_details.step_invoice_id', $get_step_id["id"])
                   ->where('tbl_invoice_details.invoice_id', $invoice_id)
                   ->where('tbl_invoice_details.tipe_tagihan', 2)
                   ->where('tbl_invoice_details.tipe_pajak', 2)
                   ->select('tbl_invoice_details.*, tbl_pph.id as pph_id, tbl_pph.coa_id as pph_coa_id')
                   ->select_sum('tbl_invoice_details.harga')
                   ->group_by('tagihan')
                   ->get('tbl_invoice_details')
                   ->result_array();

	foreach ($pph as $key => $value) {

		// PPh
        $data["INV_TAX"]["item"][] = array( // untuk PPH
            "ID_INVOICE"        => $invoice['id'], // primari key
            "GL"                => $value['pph_coa_id'], // coa pph
            "ZPPH"              => $value['pph_id'], // tipe pph
            "AMOUNT"            => $value['harga'] // nilai
        );
    }

    $materai = $CI->db->join('tbl_materai', 'tbl_materai.materai_desc = tbl_invoice_details.tagihan', 'left')
	                   ->where('tbl_invoice_details.step_invoice_id', $get_step_id["id"])
	                   ->where('tbl_invoice_details.invoice_id', $invoice_id)
	                   ->where('tbl_invoice_details.tipe_tagihan', 3)
	                   ->limit(1)
	                   ->select('tbl_invoice_details.*, tbl_materai.id as materai_id, tbl_materai.coa_id as materai_coa_id')
	                   ->get('tbl_invoice_details')
	                   ->result_array();

	foreach ($materai as $key => $value) {

		// Materai
        $data["INV_MTRI"]["item"][] = array( // untuk materai
            "ID_INVOICE"        => $invoice['id'], //primari key
            "ZMTRI"             => $value['materai_id'], // tipe materai
            "AMOUNT"            => $value['harga'] // nilai
        );
    }

    // dd($data);
    // exit();

    if ($CI->config->item('env') == 'PROD') {
        $action_to = 'prod';
    } else {
        $action_to = 'dev';
    }

    $sap['username'] = 'it_dev';
    $sap['password'] = 'BGR2020oke';
    $sap['action_to'] = $action_to;
    $sap['url'] = 'EPROPOSAL/Invoice';
    $sap['data'] = $data;

    $url = 'http://36.91.23.156/SAP/integrasi.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sap));

    $result = curl_exec($ch);
	curl_close($ch);  

    // dd($result);
	
	$arr_result = json_decode($result);

	// dd($arr_result);
	if (!empty($arr_result)){
		return $arr_result;
	}else{
		return strip_tags($result);
	}
}

function send_to_sap_cek_invoice($action = 'I', $invoice_id) {
    $CI = get_instance(); 

	$data = array(
	    "ACT"               => $action, // action I, U, D. 
	    "ID_INVOICE"        => $invoice_id // id invoice primary key
	);

    // dd($data);

    if ($CI->config->item('env') == 'PROD') {
        $action_to = 'prod';
    } else {
        $action_to = 'dev';
    }

    $sap['username'] = 'it_dev';
    $sap['password'] = 'BGR2020oke';
    $sap['action_to'] = $action_to;
    $sap['url'] = 'EPROPOSAL/CekInvoice';
    $sap['data'] = $data;

    $url = 'http://36.91.23.156/SAP/integrasi.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sap));

    $result = curl_exec($ch);
    curl_close($ch);  

	// dd($result);
	
	$arr_result = json_decode($result);

	// dd($arr_result);
	if (!empty($arr_result)){
		return $arr_result;
	}else{
		return strip_tags($result);
	}
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}