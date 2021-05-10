<?php
class MY_controller extends  CI_controller
{
    var $CI = "";
    var $action_cek='';
    var $act_create = '';
    var $act_update = '';
    var $act_delete = '';
    var $act_hard_delete = '';
    var $act_detail = '';
    var $data_pejabat;
    var $site_config = array();

    public function __construct(){
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->load->model('Array_model','m_array');
		$this->CI->load->model('Menu_Model','menu');
        $this->CI->load->model('User_Model','user');

        $data = $this->db->get('tbl_settings')->result();
        foreach ($data as $value) {
            $this->site_config[$value->key_setting] = $value->val_setting;
        }

        if ($this->CI->router->fetch_class()!="auth"){
            if($this->verify_login(true)){
                $controller=array(
                    'requested'=>array('class'=>$this->CI->router->fetch_class(),'method'=>$this->CI->router->fetch_method())
                );
                $this->action_cek = $this->authorize_controller($controller);
                $this->act_create = $this->action_cek["act_create"];
                $this->act_update = $this->action_cek["act_update"];
                $this->act_delete = $this->action_cek["act_delete"];
                $this->act_hard_delete = $this->action_cek["act_hard_delete"];
                $this->act_detail = $this->action_cek["act_detail"];
            }
        }
    }

    function render_table(
                            $table_name,
                            $header
                         ){

        $show_header = "";
        foreach ($header as $key => $value) {
            $show_header.="<th>".$value."</th>";
        }

        $render = '
		<div class="table-responsive">
			<div class="dt-responsive table-responsive">
				<table id="table_'.$table_name.'" class="table table-striped table-bordered">
					<thead>
						<tr>
							'.$show_header.'
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
        ';
        return $render;

    }

    function render_table_js(
                            $title_page, 
                            $page, 
                            $field_suffix, 
                            $field, 
                            $class=array(), 
                            $cutstring=array(),
                            $allowExport=false,
                            $serverSide=false,
                            $filter = array(),
                            $table_name_custom = "",
                            $url_get_data = "",
                            $primary_key = ""
                        ){
        ob_start();
        ?>
<style type="text/css">
    .dataTables_processing {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        z-index: 11000 !important;
    }
</style>
            <script>
                    var isEdit=false;
                    var _datatable;
                    $('document').ready(function(){
                        var form=$('#form');
                        var table_<?php echo (!empty($table_name_custom)?$table_name_custom:$page); ?>=$('#table_<?php echo (!empty($table_name_custom)?$table_name_custom:$page); ?>');
                        var no=0;

                        _datatable = table_<?php echo (!empty($table_name_custom)?$table_name_custom:$page); ?>.DataTable({<?php if ($allowExport){ ?>                                
                                dom: 'lBfrtip',
                                buttons: [
                                    'copy', 'excel', 'print'
                                ],<?php } if ($serverSide){ ?>
                                "processing": true,
                                "language": {
                                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                                },
                                "serverSide": true,<?php } ?>
                                "aaSorting": [],
                                "initComplete": function (settings, json) {
                                },
                                "lengthMenu": [10, 25, 50],
                                "retrieve": true,
                                'ajax': {
                                    "type": "POST",
                                    "url": site_url + '/<?php echo $page."/".(!empty($url_get_data)?$url_get_data:"get"); ?>',
                                    "data": function (d) {
                                        <?php
                                        foreach ($filter as $key => $value) {
                                            echo "
                                            d.".$value." = $('#".$value."').val();
                                            ";
                                        }
                                        ?>
                                        //console.log(d);
                                        no=0;
                                    },
                                    "dataSrc": "<?php echo $serverSide?"data":"";?>"
                                },
                                'columns': [
                                    <?php 
                                        foreach ($field as $key => $columnName)
                                        {	
                                                $strCustom=$this->custom_row($field_suffix, $columnName, $primary_key);
                                                if($strCustom!="")
                                                {
                                                        echo $strCustom;
                                                }
                                                else{
                                                        echo "                                                        
                                                            {
                                                                className: '".(isset($class[$key])?$class[$key]:"")."',
                                                                render: function (data, type, full, meta) {
                                                                    return full.".$columnName."".(isset($cutstring[$key]) && $cutstring[$key]>0?".substring(0, 50)+'...'":"").";
                                                                }
                                                            },
                                                        ";
                                                }                                            
                                        }
                                    ?>
                                ]
                            });
                        
 
                        $('#btn-filter').click(function(){ 
                            _datatable.ajax.reload();  
                        });
                        $('#btn-reset').click(function(){ 
                            $('#form-filter')[0].reset();
                            $('#filter_order_type').val('').trigger('change');
                            $('#filter_branch').val('').trigger('change');
                            $('#filter_jenis_modul').val('').trigger('change');
                            $('#filter_grand_segment').val('').trigger('change');
                            $('#filter_customer').val('').trigger('change');
                            $('#filter_last_status').val('').trigger('change');
                            $('#filter_start').val('').trigger('change');
                            $('#filter_end').val('').trigger('change');
                            $('#filter_iops').val('').trigger('change');
                            _datatable.ajax.reload();  
                        });

                    });

            </script>
        <?php
        $render = ob_get_clean();
        return $render;
    }

    function render_form_modal($title_page, 
                            $page,
                            $field_suffix, 
                            $arrTitle,
                            $arrField,
                            $arrFieldType,
                            $arrRequired,
                            $page_get_edit="",
                            $file_folder = "",
                            $is_perubahan_data = false,
                            $show_ktp_kk = false,
                            $disable_on_edit = array()
    ){
        ob_start()
        ?>
        <div class="modal fade" id="modal-container" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"></h4>
                        <button type="button" class="close" id="close_dialog" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form">
                            <div>
                                <input type="hidden" name="id<?php echo $field_suffix; ?>" id="id">
                            </div>
                            <?php
                            $adaFile = false;
                            $fileRequired = false;
                            $file_id_name = "";
                            foreach ($arrTitle as $key => $value) {
                                $name_field = $arrField[$key].$field_suffix;
                                $required = $arrRequired[$key];
                                $type = explode("_",$arrFieldType[$key]);
                            if ($type[0]!="custom"){
                            $show = '';
                                if ($type[0]!="hidden"){
                                $show.= '
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="'.$name_field.'">'.$value.'<span class="required '.($type[0]=="file"&&$required?"span_req_file":"").'" style="color:#ff3333;">'.($required?'*':'').'</span>
                                    </label>
                                    <div class="col-sm-9">';
                                }
                                    if ($type[0]=="file"){
                                        $adaFile = true;
                                        $fileRequired = $required;
                                        $file_id_name = $name_field;
                                        $show.='<input id="'.$name_field.'" class="form-control" name="'.$name_field.'" placeholder="'.$value.'" type="file" accept="'.(!empty($type[1])?$type[1]:'').'" '.($required?'required="required"':'').'>
                                        <input type="hidden" name="'.$name_field.'_old" id="'.$name_field.'_old">
                                        <a href="" target="_blank" rel="noopener noreferrer" class="text-primary" id="href_file"></a>
                                        ';
                                    }else if ($type[0]=="textarea"){
                                        $show.='<textarea id="'.$name_field.'" class="form-control" name="'.$name_field.'" placeholder="'.$value.'" cols="5" rows="5" '.($required?'required="required"':'').'></textarea>';
                                    }else if ($type[0]=="select"){
                                        $show.='                                 
                                        <select id="'.$name_field.'" class="js-example-basic-single" name="'.$name_field.'" '.($required?'required="required"':'').'>';
                                        if ($type[1]=="pejabat"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            if (empty($this->data_pejabat)){
                                                $data_pejabat=$this->CI->user->get_pejabat_area($this->CI->session->userdata('nik'),$this->CI->session->userdata('or_perssubarea'));
                                            }
                                            foreach ($data_pejabat as $key => $value) {
                                                $show.='<option value="'.$value->nik.'">'.$value->emp_fullname.' / '.$value->pos_objnm.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="jenispersonalid"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_jenis_personalid() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="izintype"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_izin_type() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="gender"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_gender() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="agama"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_agama() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="comtype"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_com_type() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="famtype"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_fam_type() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="addtype"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_add_type() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="addprov"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_provinsi() as $key => $value) {
                                                $show.='<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        }
                                        else if ($type[1]=="subarea"){
                                            $show.='<option value="">Silahkan Pilih</option>';
                                            foreach ($this->arr_subarea() as $key => $value) {
                                                $show.='<option value="'.$value["subarea_id"].'">'.$value["subarea_ket"].'</option>';
                                            }
                                        }
                                        $show.='</select>
                                        
                                        <script>
                                        $(\'document\').ready(function () {
                                            $("#'.$name_field.'").select2({
                                                dropdownParent: $("#modal-container")
                                            });
                                        });
                                        </script>   
                                        '; 
                                    }else{
                                        $show.='<input id="'.$name_field.'" class="form-control" name="'.$name_field.'" placeholder="'.$value.'" type="'.$type[0].'" '.($required?'required="required"':'').'>';
                                    }
                                if ($type[0]!="hidden"){
                                    $show.='</div>
                                    </div>
                                    ';
                                }
                            }else{
                                $show = '';
                                if ($type[1]=="konfirmasiabsen"){
                                    $show.= '
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="izin_type">Izin Untuk<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="izin_type" onchange="ocIzinType(this);" class="form-control" name="izin_type" required>';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        foreach ($this->arr_izin_type() as $key => $value) {
                                            $show.='<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                    
                                    $show.= '
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="izin_type">Keterangan<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="confirm_type" onchange="ocConfirmType(this);" class="form-control" name="confirm_type" required>';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                    
                                    $show.= '
                                    <div class="form-group row subconfirm_type" style="display:none;">
                                        <label class="col-sm-3 col-form-label" for="subconfirm_type">Keterangan Lengkap<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="subconfirm_type" class="form-control" name="subconfirm_type">';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                    
                                    $show.="
                                    <script>
            
                                    function ocIzinType(el,val_selected=null){
                                        if (el.value!=null){
                                            val_id = el.value;
                                        }else{
                                            val_id = el;
                                        }
                                                    $.ajax({
                                                        url: site_url+'/konfirmasi_absen/get_confirm_type',
                                                        type: 'POST',
                                                        data: {val_id: val_id, val_selected: val_selected}, 
                                                        dataType: 'html',
                                                        success: function(result){  
                                                            $('select[name=confirm_type]').html(result);
                                                        }
                                                    });
                                    }
                                    
                                    function ocConfirmType(el,val_selected=null){
                                        if (el.value!=null){
                                            val_id = el.value;
                                        }else{
                                            val_id = el;
                                        }
                                        $.ajax({
                                            url: site_url+'/konfirmasi_absen/get_subconfirm_type',
                                            type: 'POST',
                                            data: {val_id: val_id, val_selected: val_selected}, 
                                            dataType: 'html',
                                            success: function(result){  
                                                if (result==0){
                                                    $('.subconfirm_type').css('display','none');
                                                    $('select[name=subconfirm_type]').attr('required',false);
                                                }else{
                                                    $('.subconfirm_type').css('display','');
                                                    $('select[name=subconfirm_type]').attr('required',true);
                                                }
                                                $('select[name=subconfirm_type]').html(result);
                                            }
                                        });
                                    }
                                    
                                    </script>";
                                }
                                else if ($type[1]=="edutype"){
                                    $show.= '
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="edu_subtype">Jenis Pendidikan<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="edu_subtype" onchange="ocEduType(this.value);" class="form-control" name="edu_subtype" required>';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        foreach ($this->arr_edu_subtype() as $key => $value) {
                                            $show.='<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                    $show.= '
                                    <div class="form-group row row_edu_lvl" style="display:none;">
                                        <label class="col-sm-3 col-form-label" for="edu_lvl">Jenjang Pendidikan<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="edu_lvl" class="form-control" name="edu_lvl">';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        foreach ($this->arr_edu_lvl() as $key => $value) {
                                            $show.='<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='
                                        </div>
                                    </div>';    
                                    $show.= '
                                    <div class="form-group row row_edu_jurusan1" style="display:none;">
                                        <label class="col-sm-3 col-form-label" for="edu_jurusan1">Jurusan<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="edu_jurusan1" class="form-control" name="edu_jurusan1">';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        foreach ($this->arr_jurusan() as $key => $value) {
                                            $show.='<option value="'.$value["jurusan_id"].'">'.$value["jurusan_name"].'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='
                                        </div>
                                    </div>';                     
                                                                        
                                    $show.="
                                    <script>
                                    function ocEduType(el,val_selected=null){
                                        if (el==10){
                                            $('.row_edu_lvl').css('display','');
                                            $('.row_edu_jurusan1').css('display','');
                                            $('#edu_lvl').prop('required',true);
                                            $('#edu_jurusan1').prop('required',true);
                                        }else{
                                            $('.row_edu_lvl').css('display','none');
                                            $('.row_edu_jurusan1').css('display','none');
                                            $('#edu_lvl').prop('required',false);
                                            $('#edu_jurusan1').prop('required',false);
                                        }
                                    }
                                    
                                    $('document').ready(function () {
                                        $('#edu_jurusan1').select2({
                                            dropdownParent: $(\"#modal-container\")
                                        });
                                    });
                                    </script>";
                                }
                                else if ($type[1]=="educer"){
                                    
                                    $adaFile = true;
                                    $fileRequired = true;
                                    $file_id_name = "file_image";
                                    $show.= '
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="edu_cer">Sertifikat<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">';
                                        $show.='<select id="edu_cer" onchange="ocEduCer(this.value);" class="form-control" name="edu_cer" required>';
                                        $show.='<option value="">Silahkan Pilih</option>';
                                        foreach ($this->arr_edu_cer() as $key => $value) {
                                            $show.='<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                    $show.= '
                                    <div class="form-group row row_edu_nocer" style="display:none;">
                                        <label class="col-sm-3 col-form-label" for="edu_nocer">No Sertifikat<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                        <input type="text" placeholder="No Sertifikat" class="form-control" name="edu_nocer" id="edu_nocer">
                                        </div>
                                    </div>';      
                                    $show.= '
                                    <div class="form-group row row_file_image" style="display:none;">
                                        <label class="col-sm-3 col-form-label" for="file_image">File Sertifikat<span class="required span_req_file" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-9">
                                        <input type="file" class="form-control" name="file_image" id="file_image" accept="image/*">
                                        <input type="hidden" name="file_image_old" id="file_image_old">
                                        <a href="" target="_blank" rel="noopener noreferrer" class="text-primary" id="href_file"></a>
                                        </div>
                                    </div>';                    
                                   
                                    $show.="
                                    <script>
                                    function ocEduCer(el,val_selected=null){
                                        if (el==01){
                                            $('.row_edu_nocer').css('display','');
                                            $('#edu_nocer').prop('required',true);
                                            $('.row_file_image').css('display','');
                                            $('#file_image').prop('required',true);
                                        }else{
                                            $('.row_edu_nocer').css('display','none');
                                            $('#edu_nocer').prop('required',false);
                                            $('.row_file_image').css('display','none');
                                            $('#file_image').prop('required',false);
                                        }
                                    }
                                    </script>";
                                }
                                else if ($type[1]=="eduduration"){
                                    $show.= '
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="edu_duration">Durasi<span class="required" style="color:#ff3333;">*</span>
                                        </label>
                                        <div class="col-sm-5">
                                            <input type="number" placeholder="Lama Durasi" class="form-control" name="edu_duration" id="edu_duration">
                                        </div>
                                        <div class="col-sm-4">';
                                        $show.='<select id="edu_typeduration" class="form-control" name="edu_typeduration" required>';
                                        $show.='<option value="">Jenis Durasi</option>';
                                        foreach ($this->arr_edu_typeduration() as $key => $value) {
                                            $show.='<option value="'.$key.'">'.$value.'</option>';
                                        }
                                        $show.='</select>';       
                                    $show.='</div>
                                    </div>';    
                                }
                                else if ($type[1]=="selectpegawai"){
                                    $show.='
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="nik">Pegawai<span class="required" style="color:#ff3333;">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select id="nik" required class="js-example-basic-single col-sm-12" name="nik" >
                                                    <option value="">Pilih Pegawai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                        $(\'document\').ready(function () {
                                            get_pegawai();
                                            $(\'#nik\').select2({
                                                dropdownParent: $("#modal-container")
                                            });
                                        });
                                        function get_pegawai() {
                                            $.ajax({
                                                url: site_url + \'/user/get_min_all\',
                                                type: \'GET\',
                                                dataType: \'json\',
                                                data: {},
                                                success: function (data, text) {
                                                    var opts = \'<option value="">Pilih Pegawai</option>\';
                                                    for (var i = 0; i < data.length; i++) {
                                                        opts += \'<option value="\' + data[i].nik + \'">\' + data[i].emp_fullname + \'</option>\';
                                                    }
                                                    $(\'#nik\').html(opts);
                                                },
                                                error: function (raw, stat, err) {
                                                    alert(\'ERROR: \' + err);
                                                }
                                            });
                                        }
                                             
                                        </script>                                                                           
                                        ';
                                }
                                else if ($type[1]=="subareatk"){

                                    $show.='
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="subarea_id">Divre<span class="required" style="color:#ff3333;">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select id="subarea_id" required onchange="ocSubarea(this.value);" class="js-example-basic-single col-sm-12" name="subarea_id" >
                                                    <option value="">Pilih Divre</option>';
                                                    foreach ($this->arr_subarea() as $key => $value) {
                                                        $show.='<option value="'.$value["subarea_id"].'">'.$value["subarea_ket"].'</option>';
                                                    }
                                    $show.='
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="subdivre_id">Subdivre<span class="required" style="color:#ff3333;">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select id="subdivre_id" required class="js-example-basic-single col-sm-12" name="subdivre_id" >
                                                    <option value="">Pilih Subdivre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                        $(\'document\').ready(function () {
                                            $(\'#subarea_id\').select2({
                                                dropdownParent: $("#modal-container")
                                            });
                                            $(\'#subdivre_id\').select2({
                                                dropdownParent: $("#modal-container")
                                            });
                                        });
                                        function ocSubarea(val_id, val_selected=\'\') {
                                            $.ajax({
                                                url: site_url + \'/subdivre/get\',
                                                type: \'GET\',
                                                dataType: \'json\',
                                                data: {subarea_id:val_id},
                                                success: function (data, text) {
                                                    var opts = \'<option value="">Pilih Subdivre</option>\';
                                                    for (var i = 0; i < data.length; i++) {
                                                        opts += \'<option value="\' + data[i].id + \'">\' + data[i].subdivre_name + \'</option>\';
                                                    }
                                                    $(\'#subdivre_id\').html(opts);
                                                    if (val_selected!=\'\'){
                                                        $(\'#subdivre_id\').val(val_selected).trigger(\'change\');
                                                        $(\'#subdivre_id\').val(val_selected);        
                                                    }
                                                },
                                                error: function (raw, stat, err) {
                                                    alert(\'ERROR: \' + err);
                                                }
                                            });
                                        }
                                             
                                        </script>                                                                           
                                        ';
                                }
                                else if ($type[1]=="statusnikah"){
                                    $option = "";
                                    foreach ($this->arr_status_nikah() as $key => $value) {
                                        $option.= "<option value=\"".$key."\">".$value."</option>";
                                    }
                                    $show.='
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="nik">Status Pernikahan<span class="required" style="color:#ff3333;">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select name="emp_mrd" onchange="ocStatusNikah(this);" class="form-control" required id="emp_mrd">
                                                    '.$option.'
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row row_emp_dtmrd">
                                            <label class="col-sm-3 col-form-label" for="nik">Tanggal Menikah<span class="required" style="color:#ff3333;">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                            <input type="date" class="form-control" value="" name="emp_dtmrd" id="emp_dtmrd" >
                                            </div>
                                        </div>

                                        <script>
                                        var emp_dtmrd=\'\';
                                        $(\'document\').ready(function () {
                                            $(\'#emp_mrd\').select2({
                                                dropdownParent: $("#modal-container")
                                            });
                                        });    
                                        function ocStatusNikah(el){
                                            if (el.value==1){
                                                $(\'.row_emp_dtmrd\').show();
                                                $(\'#emp_dtmrd\').prop(\'required\',true);
                                                $(\'#emp_dtmrd\').val(emp_dtmrd);
                                            }else{
                                                $(\'.row_emp_dtmrd\').hide();
                                                $(\'#emp_dtmrd\').prop(\'required\',false);
                                                $(\'#emp_dtmrd\').val(\'\');
                                            }
                                        }                                         
                                        </script>                                                                           
                                        ';
                                }
                            }
                            echo $show;       
                            }
                            
                            if ($show_ktp_kk){
                                echo'<div class="form-group row">
                                        <label class="col-sm-3 col-form-label">KTP
                                        </label>
                                        <div class="col-sm-9 col_ktp">
                                            <a href="" target="_blank" rel="noopener noreferrer" class="text-primary" id="href_ktp"></a>
                                            <span id="belum_ktp" class="label label-danger">Belum Upload KTP</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Kartu Keluarga
                                        </label>
                                        <div class="col-sm-9 col_kk">
                                            <a href="" target="_blank" rel="noopener noreferrer" class="text-primary" id="href_kk"></a>
                                            <span id="belum_kk" class="label label-danger">Belum Upload KK</span>
                                        </div>
                                    </div>
                                    ';
              
                            }
                            ?>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="color:#ff3333;">Required (*)</span>
                                </label>
                            </div>
                            <?php
                            if ($is_perubahan_data){
                                echo "
                                <b>Catatan/Alasan Ditolak:</b>
                                <textarea name=\"reject_note\" id=\"reject_note\" class=\"form-control\"></textarea>                                
                                <span class=\"text-warning f-12\">Wajib diisi jika menolak permintaan.</span>
                                ";
                            }
                            ?>
                            <button hidden type="submit" id="sendSubmit"></button>
                            <input type="hidden" name="approval_status">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>

                        <?php
                        if ($is_perubahan_data){
                        ?>
                            <button type="button" id="submit_tolak" class="btn btn-danger waves-effect waves-light ">Tolak</button>
                            <button type="button" id="submit_terima" class="btn btn-primary waves-effect waves-light ">Terima</button>
                        <?php
                        }else{
                        ?>
                            <button type="button" id="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <script>
            var isEdit = false;
            var is_submit = false;
                    $('document').ready(function(){
                        var modalLabel=$('#myModalLabel');
                        var form=$('#form');
                        // Modal Section
                        

                        if (!is_submit){
                        form.submit(function(e){ 
                            is_submit = true;   
                            $('#modal-container').modal('hide');
                            swal({
                                html:true,
                                title: "Menyimpan...",
                                text: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                showCancelButton: false,
                            });                        
                            $(':disabled').each(function(e) {
                                $(this).removeAttr('disabled');
                            })
                            <?php
                            
                            if ($is_perubahan_data){
                            ?>
                            var url_form=site_url+'/<?php echo $page; ?>/action'
                            <?php
                            }
                            else{
                            ?>
                            var url_form=(isEdit==false)?site_url+'/<?php echo $page; ?>/add':site_url+'/<?php echo $page; ?>/edit'
                            <?php 
                            } 
                            ?>
                            e.preventDefault();
                            $.ajax({
                                url:url_form,
                                type:'post',
                                data:new FormData(this), //penggunaan FormData
                                processData:false,
                                contentType:false,
                                cache:false,
                                async:true,
                                dataType:'json',
                                success:function(data,text){
                                    var caption=(isEdit==false)?'input':'edit';
                                    if(data.success)
                                    {
                                        // $('#modal-container').modal('hide');
                                        swal(
                                        'Saved!',
                                        'Successful '+caption+' data!',
                                        'success'
                                        );
                                        $('#table_<?php echo $page; ?>').DataTable().ajax.reload();

                                    }
                                    else{
                                        // $('#modal-container').modal('hide');
                                        swal(
                                        'Saved!',
                                        'Failed '+caption+' data! '+(data.message!=null?data.message:''),
                                        'error'
                                        );
                                        $('#table_<?php echo $page; ?>').DataTable().ajax.reload();
                                    }
                                    isEdit=false;
                                    is_submit = false;     
                                    $("#id").val("");
                                },
                                error: function(xhr, status, error) {
                                    is_submit = false; 
                                    if (xhr.responseText) {
                                    oResponse = JSON.parse(xhr.responseText);
                                    alert(oResponse.error.message)
                                    } else {
                                    alert("Status: "+status+"\nXhr: "+JSON.stringify(xhr)+"\n\nError: " + error);
                                    }
                                }
                            });
                        });
                        }


                        $('#modal-btn').click(function(){
                            if(!isEdit)
                            {
                                $('#form :input').val('');
                                modalLabel.html('Buat <?php echo $title_page; ?>');  
                                <?php
                                    if (!empty($disable_on_edit)){
                                        foreach ($disable_on_edit as $key => $value) {
                                            echo '$("#'.$value.'").prop(\'disabled\', false);';
                                        }
                                    }
                                if ($adaFile){
                                ?>
                                $('#href_file').text('');
                                $('#href_file').attr('href','');
                                    <?php
                                    if ($fileRequired){
                                        ?>
                                        $('#<?php echo $file_id_name; ?>').prop('required',true);
                                        $('.span_req_file').text('*');                                                    
                                <?php } } ?>
                            }
                            else
                            {
                                modalLabel.html('Edit <?php echo $title_page; ?>');
                                <?php
                                    if (!empty($disable_on_edit)){
                                        foreach ($disable_on_edit as $key => $value) {
                                            echo '$("#'.$value.'").prop(\'disabled\', true);';
                                        }
                                    }
                                
                                if ($adaFile){
                                    if ($fileRequired){
                                        ?>
                                        $('#<?php echo $file_id_name; ?>').prop('required',false);
                                        $('.span_req_file').text('');                                                    
                                <?php } } ?>
                            }
                        });

                        $('#close_dialog').click(function(){
                            isEdit=false;
                            $("#id").val("");
                        });

                        $('#cancel').click(function(){
                            isEdit=false;
                            $("#id").val("");
                        });
                        $('#submit').click(function(){
                            $('#sendSubmit').click();
                        });
                        $('#submit_tolak').click(function(){
                            if ($("#reject_note").val()!=""){
                                $("#form :input").prop('required', false);
                                act_perubahan_data("2");
                            }else{
                                alert("Anda belum mengisi alasan ditolak!");
                            }
                        });
                        $('#submit_terima').click(function(){
                            act_perubahan_data("1");
                        });

                        
                        //Modal Section    
                    });

                    <?php
                    if ($is_perubahan_data){
                    ?>
                    function act_perubahan_data(act)
                    {
                        $('#modal-container').modal('hide');
                        $("input[name=approval_status]").val(act);
                        swal({
                                title: "Anda Yakin?",
                                text: "Data ini akan "+(act==1?"diterima":"ditolak")+"!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, "+(act==1?"Terima":"Tolak")+"!",
                                closeOnConfirm: false
                                },
                            function(){
                                $('#sendSubmit').click();
                            });
                    }
                <?php } ?>

                    function edit_data(idData, is_temp = false)
                    {
                        $.ajax({
                            url:site_url+"/<?php echo $page."/".(!empty($page_get_edit)?$page_get_edit:"get"); ?>"+(is_temp?"_temp":"")
                            ,type:'GET'
                            ,dataType:'json'
                            ,data:{id<?php echo $field_suffix; ?>:idData}
                            ,success:function(data,text)
                            {
                                if(data.length>=1)
                                {
                                    isEdit=true;
                                    $('#id').val(data[0].id<?php echo $field_suffix; ?>);
                                    
                                    <?php
                                    foreach ($arrField as $key => $value) {
                                        $name_field = $value.$field_suffix;
                                        $required = $arrRequired[$key];
                                        $type = explode("_",$arrFieldType[$key]);
                                        if ($type[0]!="custom"){
                                            if ($type[0]=="file"){
                                                echo "$('#".$name_field."_old').val(data[0].".$name_field.");
                                                $('#href_file').text(data[0].".$name_field.");
                                                $('#href_file').attr('href',base_url+'upload/".(!empty($file_folder)?$file_folder:$page)."/'+data[0].".$name_field.");";
                                            }else if ($type[0]=="select"){
                                                echo "                                            
                                                $('#".$name_field."').val(data[0].".$name_field.").trigger('change');
                                                $('#".$name_field."').val(data[0].".$name_field.");
                                                ";
                                            }
                                            else{
                                                echo "$('#".$name_field."').val(data[0].".$name_field.");";
                                            }        
                                        }else{
                                            if ($type[1]=="konfirmasiabsen"){
                                                echo "
                                                $('#izin_type').val(data[0].izin_type);
                                                ocIzinType(data[0].izin_type,data[0].confirm_type);
                                                ocConfirmType(data[0].confirm_type,data[0].subconfirm_type);                                                
                                                ";
                                            }  
                                            else if ($type[1]=="edutype"){
                                                echo "
                                                $('#edu_subtype').val(data[0].edu_subtype);
                                                $('#edu_lvl').val(data[0].edu_lvl);
                                                $('#edu_jurusan1').val(data[0].edu_jurusan1).trigger('change');
                                                $('#edu_jurusan1').val(data[0].edu_jurusan1);

                                                ocEduType(data[0].edu_subtype);
                                                ";
                                            } 
                                            else if ($type[1]=="eduduration"){
                                                echo "
                                                $('#edu_duration').val(data[0].edu_duration);
                                                $('#edu_typeduration').val(data[0].edu_typeduration);
                                                ";
                                            }  
                                            else if ($type[1]=="educer"){
                                                echo "$('#file_image_old').val(data[0].file_image);
                                                $('#href_file').text(data[0].file_image);
                                                $('#href_file').attr('href',base_url+'upload/pendidikan/'+data[0].file_image);
                                                $('#edu_cer').val(data[0].edu_cer);
                                                $('#edu_nocer').val(data[0].edu_nocer);
                                                ocEduCer(data[0].edu_cer);
                                                ";
                                            } 
                                            else if ($type[1]=="selectpegawai"){
                                                echo "
                                                $('#nik').val(data[0].nik).trigger('change');
                                                $('#nik').val(data[0].nik);
                                                ";
                                            }  
                                            else if ($type[1]=="subareatk"){
                                                echo "
                                                $('#subarea_id').val(data[0].subarea_id).trigger('change');
                                                $('#subarea_id').val(data[0].subarea_id);
                                                ocSubarea(data[0].subarea_id,data[0].subdivre_id)
                                                ";
                                            }  
                                            else if ($type[1]=="statusnikah"){
                                                echo "
                                                $('#emp_mrd').val(data[0].emp_mrd).trigger('change');
                                                $('#emp_mrd').val(data[0].emp_mrd);
                                                $('#emp_dtmrd').val(data[0].emp_dtmrd);
                                                emp_dtmrd = data[0].emp_dtmrd;
                                                ";
                                            }                                            
                                        }
                                    }
                                    if ($show_ktp_kk){
                                        echo "
                                        if (data[0].ktp!=null){
                                            $('#href_ktp').css('display','');
                                            $('#href_ktp').text(data[0].ktp);
                                            $('#href_ktp').attr('href',base_url+'upload/personal_id/'+data[0].ktp);
                                            $('#belum_ktp').css('display','none');
                                        }else{
                                            $('#href_ktp').css('display','none');
                                            $('#belum_ktp').css('display','');
                                        }
                                        if (data[0].kk!=null){    
                                            $('#href_kk').css('display','');                                        
                                            $('#href_kk').text(data[0].kk);
                                            $('#href_kk').attr('href',base_url+'upload/personal_id/'+data[0].kk);
                                            $('#belum_kk').css('display','none');
                                        }else{
                                            $('#href_kk').css('display','none');
                                            $('#belum_kk').css('display','');
                                        }
                                        ";
                                    }
                                    ?>
                                    if (is_temp){
                                        $('#is_temp').val('1');
                                    }
                                    
                                    $('#modal-btn').click();                                    
                                }
                            }
                            ,error:function(stat,res,err)
                            {
                                alert(err);
                            }
                        })
                    }


                    function delete_data(idData,hard=0,file_string='',is_temp=false)
                    {
                        swal({
                                title: "Are you sure?",
                                text: "This data will be"+((hard==1)?" hard":"")+" deleted!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, delete it!",
                                closeOnConfirm: false
                                },
                            function(){
                                $.ajax({
                                    url:site_url+"/<?php echo $page; ?>/delete"+(is_temp?"_temp":""),
                                    type:'POST',
                                    data:{id<?php echo $field_suffix; ?>:idData,file<?php echo $field_suffix; ?>:file_string,is_hard_delete:hard},
                                    dataType:'json',
                                    async:true,
                                    success:function(data,text)
                                    {
                                        if(data.success)
                                        {
                                            swal(
                                            'Deleted!',
                                            'Successful delete data!',
                                            'success'
                                            );
                                            $('#table_<?php echo $page; ?>').DataTable().ajax.reload();
                                        }
                                        else{
                                            swal(
                                            'Deleted!',
                                            'Failed delete data! '+(data.message!=null?data.message:''),
                                            'error'
                                            );
                                            $('#table_<?php echo $page; ?>').DataTable().ajax.reload();
                                        }
                                    },
                                    error:function(stat,res,err)
                                    {
                                        alert("ERROR: "+err);
                                    }
                                });
                            });
                    }
                    
        </script>
        <?php
        $render = ob_get_clean();
        return $render;

    }

    function render_detail_modal($title_modal, 
                            $page,
                            $field_suffix, 
                            $arrTitle,
                            $arrField,
                            $arrFieldType,
                            $page_get_detail=""
    ){
        ob_start()
        ?>

        <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title_detail"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $adaDownloadFile = false;
                        foreach ($arrField as $key => $value) {
                            $type=$arrFieldType[$key];
                            $title_field = $arrTitle[$key];
                            echo (!empty($title_field)?"<b>".$title_field."</b><br>":"");
                            if ($type=="image"){
                                echo "<img src='' class='img-fluid' id='".$value."_image'>";
                            }
                            else if ($type=="pdf"){
                                $adaDownloadFile = true;
                                echo '<object data="" id="'.$value.'_pdf" type="application/pdf" width="100%" height="500px"></object>;';
                            }                            
                            else{
                                echo "<div id='".$value."body_detail' class='mb-2'></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                    <?php
                        if ($adaDownloadFile){
                    ?>
                        <a href="" id="href_download_file" target="_blank" class="btn btn-primary">Download File</a>  
                    <?php } ?>
                        <button type="button" id="cancel" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>

                    function detail_data(idData)
                    {
                        $.ajax({
                            url:site_url+"/<?php echo $page."/".(!empty($page_get_detail)?$page_get_detail:"get"); ?>"
                            ,type:'GET'
                            ,dataType:'json'
                            ,data:{id<?php echo $field_suffix; ?>:idData}
                            ,success:function(data,text)
                            {
                                if(data.length>=1)
                                {
                                    $("#modal-detail").modal("show");
                                    $("#title_detail").text(data[0].<?php echo $title_modal.$field_suffix; ?>);
                                    <?php
                                    foreach ($arrField as $key => $value) {
                                        $type=$arrFieldType[$key];
                                        $name_field=$value.$field_suffix;
                                        if ($type=="image"){
                                            echo '$("#'.$value.'_image").attr(\'src\',base_url+\'upload/'.$page.'/\'+data[0].'.$name_field.');';
                                        }
                                        else if ($type=="pdf"){
                                            echo '$("#'.$value.'_pdf").attr(\'data\',base_url+\'upload/'.$page.'/\'+data[0].'.$name_field.');';
                                            echo '$("#href_download_file").attr(\'href\',base_url+\'upload/'.$page.'/\'+data[0].'.$name_field.');';
                                        }
                                        else{
                                            echo '$("#'.$value.'body_detail").html(data[0].'.$name_field.'.replace(/(?:\r\n|\r|\n)/g, \'<br>\'));';
                                        }
                                    }
                                    ?>                                    
                                }
                            }
                            ,error:function(stat,res,err)
                            {
                                alert(err);
                            }
                        })
                    }

                    
        </script>
        <?php
        $render = ob_get_clean();
        return $render;

    }
    function render_approve(
                            $page,
                            $field_suffix=""
    ){
        ob_start()
        ?>
        <script>
                    function approval_data(idData,action,nik)
                    {
                        var str_action = ((action==1)?"Approved":" Rejected");
                        var str_low = ((action==1)?"approve":" reject");

                        swal({
                                title: "Are you sure?",
                                text: "This data will be "+str_low+"!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-danger",
                                confirmButtonText: "Yes, "+str_low+" it!",
                                closeOnConfirm: false
                                },
                            function(){
                                $.ajax({
                                    url:site_url+"/<?php echo $page; ?>/approval",
                                    type:'POST',
                                    data:{id<?php echo $field_suffix; ?>:idData,action:action,nik:nik},
                                    dataType:'json',
                                    async:true,
                                    success:function(data,text)
                                    {
                                        if(data.success)
                                        {
                                            swal(
                                            str_action+'!',
                                            'Successful '+str_low+' data!',
                                            'success'
                                            );
                                            $('#table_<?php echo $page; ?>').DataTable().ajax.reload();
                                        }
                                        else{
                                            swal(
                                            str_action+'!',
                                            'Failed '+str_low+' data! '+(data.message!=null?data.message:''),
                                            'error'
                                            );
                                            $('#table_<?php echo $page; ?>').DataTable().ajax.reload();
                                        }
                                    },
                                    error:function(stat,res,err)
                                    {
                                        alert("ERROR: "+err);
                                    }
                                });
                            });
                    }
                    
                    
        </script>
        <?php
        $render = ob_get_clean();
        return $render;

    }

    function custom_row($field_suffix, $field, $primary_key){
        $render = "";

        $primary = "";

        if (!empty($primary_key)){
            $primary = "full.".$primary_key;
        }else{
            $primary = "full.id".$field_suffix;
        }

        if ($field=="_no"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    no+=1;
                    return no;
                }
            },
            ";
        }
        else if ($field=="_tgl_masuk"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return full.tanggal;
                }
            },
            ";
        }
        else if ($field=="_senin"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return (full.monday_status==0?'Libur':full.monday_masuk+' - '+full.monday_pulang);
                }
            },
            ";
        }
        else if ($field=="_link"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"'+ site_url + 'notifikasi/link_notif/'+full.id+'\" target=\"_blank\" class=\"btn btn-info btn-sm\"> <span class=\"fa fa-external-link\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_link_notif"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"'+ site_url + 'notifikasi/link_notif/'+full.id+'\" class=\"btn btn-info btn-sm\"> <span class=\"fa fa-external-link\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_title_notif"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return full.title+(full.status==0?'<br><label class=\"label label-warning\">NEW</label>':'');
                }
            },
            ";
        }
        else if ($field=="_status_deal"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var show = '';
                    if (full.status==0){
                        show+='<label class=\"label label-warning\">Menunggu Keputusan</label>';
                    }
                    else if (full.status==1){
                        show+='<label class=\"label label-success\">Deal</label>';
                    }
                    else if (full.status==2){
                        show+='<label class=\"label label-danger\">No Deal</label>';
                    }
                    return show;
                }
            },
            ";
        }     
        else if ($field=="_status_approval_penawaran"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var show = '';
                    if (full.status_approval==0){
                        show+='<label class=\"label label-warning\">Menunggu Keputusan</label>';
                    }
                    else if (full.status_approval==1){
                        show+='<label class=\"label label-success\">Diapprove</label>';
                    }
                    else if (full.status_approval==2){
                        show+='<label class=\"label label-danger\">Dikembalikan</label>';
                    }
                    return show;
                }
            },
            ";
        }    
        else if ($field=="_status_final"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    var is_available = dateCheck(full.start_date, full.end_date, '".date("Y-m-d")."');
                    if (is_available){              
                        return '<label class=\"label label-success\">Available</label>';
                    }else{
                        return '<label class=\"label label-danger\">Not Available</label>';
                    }
                }
            },
            ";
        }         
        else if ($field=="_status_proposal"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    return '<a href=\"#;\" onclick=\"cek_status_proposal('+".$primary."+');\" class=\"btn btn-warning btn-sm\">Cek</a>';
                }
            },
            ";
        }      
        else if ($field=="_action_validasi"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"edit_data('+".$primary."+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_personal_id"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_personal_id('+".$primary."+','+full.nik+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_edu"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_edu('+".$primary."+','+full.nik+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="create_penawaran"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"".site_url("penawaran/add/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_fam"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_fam('+".$primary."+','+full.nik+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_hpp"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_hpp('+".$primary."+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_hpp_kembali"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"".site_url("hpp_kembali/edit/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_penawaran"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_penawaran('+".$primary."+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_penawaran_kembali"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"".site_url("penawaran_kembali/edit/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_detail_final"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"#;\" onclick=\"detail_final('+".$primary."+');\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }

        else if ($field=="_detail_proposal"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';
                    var id_usr_role = '" . $this->session->userdata('id_usr_role') . "';

                    if (full.jenis_modul == 'io') {
                        html += '<a href=\"".site_url("proposal/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    } else {
                        html += '<a href=\"".site_url("proposal/detail_ps/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    }

                    if ((id_usr_role == 3 || id_usr_role == 11 || id_usr_role == 1) && full.is_batal == 0 && full.status == 1) {
                        html += '<a onclick=\"batal_io_ps('+". $primary . "+', \''+ full.jenis_modul +'\')\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Batalkan IO/PS</a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_proposal_delete"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';
                    if (full.jenis_modul == 'io') {
                        html += '<a href=\"".site_url("proposal/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    } else {
                        html += '<a href=\"".site_url("proposal/detail_ps/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    }

                    if (full.status != 1) {
                        html += '<a onclick=\"hapus_proposal('+". $primary . "+')\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-trash\"></span></a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_proposal_status_io_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';
                    if (full.jenis_modul == 'io') {
                        html += '<a href=\"".site_url("proposal/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    } else {
                        html += '<a href=\"".site_url("proposal/detail_ps/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    }

                    if (full.status == 1 && full.status_io == 1) {
                        html += '<a onclick=\"update_status_io('+". $primary . "+', 0)\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Close IO/PS</a>';
                    } else if (full.status == 1 && full.status_io == 0) {
                        html += '<a onclick=\"update_status_io('+". $primary . "+', 1)\" class=\"btn btn-success btn-sm ml-1 text-white\"><span class=\"fa fa-check\"></span> Open IO/PS</a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_status_io_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.status == 1 && full.status_io == 1) {
                        return '<span class=\"text-success\">Open</span>';
                    } else if (full.status == 1 && full.status_io == 0) {
                        return '<span class=\"text-danger\">Closed</span>';
                    }
                }
            },
            ";
        }

        else if ($field=="_status_batal_io_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.status == 1 && full.is_batal == 1) {
                        return 'Ya';
                    } else if (full.status == 1 && full.is_batal == 0) {
                        return 'Tidak';
                    }
                }
            },
            ";
        }

        else if ($field=="_detail_proposal_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"".site_url("proposal/detail_ps/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }

        else if ($field=="_detail_proposal_list"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.jenis_modul == 'io') {
                        return '<a href=\"".site_url("list_proposal/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    } else {
                        return '<a href=\"".site_url("list_proposal/detail_ps/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                    }
                }
            },
            ";
        }

        else if ($field=="_detail_pegawai"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    return '<a href=\"pegawai/detail/'+full.nik+'\" target=\"_blank\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';
                }
            },
            ";
        }
        else if ($field=="_action"){
            $render= "
                    {
                        render: function (data, type, full, meta) {
                            ".($this->act_update || $this->act_delete || $this->act_hard_delete || $this->act_detail?"
                            return '\
                            <div class=\"text-center\">\
                                    <a href=\"#;\" class=\"dropdown-toggle addon-btn\" data-toggle=\"dropdown\" aria-expanded=\"true\">\
                                        <i class=\"icofont icofont-ui-settings\"></i>\
                                    </a>\
                                    <div class=\"dropdown-menu dropdown-menu-right\">\
                                    ".($this->act_update?"<a class=\"dropdown-item\" href=\"#;\" onclick=\"edit_data('+".$primary."+');\" ><i class=\"icofont icofont-ui-edit\"></i>Edit</a>\\":"\\")."
                                    ".($this->act_delete?"<a class=\"dropdown-item\" href=\"#;\" onclick=\"delete_data('+".$primary."+');\" ><i class=\"icofont icofont-ui-delete\"></i>Delete</a>\\":"\\")."
                                    ".($this->act_hard_delete?"<a class=\"dropdown-item\" href=\"#;\" onclick=\"delete_data('+".$primary."+',1,\''+full.file".$field_suffix."+'\');\" ><i class=\"icofont icofont-ui-delete\"></i>Hard Delete</a>\\":"\\")."
                                    ".($this->act_detail?"<a class=\"dropdown-item\" href=\"#;\" onclick=\"detail_data('+".$primary."+');\" ><i class=\"icofont icofont-learn\"></i>Detail</a>\\":"\\")."
                                </div>\
                            </div>';
                            ":"
                                return 'no action';
                            ")."
                        }
                    },
                    ";
        }
        else if ($field=="_action_permintaan"){
            $render= "
                    {
                        render: function (data, type, full, meta) {
                            return '\
                            '+(full.approval_status==0?'<div class=\"text-center\">\
                                    <a href=\"#;\" class=\"dropdown-toggle addon-btn\" data-toggle=\"dropdown\" aria-expanded=\"true\">\
                                        <i class=\"icofont icofont-ui-settings\"></i>\
                                    </a>\
                                    <div class=\"dropdown-menu dropdown-menu-right\">\
                                    ".($this->act_update?"<a class=\"dropdown-item\" href=\"#;\" onclick=\"edit_data('+".$primary."+',true);\" ><i class=\"icofont icofont-ui-edit\"></i>Edit</a>\\":"\\")."
                                    <a class=\"dropdown-item\" href=\"#;\" onclick=\"delete_data('+".$primary."+',0,\'\',true);\" ><i class=\"icofont icofont-ui-delete\"></i>Batal</a>\\
                                    </div>\
                            </div>':'no action');
                        }
                    },
                    ";
        }
        else if ($field=="_action_approve"){
            $render= "
                    {
                        render: function (data, type, full, meta) {
                           
                            return '\
                            <div class=\"text-center\">\
                                    <a href=\"#;\" class=\"dropdown-toggle addon-btn\" data-toggle=\"dropdown\" aria-expanded=\"true\">\
                                        <i class=\"icofont icofont-ui-settings\"></i>\
                                    </a>\
                                    <div class=\"dropdown-menu dropdown-menu-right\">\
                                    <a class=\"dropdown-item\" href=\"#;\" onclick=\"approval_data('+".$primary."+',1,'+full.nik+');\" ><i class=\"fa fa-check-circle\"></i>Terima</a>\
                                    <a class=\"dropdown-item\" href=\"#;\" onclick=\"approval_data('+".$primary."+',2,'+full.nik+');\" ><i class=\"fa fa-times-circle\"></i>Tolak</a>\
                                </div>\
                            </div>';
                            
                        }
                    },
                    ";
        }
        else if ($field=="_action_jam_kerja"){

            $show = "<select name=\"jam_kerja\" onchange=\"ocJamKerja(\''+full.nik+'\',this);\">";
            foreach ($this->arr_jam_kerja() as $key => $value) {
                $show.= "<option '+(full.jam_kerja_id==".$key."?\"selected\":\"\")+' value=\"".$key."\">".$value["name"]."</option>";
            }
            $show.="</select>";

            $render= "
                    {
                        render: function (data, type, full, meta) {                           
                            return '".$show."';                            
                        }
                    },
                    ";
        }
        else if ($field=="_last_step_status"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    //console.log(full);
                    var html = '';
                    var sub_text = '';
                    var fa = '';

                    //console.log(full);

                    if (full.step_type==0){
                        step_type = 'Proposal Dibuat Oleh '+full.role_name;
                        sub_text = '';
                        color_class = 'label-info';
                        fa = 'fa fa-plus';
                    } else if (full.step_type==2) {

                        if (full.role_name == 'Kepala Cabang' || full.role_name == 'GM Marketing') {
                            color_class = 'label-warning'; // ok
                        } else if (full.role_name == 'Operasional Pusat') {
                            color_class = 'label-info'; // ok
                        } else if (full.role_name == 'Manager Operasional Pusat' || full.role_name == 'Manager PMO') {
                            color_class = 'label-yellow'; // ok
                        } else if (full.role_name == 'Senior Manager Operasional Pusat' || full.role_name == 'General Manager Operasional Pusat') {
                            color_class = 'label-inverse'; // ok
                        } else if (full.role_name == 'Vp Operasional') {
                            color_class = 'label-purple'; // ok
                        } else if (full.role_name == 'Direksi Ops' || full.role_name == 'D1') {
                            color_class = 'label-gray'; // ok
                        } else if (full.role_name == 'D2') {
                            color_class = 'label-green-blue'; // ok
                        } else if (full.role_name == 'D3') {
                            color_class = 'label-green-blue-2'; // ok
                        } else if (full.role_name == 'Direktur Utama') {
                            color_class = 'label-lemon'; // ok
                        } else if (full.role_name == 'Project Management Office (PMO)') {
                            color_class = 'label-orange'; // ok
                        } else if (full.role_name == 'Keuangan Pusat' || full.role_name == 'Project Management Office (PMO)' || full.role_name == 'Manajer Keuangan Cabang') {
                            color_class = 'label-primary'; // ok
                        } else {
                            color_class = 'label-warning';
                        }

                        step_type = 'Proposal Dilanjutkan Ke '+full.role_name;
                        sub_text = 'Oleh '+full.from_role_name;
                        
                        fa = 'fa fa-check';
                    }
                    else if (full.step_type==3){
                        step_type = 'Proposal Dikembalikan Ke '+full.role_name;
                        sub_text = 'Oleh '+full.from_role_name;
                        color_class = 'label-danger';
                        fa = 'fa fa-times';
                    }
                    else if (full.step_type==1){
                        is_finish = true;
                        step_type = 'Proposal Selesai Divalidasi Oleh '+full.role_name;
                        color_class = 'label-success';
                        fa = 'fa fa-star';
                    }
                    //html = '<i class=\"' + color_class + ' update-icon\"></i> <h6>'+step_type+\" \"+ sub_text +'</h6>';

                    html = '<label class=\"label '+color_class+'\"><i class=\"' + fa + ' update-icon\"></i> '+step_type+\" \"+sub_text+'</label>';

                    return html;
                }
            },
            ";
        }
        else if ($field=="_last_step_status_invoice"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    var html = '';
                    var sub_text = '';
                    var fa = '';

                    if (full.step_type==0){
                        step_type = 'Invoice Dibuat Oleh '+full.role_name;
                        sub_text = '';
                        color_class = 'label-info';
                        fa = 'fa fa-plus';
                    }
                    else if (full.step_type==2){

                        if (full.role_name == 'Kepala Cabang' || full.role_name == 'GM Marketing' || full.role_name == 'Deputy Cabang') {
                            color_class = 'label-warning'; // ok
                        } else if (full.role_name == 'Operasional Pusat') {
                            color_class = 'label-info'; // ok
                        } else if (full.role_name == 'Manager Operasional Pusat' || full.role_name == 'Manager PMO') {
                            color_class = 'label-yellow'; // ok
                        } else if (full.role_name == 'Senior Manager Operasional Pusat') {
                            color_class = 'label-inverse'; // ok
                        } else if (full.role_name == 'Vp Operasional') {
                            color_class = 'label-purple'; // ok
                        } else if (full.role_name == 'Direksi Ops'|| full.role_name == 'D1') {
                            color_class = 'label-gray'; // ok
                        } else if (full.role_name == 'Direktur Utama') {
                            color_class = 'label-lemon'; // ok
                        } else if (full.role_name == 'Project Management Office (PMO)') {
                            color_class = 'label-orange'; // ok
                        } else if (full.role_name == 'Keuangan Pusat' || full.role_name == 'Project Management Office (PMO)' || full.role_name == 'Manajer Keuangan Cabang') {
                            color_class = 'label-primary'; // ok
                        } else if (full.role_name == 'Keuangan Cabang') {
                            color_class = 'label-indigo'; // ok
                        } else if (full.role_name == 'VP Keuangan') {
                            color_class = 'label-blue'; // ok
                        } else {
                            color_class = 'label-warning';
                        }

                        step_type = 'Invoice Dilanjutkan Ke '+full.role_name;
                        sub_text = 'Oleh '+full.from_role_name;
                        
                        fa = 'fa fa-check';
                    }
                    else if (full.step_type==3){
                        step_type = 'Invoice Dikembalikan Ke '+full.role_name;
                        sub_text = 'Oleh '+full.from_role_name;
                        color_class = 'label-danger';
                        fa = 'fa fa-times';
                    }
                    else if (full.step_type==4){
                        step_type = 'Invoice Direvisi';
                        sub_text = 'Oleh '+full.from_role_name;
                        color_class = 'label-info';
                        fa = 'fa fa-wrench';
                    }
                    else if (full.step_type==1){
                        is_finish = true;
                        step_type = 'Invoice Divalidasi Oleh '+full.role_name;
                        color_class = 'label-success';
                        fa = 'fa fa-star';
                    }
                    //html = '<i class=\"' + color_class + ' update-icon\"></i> <h6>'+step_type+\" \"+ sub_text +'</h6>';

                    html = '<label class=\"label '+color_class+'\"><i class=\"' + fa + ' update-icon\"></i> '+step_type+\" \"+sub_text+'</label>';

                    return html;
                }
            },
            ";
        }
        else if ($field=="_no_io_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    if (full.jenis_modul == 'io') {
                        return full.no_io;
                    } else {
                        return full.no_ps;
                    }
                }
            },
            ";
        }
        else if ($field=="_no_io_ps_input"){
            // Unit Budgeting Kantor Pusat
            if ($this->session->userdata('id_usr_role') == 9) {
                $render= "
                {
                    render: function (data, type, full, meta) {  
                        if (full.jenis_modul == 'io') {
                            return full.no_io;
                        } else {
                            return full.no_ps;
                            // if (full.no_ps == '') {
                            //     return '<button class=\"btn btn-success\" onclick=\"proses_no_ps('+".$primary."+');\" type=\"button\">Input <i class=\"fa fa-edit\"></i></button>';
                            // } else {
                            //     return full.no_ps;
                            // }
                        }
                    }
                },
                ";
            } else {
                $render= "
                {
                    render: function (data, type, full, meta) {  
                        if (full.jenis_modul == 'io') {
                            return full.no_io;
                        } else {
                            if (full.no_ps == '') {
                                return '<label class=\"label label-info\"><i class=\"fa fa-info-circle update-icon\"></i> Belum Diinput</label>';
                            } else {
                                return full.no_ps;
                            }
                        }
                    }
                },
                ";
            }
        }
        else if ($field=="_total_pendapatan") {
            $render= "
            {
                render: function (data, type, full, meta) {  
                    return full.total_pendapatan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            },
            ";
        }
        else if ($field=="_total_biaya") {
            $render= "
            {
                render: function (data, type, full, meta) {  
                    return full.total_biaya.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            },
            ";
        }
        else if ($field=="_jumlah_tagihan") {
            $render= "
            {
                render: function (data, type, full, meta) {  
                    return full.jumlah_tagihan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }
            },
            ";
        }
        else if ($field=="_order_type_name") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.order_type_name == full.sub_order_type_name) {
                        return full.order_type_name;
                    } else {
                        return full.order_type_name + ' - ' + full.sub_order_type_name;
                    }
                }
            },
            ";
        }
        else if ($field=="_sla") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.step_type == 1) {
                        var start_date = new Date(full.created_at);
                        var end_date = new Date(full.sla); 
                    } else {
                        var start_date = new Date(full.sla);
                        var end_date = new Date();
                    }

                    //console.log('start date : ' + start_date);
                    //console.log('end date : ' + end_date);

                    //return start_date.getTime() / 1000 + ' - ' + end_date.getTime() / 1000;

                    // get total seconds between the times
                    var delta = Math.abs(start_date - end_date) / 1000;

                    // calculate (and subtract) whole days
                    var days = Math.floor(delta / 86400);
                    delta -= days * 86400;

                    // calculate (and subtract) whole hours
                    var hours = Math.floor(delta / 3600) % 24;
                    delta -= hours * 3600;

                    // calculate (and subtract) whole minutes
                    var minutes = Math.floor(delta / 60) % 60;
                    delta -= minutes * 60;

                    // what's left is seconds
                    // var seconds = delta % 60;

                    //console.log(days);
                    //console.log(minutes);

                    if (full.step_type == 1) {
                        if (days == 0 && hours == 0) {
                            return 'Selesai (' + minutes + ' Menit)';
                        } else if (days == 0 && hours != 0) {
                            return 'Selesai (' + hours + ' Jam ' + minutes + ' Menit)'; 
                        } else {
                            return 'Selesai (' + days + ' Hari ' + hours + ' Jam ' + minutes + ' Menit)';
                        }
                    } else {
                        if (days == 0 && hours == 0) {
                            return minutes + ' Menit';
                        } else if (days == 0 && hours != 0) {
                            return hours + ' Jam ' + minutes + ' Menit'; 
                        } else {
                            return days + ' Hari ' + hours + ' Jam ' + minutes + ' Menit';
                        }
                    }
                }
            },
            ";
        }

        else if ($field=="_detail_invoice"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '<a href=\"".site_url("invoice/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_invoice_delete"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '<a href=\"".site_url("invoice/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    if (full.status == 0 || full.status == 3) {
                        html += '<a onclick=\"hapus_invoice('+". $primary . "+')\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-trash\"></span></a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_invoice_revisi"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '<a href=\"".site_url("invoice/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    var id_usr_role = '" . $this->session->userdata('id_usr_role') . "';

                    if ((id_usr_role == 3 || id_usr_role == 10) && (full.status == 1)) {
                        html += '<a onclick=\"revisi_invoice('+". $primary . "+')\" class=\"btn btn-warning btn-sm ml-1 text-white\"><span class=\"fa fa-wrench\"></span> Revisi</a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_invoice_revisi_hapus"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '<a href=\"".site_url("invoice/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    var id_usr_role = '" . $this->session->userdata('id_usr_role') . "';

                    if ((id_usr_role == 3 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0) {
                        html += '<a onclick=\"revisi_invoice('+". $primary . "+')\" class=\"btn btn-warning btn-sm ml-1 text-white\"><span class=\"fa fa-wrench\"></span> Revisi</a>';
                    }

                    if ((id_usr_role == 3 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 9 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0) {
                        html += '<a onclick=\"hapus_invoice_finish('+". $primary . "+', \''+ full.jenis_modul +'\')\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Batalkan</a>';
                    }

                    if ((id_usr_role == 3 || id_usr_role == 9 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 20 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.is_ditagihkan == 0) {
                        html += '<a onclick=\"update_status_tagihan('+". $primary . "+', 1)\" class=\"btn btn-primary btn-sm ml-1 text-white\"><span class=\"fa fa-check\"></span> Sudah Ditagihkan</a>';
                    } else if ((id_usr_role == 3 || id_usr_role == 9 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 20 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.is_ditagihkan == 1) {
                        html += '<a onclick=\"update_status_tagihan('+". $primary . "+', 0)\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Belum Ditagihkan</a>';
                    }

                    if ((id_usr_role == 3 || id_usr_role == 9 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 20 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.is_posting_sap == 0) {
                        html += '<a onclick=\"update_status_sap('+". $primary . "+', 1)\" class=\"btn btn-success btn-sm ml-1 text-white\"><span class=\"fa fa-paper-plane\"></span> Sudah Posting SAP</a>';
                    } else if ((id_usr_role == 3 || id_usr_role == 9 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 20 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.is_posting_sap == 1) {
                        html += '<a onclick=\"update_status_sap('+". $primary . "+', 0)\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Batal Posting SAP</a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_detail_invoice_status_revisi_hapus"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '<a href=\"".site_url("invoice/detail/")."'+".$primary."+'\" class=\"btn btn-info btn-sm\"><span class=\"fa fa-hand-pointer-o\"></span></a>';

                    html += '<a href=\"".site_url("invoice_status/detail/")."'+".$primary."+'\" class=\"btn btn-success ml-1 btn-sm\"><span class=\"fa fa-info-circle\"></span> Update Status Invoice</a>';

                    var id_usr_role = '" . $this->session->userdata('id_usr_role') . "';
                    var branch = '" . $this->session->userdata('user_area') . "';

                    if (full.status == 1 && (full.branch == branch || id_usr_role == 1) && full.is_send_to_sap == 1) {
                        html += '<a onclick=\"sync_invoice_sap('+". $primary . "+')\" class=\"btn btn-primary btn-sm ml-1 text-white\"><span class=\"fa fa-refresh\"></span> Sync SAP</a>';
                    }

                    if ((id_usr_role == 3 || id_usr_role == 10 || id_usr_role == 19 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.branch == branch) {
                        html += '<a onclick=\"revisi_invoice('+". $primary . "+')\" class=\"btn btn-warning btn-sm ml-1 text-white\"><span class=\"fa fa-wrench\"></span> Revisi</a>';
                    }

                    if ((id_usr_role == 19 || id_usr_role == 9 || id_usr_role == 1) && full.status == 1 && full.is_cancel == 0 && full.branch == branch) {
                        html += '<a onclick=\"hapus_invoice_finish('+". $primary . "+', \''+ full.jenis_modul +'\')\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-times\"></span> Batalkan</a>';
                    }

                    return html;
                }
            },
            ";
        }

        else if ($field=="_status_invoice"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    return '<a href=\"#;\" onclick=\"cek_status_invoice('+".$primary."+');\" class=\"btn btn-warning btn-sm\">Cek</a>';
                }
            },
            ";
        } 

        else if ($field=="_is_cancel_invoice"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.is_cancel == 1) {
                        //return '<span class=\"text-danger\"><i class=\"fa fa-check\"></i></span>';
                        return 'Ya';
                    } else if (full.is_cancel == 0) {
                        return 'Tidak';
                        //return '<span class=\"text-success\">Ya</span>';
                    }
                }
            },
            ";
        }

        else if ($field=="_ver_revisi"){
            $render= "
            {
                render: function (data, type, full, meta) {  
                    if (full.ver_revisi == 0) {
                        return '-';
                    } else {
                        return full.ver_revisi;
                    }
                }
            },
            ";
        }

        else if ($field=="_keterangan_batal"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.is_cancel == 1) {
                        return full.keterangan_batal;
                    } else {
                        return '-';
                    }
                }
            },
            ";
        } 

        else if ($field=="_keterangan_batal_io_ps"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.is_batal == 1) {
                        return full.keterangan_batal;
                    } else {
                        return '-';
                    }
                }
            },
            ";
        } 

        else if ($field=="_is_ditagihkan"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.is_ditagihkan == 1) {
                        return '<span class=\"text-success\">Sudah Ditagihkan</span>';
                    } else if (full.is_ditagihkan == 0) {
                        return '<span class=\"text-danger\">Belum Ditagihkan</span>';
                    }
                }
            },
            ";
        }

        else if ($field=="_is_posting_sap"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.is_cancel == 1 && full.document_number != '' && full.document_number != null) {
                        return '<span class=\"text-success\">Batal Diposting</span>';
                    } else if (full.is_posting_sap == 1) {
                        return '<span class=\"text-success\">Sudah Diposting</span>';
                    } else if (full.is_posting_sap == 0) {
                        return '<span class=\"text-danger\">Belum Diposting</span>';
                    }
                }
            },
            ";
        }

        else if ($field=="_action_crud"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';

                    html += '<a onclick=\"edit_data('+ full.kd_plg +');\" class=\"btn btn-info btn-sm text-white\"><span class=\"fa fa-edit\"></span></a>';

                    html += '<a onclick=\"hapus_data('+ full.kd_plg +');\" class=\"btn btn-danger btn-sm ml-1 text-white\"><span class=\"fa fa-trash\"></span></a>';
                    
                    return html;
                }
            },
            ";
        }

        else if ($field=="_action_crud_open"){
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';
                    var branch_id = '" . $this->session->userdata('user_area') . "';
                    var id_usr_role = '" . $this->session->userdata('id_usr_role') . "';

                    html += '<a onclick=\"lihat_data('+ full.id +');\" class=\"btn btn-primary btn-sm mr-1 text-white\"><span class=\"fa fa-eye\"></span> Lihat</a>';

                    if (branch_id == full.branch_id || id_usr_role == 1 || branch_id == 1000) {

                        if (full.jenis_bupot == 1) {
                            html += '<a href=\"'+ site_url + 'ebupot/edit_ppn/'+full.id+'\" class=\"btn btn-info btn-sm mr-1 text-white\"><span class=\"fa fa-edit\"></span> Edit</a>';
                        } else if (full.jenis_bupot == 2) {
                            html += '<a href=\"'+ site_url + 'ebupot/edit_pph/'+full.id+'\" class=\"btn btn-info btn-sm mr-1 text-white\"><span class=\"fa fa-edit\"></span> Edit</a>';
                        } else if (full.jenis_bupot == 3) {
                            html += '<a href=\"'+ site_url + 'ebupot/edit_spt_masa/'+full.id+'\" class=\"btn btn-info btn-sm mr-1 text-white\"><span class=\"fa fa-edit\"></span> Edit</a>';
                        }

                        html += '<a onclick=\"hapus_data('+ full.id +');\" class=\"btn btn-danger btn-sm text-white\"><span class=\"fa fa-trash\"></span> Hapus</a>';
                    }
                    
                    return html;
                }
            },
            ";
        }

        else if ($field=="_action_view") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    var html = '';
                    
                    html += '<a onclick=\"lihat_data('+ full.id +');\" class=\"btn btn-primary btn-sm mr-1 text-white\"><span class=\"fa fa-eye\"></span> Lihat</a>';
                    
                    return html;
                }
            },
            ";
        }

        else if ($field=="_jenis_pph") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.jenis_pph == 1) {
                        return 'PPh 4(2)';
                    } else if (full.jenis_pph == 2) {
                        return 'PPh 15';
                    } else if (full.jenis_pph == 3) {
                        return 'PPh 22';
                    } else if (full.jenis_pph == 4) {
                        return 'PPh 23';
                    }
                }
            },
            ";
        }

        else if ($field=="_jenis_pajak") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    if (full.jenis_pajak == 1) {
                        return 'PPh Pasal 4(2)';
                    } else if (full.jenis_pajak == 2) {
                        return 'PPh Pasal 15';
                    } else if (full.jenis_pajak == 3) {
                        return 'PPh Pasal 22';
                    } else if (full.jenis_pajak == 4) {
                        return 'PPh Pasal 23';
                    } else if (full.jenis_pajak == 5) {
                        return 'PPh Pasal 21';
                    } else if (full.jenis_pajak == 6) {
                        return 'PPN WAPU';
                    } else if (full.jenis_pajak == 7) {
                        return 'PPN MASA';
                    } else if (full.jenis_pajak == 8) {
                        return 'PPh Badan';
                    }
                }
            },
            ";
        }

        else if ($field=="_tahun") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    var str = full.bulan_tahun.split('-');

                    return str[0];
                }
            },
            ";
        }

        else if ($field=="_bulan") {
            $render= "
            {
                render: function (data, type, full, meta) {
                    var str = full.bulan_tahun.split('-');

                    return str[1];
                }
            },
            ";
        }

        return $render;
    }

    function verify_login($allow_own_action=false)
    {
        if($this->CI->session->userdata('login')==TRUE)
        {
            return true;
        }
        else
        {
            if($allow_own_action)
            {
                echo '<script>
                alert("Please login first!");
                document.location.href="'.site_url().'/auth";
                </script>';	
            }
			return false;
        }
    }
	function authorize_controller($controller=array('requested'=>array('class'=>null,'method'=>null),'avoid'=>array()))
	{
		$id_role=$this->CI->session->userdata('id_usr_role');
		$menus=$this->CI->menu->get_menu_privilege($id_role);
		$authorized=false;
		$is_core=false;
		// $requested_uri=$controller['requested']['class'].'/'.$controller['requested']['method'];
		$requested_uri=$controller['requested']['class'];
		$is_key = "";

		//avoid checking for dev only
		$core_controllers=array(
			array('class'=>'dashboard'),
			array('class'=>'master_get'),
			array('class'=>'export'),
            array('class'=>'APISelect2'),
            array('class'=>'reporting_financial_planning'),
            array('class'=>'reporting_io_ps/io_ps'),
			array('class'=>'menu','method'=>'get'),
			array('class'=>'user','method'=>'profile'),
			array('class'=>'user','method'=>'get_temp'),
			array('class'=>'user','method'=>'edit_to_temp'),
			array('class'=>'final_lr','method'=>'get_biaya'),
			// array('class'=>'user','method'=>'upload_foto'),
			// array('class'=>'user','method'=>'change_password'),
			array('id_role'=>1,'class'=>'menu'),
			array('id_role'=>1,'class'=>'user_role'),
		);
		
		for($i=0;$i<count($core_controllers);$i++)
		{
			if(isset($core_controllers[$i]['id_role']))
			{
				if($core_controllers[$i]['id_role']==$id_role 
				&& $core_controllers[$i]['class']==$controller['requested']['class'])
				{
					$authorized=true;
					break;
				}
			}
			else if(isset($core_controllers[$i]['method']))
			{
				if($core_controllers[$i]['method']==$controller['requested']['method'])
				{
					$authorized=true;
					break;
				}
			}
			else
			{
				if($core_controllers[$i]['class']==$controller['requested']['class'])
				{
					$authorized=true;
					break;
				}
			}
		}

		if(!$is_core)
		{
            $menus[]=array(
                "id_menu" => "",
                "label" => "",
                "link" => "user",
                "icon" => "",
                "have_crud" => "",
                "parent" => "",
                "is_head_section" => "",
                "sort" => "",
                "created_at" => "",
                "id" => "",
                "id_usr_role" => "",
                "act_create" => "0",
                "act_update" => "0",
                "act_delete" => "0",
                "act_hard_delete" => "0",
                "act_detail" => "0",
                "filter_by_area" => "0",
                "updated_at" => "0000-00-00 00:00:00"
            );
			foreach($menus as $key => $menu)
			{
				
				if($menu['link']!='' && $menu['link']!=null)
				{
		
					if(strpos($requested_uri,$menu['link'])!==false)
					{

						$is_key = $key;
						$method = $controller['requested']['method'];
						if ($method=="add" && $menu["act_create"]==1){
							$authorized=true;
						}else if ($method=="edit" && $menu["act_update"]==1){
							$authorized=true;
						}else if ($method=="delete" && $menu["act_delete"]==1){
							$authorized=true;
						}else if ($method=="hard_delete" && $menu["act_hard_delete"]==1){
							$authorized=true;
						}
						else{
							if ($method=="add" || $method=="edit" || $method=="delete"){
								$authorized=false;
							}
							else {
								$authorized=true;
							}
						}
						break;
					}	
					if(isset($controller['avoid']))
					{
						for($i=0;$i<count($controller['avoid']);$i++)
						{
							if($controller['requested']['method']==$controller['avoid'][$i])
							{
								$authorized=true;
								break;
							}
						}
					}
				}
			}
		}

		if(!$authorized)
		{
			echo '<script>
			alert("Sorry, you\'re not authorized for accessing this url !");
			document.location.href="'.base_url().'";
			</script>';
		}else{
			if (!empty($is_key)){
				return $menus[$is_key];
			}
		}
	}   
    function arr_status(){
        $arr_status[0]="Menunggu Persetujuan";
        $arr_status[1]="Disetujui";
        $arr_status[2]="Ditolak";
        return $arr_status;
    }  
    function arr_gender(){
        $arr_gender[1]="Laki-Laki";
        $arr_gender[2]="Perempuan";
        return $arr_gender;
    }  
    function arr_jenis_personalid(){
        $arr_jenis_personalid['01']="Kartu Tanda Penduduk (KTP)";
        $arr_jenis_personalid['10']="Kartu Keluarga (KK)";
        $arr_jenis_personalid['02']="Passpor";
        return $arr_jenis_personalid;
    } 
    function arr_status_presensi(){
        $arr_status_presensi = array();
        $arr_status_presensi[1] = "Masuk";
        $arr_status_presensi[2] = "Tidak Masuk";
        $arr_status_presensi[3] = "Cuti";
        $arr_status_presensi[4] = "Dinas";
        $arr_status_presensi[5] = "Libur";
        $arr_status_presensi[6] = "Lembur";
        return $arr_status_presensi;
    }
    function arr_izin_type(){
        $arr_izin_type[1]="Tidak Masuk Kerja";
        $arr_izin_type[2]="Datang Terlambat/Pulang Lebih Awal";
        $arr_izin_type[3]="Masuk Kerja";
        return $arr_izin_type;
    }
    function arr_confirm_type(){
        $arr_confirm_type[1][1]="Istirahat Sakit";
        $arr_confirm_type[1][2]="Keperluan Keluarga";
        $arr_confirm_type[1][3]="Ijin Khusus";
        $arr_confirm_type[1][98]="Cuti";
        $arr_confirm_type[1][99]="Dinas";

        $arr_confirm_type[2][4]="Sakit";
        $arr_confirm_type[2][5]="Keperluan Keluarga";
        $arr_confirm_type[2][6]="Gangguan Dalam Perjalanan";
        $arr_confirm_type[2][7]="Gangguan Sistem Presensi";
        $arr_confirm_type[2][100]="Dinas";

        $arr_confirm_type[3][8]="Handphone Ketinggalan";
        $arr_confirm_type[3][9]="Handphone Rusak";
        $arr_confirm_type[3][10]="Sistem Error";
    
        return $arr_confirm_type;
    }
    function arr_subconfirm_type(){
        $arr_subconfirm_type[1][1]="Tanpa Surat Dokter";
        $arr_subconfirm_type[1][2]="Dengan Surat Dokter";
        $arr_subconfirm_type[3][3]="Menikah";
        $arr_subconfirm_type[3][4]="Menikahkan Anak";
        $arr_subconfirm_type[3][5]="Mengkhitankan Anak";
        $arr_subconfirm_type[3][6]="Membaptiskan Anak";
        $arr_subconfirm_type[3][7]="Menatahkan Gigi Anak";
        $arr_subconfirm_type[3][8]="Sakit Haid";
        $arr_subconfirm_type[3][9]="Pernikahan Kakak/Adik";
        $arr_subconfirm_type[3][10]="Suami/Istri/Anak Dirawat di RS";
        $arr_subconfirm_type[3][11]="Anggota Keluarga Meninggal";
        $arr_subconfirm_type[3][12]="Istri Melahirkan/Keguguran";
        $arr_subconfirm_type[3][13]="Menunaikan Haji";
        $arr_subconfirm_type[3][14]="Bencana Alam, Kebakaran & Huru hara";
        return $arr_subconfirm_type;
    }

    function arr_bulan_id(){
        $arr_bulan_id[1]="Januari";
        $arr_bulan_id[2]="Februari";
        $arr_bulan_id[3]="Maret";
        $arr_bulan_id[4]="April";
        $arr_bulan_id[5]="Mei";
        $arr_bulan_id[6]="Juni";
        $arr_bulan_id[7]="Juli";
        $arr_bulan_id[8]="Agustus";
        $arr_bulan_id[9]="September";
        $arr_bulan_id[10]="Oktober";
        $arr_bulan_id[11]="November";
        $arr_bulan_id[12]="Desember";
        return $arr_bulan_id;
    }
    function arr_status_pegawai(){
        $arr_status_pegawai['01']='PKWTT';
        $arr_status_pegawai['02']='PKWT';
        $arr_status_pegawai['03']='Masa Percobaan';
        $arr_status_pegawai['04']='MPP';
        $arr_status_pegawai['05']='MTP';
        $arr_status_pegawai['06']='KomDir/Komite';
        return $arr_status_pegawai;
    }
    function arr_jabatan(){
        $arr_jabatan['1']='Supervisor';
        $arr_jabatan['2']='Senior Supervisor';
        $arr_jabatan['3']='Manager';
        $arr_jabatan['4']='Senior Manager';
        $arr_jabatan['5']='General Manager';
        $arr_jabatan['6']='Vice President';
        return $arr_jabatan;
    }
    function arr_agama(){
        $arr_agama['10']='Islam';
        $arr_agama['02']='Katholik';
        $arr_agama['22']='Hindu';
        $arr_agama['24']='Budha';
        $arr_agama['36']='Protestan';
        $arr_agama['43']='Kong Hucu';
        return $arr_agama;
    }
    function arr_status_nikah(){
        $arr_status_nikah['0']='Lajang';
        $arr_status_nikah['1']='Menikah';
        $arr_status_nikah['2']='Janda';
        $arr_status_nikah['3']='Duda';
        return $arr_status_nikah;
    }
    function arr_com_type(){
        $arr_com_type['0010']='Email Kantor';
        $arr_com_type['CELL']='No HP';
        return $arr_com_type;
    }
    function arr_add_type(){
        $arr_add_type['1']='Alamat KTP';
        $arr_add_type['2']='Alamat Domisili';
        return $arr_add_type;
    }
    function arr_edu_subtype(){
        $arr_edu_subtype['10']='Pendidikan Formal';
        $arr_edu_subtype['70']='Sertifikasi';
        return $arr_edu_subtype;
    }
    function arr_edu_typeduration(){
        $arr_edu_typeduration['010']='Hari';
        $arr_edu_typeduration['011']='Minggu';
        $arr_edu_typeduration['012']='Bulan';
        $arr_edu_typeduration['014']='Semester';
        $arr_edu_typeduration['013']='Tahun';
        $arr_edu_typeduration['015']='Kelas';
        return $arr_edu_typeduration;
    }    
    function arr_edu_cer(){
        $arr_edu_cer['01']='Ada Sertifikat Lulus';
        $arr_edu_cer['00']='Tidak Ada Sertifikat';
        return $arr_edu_cer;
    }
    function arr_edu_lvl(){
        $arr_edu_lvl['11000000']='SD';
        $arr_edu_lvl['12000000']='SLTP';
        $arr_edu_lvl['13000000']='SLTA';
        $arr_edu_lvl['21000000']='D1';
        $arr_edu_lvl['22000000']='D2';
        $arr_edu_lvl['23000000']='D3';
        $arr_edu_lvl['31000000']='S1';
        $arr_edu_lvl['32000000']='S2';
        $arr_edu_lvl['33000000']='S3';
        return $arr_edu_lvl;
    }
    function arr_fam_type(){
        $arr_fam_type['1']='Pasangan (Istri/Suami)';
        $arr_fam_type['2']='Anak Kandung';
        $arr_fam_type['6']='Anak Tiri';
        $arr_fam_type['3']='Anak Angkat (Legal)';
        $arr_fam_type['11']='Ayah';
        $arr_fam_type['12']='Ibu';
        $arr_fam_type['93']='Kakak';
        $arr_fam_type['94']='Adik';
        return $arr_fam_type;
    }
    function arr_provinsi(){
        $arr_provinsi["01"]="DKI Jakarta";
        $arr_provinsi["02"]="Jawa Barat";
        $arr_provinsi["03"]="Jawa Tengah";
        $arr_provinsi["04"]="Jawa Timur";
        $arr_provinsi["05"]="DI Yogyakarta";
        $arr_provinsi["06"]="DI Aceh";
        $arr_provinsi["07"]="Sumatera Utara";
        $arr_provinsi["08"]="Sumatera Barat";
        $arr_provinsi["09"]="Riau";
        $arr_provinsi["10"]="Jambi";
        $arr_provinsi["11"]="Sumatera Selatan";
        $arr_provinsi["12"]="Bengkulu";
        $arr_provinsi["13"]="Lampung";
        $arr_provinsi["14"]="Kalimantan Selatan";
        $arr_provinsi["15"]="Kalimantan Barat";
        $arr_provinsi["16"]="Kalimantan Tengah";
        $arr_provinsi["17"]="Kalimantan Timur";
        $arr_provinsi["18"]="Sulawesi Selatan";
        $arr_provinsi["19"]="Sulawesi Tenggara";
        $arr_provinsi["20"]="Sulawesi Tengah";
        $arr_provinsi["21"]="Sulawesi Utara";
        $arr_provinsi["22"]="Bali";
        $arr_provinsi["23"]="Nusa Tenggara Barat";
        $arr_provinsi["24"]="Nusa Tenggara Timur";
        $arr_provinsi["25"]="Maluku";
        $arr_provinsi["26"]="Papua";
        $arr_provinsi["27"]="Timor Timur";
        $arr_provinsi["28"]="Banten";
        $arr_provinsi["29"]="Kep. Bangka Belitung";
        $arr_provinsi["30"]="Kep. Riau";
        $arr_provinsi["31"]="Gorontalo";
        $arr_provinsi["32"]="Maluku Utara";
        $arr_provinsi["33"]="Kalimantan Utara";
        $arr_provinsi["34"]="Papua Barat";
        $arr_provinsi["35"]="Sulawesi Barat";
        return $arr_provinsi;
    }


    function arr_status_hpp(){
        $arr_status_hpp = array(
            '0' => 'Penawaran No Deal',
            '1' => 'Menunggu Penawaran',
            '2' => 'Penawaran Dibuat',
            '3' => 'Penawaran Deal',
            '4' => 'Final L/R Dibuat'
        );
        return $arr_status_hpp;
    }

    function arr_status_approval_hpp(){
        $arr_status_hpp = array(
            '0' => 'Menunggu Persetujuan',
            '1' => 'Diapprove',
            '2' => 'Dikembalikan'
        );
        return $arr_status_hpp;
    }

    function arr_jurusan(){
        $data=$this->CI->m_array->get_jurusan();
        $arr_jurusan = array();
        foreach ($data as $value) {
            $arr_jurusan[$value["jurusan_id"]] = $value;
        }
        return $arr_jurusan;
    }

    function arr_subarea(){
        $data=$this->CI->m_array->get_subarea();
        $arr_subarea = array();
        foreach ($data as $value) {
            $arr_subarea[$value["subarea_id"]] = $value;
        }
        return $arr_subarea;
    }

    function arr_city(){
        $data=$this->CI->m_array->get_city();
        $arr_city = array();
        foreach ($data as $value) {
            $arr_city[$value["id"]] = $value;
        }
        return $arr_city;
    }

    function arr_jam_kerja(){
        $data=$this->CI->m_array->get_jam_kerja();
        $arr_jam_kerja = array();
        foreach ($data as $value) {
            $arr_jam_kerja[$value["id"]] = $value;
        }
        return $arr_jam_kerja;
    }

    function get_name_from_nik($nik){
        $data=$this->CI->user->get_name($nik);
        return $data;
    }

    function send_push_notif($judul,$isi,$playerid=array(),$url){
        $content = array(
            "en" => $isi
            );
        $head=array(
            "en" =>$judul
        );	
            $fields = array(
                'app_id' => "d84db72c-1710-4333-b49e-d2a3f1b38c72",
                'include_player_ids' => $playerid,
                'url' => $url,
                'contents' => $content,
                'headings' =>$head
            );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                'Authorization: Basic ODc2MTk0NDItYjJhYy00NDliLWJmMDUtY2UyZDljNDY2ODVm'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    function format_rp($nominal){
      return number_format($nominal,2,',','.');
    }

    function arr_day_month($month,$year=FALSE){
        if(!$year){
            $year=date('Y');
        }
        $arr_day = array();
         $num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
         for($day=1;$day<=$num;$day++){
            $arr_day[]=$year.'-'.$month.'-'.$day;
         }
         return $arr_day;
    }

    function save_notif_permintaan_pd($url, $name_url){
        $data_nik_notif = $this->menu->get_user_by_menu($url);
        foreach ($data_nik_notif as $key => $value) {
            $param_notif["title"]="Permintaan Perubahan Data";
            $param_notif["detail"]=$this->session->userdata("nama")." mengajukan permintaan perubahan data ".$name_url;
            $param_notif["link"]=$url;
            $param_notif["link_type"]="1";
            $param_notif["status"]="0";
            $param_notif["nik"]=$value["nik"];
            rcrud_add("tbl_notifikasi", $param_notif);    
        }
    }

    function save_notif_action_pd($nik, $url, $detail){
            $param_notif["id"]="";
            $param_notif["title"]="Hasil Validasi Perubahan Data";
            $param_notif["detail"]=$detail;
            $param_notif["link"]=$url;
            $param_notif["link_type"]="1";
            $param_notif["status"]="0";
            $param_notif["nik"]=$nik;
            rcrud_add("tbl_notifikasi", $param_notif);    
    }


}