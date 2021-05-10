var isEdit=false;
$('document').ready(function(){
    var modalLabel=$('#myModalLabel');
    var form=$('#form');
    var table=$('#table_user_role');
    var no=0;

    table.DataTable({
        "aaSorting": [],
		"initComplete": function (settings, json) {

        },
        "retrieve": true,
        "processing": true,
        'ajax': {
			"type": "GET",
			"url": site_url + '/user_role/get',
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
					return full.role_name;
				}
            },
            {
				render: function (data, type, full, meta) {
                    var role_desc=(full.role_desc!=null && full.role_desc!='')?full.role_desc:'-';
					return role_desc;
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
                                <a class="dropdown-item" href="#" onclick="edit_data('+full.id_usr_role+')" ><i class="icofont icofont-ui-edit"></i>Edit</a>\
                                <a class="dropdown-item" href="#" onclick="delete_data('+full.id_usr_role+')" ><i class="icofont icofont-ui-delete"></i>Delete</a>\
                            <div role="separator" class="dropdown-divider"></div>\
                        </div>\
                    </div>';
                }
            }
        ]
    });
    
    form.submit(function(e){
        var url_form=(isEdit==false)?site_url+'/user_role/add':site_url+'/user_role/edit'
        e.preventDefault();
        $.ajax({
            url:url_form,
            type:'post',
            data:form.serialize(),
            dataType:'json',
            success:function(data,text){
                var caption=(isEdit==false)?'input':'edit';
                if(data.success)
                {
                    swal(
                    'Saved!',
                    'Successful '+caption+' data!',
                    'success'
                    );
                    $('#table_user_role').DataTable().ajax.reload();
                    $('#cancel').click();
                }
                else{
                    swal(
                    'Saved!',
                    'Failed '+caption+' data!',
                    'error'
                    );
                    $('#table_user_role').DataTable().ajax.reload();
                    $('#cancel').click();
                }
                isEdit=false;

                console.log('a');
            },
            error:function(stat,res,err)
            {
                console.log('b');
                console.log(stat);
                console.log(res);
                console.log(err);
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
            modalLabel.html('Add New User Role');
        }
        else
        {
            modalLabel.html('Edit User Role');
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
        url:site_url+"/user_role/get"
        ,type:'GET'
        ,dataType:'json'
        ,data:{id_usr_role:idData}
        ,success:function(data,text)
        {
            if(data.length>=1)
            {
                isEdit=true;
                $('#id').val(data[0].id_usr_role);
                $('#role_name').val(data[0].role_name);
                $('#role_desc').val(data[0].role_desc);
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
                url:site_url+"/user_role/delete",
                type:'POST',
                data:{id_usr_role:idData},
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
                        $('#table_user_role').DataTable().ajax.reload();
                    }
                },
                error:function(stat,res,err)
                {
                    alert(err);
                }
            });
        });
}