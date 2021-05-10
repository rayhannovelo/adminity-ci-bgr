var isEdit=false;
$('document').ready(function(){
    var modalLabel=$('#myModalLabel');
    var form=$('#form');
    var table=$('#table_user_status');
    var no=0;

    table.DataTable({
        "aaSorting": [],
		"initComplete": function (settings, json) {

        },
        "retrieve": true,
        "processing": true,
        'ajax': {
			"type": "GET",
			"url": site_url + '/user_status/get',
			"data": function (d) {
                no=0;
			},
			"dataSrc": ""
        },
        'columns': [
			{
				render: function (data, type, full, meta) {
                    no+=1;
					return no;
				}
            },
            {
				render: function (data, type, full, meta) {
					return full.status_name;
				}
            },
            {
				render: function (data, type, full, meta) {
                    var status_desc=(full.status_desc!=null && full.status_desc!='')?full.status_desc:'-';
					return status_desc;
				}
            },
            {
				render: function (data, type, full, meta) {
					return full.created_at;
				}
            },
            {
                render: function (data, type, full, meta) {
                    return '\
                    <div class="text-center">\
                            <a href="#" class="dropdown-toggle addon-btn" data-toggle="dropdown" aria-expanded="true">\
                                <i class="icofont icofont-ui-settings"></i>\
                            </a>\
                            <div class="dropdown-menu dropdown-menu-right">\
                                <a class="dropdown-item" href="#" onclick="edit_data('+full.id_usr_status+')" ><i class="icofont icofont-ui-edit"></i>Edit</a>\
                                <a class="dropdown-item" href="#" onclick="delete_data('+full.id_usr_status+')" ><i class="icofont icofont-ui-delete"></i>Delete</a>\
                            <div role="separator" class="dropdown-divider"></div>\
                        </div>\
                    </div>';
                }
            }
        ]
    });
    
    form.submit(function(e){
        var url_form=(isEdit==false)?site_url+'/user_status/add':site_url+'/user_status/edit'
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
                    $('#modal-container').modal('hide');
                    swal(
                    'Saved!',
                    'Successful '+caption+' data!',
                    'success'
                    );
                    $('#table_info_training').DataTable().ajax.reload();

                }
                else{
                    $('#modal-container').modal('hide');
                    swal(
                    'Saved!',
                    'Failed '+caption+' data!',
                    'error'
                    );
                    $('#table_info_training').DataTable().ajax.reload();
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
    $('#modal-btn').click(function(){
        if(!isEdit)
        {
            form[0].reset();
            modalLabel.html('Add New User Status');
        }
        else
        {
            modalLabel.html('Edit User Status');
        }
    });

    $('#close_dialog').click(function(){
        isEdit=false;
    });

    $('#cancel').click(function(){
        isEdit=false;
    });

    $('#submit').click(function(){
        $('#sendSubmit').click();
    });
    //Modal Section

    
});

function edit_data(idData)
{
    $.ajax({
        url:site_url+"/user_status/get"
        ,type:'GET'
        ,dataType:'json'
        ,data:{id_usr_status:idData}
        ,success:function(data,text)
        {
            if(data.length>=1)
            {
                isEdit=true;
                $('#id').val(data[0].id_usr_status);
                $('#status_name').val(data[0].status_name);
                $('#status_desc').val(data[0].status_desc);
                $('#modal-btn').click();
            }
        }
        ,error:function(stat,res,err)
        {
            alert(err);
        }
    })
}

function delete_data(idData)
{
    swal({
		    title: "Are you sure?",
			text: "This data will be deleted!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
			},
		function(){
            $.ajax({
                url:site_url+"/user_status/delete",
                type:'POST',
                data:{id_usr_status:idData},
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
                        $('#table_user_status').DataTable().ajax.reload();
                    }
                },
                error:function(stat,res,err)
                {
                    alert(err);
                }
            });
        });
}