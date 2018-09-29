<?php $this->load->view('header1'); ?>

<div class="add-group">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add Group</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('add_group'); ?>
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">

                    <?php
                        //Show Flash Message
                        if($msg = $this->session->flashdata('flash_message'))
                        {
                            echo $msg;
                        }
                    ?>

                    <form role="form" name="addGroup" id="addGroup" class="form-horizontal" method="post" action="<?php echo admin_url('skills/addGroup'); ?>">

                        <div class="form-body">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="group_name">
                                    <?= t('group_name');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="group_name" value="<?php echo set_value('group_name'); ?>">
                                    <div class="form-control-focus"> </div>
                                    <!--                                    <span class="help-block">Enter user name</span>-->
                                    <?php echo form_error('group_name'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="group_logo">
                                    <?= t('group_logo'); ?>
                                </label>
                                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" name="attachment_url" id="attachment_url" value="<?php echo set_value('attachment_url'); ?>"  />
                                    <input type="hidden" name="attachment_name" id="attachment_name" value="<?php echo set_value('attachment_name'); ?>"  />

                                    <div class="logo-container" id="logo-container">
                                        <div class="dropzone" <?php if (set_value('attachment_name') != '') echo 'hidden="hidden"'; ?> ></div>
                                        <div class="logo-container-inner">
                                            <img class="logo-image" src="<?php echo set_value('attachment_url'); ?>" <?php if (set_value('attachment_name') == '') echo 'hidden="hidden"'; ?>/>
                                        </div>
                                    </div>
                                    <?php echo form_error('group_logo'); ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <a id="delete_logo" class="button big primary <?php if (set_value('attachment_name') == '') echo 'disabled'; ?>">Delete Photo</a>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="description">
                                    <?= t('description'); ?>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">

                                    <input type="hidden" name="operation" value="add" />

                                    <div class="col-md-offset-2 col-md-4" align="left">
                                        <a href="<?php echo admin_url('skills/viewGroups') ?>">
                                            <button type="button" class="btn default"><?= t('Cancel');?></button>
                                        </a>
                                        <input type="submit" name="addGroup" class="btn blue" value="<?= t('Submit');?>" />
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

<!-- End Of Main -->
<?php $this->load->view('footer1'); ?>
