<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <h2><?= t('Payment Packages'); ?></h2>

        <?php flash_message(); ?>

        <div class="content">

            <div class="dashboard row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <a href="<?php echo admin_url('packages/addPackages'); ?>" id="add_new_user" class="button big primary"><i class="fa fa-plus"></i>&nbsp;<?= t('Add Package'); ?></a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table" width="100%" cellspacing="0">
                    <thead data-field="" data-sort="">
                    <tr>
                        <th><?= t('ID');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span></th>
                        <th><?= t('Package Name');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="package_name" data-sort=""></span></th>
                        <th><?= t('Description');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="description" data-sort=""></span></th>
                        <th><?= t('Credits');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="credits" data-sort=""></span></th>
                        <th><?= t('Total Days');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="total_days" data-sort=""></span></th>
                        <th><?= t('Amount');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                        <th><?= t('Status');?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="isactive" data-sort=""></span></th>
                        <th><?= t('actions');?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $this->load->view('admin/package/viewpackage_table', $this->outputData); ?>
                    </tbody>
                </table>
				<?php $this->load->view('pagination', $this->outputData); ?>
            </div>

        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>

<script>

    function deletePackage(e) {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('tr');
        m.dialog({
            header: '<?= t('Delete package'); ?>',
            body: '<?= t('Do you wish to delete package?'); ?>',
            btnOk: {
                label:'<?= t('Yes'); ?>',
                callback: function() {
                    m.post(url, null, function(result) {
                        row.remove();
                    });
                }
            },
            btnCancel: {
                label:'<?= t('No'); ?>'
            }
        });
    }

    jQuery(document).ready(function () {

        pagination.init(
            "<?php echo admin_url('packages/viewPackages'); ?>",
            null,
            function () {
                jQuery('.delete').click(deletePackage);
                jQuery('[data-toggle="tooltip"]').tooltip();
            },
            null
        );

        jQuery('.delete').click(deletePackage);
        jQuery('[data-toggle="tooltip"]').tooltip();
    })

</script>