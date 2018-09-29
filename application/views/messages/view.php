<?php $this->load->view('header1'); ?>

<h2><?= t('Mail Box').(($this->outputData['inbox_count'] > 0)?' ('.$this->outputData['inbox_count'].' '.t('new').')':''); ?></h2>

<?php flash_message(); ?>

<div class="col-md-3 col-sm-3 col-xs-12">
    <ul class="nav nav-pills nav-stacked">
        <li class="message-compose">
            <a class="button big primary" href="<?php echo site_url('messages/create'); ?>"><?= t('Compose Message'); ?><span class="icon-svg-img"><?php echo svg('messages/compose-message', TRUE) ?></span></a>
        </li>
        <li class="message-tab active">
            <a href="#" class="tab" data-tab="1">
                <span class="icon-svg-img"><?php echo svg('messages/inbox', TRUE); ?></span>&nbsp;
				<?= t('Inbox'); ?>
                <span id="inbox-unread" class="pull-right badge" <?php if ($this->outputData['inbox_count'] == 0) echo 'hidden="hidden"'; ?> ><?php echo $this->outputData['inbox_count']; ?></span>
            </a>
        </li>
        <li class="message-tab">
            <a href="#" class="tab" data-tab="2">
                <span class="icon-svg-img"><?php echo svg('messages/outbox', TRUE); ?></span>&nbsp;
				<?= t('Sent'); ?>
            </a>
        </li>
        <li class="message-tab">
            <a href="#" class="tab" data-tab="3">
                <span class="icon-svg-img"><?php echo svg('messages/trash', TRUE); ?></span>&nbsp;
				<?= t('Trash'); ?>
            </a>
        </li>
    </ul>
</div>

<div class="tab-content col-md-9 col-sm-9 col-xs-12">

    <div class="clsEditProfile clsSitelinks">
        <div class="cls_slet-refrs">

            <div class="page-actions check">
                <input type="checkbox" name="select_all" id="select_all" value="1"/>
                <label for="select_all" class="form-control-label"><?= t('All'); ?></label>
            </div>

            <div class="page-actions btn-group">

                <button type="button" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="hidden-sm hidden-xs"><?= t('More'); ?></span>
                    <span class="fa fa-caret-down"></span>
                </button>

                <ul class="dropdown-menu cls_more_toggle" role="menu">
                    <li class="more_option" id="1">
                        <a href="#" id="delete-messages"><span class="icon-svg-img"><?php echo svg('messages/trash', TRUE); ?></span>&nbsp;<?= t('Delete'); ?></a>
                    </li>
                    <li class="more_option" id="2">
                        <a href="#" id="restore-messages" class="hidden"><span class="icon-svg-img"><?php echo svg('messages/trash', TRUE); ?></span>&nbsp;<?= t('Restore'); ?></a>
                    </li>
                </ul>

            </div>

            <div class="page-actions">
                <button type="button" id="project_submit"><span class="icon-svg-img"><?php echo svg('messages/refresh', TRUE); ?></span>&nbsp;<?= t('Refresh'); ?></button>
            </div>

            <div class="page-actions">
                <select id="project-list" class="form-control">
                    <option value="">-- <?= t('Select Project'); ?> --</option>
					<?php foreach ($this->outputData['projects'] as $project) { ?>
                        <option value="<?php echo $project['id']; ?>"><?php echo $project['job_name']; ?></option>
					<?php } ?>
                </select>
            </div>

            <div class="clearfix"></div>

        </div>
    </div>

    <div class="content" id="content">
        <?php $this->load->view($this->outputData['view']); ?>
    </div>

</div>

<script type="text/javascript" class="init">

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
                var unread = jQuery('#inbox-unread');
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
                url: '<?php echo site_url('messages/set_notified'); ?>',
                data: {
                    id: row.data('id')
                }
            });
        }
    }

    function deleteMessages(e) {
        e.preventDefault();
        // Send AJAX
        jQuery.ajax({
            url: '<?php echo site_url('messages/delete'); ?>',
            data: {
                id: jQuery("input:checked").closest('tr').map(function () {
                    return jQuery(this).data('id');
                }).toArray()
            },
            success: function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
            }
        });
    }

    function restoreMessages(e) {
        e.preventDefault();
        // Send AJAX
        jQuery.ajax({
            url: '<?php echo site_url('messages/restore'); ?>',
            data: {
                id: jQuery("input:checked").closest('tr').map(function () {
                    return jQuery(this).data('id');
                }).toArray()
            },
            success: function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
            }
        });
    }

    jQuery(document).ready(function () {

        pagination.init(
            "<?php echo site_url('messages'); ?>",
            function () {
                return {
                    project: jQuery('#project-list').val()
                }
            },
            function () {
                jQuery('[data-toggle="tooltip"]').tooltip();
                jQuery('.button-details').click(showHideMessage);
            },
            function (data) {
                jQuery('#inbox-unread').text(data.inbox_count);
                if (jQuery('.table-responsive').data('tab') == 3)
                {
                    jQuery('#restore-messages').removeClass('hidden');
                }
                else
                {
                    jQuery('#restore-messages').addClass('hidden');
                }
            }
        );

        jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('.button-details').click(showHideMessage);

        jQuery('#project-list').change(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        jQuery('#project_submit').click(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        jQuery('#delete-messages').click(deleteMessages);
        jQuery('#restore-messages').click(restoreMessages);

        $("#select_all").change(function () {
            $("input:checkbox").prop('checked', this.checked);
        });

    });

</script>

<?php $this->load->view('footer1'); ?>