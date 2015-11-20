<!-- Begin page content -->
<div class="container">
    <div class='row'>
        <div class="col-xs-2"></div>
        <div id="registrationForm" class='col-xs-8'>
            <div class="form-horizontal">
                <h3 class="text-center" style="font-weight: bold;">Registration</h3>
                <div class="alert alert-info" id="regMessage">
                    <i class="fa fa-info-circle"></i> Please fill up all fields.
                </div>
                <hr />
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Email Address 
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                        data-toggle="popover" data-placement="top" data-content="Enter your email address."></i>
                    </label>
                    <div class="col-xs-9">
                        <input type="email" class="form-control required" id="email" placeholder="Email Address">
                        <small id="emailMessage"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Confirm Email 
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                        data-toggle="popover" data-placement="top" data-content="Enter your email address again for confirmation."></i>
                    </label>
                    <div class="col-xs-9">
                        <input type="email" class="form-control required" id="confirmEmail" placeholder="Confirm Email Address">
                    </div>
                </div>
                            <div class="form-group">
                <label for="password" class="col-xs-3 control-label">Password 
                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                    data-toggle="popover" data-placement="top" data-content="Should be atleast 5 characters."></i>
                </label>
                <div class="col-xs-9">
                    <input type="password" class="form-control required" id="password" id="username" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-xs-3 control-label">Confirm Password 
                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                    data-toggle="popover" data-placement="top" data-content="Confirm your password."></i>
                </label>
                <div class="col-xs-9">
                    <input type="password" class="form-control required" id="confirmPassword" placeholder="Confirm Password">
                </div>
            </div>
                <div class="form-group">
                    <label for="firstName" class="col-xs-3 control-label">First Name 
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                        data-toggle="popover" data-placement="top" data-content="Enter you first name."></i>
                    </label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control required" id="firstname" placeholder="First Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName" class="col-xs-3 control-label">Last Name 
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                        data-toggle="popover" data-placement="top" data-content="Enter you last name."></i>
                    </label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control required" id="lastname" placeholder="Last Name">
                    </div>
                </div>
                <!-- 
                <div class="form-group">
                    <label for="username" class="col-xs-3 control-label">Username 
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                           data-toggle="popover" data-placement="top" data-content="4-20 Characters. Special characters not allowed."></i>
                    </label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control required" id="username" placeholder="Username">
                        <small id="usernameMessage"></small>
                    </div>
                </div>
                -->
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Primary Phone 
                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                    data-toggle="popover" data-placement="top" data-content="Enter your primary phone."></i>
                </label>
                <div class="col-xs-9">
                    <input type="text" class="form-control required" id="phone" placeholder="Primary Phone">
                </div>
            </div>
            <hr />
            <div class="form-group">
                <label for="country" class="col-xs-3 control-label">Country 
                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                    data-toggle="popover" data-placement="top" data-content="Select your posting country."></i>
                </label>
                <div class="col-xs-9">
                    <select class="form-control required" id="country">
                        <option value=""> -- Select Country -- </option>
                        <option value="United States">United States</option>
                        <option value="Canada">Canada</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-xs-3 control-label">State 
                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                    data-toggle="popover" data-placement="top" data-content="Select your posting state."></i>
                </label>
                <div class="col-xs-9">
                    <select class="form-control required" id="state" disabled="true"></select>
                </div>
            </div>
            <hr />
            <div class="form-group">
                <button type="button" id="registerBtn" class="btn btn-sm btn-success pull-right">Sign Up</button>
            </div>
        </div>
    </div>
    <div class='col-xs-2'>
    </div>
</div>
</div>
<div class="spacer"></div>

<script>
    $(document).ready(function() {
        $("#signupNav").addClass('active');
    });
</script>