<div class="clsEditProfile clsSitelinks">
    <form method="post" action="<?php echo admin_url('dispute'); ?>" enctype="multipart/form-data">
        <input type="hidden" name="segment" value="<?php echo $this->outputData['current_case']['id']; ?>"/>
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <input type="submit" name="close" class="button big primary" value="<?= t('Close Case'); ?>" <?php if ($this->outputData['current_case']['status'] != 1) echo 'disabled="disabled"'; ?>/>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <input type="submit" name="cancel" class="button big primary" value="<?= t('Cancel Project'); ?>" <?php if ($this->outputData['current_case']['status'] != 1 or $this->outputData['current_case']['case_type'] != 2) echo 'disabled="disabled"'; ?>/>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <input type="submit" name="escalate" class="button big primary" value="<?= t('Escalate Case'); ?>" <?php if ($this->outputData['current_case']['status'] != 1) echo 'disabled="disabled"'; ?>/>
            </div>
        </div>
    </form>
</div>

<div class="content">
    <div class="table-responsive">
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
                    <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""></span>
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
                <th><?= t('Actions'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $this->load->view('admin/dispute/view_table'); ?>
            </tbody>
        </table>
        <?php $this->load->view('pagination', $this->outputData); ?>
    </div>
</div>