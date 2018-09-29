<?php $this->load->view('header1'); ?>

<h2><?= t('Failed Logins'); ?></h2>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <?php flash_message(); ?>

        <div class="content" id="content">
            <div class="table-responsive">
                <table id="table-jobs" class="table" width="100%" cellspacing="0">
                    <thead data-field="" data-sort="">
                    <tr>
                        <th><?= t('User'); ?> <span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""></span></th>
                        <th><?= t('Date/Time'); ?> <span role="button" class="table-sort fa fa-sort" data-field="time" data-sort=""></span></th>
                        <th><?= t('Reason'); ?> <span role="button" class="table-sort fa fa-sort" data-field="reason" data-sort=""></span></th>
                        <th><?= t('User Agent'); ?> <span role="button" class="table-sort fa fa-sort" data-field="user_agent" data-sort=""></span></th>
                        <th><?= t('IP Address'); ?> <span role="button" class="table-sort fa fa-sort" data-field="ip" data-sort=""></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $this->load->view('admin/safety/failed_logins_table'); ?>
                    </tbody>
                </table>
                <?php $this->load->view('pagination', $this->outputData); ?>
            </div>
        </div>

    </div>
</div>

<script>

    jQuery(document).ready(function () {

        pagination.init(
            "<?php echo admin_url('safety/failed_logins'); ?>"
        );

    });

</script>

<?php $this->load->view('footer1'); ?>