<div class="card">
        <div class="card-header">
            <h5>User Roles List Table
                <button data-toggle="modal" data-target="#modal-container" id="modal-btn" style="margin-left:5px;" title="Add/Edit Data" class="card-block icon-btn btn btn-inverse btn-outline-inverse btn-icon">
                    <i class="icofont icofont-ui-add"></i>
                </button>
            </h5>
            <span>All User Roles data on this system</span>
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
                        <input type="text" name="id_usr_role" id="id" hidden>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="role_name">Role Name<span class="required" style="color:#ff3333;">*</span>
                        </label>
                        <div class="col-sm-10">
                            <input id="role_name" class="form-control" name="role_name" placeholder="Name" type="text" required="required">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="role_desc">Role Desc
                        </label>
                        <div class="col-sm-10">
                            <textarea id="role_desc" class="form-control" name="role_desc" placeholder="Role Desc" cols="5" rows="5"></textarea>
                        </div>
                    </div>
                    
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

<script src="<?php echo base_url('assets/js/page/user_role.js');?>"/>