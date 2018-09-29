<?php $this->load->view('header1'); ?>

<?php flash_message(); ?>

<h2><?= t('All Disputes'); ?></h2>

<div class="col-md-3 col-sm-3 col-xs-12">
    <ul class="nav nav-pills nav-stacked">
		<?php foreach($this->outputData['cases'] as $case) { ?>
            <li class="message-tab<?php if ($case['id'] == $this->outputData['current_case']['id']) echo ' active'; ?>">
                <a href="#" class="tab" data-tab="<?php echo $case['id']; ?>">
                    <div class="case-type <?php echo $case['case_type_class']; ?>"><?php echo $case['case_type_name']; ?></div>
                    <div class="case-status <?php echo $case['status']['class']; ?>"><?php echo $case['status']['text']; ?></div>
                    <div><?php echo $case['job_name']; ?></div>
                </a>
            </li>
		<?php } ?>
    </ul>
</div>

<div class="tab-content col-md-9 col-sm-9 col-xs-12" id="content">
    <?php $this->load->view('admin/dispute/view_tab', $this->outputData); ?>
</div>

<script type="text/javascript">

    function showHideMessage(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        row.next().toggle();
    }

    function messageOperation(e) {
        e.preventDefault();
        m.post(
            jQuery(this).attr('href'),
            null,
            function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 0);
            }
        );
    }

    jQuery(document).ready(function () {

        pagination.init(
            "<?php echo admin_url('dispute'); ?>",
            null,
            function () {
                jQuery('[data-toggle="tooltip"]').tooltip();
                jQuery('.button-details').click(showHideMessage);
                jQuery('.table-button').click(messageOperation);
            }
        );

        jQuery('#project_submit').click(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('.button-details').click(showHideMessage);
        jQuery('.table-button').click(messageOperation);

    });

</script>

<?php $this->load->view('footer1'); ?>