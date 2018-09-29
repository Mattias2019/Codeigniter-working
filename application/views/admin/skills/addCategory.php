<?php $this->load->view('header1'); ?>

<div class="add-category">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Add Category</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('add_category'); ?>
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

                    <form role="form" name="addCategory" id="addCategory" class="form-horizontal" method="post" action="<?php echo admin_url('skills/addCategory'); ?>">

                        <div class="form-body">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="category_name">
                                    <?= t('category_name');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="category_name" value="<?php echo set_value('category_name'); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('category_name'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="group_id">
                                    <?= t('group'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <select class="form-control" id="group_id" name="group_id">
                                        <option value=""></option>

                                        <?php
                                        if(isset($groups) and $groups->num_rows()>0)
                                        {
                                            foreach($groups->result() as $group)
                                            {
                                                ?>
                                                <option value="<?php echo $group->id; ?>"><?php echo $group->group_name; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('group_id'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-checkboxes">
                                <label class="col-md-2 control-label" for="is_active">
                                    <?= t('is_active'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" name="is_active" value="1" <?php echo 'checked'; ?> id="site_status" class="md-check">
                                            <label for="site_status">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="category_logo">
                                    <?= t('category_logo'); ?>
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
                                    <?php echo form_error('category_logo'); ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <a id="delete_logo" class="button big primary <?php if (set_value('attachment_name') == '') echo 'disabled'; ?>">Delete Photo</a>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="description">
                                    <?= t('description'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="description" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('description'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="page_title">
                                    <?= t('page_title'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="page_title" rows="3"><?php echo set_value('page_title'); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('page_title'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="meta_keywords">
                                    <?= t('meta_keywords'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="meta_keywords" rows="3"><?php echo set_value('meta_keywords'); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('meta_keywords'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="meta_description">
                                    <?= t('meta_description'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="meta_description" rows="3"><?php echo set_value('meta_description'); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('meta_description'); ?>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <input type="hidden" name="operation" value="add" />
                                    <div class="col-md-offset-2 col-md-4" align="left">
                                        <a href="#" onclick="history.go(-1);return false;">
                                            <button type="button" class="btn default"><?= t('Cancel');?></button>
                                        </a>
                                        <input type="submit" name="addCategory" class="btn green" value="<?= t('Submit'); ?>"/>
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

