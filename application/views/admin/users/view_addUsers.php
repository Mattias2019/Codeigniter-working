<?php $this->load->view('header1'); ?>

    <script type="text/javascript">
        $(function () { add_user.init(); });
    </script>

    <div class="add-user">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>User Manager</span>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?= t('add_user'); ?></span>
                </li>
            </ul>
        </div>

        <h1 class="page-title"> User Manager
            <small>Manage all existing users</small>
        </h1>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-body">

                    <?php
                        //Show Flash Message
                        if($msg = $this->session->flashdata('flash_message')) {
                            echo $msg;
                        }
                    ?>

                        <form role="form" name="addUser" id="addUser" class="form-horizontal" method="post" action="<?php echo site_url('admin/users/addUser'); ?>">

                            <div class="form-body">

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="first_name">
                                        <?= t('first_name');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name'); ?>">
                                        <div class="form-control-focus"> </div>
                                        <!--                                    <span class="help-block">Enter user name</span>-->
                                        <?php echo form_error('first_name'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="last_name">
                                        <?= t('last_name');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name'); ?>">
                                        <div class="form-control-focus"> </div>
                                        <!--                                    <span class="help-block">Enter user name</span>-->
                                        <?php echo form_error('last_name'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="username">
                                        <?= t('Username');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>">
                                        <div class="form-control-focus"> </div>
                                        <!--                                    <span class="help-block">Enter user name</span>-->
                                        <?php echo form_error('username'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="password">
                                        <?= t('Password');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-lock fa-fw"></i>
                                            </span>
                                            <div class="input-group-control">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                                <input name="passwordold" type="hidden" class="textbox" value="<?php echo set_value('password'); ?>">
                                            </div>
                                        </div>
                                        <?php echo form_error('password'); ?>
                                        <?php echo form_error('value'); ?>
                                    </div>
                                    <input type="checkbox" name="password-switch" id="password-switch" checked data-on-text="<i class='fa fa-lock'></i>" data-off-text="<i class='fa fa-unlock'></i>" data-on-color="danger" data-off-color="success">
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="role">
                                        <?= t('Role');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="role_id" name="role_id">
                                            <option value=""></option>

                                            <?php
                                            if(isset($userRoles) and $userRoles->num_rows()>0) {
                                                foreach($userRoles->result() as $userRole) {
                                                    ?>
                                                    <option value="<?php echo $userRole->id ?>" <?php if(set_value('role_id') == $userRole->id) echo "selected"; ?>> <?php echo $userRole->role_name ?> </option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('role_id'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="email">
                                        <?= t('Email');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>

                                    <div class="col-md-4">

                                        <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo set_value('email'); ?>">
                                            <div class="form-control-focus"> </div>
                                        </div>
                                        <?php echo form_error('email'); ?>

                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="company_name">
                                        <?= t('Name/Company');?>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('company_name'); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('company_name'); ?>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-4" align="left">
                                            <a href="#" onclick="history.go(-1);return false;">
                                                <button type="button" class="btn default"><?= t('Cancel');?></button>
                                            </a>
                                            <input type="submit" name="submit" class="btn blue" value="<?= t('Submit');?>" />

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

	                </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('footer1'); ?>