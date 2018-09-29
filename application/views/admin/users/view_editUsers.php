<?php $this->load->view('header1'); ?>

<script type="text/javascript">
    $(function () { edit_user.init(); });
</script>

<div class="edit-user">
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
                <span>Edit User</span>
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

<!--                Show Flash Message-->
                    <?php
                    if($msg = $this->session->flashdata('flash_message'))
                    {
                        echo $msg;
                    }
                    $userDetails = $userDetails->row();
                    if(is_object($userDetails)){

                    ?>

                    <form role="form" name="editUser" id="editUser" class="form-horizontal" method="post" action="<?php echo admin_url('users/editUser/'.$userDetails->id); ?>">

                        <div class="form-body">

                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $userDetails->id; ?>">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="username">
                                    <?= t('Username');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="username" value="<?php echo set_value('username', $userDetails->user_name); ?>">
                                    <div class="form-control-focus"> </div>
                                    <!--                                    <span class="help-block">Enter user name</span>-->
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="password">
                                    <?= t('edit_password');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock fa-fw"></i>
                                        </span>
                                        <div class="input-group-control">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                            <div class="form-control-focus"> </div>
                                            <input name="passwordold" type="hidden" class="textbox" value="<?php echo $userDetails->password;?>" >
                                        </div>
                                    </div>
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
                                                <option value="<?php echo $userRole->id ?>" <?php if(set_value('role_id', $userDetails->role_id) == $userRole->id) echo "selected"; ?>> <?php echo $userRole->role_name ?> </option>
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
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter your email" value="<?php echo set_value('email', $userDetails->email); ?>">
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
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('name', $userDetails->name); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('company_name'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="balance">
                                    <?= t('Balance Amount');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="balance" name="balance" value="<?php echo set_value('balance', $userDetails->amount); ?>">
                                    <div class="form-control-focus"></div>
                                    <?php echo form_error('balance'); ?>
                                </div>
                            </div>

                            <div class="advanced-options">

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="country_id"><?= t('Country');?></label>
                                    <div class="col-md-4">
                                        <select class="form-control" id="country_id" name="country_id">
                                            <option value=""></option>
                                            <?php foreach($countries as $country) { ?>
                                                <option value="<?php echo $country->id ?>" <?php if(set_value('country_id', $userDetails->country_id) == $country->id) echo "selected"; ?>> <?php echo $country->country_name ?> </option>
                                            <?php } ?>
                                        </select>
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('country_id'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="state"><?= t('State');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="state" name="state" value="<?php echo set_value('state', $userDetails->state); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('state'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="city"><?= t('City');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="city" name="city" value="<?php echo set_value('city', $userDetails->city); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('city'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="rate"><?= t('Rate');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="rate" name="rate" value="<?php echo set_value('rate', $userDetails->rate); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('rate'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="user_rating"><?= t('User Rating');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="user_rating" name="user_rating" value="<?php echo set_value('user_rating', $userDetails->user_rating); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('user_rating'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="num_reviews"><?= t('Number of Reviews');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="num_reviews" name="num_reviews" value="<?php echo set_value('num_reviews', $userDetails->num_reviews); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('num_reviews'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="rating_hold"><?= t('Rating Hold');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="rating_hold" name="rating_hold" value="<?php echo set_value('rating_hold', $userDetails->rating_hold); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('rating_hold'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="tot_rating"><?= t('Total Rating');?></label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="tot_rating" name="tot_rating" value="<?php echo set_value('tot_rating', $userDetails->tot_rating); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('tot_rating'); ?>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input">
                                    <label class="col-md-2 control-label" for="refid">
                                        <?= t('Ref ID');?>
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" id="refid" name="refid" value="<?php echo set_value('refid', $userDetails->tot_rating); ?>">
                                        <div class="form-control-focus"> </div>
                                        <?php echo form_error('refid'); ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-4" align="left">
                                    <a href="<?php echo admin_url('users/viewUsers');?>">
                                        <button type="button" class="btn default"><?= t('Cancel');?></button>
                                    </a>
                                    <button type="button" id="advanced-options-btn" class="btn btn-success">Advanced options</button>
                                    <input type="submit" name="submit" class="btn blue" value="<?= t('Submit');?>" />

                                </div>
                            </div>
                        </div>

                    </form>

                    <?php } ?>

<!--          <form method="post" action="">-->
<!--           <table class="table1" cellpadding="0" cellspacing="2" border="0">-->
<!--              <tr>-->
<!--                <td width="25%"><span id="valuen">--><?php //echo t('Password');?><!--</span></td>-->
<!--                <td width="55%">-->
<!--                    <div id="show1" --><?php //if(form_error('password')){?><!-- style="display:block"--><?php //}?><!-- style="display:none">-->
<!--                            : <input name="password" type="password" class="textbox" id="password" value="--><?php //echo $this->input->post('password');?><!--"  >&nbsp;-->
<!--                            <input name="passwordold" type="hidden" class="textbox" value="--><?php //echo $userDetails->password;?><!--" >-->
<!--                            --><?php ////echo form_error('password'); ?>
<!--                            <a href="#" onclick="return cancel();" >cancel</a>-->
<!--                            </div>-->
<!--                            <div id="change" >-->
<!--                            : <a href="#" onclick="return passwordchange();" >change password</a>-->
<!--                        </div>-->
<!---->
<!--                    --><?php //echo form_error('password'); ?>
<!---->
<!--                    </td>-->
<!--                    --><?php //echo form_error('value'); ?>
<!---->
<!--              <tr id="bansubmit" >-->
<!--                <td></td>-->
<!--                <td height="30" style="padding-left:6px;"><input name="editUser" type="submit" class="clsSubmitBt1" value="--><?php //echo t('Submit');?><!--">-->
<!--                <input type="hidden" name="userid" value="--><?php //echo $userDetails->id;?><!--" />-->
<!---->
<!---->
<!--                </td>-->
<!--            <script type="text/javascript">-->
<!--                function passwordchange()-->
<!--                {-->
<!--                document.getElementById('show1').style.display='block';-->
<!--                document.getElementById('change').style.display='none';-->
<!---->
<!--                }-->
<!--                function cancel()-->
<!--                {-->
<!--                document.getElementById('change').style.display='block';-->
<!--                document.getElementById('show1').style.display='none';-->
<!---->
<!--                }-->
<!--            </script>-->
<!--              </tr>-->
<!--            </table>-->
<!--          </form>-->
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer1'); ?>
