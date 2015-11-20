<div class='row'>
    <div class='col-xs-12'>
        <table cellpadding="0" cellspacing="0" border="0" class="display table table-striped" id="users">
            <thead>
            <tr>
                <th width="9%">Actions</th>
                <th width="9%">Status</th>
                <th width="9%">First Name</th>
                <th width="9%">Last Name</th>
                <th width="9%">Username</th>
                <th width="9%">Phone</th>
                <th width="9%">Email</th>
                <th width="9%">Country</th>
                <th width="9%">State</th>
                <th width="9%">Type</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="6" class="dataTables_empty">Loading data from server</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">User Details</h4>
            </div>
            <div class="modal-body">
                <div role="tabpanel">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab"
                                                                  data-toggle="tab">General</a></li>
                        <li role="presentation"><a href="#advance" aria-controls="advance" role="tab" data-toggle="tab">Advance</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content" style="padding-top: 20px;">
                        <!-- General tab -->
                        <div role="tabpanel" class="tab-pane active" id="general">
                            <form class="form-horizontal" style="width: 90%;" role="form" id="userDetailForm"
                                  style="display: none;">
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Username
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Username"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <input type="text" class="form-control required" id="username" disabled="true"/>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">First Name
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="First Name"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <input type="text" class="form-control required" id="first-name"/>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Last Name
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Last Name"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <input type="text" class="form-control required" id="last-name"/>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Phone
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Phone"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <input type="text" class="form-control required" id="phone"/>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Email
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Email"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <input type="text" class="form-control required" id="email"/>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Country
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Country"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <select class="form-control" id="country">
                                            <option value=""> -- Select Country --</option>
                                            <option value="United States">United States</option>
                                            <option value="Canada">Canada</option>
                                        </select>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">State
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="State"></i>
                                    </label>

                                    <div class="input-group input-group-sm col-xs-9">
                                        <select class="form-control" id="state"></select>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Advance tab -->
                        <div role="tabpanel" class="tab-pane" id="advance">
                            <form class="form-horizontal" role="form" id="userDetailFormAdvance">
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Type</label>

                                    <div class="input-group input-group-sm col-xs-8">
                                        <select class="form-control" id="type">
                                            <option value="member">Member</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-xs-3 control-label">Status</label>

                                    <div class="input-group input-group-sm col-xs-8">
                                        <select class="form-control" id="status">
                                            <option value="active">Active</option>
                                            <option value="disabled">Disabled</option>
                                            <option value="pending">Pending</option>
                                        </select>

                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label for="password" class="col-xs-3 control-label">Change Password </label>
                                    <div class="input-group input-group-sm col-xs-8">
                                        <input type="password" class="form-control" id="newPassword"/>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-primary" id="changePasswordBtn"><i class="fa fa-save"></i>Change
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label for="password" class="col-xs-3 control-label">Delete User </label>

                                    <div class="input-group input-group-sm col-xs-8">
                                        <button type="button" class="btn btn-xs btn-danger" id="deleteUserBtn"><i class="fa fa-trash-o"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="saveBtn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#usersSideLink').addClass('custom-nav-active');
        $('#usersTopLink').addClass('custom-nav-active');
    });
</script>