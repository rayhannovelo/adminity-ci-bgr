var isEdit = false;
$('document').ready(function () {
	var modalLabel = $('#myModalLabel');
	var form = $('#form');
	var table = $('#table_user');
	var no = 0;
	getUserStatus();
	getUserRole();
	getUserSiska();
	//getUserAM();

	//Form Components
	var el_select_2 = $('.select_2');
	el_select_2.select2({
		dropdownParent: $("#modal-container")
	});

	var el_select_2_edit = $('.select_2_edit');
	el_select_2_edit.select2({
		dropdownParent: $("#modal-edit")
	});

	//Form Components
	table.DataTable({
		"aaSorting": [],
		"initComplete": function (settings, json) {

		},
		"retrieve": true,
		"processing": true,
		'ajax': {
			"type": "GET",
			"url": site_url + '/user/get',
			"data": function (d) {
				no = 0;
			},
			"dataSrc": ""
		},
		'columns': [{
				render: function (data, type, full, meta) {
					no += 1;
					return no;
				}
			},
			{
				render: function (data, type, full, meta) {
					return full.nik == null ? '-' : full.nik;
				}
			},
			{
				render: function (data, type, full, meta) {
					return full.full_name == null ? '-' : full.full_name;
				}
			},
			{
				render: function (data, type, full, meta) {
					return full.role_name == null ? '-' : full.role_name;
				}
			},
			{
				render: function (data, type, full, meta) {
					return full.name == null ? '-' : full.name;
				}
			},
			{
				render: function (data, type, full, meta) {
					var label='';
					switch(full.id_usr_status)
					{
						case '1':{
							label='label-primary';
							break;
						}
						case '2':{
							label='label-success';
							break;
						}
						case '3':{
							label='label-warning';
							break;
						}
						case '4':{
							label='label-danger';
							break;
						}
					}
					return '<label class="label '+label+'">'+full.status_name+'</label>';;
				}
			},
			{
				render: function (data, type, full, meta) {
					return full.action;
					// return '\
                    // <div class="text-center">\
                    //         <a href="#" class="dropdown-toggle addon-btn" data-toggle="dropdown" aria-expanded="true">\
                    //             <i class="icofont icofont-ui-settings"></i>\
                    //         </a>\
                    //         <div class="dropdown-menu dropdown-menu-right">\
                    //             <a class="dropdown-item" href="#" onclick="edit_data(' + full.id_user + ')" ><i class="icofont icofont-ui-edit"></i>Edit</a>\
                    //             <a class="dropdown-item" href="#" onclick="delete_data(' + full.id_user + ')" ><i class="icofont icofont-ui-delete"></i>Delete</a>\
                    //         <div role="separator" class="dropdown-divider"></div>\
                    //     </div>\
                    // </div>';
				}
			}
		]
	});

	form.submit(function (e) {
		e.preventDefault();
		var url_form = (isEdit == false) ? site_url + '/user/add' : site_url + '/user/edit'
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
                    $('#modal-container').modal('hide');
                    swal(
                    'Saved!',
                    'Successful '+caption+' data!',
                    'success'
                    );
                    $('#table_user').DataTable().ajax.reload();

                }
                else{
                    $('#modal-container').modal('hide');
                    swal(
                    'Saved!',
                    data.message!=null?data.message:'Failed '+caption+' data!',
                    'error'
                    );
                    $('#table_user').DataTable().ajax.reload();
                }
                isEdit=false;
            },
            error:function(stat,res,err)
            {
                alert(err);
                isEdit=false;
            }
        });
	});


	// Modal Section
	$('#modal-btn').click(function () {
		if (!isEdit) {
			form[0].reset();
			$('#id_usr_status').val('');
			$('#id_usr_status').select2('val', '');
			$('#id_usr_role').val('');
			$('#id_usr_role').select2('val', '');

			$('#password').attr('required="required"');
			modalLabel.html('Add New User');
		} else {
			$('#password').removeAttr('required="required"');
			modalLabel.html('Edit User');
		}
	});

	$('#close_dialog').click(function () {
		isEdit = false;
		$('#password').prop('required', true);
	});

	$('#cancel').click(function () {
		isEdit = false;
		$('#password').prop('required', true);
	});

	$('#submit').click(function () {
		$('#sendSubmit').click();
	});

	$('#submitEdit').click(function () {
		$('#sendSubmitEdit').click();
	});
	//Modal Section
});

function edit_data(idData) {
	$.ajax({
		url: site_url + "/user/get",
		type: 'GET',
		dataType: 'json',
		data: {
			id_user: idData
		},
		success: function (data, text) {
			if (data.length >= 1) {
				isEdit = true;
				$('#edit_id').val(data[0].id_user);
				$('#edit_id_usr_role_old').val(data[0].id_usr_role);
				$('#edit_user_area_old').val(data[0].user_area);

				$('#edit_nik').val(data[0].nik);
				$('#edit_full_name').val(data[0].full_name);
				$('#edit_id_usr_role').val(data[0].id_usr_role).trigger('change');
				$('#edit_user_area').val(data[0].user_area).trigger('change');
				$('#edit_id_usr_status').val(data[0].id_usr_status).trigger('change');
				
				$('#modal-edit').modal('show');
			}
		},
		error: function (stat, res, err) {
			alert(err);
		}
	})
}

$("#form-edit").on("submit", function() {
	$('#modal-edit').modal('hide');
    $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: site_url + "/user/update_user",
        data: $('#form-edit').serialize(),
        beforeSend: function() {
            swal({
                html: true,
                title: "Menyimpan...",
                text: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                showConfirmButton: false,
                allowOutsideClick: true,
                showCancelButton: false,
            });
        },
        success: function(data) {
            if (data.status) {
                $('#table_user').DataTable().ajax.reload();
                swal("Updated!", "Successful update data!", "success");
            } else {
                swal("Failed!", "Failed update data!", "error");
            }
        },
        error: function (err) {
            
        }
    });
});

function delete_data(idData) {
	swal({
			title: "Are you sure?",
			text: "This data will be deleted!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
		},
		function () {
			$.ajax({
				url: site_url + "/user/delete",
				type: 'POST',
				data: {
					id_user: idData
				},
				dataType: 'json',
				async: false,
				success: function (data, text) {
					if (data.success) {
						swal(
							'Deleted!',
							'Successful delete data!',
							'success'
						);
						$('#table_user').DataTable().ajax.reload();
					}
				},
				error: function (stat, res, err) {
					alert(err);
				}
			});
		});
}



function reset_device(nik) {
	swal({
			title: "Anda yakin?",
			text: "Device akan direset!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, Reset Device!",
			closeOnConfirm: false
		},
		function () {
			$.ajax({
				url: site_url + "/user/reset_device",
				type: 'POST',
				data: {
					nik: nik
				},
				dataType: 'json',
				async: false,
				success: function (data, text) {
					if (data.success) {
						swal(
							'Reseted!',
							'Successful reset device data!',
							'success'
						);
						$('#table_user').DataTable().ajax.reload();
					}else{
						swal(
							'Gagal!',
							'Gagal reset device',
							'error'
						);
					}
				},
				error: function (stat, res, err) {
					alert(err);
				}
			});
		});
}

function reset_password(nik) {
	swal({
		title: "Anda yakin?",
		text: "Password akan direset!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes, Reset Password!",
		closeOnConfirm: false
	},
	function () {
		$.ajax({
			url: site_url + "/user/reset_password",
			type: 'POST',
			data: {
				nik: nik
			},
			dataType: 'json',
			async: false,
			success: function (data, text) {
				if (data.success) {
					swal(
						'Reseted!',
						data.message,
						'success'
					);
					$('#table_user').DataTable().ajax.reload();
				}else{
					swal(
						'Gagal!',
						'Gagal reset password',
						'error'
					);
				}
			},
			error: function (stat, res, err) {
				alert(err);
			}
		});
	});
}

function getUserStatus() {
	$.ajax({
		url: site_url + '/user_status/get',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Choose User Status</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id_usr_status + '">' + data[i].status_name + '</option>';
			}
			$('.id_usr_status').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function getUserRole() {
	$.ajax({
		url: site_url + '/user_role/get',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Choose User Role</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id_usr_role + '">' + data[i].role_name + '</option>';
			}
			$('.id_usr_role').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function getUserSiska() {
	$.ajax({
		url: site_url + '/user/get_user_siska',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (hasil, text) {
			//console.log(hasil);
			var data = hasil.result;
			var opts = '<option value="">Pilih Pegawai yang akan ditambahkan</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].nik + '">' + data[i].nik + ' - ' + data[i].emp_fullname + ' ('+data[i].subarea_ket+' - '+data[i].pos_objnm+')</option>';
			}
			$('#user_from_siska').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function getUserAM() {
	$.ajax({
		url: site_url + '/hpp/get_user_am',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (hasil, text) {
			var data = hasil.result;
			var opts = '<option value="">Pilih AM</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof am !== 'undefined') {
					if (data[i].emp_fullname == am) {
						opts += '<option value="' + data[i].emp_fullname + '" selected>' + data[i].emp_fullname + '</option>';
					} else {
						opts += '<option value="' + data[i].emp_fullname + '">' + data[i].emp_fullname + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].emp_fullname + '">' + data[i].emp_fullname + '</option>';
				}
			}
			$('.am').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function ocUserSiska(el){
	$.ajax({
		url: site_url + '/user/get_user_siska/'+el.value,
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (hasil, text) {
			var data = hasil.result[0];
			$("input[name=user_pass]").val(data.user_pass);
			$("input[name=full_name]").val(data.emp_fullname);
			$("input[name=user_area]").val(data.or_perssubarea);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

