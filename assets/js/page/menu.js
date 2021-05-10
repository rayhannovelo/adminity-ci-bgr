var isEdit=false;
var menu_data=[{}];
var list='';
var initiateMenu=true;
$(document).ready(function () {
	menu_get();
	var table=$('#table_user_role');
	var modalLabel=$('#menu-modal-label');
	var form=$('#form');
	var map=[];
	var child=[];
	var parent=[];
	var index=0;

	var nesOneArray=function(menus,parent)
	{
		for(var i=0;i<menus.length;i++)
		{
			map[index]={id:menus[i].id,parent:parent};
			index++;
			if(menus[i].children!=undefined)
			{
				nesOneArray(menus[i].children,menus[i].id);
			}
		}
	}

	var updateOutput = function (e) {
		var list = e.length ? e : $(e.target),
			output = list.data('output');
		if (window.JSON) {
			var data_output=window.JSON.stringify(list.nestable('serialize'));
			output.val(data_output);
			index=0;
			map=[];
			nesOneArray(list.nestable('serialize'),0);
			//console.log(map);
			if(!initiateMenu)
			{
				$.blockUI({ css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} }); 

				$.ajax({
					url:site_url+'/menu/save_map_menu'
					,type:'POST'
					,dataType:'json'
					,data:{
						menu_data:map
					}
					,success:function(data,text)
					{
						$.unblockUI();
					}
					,error:function(stat,res,err)
					{
			
					}
				});
			}
			else{
				initiateMenu=false;
			}
        } else {
            output.val('JSON browser support required for this demo.');
		}
		
		initiateMenu=false;	
	};


	// activate Nestable for list 2
	$('#nestable2').nestable({
			group: 1
	})
	.on('change', updateOutput);

	// output initial serialised data
	updateOutput($('#nestable2').data('output', $('#nestable2-output')));

	$('#nestable-menu').on('click', function (e) {
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');

		}
	});

	
	function menu_get(){
		$.ajax({
			url:site_url+'/menu/get',
			type:'GET',
			dataType:'json',
			success:function(data,text)
			{
				list='';
				recursive_menu(data, 0);
				$('#nestable2').html(list);
				updateOutput($('#nestable2').data('output', $('#nestable2-output')));

			},
			error:function(stat,res,err)
			{
				alert(err);
			}
		});
	}
	

	// Datatable
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
                                <a class="dropdown-item" href="#" onclick="menu_privilege('+full.id_usr_role+')" ><i class="icofont icofont-ui-edit"></i>Menu Privilege</a>\
                            <div role="separator" class="dropdown-divider"></div>\
                        </div>\
                    </div>';
                }
            }
        ]
	});


	$('#is_head_section').click(function(){
		var check=$(this).is(':checked')?1:0;
		$('#m_head_sec').val(check);
	});
	$('#have_crud').click(function(){
		var check=$(this).is(':checked')?1:0;
		$('#m_have_crud').val(check);
	});
	form.submit(function(e){
        var url_form=(isEdit==false)?site_url+'/menu/add':site_url+'/menu/edit';
		e.preventDefault();

        $.ajax({
            url:url_form,
            type:'post',
            data:$("#form").serialize(),
            dataType:'json',
            success:function(data,text){
                var caption=(isEdit==false)?'input':'edit';
                if(data.success)
                {
					$('#cancel-menu').click();
					
                    swal({
						title:'Saved!',
						text:'Successful '+caption+' data!',
						type:'success',
						closeOnConfirm: true},
						function(){
							menu_get();
							// swal({
							// 	title: "Information",
							// 	text: "Menu change will take effect after reload the page, reload now?",
							// 	type: "warning",
							// 	showCancelButton: true,
							// 	confirmButtonClass: "btn-primary",
							// 	confirmButtonText: "Yes, reload now!",
							// 	closeOnConfirm: false
							// 	},
							// 	function(){
							// 		location.reload();
							// 	}
							// );
							
							notify('Information :',' Menu Change can be effected by reloading the page.',3000,'top','right','fa fa-comments','info');
						}
						
					);
                }
                else{
                    $('#cancel-menu').click();
                    swal({
                    title:'Failed!',
                    text:'Failed '+caption+' data!',
                    type:'error'
					});
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
    $('#modal-btn-menu').click(function(){
        if(!isEdit)
        {
            form[0].reset();
            modalLabel.html('Add New Menu');
        }
        else
        {
            modalLabel.html('Edit Menu');
        }
    });

    $('#close_dialog-menu').click(function(){
        isEdit=false;
    });

    $('#cancel-menu').click(function(){
        isEdit=false;
    });

    $('#submit-menu').click(function(){
        $('#sendSubmit').click();
    });
    //Modal Section
	
	//Role Privilege Submit
	$('#submit-privilege').click(function(){
		submit_menu_role_privilege();
	});

	
	menu_edit=function(dataID)
	{
		$.ajax({
			url:site_url+'/menu/get'
			,type:'get'
			,dataType:'json'
			,data:{id_menu:dataID}
			,success:function(data,text){
				isEdit=true;
				var menu=data[0];
				$('#id').val(menu.id_menu);
				$('#label').val(menu.label);
				$('#link').val(menu.link);
				$('#icon').val(menu.icon);

				if(menu.is_head_section==1)
				{
					$('#is_head_section').prop('checked', true);;
					$('#m_head_sec').val('1');
				}
				else
				{
					$('#is_head_section').prop('checked', false);
					$('#m_head_sec').val('0');
				}

				if(menu.have_crud==1)
				{
					$('#have_crud').prop('checked', true);;
					$('#m_have_crud').val('1');
				}
				else
				{
					$('#have_crud').prop('checked', false);
					$('#m_have_crud').val('0');
				}

				$('#modal-btn-menu').click();
			}
			,error:function(stat,res,err){
				alert(err);
			}
		});
	}

	menu_delete=function(dataID)
	{
		swal({
			title: "Are you sure?",
			text: "This data and its children will be deleted!,",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			closeOnConfirm: false
			},
			function(){
				$.ajax({
					url:site_url+'/menu/delete',
					type:'post',
					data:{id:dataID},
					dataType:'json',
					success:function(data,text){
						var caption='delete';
						if(data.success)
						{
							$('#cancel-menu').click();
							swal({
							title:'Deleted!',
							text:'Successful '+caption+' data!',
							type:'success'
							},
							function(){
								menu_get();
								notify('Information :',' Menu Change can be effected by reloading the page.',3000,'top','right','fa fa-comments','info');
							});
							menu_get();
			
						}
						else{
							$('#cancel-menu').click();
							swal(
							'Failed!',
							'Failed '+caption+' data!',
							'error'
							);
						}
						isEdit=false;
					},
					error:function(stat,res,err)
					{
						alert(err);
						isEdit=false;
					}
				});
			}
		);

	}


});


$.jstree.plugins.addHTML = function (options, parent) {
    this.redraw_node = function(obj, deep,
                                callback, force_draw) {
        obj = parent.redraw_node.call(
            this, obj, deep, callback, force_draw
        );
        if (obj) {
            var node = this.get_node(jQuery(obj).attr('id'));
            if (node && 
                node.data &&
                ( "addHTML" in node.data ) ) {
                jQuery(obj).append(
                    "<div style='margin-left: 50px'>" +
                        node.data.addHTML +
                    "</div>"
                );
            }
        }
        return obj;
    };
};
$.jstree.defaults.addHTML = {};

$('#checkTree').jstree({
	'core': {
		'themes' : {
			'responsive': false
		},
		data:[]
	},
	'types' : {
		'default' : {
			'icon' : 'icofont icofont-folder'
		},
		'file' : {
			'icon' : 'icofont icofont-file-alt'
		}
	},
	'checkbox': {
	  three_state : false, 
      whole_node : false,//Used to check/uncheck node only if clicked on checkbox icon, and not on the whole node including label
      tie_selection : false        
	},
	'plugins' : ['types', 'checkbox','addHTML']
});

function menu_privilege(roleID)
{
	$('#id_role').html(roleID);
	$('#checkTree').jstree(true).settings.core.data = [];
	$('#checkTree').jstree(true).refresh(true);
	$.ajax({
		url:site_url+'/menu/get_role_privilege',
		type:'GET',
		dataType:'json',
		data:{id_role:roleID},
		success:function(data,text){
			$('#checkTree').jstree(true).settings.core.data = data;
			$('#checkTree').jstree(true).refresh(true);
			$("#checkTree").jstree(true).load_node('#');
			$('#modal-btn').click();
		},
		error:function(stat,res,err)
		{
			alert(err);
		}
	});
}

function submit_menu_role_privilege()
{
	menu_data=[{}];
	var id_role=$('#id_role').html();
	var selectedElms = $('#checkTree').jstree("get_checked", true);
	var i = 0;
	$.each(selectedElms, function () {
		menu_data[i] = {
			id_menu: this.id,
			id_role: id_role,
			act_create: $('#'+this.id+'-create').is(':checked')?1:0,
			act_update: $('#'+this.id+'-update').is(':checked')?1:0,
			act_delete: $('#'+this.id+'-delete').is(':checked')?1:0,
			act_detail: $('#'+this.id+'-detail').is(':checked')?1:0
		};
		i++;
	});

	$.ajax({
		url:site_url+'/menu/save_map_menu_role',
		type:'POST',
		dataType:'json',
		data:{
			id_role:id_role,
			menu_data:menu_data
		},
		success:function(data,text){
			if(data.success)
			{
				$('#cancel-privilege').click();
				swal({
                    title:'Saved!',
                    text:'Successful saving data!',
					type:'success'
				},function(){
					menu_privilege(id_role);
				});
			}
			else{
				swal(
                    'Failed!',
                    'Failed saving data!',
                    'error'
                );
			}
		},
		error:function(stat,res,err){
			alert(err);
		}
	});
}

function recursive_menu(items, parent) {
	var child = 0;
	for(var i=0;i<items.length;i++)
	{
		var menu=items[i];

		if (menu.parent == parent) {
			child += 1;
			if (child == 1) {
				list+='<ol class="dd-list">';
			}
			list+=' <li class = "dd-item dd3-item" data-id = "'+menu.id_menu+'" >';

			if(menu.count_child>0)
			{
				list+='\
				<button data-action="collapse" type="button" style="display: block;">Collapse</button>\
				<button data-action="expand" type="button" style="display: none;">Expand</button>';
			}

			list+='<div class = "dd-handle dd3-handle"></div>\
				<div class = "dd3-content" > '+menu.label+'\
				<span style="position:absolute;right:5px;">\
					<a href="javascript:void(0)" title="edit" onclick="menu_edit('+menu.id_menu+')"><i class="icofont icofont-ui-edit"></i></a>\
					<a href="javascript:void(0)" title="delete" onclick="menu_delete('+menu.id_menu+')"><i class="icofont icofont-ui-delete"></i></a>\
				</span>\
				</div>';
			recursive_menu(items, menu.id_menu);
			list+='</li>';
		}
	}
	if (child > 0) {
		list+='</ol>';
	}
}
