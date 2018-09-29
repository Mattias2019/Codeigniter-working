<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

			<?php flash_message(); ?>

            <h2><?= t('Subscription Payments List'); ?></h2>

            <div class="dashboard border-top border-primary container-fluid">

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_name" class="form-control-label"><?= t('User Name'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <input name="search_name" id="search_name" class="form-control"/>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_email" class="form-control-label"><?= t('Email'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <input name="search_email" id="search_email" class="form-control"/>
                    </div>
                </div>

                <div class="col-md-1 col-sm-1 col-xs-3">
                    <div class="form-group">
                        <label for="search_package" class="form-control-label"><?= t('Package'); ?>:</label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-9">
                    <div class="form-group">
                        <select name="search_package" id="search_package" class="form-control">
                            <option value="">-- <?= t('Select Package'); ?> --</option>
							<?php foreach ($this->outputData['packages'] as $package) { ?>
                                <option value="<?php echo $package['id']; ?>"><?php echo $package['package_name']; ?></option>
							<?php } ?>
                        </select>
                    </div>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table" width="100%" cellspacing="0">
                    <thead data-field="" data-sort="">
                    <tr>
                        <th><?= t('User ID'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="user_id" data-sort=""></span></th>
                        <th><?= t('User Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""></span></th>
                        <th><?= t('Package'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="package_name" data-sort=""></span></th>
                        <th><?= t('Valid'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="valid" data-sort=""></span></th>
                        <th><?= t('Amount'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $this->load->view('admin/package/viewsubscriptionpayment_table'); ?>
                    </tbody>
                </table>
				<?php $this->load->view('pagination', $this->outputData); ?>
            </div>

        </div>
    </div>

    <script>

        jQuery(document).ready(function () {

            pagination.init(
                "<?php echo admin_url('packages/viewSubscriptionPayment'); ?>",
                function () {
                    return {
                        name: jQuery('#search_name').val(),
                        email: jQuery('#search_email').val(),
                        package_id: jQuery('#search_package').val()
                    }
                },
                function () {
                    jQuery('[data-toggle="tooltip"]').tooltip();
                }
            );

            jQuery('#search_name,#search_email, #search_package').change(function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
            });

            jQuery('[data-toggle="tooltip"]').tooltip();

        });

    </script>

<?php $this->load->view('footer1'); ?>