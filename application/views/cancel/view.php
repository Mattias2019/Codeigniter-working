<?php $this->load->view('header1'); ?>

<h2><?= t('Dispute Mail Box'); ?></h2>

<div class="col-md-3 col-sm-3 col-xs-12">
    <ul class="nav nav-pills nav-stacked">
        <li class="message-compose">
            <a class="button big primary" href="<?php echo site_url('cancel/message?id='.$this->outputData['current_case']); ?>"><?= t('Dispute'); ?><span><img class="icon-svg-img" src="<?php echo svg('Messages/ic_compose-message');?>"/></span></a>
        </li>
		<?php foreach($this->outputData['cases'] as $case) { ?>
            <li class="message-tab<?php if ($case['id'] == $this->outputData['current_case']) echo ' active'; ?>">
                <a href="#" class="tab" data-tab="<?php echo $case['id']; ?>">
                    <div class="case-type <?php echo $case['case_type_class']; ?>"><?php echo $case['case_type_name']; ?></div>
                    <div class="case-status <?php echo $case['status']['class']; ?>"><?php echo $case['status']['text']; ?></div>
                    <div><?php echo $case['job_name']; ?><span class="dispute-unread" <?php if ($case['unread_count'] == 0) echo 'hidden="hidden"'; ?> ><?php echo $case['unread_count']; ?></span></div>
                </a>
            </li>
		<?php } ?>
    </ul>
</div>

<div class="tab-content col-md-9 col-sm-9 col-xs-12">

    <div class="clsEditProfile clsSitelinks">
        <div class="cls_slet-refrs">
            <button type="button" id="project_submit" class="cls_btn-refres"><img class="icon-svg-img" src="<?php echo svg('Messages/ic_refresh_TOP');?>"/>&nbsp;<?= t('Refresh'); ?></button>
        </div>
    </div>

    <div class="content" id="content">
        <div class="table-responsive" data-tab="1">
            <table class="table" width="100%" cellspacing="0">
                <thead data-field="" data-sort="">
                    <tr>
                        <th>
                            <span class="icon-svg-img"><?php echo svg('messages/from', TRUE) ?></span>&nbsp;
                            <?= t('From'); ?>&nbsp;
                            <span role="button" class="table-sort fa fa-sort" data-field="from_name" data-sort=""></span>
                        </th>
                        <th>
                            <span class="icon-svg-img"><?php echo svg('messages/project', TRUE) ?></span>&nbsp;
                            <?= t('Job Title'); ?>&nbsp;
                        </th>
                        <th>
                            <span class="icon-svg-img"><?php echo svg('messages/subject', TRUE) ?></span>&nbsp;
                            <?= t('Subject'); ?>&nbsp;
                            <span role="button" class="table-sort fa fa-sort" data-field="subject" data-sort=""></span>
                        </th>
                        <th>
                            <span class="icon-svg-img"><?php echo svg('messages/data', TRUE) ?></span>&nbsp;
                            <?= t('Date/Time'); ?>&nbsp;
                            <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span>
                        </th>
                        <th><?= t('Status'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="admin_approved" data-sort=""></span></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $this->load->view('cancel/view_table'); ?>
                </tbody>
            </table>
            <?php $this->load->view('pagination', $this->outputData); ?>
        </div>
    </div>

</div>

<script type="text/javascript">

    function showHideMessage(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        row.next().toggle();
        // Mark message as read
        if (row.hasClass('unread'))
        {
            row.removeClass('unread');
            if (jQuery('.table-responsive').data('tab') == 1)
            {
                var unread = jQuery('.nav-pills').find('li.active').find('.dispute-unread');
                var unread_val = Number(unread.text());
                if (isNaN(unread_val) || unread_val <= 0)
                {
                    unread_val = 0;
                }
                else
                {
                    unread_val--;
                }
                unread.text(unread_val);
                if (unread_val == 0)
                {
                    unread.hide();
                }
            }
            // Send AJAX
            jQuery.ajax({
                url: '<?php echo site_url('cancel/set_notified'); ?>',
                data: {
                    id: row.data('id')
                }
            });
        }
    }

    jQuery(document).ready(function () {

        pagination.init(
            "<?php echo site_url('cancel'); ?>",
            null,
            function () {
                jQuery('[data-toggle="tooltip"]').tooltip();
                jQuery('.button-details').click(showHideMessage);
                jQuery('.message-compose').find('a').attr('href', site_url + '/cancel/message?id=' + jQuery('.message-tab.active').find('.tab').data('tab'));
            }
        );

        jQuery('#project_submit').click(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('.button-details').click(showHideMessage);

    });

</script>

<?php $this->load->view('footer1'); ?>