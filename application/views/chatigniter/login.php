<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/views/chatigniter/css/login.css">
<h2 class="chat-header">
    <i class="fa fa-comment"></i> Chatigniter 
    <a href="javascript:;" class="chat-form-close pull-right">
        <i class="fa fa-remove"></i>
    </a>
</h2>
<div class="colored" >
 <div class="col-md-12"></div>
    <div class="col-md-12">
        <div class="" style="margin-top: 30px">
            <div class="col-md-12  contcustom" id="contentdiv" >
                <form method="POST" id="login-frm">
                    <span class="fa fa-comments bigicon"></span>
                    <br>
                    <h2>Login</h2>
                    <div class="message"></div>
                    <div class="form-group">
                        <input type="text" name="username" id="Username" class="form-control" placeholder="Username" required="required" autofocus="autofocus"/>
                    </div>
                    <div class="form-group">
                         <input type="password" name="password" class="form-control" placeholder="Password" required="required" />
                    </div>
                    <button class="btn btn-block btn-default btn-success" id="login" type="submit"><i class="fa fa-lock"></i> Login</button>
                </form> <br>
                <button class="btn btn-block btn-default btn-primary" id="create-account" type="submit"><i class="fa fa-plus-circle"></i> Register</button>
            </div>
        </div>
    </div>
</div>
