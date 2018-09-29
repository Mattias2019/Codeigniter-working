<?php $this->load->view('header1'); ?>

<div class="edit-category">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Categories</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('edit_category'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> Categories
        <small><?= t('edit_category'); ?></small>
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

                <?php
                    //Content of a group
                    if(isset($categories) and $categories->num_rows()>0) {

                        $category = $categories->row();

                        $attachment_url = $this->file_model->get_category_logo_file_path($category->id, $category->attachment_name);
                ?>

                    <form role="form" name="editCategory" id="editCategory" class="form-horizontal" method="post" action="<?php echo admin_url('skills/editCategory/'.$category->id)?>">

                        <div class="form-body">

                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $category->id; ?>">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="category_name">
                                    <?= t('category_name');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="category_name" value="<?php echo set_value('category_name', $category->category_name); ?>">
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
                                                <option value="<?php echo $group->id; ?>" <?php if($category->group_id == $group->id) echo "selected"; ?> ><?php echo $group->group_name; ?></option>
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
                                            <input type="checkbox" name="is_active" value="<?php echo ($category->is_active?$category->is_active:0); ?>" <?php if(isset($category->is_active) and $category->is_active==1) { echo 'checked';  } else { echo ''; } ?> id="site_status" class="md-check">
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
                                    <input type="hidden" name="attachment_url" id="attachment_url" value="<?php echo set_value('attachment_url', $attachment_url); ?>"  />
                                    <input type="hidden" name="attachment_name" id="attachment_name" value="<?php echo set_value('attachment_name', $category->attachment_name); ?>"  />

                                    <div class="logo-container" id="logo-container">
                                        <div class="dropzone" <?php if (set_value('attachment_name', $category->attachment_name) != '') echo 'hidden="hidden"'; ?> ></div>
                                        <div class="logo-container-inner">
                                            <img class="logo-image" src="<?php echo set_value('attachment_url', $attachment_url); ?>" <?php if (set_value('attachment_name', $category->attachment_name) == '') echo 'hidden="hidden"'; ?>/>
                                        </div>
                                    </div>
                                    <?php echo form_error('category_logo'); ?>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <a id="delete_logo" class="button big primary <?php if (set_value('attachment_name', $category->attachment_name) == '') echo 'disabled'; ?>">Delete Photo</a>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="description">
                                    <?= t('description'); ?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <textarea class="form-control" name="description" rows="3"><?php echo set_value('description',$category->description); ?></textarea>
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
                                    <textarea class="form-control" name="page_title" rows="3"><?php echo set_value('page_title', $category->page_title); ?></textarea>
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
                                    <textarea class="form-control" name="meta_keywords" rows="3"><?php echo set_value('meta_keywords', $category->meta_keywords); ?></textarea>
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
                                    <textarea class="form-control" name="meta_description" rows="3"><?php echo set_value('meta_description', $category->meta_description); ?></textarea>
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('meta_description'); ?>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <div class="row">
                                <input type="hidden" name="operation" value="edit" />
                                <div class="col-md-offset-2 col-md-4" align="left">
                                    <a href="#" onclick="history.go(-1);return false;">
                                        <button type="button" class="btn default"><?= t('Cancel');?></button>
                                    </a>
                                    <input type="submit" name="editCategory" class="btn green" value="<?= t('Submit'); ?>"/>
                                </div>
                            </div>
                        </div>

                    </form>

                <?php
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
	  	  
<?php $this->load->view('footer1'); ?>
