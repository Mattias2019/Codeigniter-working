<form method="post" action="<?php echo site_url('account/edit'); ?>" enctype="multipart/form-data" id="user-form">
    <input type="hidden" value="1" name="segment">
    <div class="cls_div-divides">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

            <div class="cls_page-title clearfix">
                <h2><?= t('edit_account'); ?></h2>
            </div>

            <div class="cls_div-first">

                <div class="row form-group">
                    <?php echo form_error('logo'); ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <input type="hidden" name="logo" id="logo" value="<?php echo set_value('logo', $this->outputData['user']['logo']); ?>"/>
                        <input type="hidden" name="img_logo" id="img_logo" value="<?php echo set_value('img_logo', $this->outputData['user']['img_logo']); ?>"/>
                        <div class="logo-container" id="logo-container">
                            <div class="dropzone" <?php if (set_value('logo', $this->outputData['user']['logo']) != '') echo 'hidden="hidden"'; ?> ></div>
                            <div class="logo-container-inner">
                                <img class="logo-image" src="<?php echo set_value('img_logo', $this->outputData['user']['img_logo']); ?>" <?php if (set_value('logo', $this->outputData['user']['logo']) == '') echo 'hidden="hidden"'; ?>/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <a id="delete_logo" class="button big primary <?php if (set_value('logo', $this->outputData['user']['logo']) == '') echo 'disabled'; ?>">Delete Photo</a>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('first_name'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="first_name" class="form-control-label"><?= t('First Name'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="first_name" id="first_name" class="form-control" value="<?php echo set_value('first_name', $this->outputData['user']['first_name']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('last_name'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="last_name" class="form-control-label"><?= t('Last Name'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="last_name" id="last_name" class="form-control" value="<?php echo set_value('last_name', $this->outputData['user']['last_name']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('name'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="name" class="form-control-label"><?= t('Company Name'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="name" id="name" class="form-control" value="<?php echo set_value('name', $this->outputData['user']['name']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('vat_id'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="vat_id" class="form-control-label"><?= t('VAT/TIN ID'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="vat_id" id="vat_id" class="form-control" value="<?php echo set_value('vat_id', $this->outputData['user']['vat_id']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('email'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="email" class="form-control-label"><?= t('Email'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="email" id="email" class="form-control" value="<?php echo set_value('email', $this->outputData['user']['email']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('company_address'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="company_address" class="form-control-label"><?= t('Company Address'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="company_address" id="company_address" class="form-control" value="<?php echo set_value('company_address', $this->outputData['user']['company_address']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('city'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="city" class="form-control-label"><?= t('City'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="city" id="city" class="form-control" value="<?php echo set_value('city', $this->outputData['user']['city']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('zip_code'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="zip_code" class="form-control-label"><?= t('ZIP Code'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="zip_code" id="zip_code" class="form-control" value="<?php echo set_value('zip_code', $this->outputData['user']['zip_code']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('state'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="state" class="form-control-label"><?= t('State/Province'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="state" id="state" class="form-control" value="<?php echo set_value('state', $this->outputData['user']['state']); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('country_id'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="country_id" class="form-control-label"><?= t('Country'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <select class="form-control" name="country_id" id="country_id" tabindex="1">
                            <option value="">-- <?= t('Select Country'); ?> --</option>
                            <?php
                            $sel_country = set_value('country_id', $this->outputData['user']['country_id']);
                            foreach ($this->outputData['countries'] as $country) { ?>
                                <option value="<?php echo $country['id']; ?>" <?php if ($country['id'] == $sel_country) echo 'selected="selected"' ?> > <?php echo $country['country_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="cls_bg-white">

                <div class="row form-group">
                    <?php echo form_error('pick_password'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="pick_password" class="form-control-label"><?= t('Password'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input type="password" name="pick_password" id="pick_password" class="form-control" value="<?php echo set_value('pick_password'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('repeat_password'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="repeat_password" class="form-control-label"><?= t('Repeat Password'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input type="password" name="repeat_password" id="repeat_password" class="form-control" value="<?php echo set_value('repeat_password'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="button big primary outline" data-toggle="modal" data-target="#GenPasswordModal">
                            <img src="<?php echo image_url('tmpl-img/gen-paswrd.png'); ?>"/> <?= t('Generate Secure Password'); ?>
                        </button>
                    </div>
                    <div class="col-lg-3"></div>
                </div>

            </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">


            <div class="cls_page-title clearfix">
                <!-- @todo fix using lang -->
                <h2>Expertise</h2>
            </div>

            <div class="cls_div-scnd">
                <div class="row form-group">
                    <?php echo form_error('rate'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="rate" class="form-control-label"><?= t('Daily rate'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input name="rate" id="rate" class="form-control" value="<?php echo set_value('rate', $this->outputData['user']['rate']); ?>"/>
                    </div>
                </div>
            </div>

            <div class="cls_scnd-div-part clearfix">

                <div class="row form-group">
                    <?php echo form_error('profile_desc'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="profile_desc" class="form-control-label"><?= t('Description (VITA/Company Info)'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <textarea rows="7" name="profile_desc" id="profile_desc" class="form-control profile_desc"><?php echo set_value('profile_desc', $this->outputData['user']['profile_desc']); ?></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('categories'); ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label for="categories" class="form-control-label"><?= t('Category'); ?>:</label>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                        <input type="hidden" name="categories" id="categories"/>
                        <?php
                        $categories = explode(',', set_value('categories'));
                        if (!is_array($categories) or count($categories) == 0 or $categories[0] == '')
                        {
                            $categories = $this->outputData['user']['categories'];
                        }
                        $this->outputData['selectedCategories'] = $categories;
                        $this->load->view('multiselect');
                        ?>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-8 col-md-8 col-sm-6"></div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('Save Changes'); ?>"/>
                    </div>
                </div>

            </div>

        </div>

    </div>
</form>
<!-- Modal -->
<div class="modal fade bs-example-modal-sm" id="GenPasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= t('Secure Password'); ?></h4>
            </div>
            <div class="modal-body">
                <p>
                    <label for="suggest_password"><?= t('Password'); ?></label>
                    <input type="text" name="suggest_password" id="suggest_password" value=""/>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= t('Close'); ?></button>
                <input type="button" id="use_secure_pwd" value="Use Password" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

<style>

    .logo-container
    {
        height: 128px;
        width: 128px;
        border: 1px solid black;
        border-radius: 50%;
        margin: auto;
    }
    .logo-container > .dropzone, .logo-container > .dropzone > .dz-preview, .logo-container > .dropzone > .dz-preview > .dz-image
    {
        height: 100%;
        width: 100%;
        border-radius: 50%;
        margin: 0;
        padding: 0;
    }
    .logo-container > .dropzone > .dz-message
    {
        font-size: 64px;
        margin: 14px 0;
    }
    .logo-container > .dropzone > .dz-preview > .dz-image
    {
        position: relative;
    }
    .logo-container > .dropzone > .dz-preview > .dz-image > img
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        max-height: 100%;
        max-width: 100%;
    }

    .logo-container-inner
    {
        height: 100%;
        width: 100%;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }
    .logo-image
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        max-height: 100%;
        max-width: 100%;
    }

    #delete_logo
    {
        margin: 40px 0;
    }

</style>