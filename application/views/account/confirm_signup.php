<?php $this->load->view('header'); ?>

    <div class="container">
        <div class="dashboard">

            <?php flash_message(); ?>

            <form id="signup-form" method="post" action="<?php echo site_url('account/confirm'); ?>" enctype="multipart/form-data">

				<?= form_token(); ?>

                <input type="hidden" name="id" value="<?php if (isset($id)) echo $id; ?>"/>
                <input type="hidden" name="role_id" value="<?php if (isset($role_id)) echo $role_id; ?>"/>
                <input type="hidden" name="activation_key" value="<?php echo set_value('activation_key', $this->uri->segment(2)); ?>"/>

                <div class="row form-group">
                    <div class="col-xs-12">
                        <h2><?= t('Sign Up'); ?></h2>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-4 col-xs-12">
                        <label class="form-control-label"><?= t('Confirmed E-mail'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <label class="form-control-label"><?php if (isset($confirmed_mail)) echo $confirmed_mail; ?></label>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('user_name'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="user_name" class="form-control-label"><?= t('Login Name:'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="user_name" name="user_name" class="form-control" value="<?php echo set_value('user_name'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('first_name'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="first_name" class="form-control-label"><?= t('First name'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="first_name" name="first_name" class="form-control" value="<?php echo set_value('first_name'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('last_name'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="last_name" class="form-control-label"><?= t('Last name'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="last_name" name="last_name" class="form-control" value="<?php echo set_value('last_name'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('password'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="password" class="form-control-label"><?= t('Enter your password'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" id="password" name="password" class="form-control"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('confirm_password'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="confirm_password" class="form-control-label"><?= t('Repeat password'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('name'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="name" class="form-control-label"><?= t('Your company name'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="name" name="name" class="form-control" value="<?php echo set_value('name'); ?>"/>
                        <p><small><?= t('(This name will be displayed to others.)'); ?></small></p>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('logo'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="logo" class="form-control-label"><?= t('Your picture or company logo'); ?>:</label>
                    </div>
                    <div class="col-sm-4 col-xs-12">

                        <input type="hidden" name="logo" id="logo" value="<?php echo set_value('logo'); ?>"/>
                        <input type="hidden" name="img_logo" id="img_logo" value="<?php echo set_value('img_logo'); ?>"/>
                        <div class="logo-container" id="logo-container">
                            <div class="dropzone" <?php if (set_value('logo') != '') echo 'hidden="hidden"'; ?> ></div>
                            <div class="logo-container-inner">
                                <img class="logo-image" src="<?php echo set_value('img_logo'); ?>" <?php if (set_value('logo') == '') echo 'hidden="hidden"'; ?>/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <p><small><?= t('(Use only JPG or PNG files)'); ?></small></p>
                        <a id="delete_logo" class="button big primary <?php if (set_value('logo') == '') echo 'disabled'; ?>"><?= t('Delete Logo'); ?></a>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('notify_bid'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="notify_bid" class="form-control-label"><?= t('New quote E-mail notifications'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <select id="notify_bid" name="notify_bid" class="form-control">
                            <option value=""><?= t('Never'); ?></option>
                            <option value="0" <?php echo set_select('notify_bid', 'Instantly'); ?>><?= t('Instantly'); ?></option>
                            <option value="1" <?php echo set_select('notify_bid', 'Hourly'); ?>><?= t('Hourly'); ?></option>
                            <option value="2" <?php echo set_select('notify_bid', 'Daily'); ?>><?= t('Daily'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('notify_message'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="notify_message" class="form-control-label"><?= t('New message E-mail notifications'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <select id="notify_message" name="notify_message" class="form-control">
                            <option value=""><?= t('Never'); ?></option>
                            <option value="0" <?php echo set_select('notify_message', 'Instantly'); ?>><?= t('Instantly'); ?></option>
                            <option value="1" <?php echo set_select('notify_message', 'Hourly'); ?>><?= t('Hourly'); ?></option>
                            <option value="2" <?php echo set_select('notify_message', 'Daily'); ?>><?= t('Daily'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('categories'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="categories" class="form-control-label"><?= t('Areas of expertise'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input type="hidden" id="categories" name="categories"/>
                        <?php
						$this->outputData['selectedCategories'] = explode(',', set_value('categories'));
                        $this->load->view('multiselect', $this->outputData);
                        ?>
                    </div>
                </div>



<!--                --><?php //if (isset($role_id) and $role_id == 2 /* provider */ ) { ?>
<!--                <div class="row form-group">-->
<!--					--><?php //echo form_error('rate'); ?>
<!--                    <div class="col-sm-4 col-xs-12">-->
<!--                        <label for="rate" class="form-control-label">--><?php //echo t('Your average hourly rate'); ?><!--<span class="text-danger">*</span>:</label>-->
<!--                    </div>-->
<!--                    <div class="col-sm-8 col-xs-12">-->
<!--                        <input id="rate" name="rate" class="form-control inputmask" data-prefix="--><?php //echo currency(); ?><!--" value="--><?php //echo set_value('rate'); ?><!--"/>-->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?php //} ?>

                <div class="row form-group">
					<?php echo form_error('profile_desc'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="profile_desc" class="form-control-label"><?= t('Profile description'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <textarea id="profile_desc" name="profile_desc" class="form-control" rows="5"><?php echo set_value('profile_desc'); ?></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('company_address'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="company_address" class="form-control-label"><?= t('Company address'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="company_address" name="company_address" class="form-control" value="<?php echo set_value('company_address'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('city'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="city" class="form-control-label"><?= t('City'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="city" name="city" class="form-control" value="<?php echo set_value('city'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('zip_code'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="zip_code" class="form-control-label"><?= t('ZIP Code'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="zip_code" name="zip_code" class="form-control" value="<?php echo set_value('zip_code'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('state'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="state" class="form-control-label"><?= t('State/Province'); ?>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <input id="state" name="state" class="form-control" value="<?php echo set_value('state'); ?>"/>
                    </div>
                </div>

                <div class="row form-group">
                    <?php echo form_error('country_id'); ?>
                    <div class="col-sm-4 col-xs-12">
                        <label for="country_id" class="form-control-label"><?= t('Country'); ?><span class="text-danger">*</span>:</label>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <select id="country_id" name="country_id" class="form-control">
                            <option value="">-- <?= t('Select Country'); ?> --</option>
                            <?php if (isset($countries)) foreach ($countries as $country) { ?>
                                <option value="<?php echo $country['id']; ?>" <?php echo set_select('country_id', $country['id']); ?>><?= t($country['country_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row form-group">
					<?php echo form_error('signup_agree_terms'); ?>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8 col-xs-12">
                        <input type="checkbox" id="signup_agree_terms" name="signup_agree_terms"/>
                        <label for="signup_agree_terms" class="form-control-label"><?= t('I have read and agree to the '); ?><a class="text-primary" href="<?php echo site_url('home/page/condition'); ?>" target="_blank"><?= t('terms and conditions'); ?></a></label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-4 col-sm-4 col-xs-12"></div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="submit" name="submit" class="button big primary" value="<?= t('Sign Up'); ?>"/>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12"></div>
                </div>

            </form>

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
            margin: 16px 0;
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

    </style>

    <script>

        function createDropzone(element)
        {
            element.dropzone({
                url: "<?php echo site_url('account/upload_file'); ?>",
                dictDefaultMessage: "<span class='fa fa-camera'></span>",
                maxFiles: 1,
                maxFilesize: 500,
                maxThumbnailFilesize: 100,
                createImageThumbnails: true,
                resizeWidth: 300,
                resizeHeight: 300,
                resizeMethod: "crop",
                acceptedFiles: "image/jpg, image/jpeg, image/png",
                init: function() {
                    this.on('error', function(file, response) {
                        jQuery('#delete_logo').removeClass('disabled');
                        var errorMessage;
                        if (response && file.xhr.status >= 400 && response.match(/<\/html>/)) {
                            errorMessage = file.xhr.statusText;
                        } else {
                            errorMessage = response;
                        }
                        $(file.previewElement).find('.dz-error-message').text(errorMessage);
                    });
                },
                success: function (file, response) {
                    var data = JSON.parse(response);
                    jQuery('#logo').val(data.logo);
                    jQuery('#img_logo').val(data.img_logo);
                    jQuery('#delete_logo').removeClass('disabled');
                }
            });
        }

        function deleteLogo() {
            var image = jQuery('.logo-image');
            var dropzone = jQuery('.dropzone');
            if (image.is(':visible')) {
                image.hide();
                dropzone.show();
            } else {
                Dropzone.forElement('.dropzone').removeAllFiles();
            }
            jQuery('#logo').val('');
            jQuery('#img_logo').val('');
            jQuery('#delete_logo').addClass('disabled');
        }

        function launchSubmit()
        {
            // Set selected categories
            jQuery('#categories').val(jQuery("input[name='category[]']:checked").map(function () {
                return this.value;
            }).toArray());
        }

        jQuery(document).ready(function() {
            createDropzone(jQuery('.dropzone'));
            jQuery('#signup-form').submit(launchSubmit);
            jQuery('#delete_logo').click(deleteLogo);
        });

    </script>

<?php $this->load->view('footer'); ?>