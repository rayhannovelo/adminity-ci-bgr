<!-- Treeview css -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/dashboard');?>/bower_components/jstree/css/style.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>

<style>

	.border-checkbox-section .border-checkbox-group .border-checkbox-label {
    position: relative;
    display: inline-block;
    cursor: pointer;
    height: 20px;
    line-height: 15px;
    padding-left: 17px;
    margin-right: 15px;
}

.border-checkbox-section .border-checkbox-group .border-checkbox-label:before {
    content: "";
    display: block;
    border: 1px solid grey;
    width: 15px;
    height: 15px;
    position: absolute;
    left: 0;
}
	.border-checkbox-section .border-checkbox-group .border-checkbox-label:after {
    content: "";
    display: block;
    width: 6px;
    height: 12px;
    opacity: 0;
    border-right: 2px solid #eee;
    border-top: 2px solid #eee;
    position: absolute;
    left: 2px;
    top: 7px;
    -webkit-transform: scaleX(-1) rotate(135deg);
    transform: scaleX(-1) rotate(135deg);
    -webkit-transform-origin: left top;
    transform-origin: left top;
}
.border-checkbox-section .border-checkbox-group-primary .border-checkbox:checked+.border-checkbox-label:after {
    border-color: grey;
}
.jstree-default .jstree-anchor {
    line-height: 24px;
    height: 24px;
	color: #353c4e;
	font-size:14.5px;
}
.icofont-folder:before {
    color: #353c4e;
    content: "\f007";
	font-size:14.5px;
}
.icofont-file-alt:before {
	color: #353c4e;
    content: "\eeac";
	font-size:14.5px;
}
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="card">

			<div class="card-header">
				<h5>Menu Management & Privilege</h5>
				<div class="card-header-right">
					<ul class="list-unstyled card-option">
						<li><i class="feather icon-maximize full-card"></i></li>
						<li><i class="feather icon-minus minimize-card"></i></li>
					</ul>
				</div>
			</div>

			<div class="card-block">

				<!-- Nav tabs -->
				<ul class="nav nav-tabs md-tabs " role="tablist">
					<li class="nav-item">
						<a id="nav_menu_privilege" class="nav-link active" data-toggle="tab" href="#menu_privilege" role="tab"><i class="icofont icofont-users"></i>
							Menu Role Privilege</a>
						<div class="slide"></div>
					</li>
					<li class="nav-item">
						<a id="nav_menu_positioning" class="nav-link" data-toggle="tab" href="#menu_positioning" role="tab"><i class="icofont icofont-listing-number"></i>
							Menu Positioning</a>
						<div class="slide"></div>
					</li>
				</ul>
				
				<!-- Tab panes -->
				<div class="tab-content card-block">
					<div class="tab-pane active" id="menu_privilege" role="tabpanel">
					
						<button hidden style="margin-bottom:10px;" data-toggle="modal" data-target="#modal-container" id="modal-btn" style="margin-left:5px;" title="Add/Edit Data"
						 class="card-block icon-btn btn btn-inverse btn-outline-inverse btn-icon">
							<i class="icofont icofont-ui-add"></i>
						</button>
						<text style="font-weight:bold;">User Roles List Table</text>
						<br />
						<text style="margin-top:10px;color:grey;font-size:13px;">All User Roles data on this system</text>
						

						<div style="margin-top:15px;" class="table-responsive">
							<div class="dt-responsive table-responsive">
								<table id="table_user_role" class="table table-striped table-bordered nowrap">
									<thead>
										<tr>
											<th>No</th>
											<th>Role Name</th>
											<th>Role Desc</th>
											<th>Created Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

						<div class="modal fade" id="modal-container" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Menu Role Privilege</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<text id="id_role" hidden></text>
										<!-- Checkbox Tree card start -->
										<div class="card-block tree-view">
											<div id="checkTree">
											</div>
										</div>
										<!-- Checkbox Tree card end -->
									</div>

									<div class="modal-footer">
										<button type="button" id="cancel-privilege" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
										<button type="button" id="submit-privilege" class="btn btn-primary waves-effect waves-light ">Submit</button>
									</div>

								</div>
							</div>
						</div>

					</div>

					<div class="tab-pane" id="menu_positioning" role="tabpanel">
						<div id="nestable-menu" class="m-b-10">
							<button data-toggle="modal" data-target="#modal-menu" id="modal-btn-menu" class="btn btn-inverse btn-round"><i
								 class="icofont icofont-ui-edit"></i> Add Menu</button>
							<button data-action="expand-all" class="btn btn-success btn-round btn-sm m-r-5 m-l-5"><i class="icofont icofont-plus"></i>
								Expand All</button>
							<button data-action="collapse-all" class="btn btn-warning btn-round btn-sm"><i class="icofont icofont-minus"></i>
								Collapse All</button>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="cf nestable-lists">
									<div class="dd" style="max-width:100% !important;" id="nestable2">

									</div>
								</div>
							</div>
						</div>

						<div class="modal fade" id="modal-menu" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="menu-modal-label"></h4>
										<button type="button" id="close_dialog-menu" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="form">
											<div>
												<input type="text" name="id" id="id" hidden>
											</div>

											<div class="form-group row">
												<label class="col-sm-2 col-form-label" for="label">Label<span class="required" style="color:#ff3333;">*</span>
												</label>
												<div class="col-sm-10">
													<input id="label" class="form-control" name="label" placeholder="Menu Label" type="text" required="required">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-2 col-form-label" for="link">Link
												</label>
												<div class="col-sm-10">
													<input id="link" class="form-control" name="link" placeholder="Menu Link (add http:// or https:// if link is external link)"
													 type="text">
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-2 col-form-label" for="icon">Menu Icon
												</label>
												<div class="col-sm-10">
													<input id="icon" class="form-control" name="icon" placeholder="Menu (feather icons)" type="text">
												</div>
											</div>

											<div class="form-group row">
												<input type="hidden" value="1333" name="is_head_section" id="m_head_sec">
												<input type="hidden" value="12222222" name="have_crud" id="m_have_crud">
												<label class="col-sm-2 col-form-label">Atributes
												</label>
												<div class="col-sm-10 border-checkbox-section">
													<div class="border-checkbox-group border-checkbox-group-primary">
														<input class="border-checkbox" type="checkbox" id="is_head_section">
														<label class="border-checkbox-label" for="is_head_section">Head Section</label>
													</div>
													<div class="border-checkbox-group border-checkbox-group-primary">
														<input class="border-checkbox" type="checkbox" id="have_crud">
														<label class="border-checkbox-label" for="have_crud">Have CRUD</label>
													</div>
												</div>
											</div>

											<div class="form-group row">
												<label class="col-sm-2 col-form-label" style="color:#ff3333;">Required (*)</span>
												</label>
											</div>

											<button hidden type="submit" id="sendSubmit"></button>
										</form>
									</div>

									<div class="modal-footer">
										<button type="button" id="cancel-menu" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
										<button type="button" id="submit-menu" class="btn btn-primary waves-effect waves-light ">Submit</button>
									</div>

								</div>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>

<!-- Tree view js -->
<script type="text/javascript" src="<?php echo base_url('assets/template/dashboard');?>/bower_components/jstree/js/jstree.min.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/jstree.min.js"></script> -->

<script src="<?php echo base_url('assets/js/page/menu.js');?>"> </script>

