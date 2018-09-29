<?php
$this->load->view('header1');
?>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><a href="<?php echo site_url("administration/home"); ?>">Home</a> <i class="fa fa-circle"></i></li>
                <li><a href="<?php echo site_url("administration/users/user_management"); ?>">User Manager</a> <i class="fa fa-circle"></i></li>
                <li><span>Edit User</span></li>
            </ul>
            <div class="page-toolbar"></div>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">
            User Editor <small>Edit a specific user</small>
        </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <?php
            // Show Flash Message
            if ($msg = $this->session->flashdata('flash_message'))
            {
                echo $msg;
            }
            ?>


            <form method="post" action="">
                <table class="table1"  cellpadding="0" cellspacing="2" border="0">
                    <tr>
                        <td width="25%"><strong><?php echo $this->lang->line('Ban Type');?> </strong></td>
                        <td width="55%">:
                            <select name="type" class="usertype">
                                <option value="">Select Type</option>
                                <option value="EMAIL" <?php if($banDetails->ban_type == 'EMAIL') echo "selected";?>>Email Address</option>
                                <option value="USERNAME" <?php if($banDetails->ban_type == 'USERNAME') echo "selected";?>>Username</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td width="25%"><strong><span id="valuen"><?php echo $this->lang->line('Ban Value');?></span></strong></td>
                        <td width="55%">:
                            <input name="value" type="text" class="textbox" id="value" value="<?php echo $banDetails->ban_value;?>"></td>
                        <?php echo form_error('value'); ?>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr id="bansubmit" >
                        <td></td>
                        <td height="30" style="padding-left:6px;"><input name="addBan" type="submit" class="clsSubmitBt1" value="<?php echo $this->lang->line('Submit');?>">
                            <input type="hidden" name="banid" value="<?php echo $banDetails->id;?>" />
                        </td>
                    </tr>
                </table>
            </form>



            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
<?php
$this->load->view('footer1');
?>