<div class="row">
	<div class="col-lg-12">
		<div class="cover-profile">
			<div class="profile-bg-img">
				<img class="profile-bg-img img-fluid" src="<?php echo base_url('assets/template/dashboard');?>/assets/images/user-profile/bg-img1.jpg"
				 alt="bg-img">
				<div class="card-block user-info">
					<div class="col-md-12">
						<div class="media-left">
							<a href="#;" onclick="change_foto();" class="profile-image">
								<!--
								<img class="user-img img-radius img-profile" src="<?php echo base_url(file_exists('upload/profil/'.$this->session->userdata("foto"))?'upload/profil/'.$this->session->userdata("foto"):'assets/img/profile.png');?>" style="background-color:#ffcc99; height:100px; width:auto;"
								 alt="user-img">
								-->
								<img src="<?php echo base_url(! is_null($this->session->userdata("foto")) ?'upload/profil/'.$this->session->userdata("foto"):'assets/img/profile.png');?>" class="user-img img-radius img-profile" style="background-color:#ffcc99; height:100px; width:auto;"
								 alt="user-img">
							</a>
						</div>
						<div class="media-body row">
							<div class="col-lg-12">
								<div class="user-title">
									<h2>
										<?php echo $user['full_name'];?>
									</h2>
									<span class="text-white">
										<?php echo $user['nik'];?>
									</span>
								</div>
							</div>
							<div>
								<!-- <div class="pull-right cover-btn">
									<button type="button" class="btn btn-primary m-r-10 m-b-5"><i class="icofont icofont-plus"></i> Follow</button>
									<button type="button" class="btn btn-primary"><i class="icofont icofont-ui-messaging"></i> Message</button>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="tab-header card">
	<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Data</a>
			<div class="slide"></div>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#password" role="tab">Ganti Password</a>
			<div class="slide"></div>
		</li>
	</ul>
</div>

<div class="card">
	<div class="card-block">
		<div class="tab-content">

			<div class="tab-pane active" id="personal" role="tabpanel">

			<form id="form-profile" method="post">
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Cabang</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" value="<?php echo $user['name'];?>" readonly>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">NIK</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" value="<?php echo $user['nik'];?>" name="nik" id="nik" readonly >
					</div>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Nama Lengkap</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" value="<?php echo $user['full_name'];?>" name="emp_fullname" id="emp_fullname" readonly >
					</div>
				</div>

				<?php if ($this->session->userdata('id_usr_role') == 3 || $this->session->userdata('id_usr_role') == 5 || $this->session->userdata('id_usr_role') == 6): ?>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Jenis Usaha</label>
					<div class="col-sm-6">
						<select class="form-control" name="grand_segment">
							<option value="" selected>-- SEMUA --</option>
							<option value="LOGISTIK" <?php echo $this->session->userdata('grand_segment') == 'LOGISTIK' ? 'selected' : ''; ?>>LOGISTIK</option>
							<option value="PERGUDANGAN" <?php echo $this->session->userdata('grand_segment') == 'PERGUDANGAN' ? 'selected' : ''; ?>>PERGUDANGAN</option>
							<option value="WIS" <?php echo $this->session->userdata('grand_segment') == 'WIS' ? 'selected' : ''; ?>>WIS</option>
						</select>
					</div>
				</div>
				<?php endif; ?>

				<?php if ($this->session->userdata('id_usr_role') == 3 || $this->session->userdata('id_usr_role') == 5 || $this->session->userdata('id_usr_role') == 6): ?>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label"></label>
					<div class="col-sm-6">
						<input type="submit" value="Simpan" class="btn btn-primary">
					</div>
				</div>
				<?php endif; ?>

			</form>

			</div>



			<div class="tab-pane" id="password" role="tabpanel">
								
			<form id="form-cp" method="post">
				
				<div class="form-group row">
				<label class="col-sm-3 col-form-label">Password Lama</label>
				<div class="col-sm-6">
					<div class="input-group">
						<input type="password" class="form-control" name="password_old" id="password_old" >
						<span class="input-group-addon" onclick="ocPass('password_old',this);" id="basic-addon3"><i class="fa fa-eye"></i></span>
					</div>
				</div>
				</div>
				
				<div class="form-group row">
				<label class="col-sm-3 col-form-label">Password Baru</label>
				<div class="col-sm-6">
					<div class="input-group">
						<input type="password" class="form-control" name="password_new" id="password_new" >
						<span class="input-group-addon" onclick="ocPass('password_new',this);" id="basic-addon3"><i class="fa fa-eye"></i></span>
					</div>
				</div>
				</div>
	
	
				<div class="form-group row">
				<label class="col-sm-3 col-form-label">Ulangi Password Baru</label>
				<div class="col-sm-6">
					<div class="input-group">
						<input type="password" class="form-control" name="password_new_confirm" id="password_new_confirm" >
						<span class="input-group-addon" onclick="ocPass('password_new_confirm',this);" id="basic-addon3"><i class="fa fa-eye"></i></span>
					</div>
				</div>
				</div>
	
	
				<div class="form-group row">
				<label class="col-sm-3 col-form-label"></label>
				<div class="col-sm-6">
					<input type="submit" value="Simpan" class="btn btn-primary">
				</div>
				</div>
	
	
			</form>

			</div>

		</div>
	</div>
</div>
<button data-toggle="modal" data-target="#modal-container" id="modal-btn" style="margin-left:5px; display:none;" title="Add/Edit Data"
			 class="card-block icon-btn btn btn-inverse btn-outline-inverse btn-icon">
				<i class="icofont icofont-ui-add"></i>
			</button>

<script>
var isEdit;
function change_foto(){
	isEdit = true;
	$("#modal-btn").click();
}

$('document').ready(function () {

	function cek_pass( str ) {	
    var rgularExp = {
        containsAngka : /\d+/,
        containsHurufKecil : /[a-z]/,
        containsHurufBesar : /[A-Z]/,
        noContainsSpecialChar : /^[a-zA-Z0-9- ]*$/,
    }
    var expMatch = {};
    expMatch.containsAngka = rgularExp.containsAngka.test(str);
    expMatch.containsHurufKecil = rgularExp.containsHurufKecil.test(str);
    expMatch.containsHurufBesar = rgularExp.containsHurufBesar.test(str);
    expMatch.noContainsSpecialChar = rgularExp.noContainsSpecialChar.test(str);

    return expMatch;
}


var form=$('#form');
                        // Modal Section
                        form.submit(function(e){ 
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
                           var url_form = site_url+'/user/upload_foto';
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
                                        //$('#modal-container').modal('hide');
										swal(
											{
											title:'Saved!',
											text:'Successful save data!',
											type:'success',
											closeOnConfirm: true},
											function(){
												$('.img-profile').attr('src',base_url+'upload/profil/'+data.foto_new);
												$('#foto_old').val(data.foto_new);
											}
										);
                                    }
                                    else{
                                        //$('#modal-container').modal('hide');
                                        swal(
                                        'Saved!',
                                        'Failed '+caption+' data! '+(data.message!=null?data.message:''),
                                        'error'
                                        );
                                    }
                                    isEdit=false;
                                    $("#id").val("");
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseText) {
                                    oResponse = JSON.parse(xhr.responseText);
                                    alert(oResponse.error.message)
                                    } else {
                                    alert("Status: "+status+"\nXhr: "+JSON.stringify(xhr)+"\n\nError: " + error);
                                    }
                                }
                            });
                        });



	$('#form-profile').submit(function(e){
		
                            swal({
                                html:true,
                                title: "Menyimpan...",
                                text: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                showCancelButton: false,
                            });                 
			e.preventDefault();
			$.ajax({
				url:site_url+'/user/update_profile',
				type:'POST',
				dataType:'json',
				data:$('#form-profile').serialize(),
				success:function(response){
					if(response.success==true)
					{
						swal(
							{
							title:'Saved!',
							text:'Successful save data!',
							type:'success',
							closeOnConfirm: true},
							function(){
								$('#table_user_table').DataTable().ajax.reload();
							}
						);
					}
					else{
						swal({
							title:'Error!',
							text:'Failed to save data! '+(response.message!=""?response.message:""),
							type:'error',
							closeOnConfirm: true}
						);
					}
				},
				error:function(stat,res,err){
					alert(err);
				}
			});
		});

		$('#form-cp').submit(function(e){
			swal({
                                html:true,
                                title: "Menyimpan...",
                                text: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                showCancelButton: false,
                            });                 

			e.preventDefault();
			var pass_old = $("#password_old").val();
			var pass_new = $("#password_new").val();
			var pass_new_confirm = $("#password_new_confirm").val();

			if (pass_old!="" 
				&& pass_new!="" 
				&& pass_new==pass_new_confirm
			    && cek_pass(pass_new).containsAngka
			    && cek_pass(pass_new).containsHurufKecil
			    && cek_pass(pass_new).containsHurufBesar
			    && !cek_pass(pass_new).noContainsSpecialChar
			   ){
			$.ajax({
				url:site_url+'/user/change_password',
				type:'POST',
				dataType:'json',
				data:$('#form-cp').serialize(),
				success:function(response){
					if(response.succces==true)
					{
						swal(
							{
							title:'Saved!',
							text:(response.message!=""?response.message:""),
							type:'success',
							closeOnConfirm: true},
							function(){
								//$('#table_user_table').DataTable().ajax.reload();
								//$('#dash_logout').click();
								location.reload();
							}
						);
					}
					else{
						swal({
							title:'Error!',
							text:'Failed to save data! '+(response.message!=""?response.message:""),
							type:'error',
							closeOnConfirm: true}
						);
					}
				},
				error:function(stat,res,err){
					alert(err);
				}
			});
			}
			else if (pass_old==""){
				swal_show("Anda belum memasukan password lama!");
			}
			else if (pass_new==""){
				swal_show("Anda belum memasukan password baru!");
			}else if (pass_new!=pass_new_confirm){
				swal_show("Password baru yang anda masukan tidak sama!");
			}else if (pass_new.length<8){
				swal_show("Password minimal 8 karakter!");
			}else{
				swal_show("Password baru yang anda masukan harus mengandung 8 karakter, huruf besar, huruf kecil, angka dan symbol!");
			}
		});


});

function ocPass(id,el){
	if (el.innerHTML=='<i class="fa fa-eye"></i>'){
		$("#"+id).attr('type','text');
		el.innerHTML = '<i class="fa fa-eye-slash"></i>';
	}else{
		$("#"+id).attr('type','password');
		el.innerHTML = '<i class="fa fa-eye"></i>';
	}
}

function swal_show(txt_shwo){
	swal({
							title:'Error!',
							text: txt_shwo,
							type:'error',
							closeOnConfirm: true}
						);
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
                                    url:site_url+"/user/delete"+(is_temp?"_temp":""),
                                    type:'POST',
                                    data:{id:idData,file:file_string,is_hard_delete:hard},
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
                                            $('#table_user_table').DataTable().ajax.reload();
                                        }
                                        else{
                                            swal(
                                            'Deleted!',
                                            'Failed delete data! '+(data.message!=null?data.message:''),
                                            'error'
                                            );
                                            $('#table_user_table').DataTable().ajax.reload();
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
<form id="form">
<div class="modal fade" id="modal-container" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Ganti Foto Profil</h4>
                        <button type="button" class="close" id="close_dialog" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div>
                                <input type="hidden" name="id" id="id">
                            </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="foto">Foto<span class="required span_req_file" style="color:#ff3333;">*</span>
                                    </label>
                                    <div class="col-sm-9"><input id="foto" class="form-control" name="foto" placeholder="Foto" type="file" accept="image/*" required="required">
                                        <input type="hidden" name="foto_old" id="foto_old" value="<?php echo $user["foto"]; ?>">
                                        <a href="" target="_blank" rel="noopener noreferrer" class="text-primary" id="href_file"></a>
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancel" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>
                    </div>
                </div>
            </div>
        </div>
</form>

<?php
	echo (!empty($render_table_js)?$render_table_js:"");	
	//echo (!empty($render_form_modal)?$render_form_modal:"");
?>

<script>
  OneSignal.push(function() {
	send_player_id();
  });
  function send_player_id(){
	OneSignal.getUserId( function(userId) {
		//console.log(userId);
		if (userId!=null){
			$.ajax({
				url: site_url + '/user/add_player_id',
				type: 'POST',
				dataType: 'json',
				data: {
					player_id: userId
				},
				success: function (data, text) {
				},
				error: function (stat, res, err) {
				}
			});
		}
    });
  }
</script>
