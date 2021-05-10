<!-- Page Body -->
<div class="card">
    <div class="card-header">
        <h5>Users List Table
            <button data-toggle="modal" data-target="#modal-container" id="modal-btn" style="margin-left:5px;" title="Add/Edit Data" class="card-block icon-btn btn btn-inverse btn-outline-inverse btn-icon">
                <i class="icofont icofont-ui-add"></i>
            </button>
        </h5>
        <span>All users data whos registered on this system</span>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><i class="feather icon-maximize full-card"></i></li>
                <li><i class="feather icon-minus minimize-card"></i></li>
            </ul>
        </div>
    </div>

    <div class="card-block">
        <div class="table-responsive">
            <div class="dt-responsive table-responsive">
                <table id="table_user" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Group Role</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-container" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div>
                        <input type="text" name="id_user" id="id" hidden>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_usr_role">Pegawai<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select id="user_from_siska" onchange="ocUserSiska(this);" class="js-example-basic-single col-sm-12 select_2" name="nik" required="required">
                                <option value="">Pilih Pegawai yang akan ditambahkan</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="id_usr_role">Role Group<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select class="js-example-basic-single col-sm-12 select_2 id_usr_role" name="id_usr_role" placeholder="id_usr_role" type="text" required="required">
                                <option value="">Choose User Role Group</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="user_pass" value="">
                    <input type="hidden" name="full_name" value="">
                    <input type="hidden" name="user_area" value="">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" style="color:#ff3333;" >Required (*)</span>
                        </label>
                    </div>
                    <button hidden type="submit" id="sendSubmit"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <button type="button" id="submit" class="btn btn-primary waves-effect waves-light ">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit" action="javascript:void(0)">
                    <input type="hidden" name="id_user" id="edit_id">
                    <input type="hidden" name="user_area_old" id="edit_user_area_old">
                    <input type="hidden" name="id_usr_role_old" id="edit_id_usr_role_old">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit_nik">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" id="edit_nik" class="form-control" name="nik" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit_full_name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="edit_full_name" class="form-control" name="full_name" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit_id_usr_role">Role Group<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select id="edit_id_usr_role" class="js-example-basic-single col-sm-12 select_2_edit id_usr_role" name="id_usr_role" required="required">
                                <option value="">Choose User Role Group</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit_branch">Branch<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select id="edit_user_area" class="js-example-basic-single col-sm-12 select_2_edit branch" name="user_area" required="required">
                                <option value="">Choose Branch</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="edit_id_usr_status">Status<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <select id="edit_id_usr_status" class="js-example-basic-single col-sm-12 select_2_edit id_usr_status" name="id_usr_status" required="required">
                                <option value="">Choose User Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" style="color:#ff3333;" >Required (*)
                        </label>
                    </div>
                    <button hidden type="submit" id="sendSubmitEdit"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <button type="button" id="submitEdit" class="btn btn-primary waves-effect waves-light ">Submit</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/js/page/user.js'); ?>?v=<?php echo date('YmdHis'); ?>"/></script>
<script src="<?php echo base_url('assets/js/page/master.js'); ?>?v=<?php echo date('YmdHis'); ?>"/></script>

<script type="text/javascript">
    $('document').ready(function() {
        get_branch();
    });
</script>