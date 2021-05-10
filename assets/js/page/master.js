function get_customer(customer = null) {
	$.ajax({
		url: site_url + '/master_get/customer',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof customer !== 'undefined') {
					if (data[i].kd_plg == customer) {
						opts += '<option value="' + data[i].kd_plg + '" selected>' + data[i].kd_plg + " - " + data[i].nm_plg + '</option>';
					} else {
						opts += '<option value="' + data[i].kd_plg + '">' + data[i].kd_plg + " - " + data[i].nm_plg + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].kd_plg + '">' + data[i].kd_plg + " - " + data[i].nm_plg + '</option>';
				}
			}

			$('.customer').html(opts);

			if (customer != null) {
				$('#customer_id').val(customer);
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_ordertype(tipe_proposal = null) {
	$.ajax({
		url: site_url + '/master_get/ordertype',
		type: 'POST',
		dataType: 'json',
		data: { tipe_proposal: tipe_proposal },
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof order_type !== 'undefined') {
					if (data[i].id == order_type) {
						opts += '<option value="' + data[i].id + '" selected>' + data[i].name + '</option>';
					} else {
						opts += '<option value="' + data[i].id + '">'+ data[i].name + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].id + '">'+ data[i].name + '</option>';
				}
			}
			$('.order_type').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_subordertype(order_type) {
	var count = 0;
	$.ajax({
		async: false,
		url: site_url + '/master_get/subordertype/' + order_type,
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
			}
			count =  data.length;
			$('.sub_order_type').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});

	return count;
}

function get_commodity() {
	$.ajax({
		url: site_url + '/master_get/commodity',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof commodity !== 'undefined') {
					if (data[i].id == commodity) {
						opts += '<option value="' + data[i].id + '" selected>'+ data[i].name + '</option>';
					} else {
						opts += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].id + '">'+ data[i].name + '</option>';
				}
			}
			$('.commodity').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_kemasan() {
	$.ajax({
		url: site_url + '/master_get/kemasan',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof uom !== 'undefined') {
					if (data[i].id == uom) {
						opts += '<option value="' + data[i].id + '" selected>' + data[i].name + '</option>';
					} else {
						opts += '<option value="' + data[i].id + '">'+ data[i].name + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].id + '">'+ data[i].name + '</option>';
				}
			}
			$('.uom').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_uom() {
	$.ajax({
		url: site_url + '/master_get/kemasan',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (typeof uom !== 'undefined') {
					if (data[i].id == uom) {
						opts += '<option value="' + data[i].name + '" selected>' + data[i].name + '</option>';
					} else {
						opts += '<option value="' + data[i].name + '">'+ data[i].name + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].name + '">'+ data[i].name + '</option>';
				}
			}
			$('.uom').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_city() {
	$.ajax({
		url: site_url + '/master_get/city',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
			}
			$('.city').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}


function get_branch() {
	$.ajax({
		url: site_url + '/master_get/branch',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
			}
			$('.branch').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_coa_biaya(is_edit=false, id=null, jenis_biaya=null, ordertype=null) {
	$.ajax({
		url: site_url + '/master_get/coabiaya',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].id + ' ('+ data[i].name +')</option>';
			}
			$('.coa_biaya').html(opts);
			if (is_edit){
				load_data_edit(id, jenis_biaya)
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_coa_biaya_ordertype(is_edit=false, id=null, jenis_biaya=null, ordertype=null, subordertype=null) {
	$.ajax({
		url: site_url + '/master_get/coabiaya_ordertype/',
		dataType: 'json',
		data: {ordertype: ordertype, subordertype: subordertype},
		success: function (data, text) {
			//console.log(data);
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].coa_id + '">' + data[i].coa_id + ' ('+ data[i].name +')</option>';
			}
			$('.coa_biaya').html(opts);
			if (is_edit){
				load_data_edit(id, jenis_biaya)
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_coa_pendapatan(is_edit=false, id=null, jenis_biaya=null, ordertype=null) {
	$.ajax({
		url: site_url + '/master_get/coapendapatan',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].id + ' ('+ data[i].name +')</option>';
			}
			$('.coa_pendapatan').html(opts);
			if (is_edit){
				load_data_edit(id, jenis_biaya)
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_coa_pendapatan_ordertype(is_edit=false, id=null, jenis_biaya=null, ordertype=null, subordertype=null) {
	$.ajax({
		url: site_url + '/master_get/coapendapatan_ordertype/',
		type: 'GET',
		dataType: 'json',
		data: {ordertype: ordertype, subordertype: subordertype},
		success: function (data, text) {
			//console.log(data);
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].coa_id + '">' + data[i].coa_id + ' ('+ data[i].name +')</option>';
			}
			$('.coa_biaya').html(opts);
			if (is_edit){
				load_data_edit(id, jenis_biaya)
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_coa_pendapatan_non_usaha(is_edit=false, id=null, jenis_biaya=null, ordertype=null) {
	$.ajax({
		url: site_url + '/master_get/coapendapatannonusaha',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].id + ' ('+ data[i].name +')</option>';
			}
			$('.coa_pendapatan_non_usaha').html(opts);
			if (is_edit){
				load_data_edit(id, jenis_biaya)
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_hpp(status,branch,selected_val=null,status_approval=null) {
	$.ajax({
		url: site_url + '/master_get/hpp',
		type: 'GET',
		dataType: 'json',
		data: {status:status,status_approval:status_approval,branch:branch},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {

				// if (typeof id_hpp !== 'undefined') {
				// 	if (data[i].id == id_hpp) {
				// 		opts += '<option value="' + data[i].id + '" selected>'+ data[i].no_rfq +'</option>';
				// 	} else {
				// 		opts += '<option value="' + data[i].id + '">'+ data[i].no_rfq +'</option>';
				// 	}
				// } else {
				 	opts += '<option value="' + data[i].id + '">'+ data[i].no_rfq +'</option>';
				// }
			}
			$('.hpp_id').html(opts);
			if (selected_val!=null){
				$('.hpp_id').val(selected_val).trigger('change');
				$('.hpp_id').val(selected_val);
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_penawaran(status,is_used,branch,status_approval=null) {
	$.ajax({
		url: site_url + '/master_get/penawaran',
		type: 'GET',
		dataType: 'json',
		data: {status:status,is_used:is_used,branch:branch,status_approval:status_approval},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">'+ data[i].no_penawaran +'</option>';
			}
			$('.penawaran_id').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_final_lr(branch) {
	$.ajax({
		url: site_url + '/master_get/final_lr',
		type: 'GET',
		dataType: 'json',
		data: {branch:branch},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">'+ data[i].no_final +'</option>';
			}
			$('.final_id').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_user() {
	$.ajax({
		url: site_url + '/master_get/user',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].nik + '">' + data[i].full_name + ' - '+data[i].role_name+'</option>';
			}
			$('.user_option').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_gm_marketing() {
	$.ajax({
		url: site_url + '/master_get/gm_marketing',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih GM Marketing</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].nik + '">' + data[i].full_name + ' - '+data[i].role_name+'</option>';
			}
			$('.gm_marketing').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_klasifikasi_biaya() {
	$.ajax({
		url: site_url + '/master_get/klasifikasi_biaya',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' +data[i].name+'</option>';
			}
			$('.user_option').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_sow(order_type_id, sub_order_type_id) {
	$.ajax({
		url: site_url + '/master_get/sow',
		type: 'GET',
		dataType: 'json',
		data: {order_type_id: order_type_id, sub_order_type_id: sub_order_type_id},
		success: function (data, text) {
			var opts = '';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">'+ data[i].name + ' (' + data[i].coa_id + ')</option>';
			}
			$('.sow-select2').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_grand_segment() {
	$.ajax({
		url: site_url + '/master_get/grand_segment',
		type: 'GET',
		dataType: 'json',
		data: {},
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].grand_segment + '">' + data[i].grand_segment + '</option>';
			}
			$('.grand_segment').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_io() {
	$.ajax({
		url: site_url + '/master_get/io',
		type: 'GET',
		dataType: 'json',
		data: { branch : branch },
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].no_proposal + '">' + data[i].no_io + ' - ' + data[i].no_proposal + '</option>';
			}

			$('.io').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_io_id() {
	$.ajax({
		url: site_url + '/master_get/io',
		type: 'GET',
		dataType: 'json',
		data: { branch : branch },
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].id + '">' + data[i].no_io + ' - ' + data[i].no_proposal + '</option>';
			}

			$('.io').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_ps() {
	$.ajax({
		url: site_url + '/master_get/ps',
		type: 'GET',
		dataType: 'json',
		data: { branch : branch },
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].no_proposal + '">' + data[i].no_ps + ' - ' + data[i].no_proposal + '</option>';
			}

			$('.ps').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_io_ps() {
	$.ajax({
		url: site_url + '/master_get/io_ps',
		type: 'POST',
		dataType: 'json',
		data: { proposal_id_arr: proposal_id_arr, order_type_id: order_type_id, customer_id: customer_id, uom: uom, jenis_modul: jenis_modul },
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				if (data[i].jenis_modul == 'io') {
					opts += '<option data-jenis-modul="' + data[i].jenis_modul + '" value="' + data[i].id + '">' + data[i].no_io + ' - ' + data[i].no_proposal + '</option>';
				} else if (data[i].jenis_modul == 'ps') {
					opts += '<option data-jenis-modul="' + data[i].jenis_modul + '" value="' + data[i].id + '">' + data[i].no_ps + ' - ' + data[i].no_proposal + '</option>';
				} else {

					// io/ps manual
					opts += '<option data-jenis-modul="' + data[i].jenis_modul + '" value="' + data[i].id + '">' + data[i].io_ps + '</option>';
				}
			}

			$('.io_ps').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_io_ps_invoice() {
	$.ajax({
		url: site_url + '/master_get/get_io_ps_invoice',
		type: 'POST',
		dataType: 'json',
		data: { invoice_id: invoice_id },
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';

			// if (jenis_modul == 'io_manual' || jenis_modul == 'ps_manual' || jenis_modul == 'io_manual_ps_manual') {
			// 	for (var i = 0; i < data.length; i++) {
			// 		opts += '<option value="' + data[i].io_ps_manual_id + '">' + data[i].no_io_ps + '</option>';
			// 	}
			// } else {
			// 	for (var i = 0; i < data.length; i++) {
			// 		opts += '<option value="' + data[i].proposal_id + '">' + data[i].no_io_ps + '</option>';
			// 	}
			// }

			for (var i = 0; i < data.length; i++) {
				if (data[i].jenis_modul == 'io' || data[i].jenis_modul == 'ps') {
					opts += '<option data-io-ps="' + data[i].no_io_ps + '" data-jenis-modul="' + data[i].jenis_modul + '" value="' + data[i].proposal_id + '">' + data[i].no_io_ps + '</option>';
				} else if (data[i].jenis_modul_manual == 'io_manual' || data[i].jenis_modul_manual == 'ps_manual') {
					opts += '<option data-io-ps="' + data[i].no_io_ps + '" data-jenis-modul="' + data[i].jenis_modul_manual + '" value="' + data[i].io_ps_manual_id + '">' + data[i].no_io_ps + '</option>';
				}
			}

			$('.io_ps_invoice').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_last_pendapatan(jenis_modul = null, io_ps = null) {
	$.ajax({
		url: site_url + '/master_get/get_last_pendapatan',
		type: 'POST',
		dataType: 'json',
		data: { invoice_id: invoice_id, step_invoice_id: step_invoice_id, except_id: except_id, jenis_modul: jenis_modul, io_ps: io_ps },
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';

			if (jenis_modul == 'io_manual' || jenis_modul == 'ps_manual' || jenis_modul == 'io_manual_ps_manual') {
				for (var i = 0; i < data.length; i++) {
					opts += '<option data-jenis-modul="' + jenis_modul + '" data-io-ps="' + io_ps + '" value="' + data[i].id + '">' + data[i].id + ' (' + data[i].name + ')</option>';
				}
			} else {
				for (var i = 0; i < data.length; i++) {
					opts += '<option data-jenis-modul="' + jenis_modul + '" data-io-ps="' + data[i].no_io_ps + '" value="' + data[i].biaya_proposal_id + '" >' + data[i].no_io_ps + ' - ' + data[i].coa_id + ' (' + data[i].coa_name + ')</option>';
				}
			}

			$('.last_pendapatan').html(opts);
			
			if (except_id != 0) {
				$('#modal-add #can_change').val(0);
				$('#modal-add #biaya_proposal_id').val(except_id).trigger('change');
				can_change = 1;
			}
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_last_tagihan() {
	$.ajax({
		url: site_url + '/master_get/get_last_tagihan',
		type: 'POST',
		dataType: 'json',
		data: { invoice_id: invoice_id },
		success: function (data, text) {
			var opts = '<option value="" selected disabled>Pilih</option>';

			// if (jenis_modul == 'io_manual' || jenis_modul == 'ps_manual') {
			// 	for (var i = 0; i < data.length; i++) {
			// 		opts += '<option value="' + data[i].id + '">' + data[i].no_io_ps_manual + ' - ' + data[i].coa_id + ' (' + data[i].coa_name + ')</option>';
			// 		//opts += '<option value="' + data[i].id + '">' + data[i].tagihan + '</option>';
			// 	}
			// } else {
			// 	for (var i = 0; i < data.length; i++) {
			// 		opts += '<option value="' + data[i].id + '">' + (data[i].jenis_modul == 'io' ? data[i].no_io : data[i].no_ps) + ' - ' + data[i].coa_id + ' (' + data[i].coa_name + ')</option>';
			// 		//opts += '<option value="' + data[i].id + '">' + data[i].tagihan + '</option>';
			// 	}
			// }

			for (var i = 0; i < data.length; i++) {
				if (data[i].jenis_modul == 'io' || data[i].jenis_modul == 'ps') {
					opts += '<option value="' + data[i].id + '">' + (data[i].jenis_modul == 'io' ? data[i].no_io : data[i].no_ps) + ' - ' + data[i].coa_id + ' (' + data[i].coa_name + ')</option>';
				} else {
					opts += '<option value="' + data[i].id + '">' + data[i].no_io_ps_manual + ' - ' + data[i].coa_id + ' (' + data[i].coa_name + ')</option>';
				}
			}
			
			$('.last_tagihan').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_user_roles(tipe_proposal = null) {
	$.ajax({
		url: site_url + '/master_get/user_roles',
		type: 'GET',
		dataType: 'json',
		data: { tipe_proposal: tipe_proposal },
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';
			for (var i = 0; i < data.length; i++) {
				opts += '<option value="' + data[i].role_name + '">' + data[i].role_name + '</option>';
			}

			$('.user_roles').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_invoices(invoice_id = null) {
	$.ajax({
		url: site_url + '/master_get/get_invoices',
		type: 'GET',
		dataType: 'json',
		success: function (data, text) {
			var opts = '<option value="">Pilih</option>';

			if (invoice_id == null) {
				for (var i = 0; i < data.length; i++) {
					opts += '<option value="' + data[i].id + '">' + data[i].no_invoice + '</option>';
				}
			} else {
				for (var i = 0; i < data.length; i++) {
					opts += '<option value="' + data[i].id + '" ' + (invoice_id == data[i].id ? 'selected' : '') + ' >' + data[i].no_invoice + '</option>';
				}
			}

			$('.invoices').html(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

function get_jenis_penghasilan(jenis_penghasilan = null, jenis_pph = null, disable = false) {
	$.ajax({
		url: site_url + '/master_get/get_jenis_penghasilan',
		type: 'POST',
		dataType: 'json',
		data: { jenis_pph: jenis_pph },
		success: function (data, text) {
			if (jenis_penghasilan == null) {
				var opts = '<option value="" selected disabled>Pilih</option>';
			} else{
				var opts = '<option value="" disabled>Pilih</option>';
			}
			
			for (var i = 0; i < data.length; i++) {
				if (typeof jenis_penghasilan !== 'undefined') {
					if (data[i].id == jenis_penghasilan) {
						opts += '<option value="' + data[i].id + '" selected>'+ data[i].nomor + ' - ' + data[i].nama_jenis_penghasilan + '</option>';
					} else {
						opts += '<option value="' + data[i].id + '">'+ data[i].nomor + ' - ' + data[i].nama_jenis_penghasilan + '</option>';
					}
				} else {
					opts += '<option value="' + data[i].id + '">'+ data[i].nomor + ' - ' + data[i].nama_jenis_penghasilan + '</option>';
				}
			}
			$('.jenis_penghasilan').html(opts);

			if (disable) {
				$('#jenis_penghasilan').prop('disabled', false);
			}

			console.log(opts);
		},
		error: function (raw, stat, err) {
			alert('Couldn\'t load data, ' + err);
		}
	});
}

$('#btn-reset').click(function(){ 
    $('#date_to').val('');
    $('#date_from').val('');
});

 function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function cleanDecimals(number) {
	var number = number.toString();
	var split = number.split(',');

	// check decimal number
	if (split[1].length < 3) {
		split[1] = split[1] + 0;
	}

	// check if formated number
	if (split[0].includes('.') == false) {
		split[0] = number_format(parseInt(split[0]), 0, ',', '.');
	}

	number = split.join();

	var zero = number.substr(-6, 6);
	var result = '';

	if (zero == ',00000') {
        result = number.replace(/,00000/g, '');
    } else {
    	zero = number.substr(-4, 4);

    	if (zero == '0000' || zero == ',000') {
    		result = number.slice(0, -4);
    	} else {
    		zero = number.substr(-3, 3);

    		if (zero == '000') {
    			result = number.slice(0, -3);
    		} else {
    			zero = number.substr(-2, 2);

		        if (zero == '00') {
		            result = number.slice(0, -2);
		        } else {
		            zero = number.substr(-1, 1);

		            if (zero == '0') {
		                result = number.slice(0, -1);
		            } else {
		                result = number;
		            }
		        }
    		}
    	}
    }

	//console.log(result);

	return result;
}

function cleanDecimalsOld(number) {
	var number = number.toString();
	var split = number.split(',');

	// check decimal number
	if (split[1].length < 3) {
		split[1] = split[1] + 0;
	}

	// check if formated number
	if (split[0].includes('.') == false) {
		split[0] = number_format(parseInt(split[0]), 0, ',', '.');
	}

	number = split.join();

	var zero = number.substr(-4, 4);
	var result = '';

	if (zero == ',000') {
        result = number.replace(/,000/g, '');
    } else {
        zero = number.substr(-2, 2);

        if (zero == '00') {
            result = number.slice(0, -2);
        } else {
            zero = number.substr(-1, 1);

            if (zero == '0') {
                result = number.slice(0, -1);
            } else {
                result = number;
            }
        }
    }

	//console.log(result);

	return result;
}

// function alphaOnly(evt) {
//   	var charCode = (evt.which) ? evt.which : evt.keyCode
//     if (charCode > 31 && (charCode < 48 || charCode > 57))
//         return true;
//     return false;
// }

function alphaOnly(event) {
  	if(!(/[a-z .]/i.test(String.fromCharCode(event.keyCode)))) {
    	event.preventDefault();
    	return false;
	}
}

function numberOnly(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}