<?php
if (array_key_exists('portfolio', $this->outputData)) {
    $portfolio = $this->outputData['portfolio'];
    $this->outputData['portfolio_standard_items'] = !empty($portfolio['standard_items']) ? $portfolio['standard_items'] : [];
    $this->outputData['portfolio_custom_items'] = !empty($portfolio['custom_items']) ? $portfolio['custom_items'] : [];
    $this->outputData['portfolio_attachments'] = !empty($portfolio['attachments']) ? $portfolio['attachments'] : [];

} else {
    $portfolio = NULL;
    $this->outputData['portfolio_standard_items'] = [];
    $this->outputData['portfolio_custom_items'] = [];
    $this->outputData['portfolio_attachments'] = [];
}
?>

<?php $this->load->view('header1'); ?>

            <?php flash_message(); ?>

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                <form method="post" id="manage-portfolio-form" action="<?php echo site_url('portfolio/manage'); ?>"
                      name="form" enctype="multipart/form-data"
                      class="req_post form-horizontal postprjform js-form-portfolio">

                    <input type="hidden" name="id" value="<?php echo set_value('id', $portfolio['id']); ?>"/>
                    <input type="hidden" name="user_id" value="<?php echo set_value('user_id', $portfolio['user_id']); ?>"/>

                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-dark bold uppercase"><?= t('Manage Portfolio'); ?></span>
                        </div>
                    </div>

                    <div class="dashboard container-fluid">

                        <div class="form-group">
                            <?php echo form_error('title'); ?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label for="title" class="form-control-label"><?= t('Title'); ?>:</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                <input name="title" id="title" class="form-control"
                                       value="<?php echo set_value('title', $portfolio['title']); ?>"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo form_error('price'); ?>
                            <?php echo form_error('payment_method'); ?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label for="price" class="form-control-label"><?= t('Price'); ?>:</label>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <input name="price" id="price" min="0" class="form-control inputmask"
                                       data-prefix="<?php echo currency(); ?>"
                                       value="<?php echo set_value('price', $portfolio['price']); ?>"/>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label class="form-control-label"><?= t('Payment Method'); ?>:</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <input type="radio" name="payment_method" id="payment_method_0"
                                       value="0" <?php if (set_value('payment_method', $portfolio['payment_method']) == 0) echo 'checked="checked"'; ?> />
                                <label class="form-control-label"
                                       for="payment_method_0"><?= t('Budget offer'); ?></label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <input type="radio" name="payment_method" id="payment_method_1"
                                       value="1" <?php if (set_value('payment_method', $portfolio['payment_method']) == 1) echo 'checked="checked"'; ?> />
                                <label class="form-control-label"
                                       for="payment_method_1"><?= t('Individual offer'); ?></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo form_error('categories'); ?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label class="form-control-label"><?= t('Category'); ?>:</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                <input type="hidden" id="categories" name="categories"/>
                                <?php
                                $this->outputData['selectedCategories'] = set_value('categories', $portfolio['categories']);
                                $this->load->view('multiselect');
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo form_error('description'); ?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label for="machine_description"
                                       class="form-control-label"><?= t('Description'); ?>:</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                                <textarea rows="5" name="machine_description" id="machine_description"
                                          class="form-control machine_description"><?php echo set_value('machine_description', $portfolio['machine_description']); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <h3><?= t('Standard Items'); ?></h3>
                                    <table id="items-standard-table" class="table">
                                        <colgroup>
                                            <col width="30%"/>
                                            <col width="10%"/>
                                            <col width="20%"/>
                                            <col width="40%"/>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th><?= t('Item'); ?></th>
                                            <th><?= t('Unit'); ?></th>
                                            <th><?= t('Value'); ?></th>
                                            <th><?= t('Remarks'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (is_array(set_value('standard_items'))) {
                                            $this->outputData['portfolio_standard_items'] = set_value('standard_items');
                                        }
                                        if (is_array($this->outputData['portfolio_standard_items'])) {
                                            $this->outputData['standard_item_number'] = 0;
                                            foreach ($this->outputData['portfolio_standard_items'] as $this->outputData['standard_item_value']) {
                                                $this->load->view('portfolio/manage_standard_items', $this->outputData);
                                                $this->outputData['standard_item_number']++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <h3><?= t('Custom Items'); ?></h3>
                                    <table id="items-custom-table" class="table">
                                        <colgroup>
                                            <col width="30%"/>
                                            <col width="10%"/>
                                            <col width="20%"/>
                                            <col width="35%"/>
                                            <col width="5%"/>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th><?= t('Item'); ?></th>
                                            <th><?= t('Unit'); ?></th>
                                            <th><?= t('Value'); ?></th>
                                            <th><?= t('Remarks'); ?></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (is_array(set_value('custom_items'))) {
                                            $this->outputData['portfolio_custom_items'] = set_value('custom_items');
                                        }
                                        if (is_array($this->outputData['portfolio_custom_items'])) {
                                            $this->outputData['custom_item_number'] = 0;
                                            foreach ($this->outputData['portfolio_custom_items'] as $this->outputData['custom_item_value']) {
                                                $this->load->view('portfolio/manage_custom_items', $this->outputData);
                                                $this->outputData['custom_item_number']++;
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <a id="add-custom-item" href="#" class="button big primary">Add Item</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="dropzone"></div>
                                <div class="attachments">
                                    <?php
                                    if (is_array(set_value('attachments'))) {
                                        $this->outputData['portfolio_attachments'] = invert_array(set_value('attachments'));
                                    }
                                    foreach ($this->outputData['portfolio_attachments'] as $key => $this->outputData['attachment']) {

                                        $this->load->view('portfolio/manage_attachment', $this->outputData);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <button name="reset" type="submit" value="reset"
                                        class="button big primary"><?= t('Reset');?></button>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <input type="submit" id="submit" name="submit" class="button big primary"/>

                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <button name="preview" type="submit" value="preview"
                                        class="button big primary"><?= t('Preview portfolio');?></button>

                            </div>
                        </div>

                    </div>

                </form>
            </div>

            <?php $this->load->view('portfolio/my_list'); ?>

    <style>
        .border {
            border: 1px solid #ccc !important;
        }

    </style>

<?php $this->load->view('footer1'); ?>