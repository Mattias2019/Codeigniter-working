<?php $this->load->view('header1'); ?>

<div class="edit-item">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Standard Items</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('edit_item'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> Standard Items
        <small><?= t('edit_item'); ?></small>
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
                        if(isset($items) and $items->num_rows()>0) {
                            $item = $items->row();

                    ?>

                    <form role="form" name="editItem" id="editItem" class="form-horizontal" method="post" action="<?php echo admin_url('items/editItem/'.$item->id)?>">

                        <div class="form-body">

                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $item->id; ?>">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="name">
                                    <?= t('item_name');?>
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $item->name); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('name'); ?>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="unit">
                                    <?= t('unit'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="unit" value="<?php echo set_value('unit', $item->unit); ?>">
                                    <div class="form-control-focus"> </div>
                                    <?php echo form_error('unit'); ?>
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
                                    <input type="submit" name="saveItem" class="btn green" value="<?= t('Submit'); ?>"/>
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
