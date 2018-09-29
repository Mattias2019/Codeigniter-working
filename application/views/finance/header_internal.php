<div class="dashboard-stat2 top_green container-fluid">
    <form method="post" action="<?php echo site_url('finance/'.$this->outputData['operation']); ?>" enctype="multipart/form-data" id="finance-form">

        <input type="hidden" name="operation" value="<?php echo $this->outputData['operation']; ?>"/>
        <input type="hidden" name="total" value="<?php echo set_value('total'); ?>"/>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <strong class="uppercase"><?= t('User Name'); ?>:</strong>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <span><?php echo $this->logged_in_user->full_name; ?></span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <strong class="uppercase"><?= t('Account Balance'); ?>:</strong>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <strong class="uppercase text-color-2"><?php echo currency().number_format($this->outputData['balance']); ?></strong>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row form-group">
				<?php echo form_error('job_id'); ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label for="job_id" class="form-control-label"><?= t('Select Project'); ?>:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <select name="job_id" class="form-control" id="job_id">
                        <option value="">-- <?= t('Select Project'); ?> --</option>
                        <?php foreach ($this->outputData['projects'] as $project) { ?>
                            <option value="<?php echo $project['id']; ?>" <?php if (set_value('job_id') == $project['id']) echo 'selected="selected"'; ?> ><?php echo $project['job_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
				<?php echo form_error('milestone_id'); ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label for="milestone_id" class="form-control-label"><?= t('Select Milestone'); ?>:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <select name="milestone_id" class="form-control" id="milestone_id">
                        <?php $this->load->view('finance/milestones'); ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
				<?php echo form_error('reciever_id'); ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label for="reciever_id" class="form-control-label"><?= t('Select Reciever'); ?>:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <select name="reciever_id" class="form-control" id="reciever_id">
						<?php $this->load->view('finance/recievers'); ?>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <span><?= t('Due Amount'); ?>:</span>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="hidden" name="due" id="project-due-input" value="<?php echo set_value('due', currency().number_format(0)); ?>"/>
                    <span id="project-due"><?php echo set_value('due', currency().number_format(0)); ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row form-group">
				<?php echo form_error('amount'); ?>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label for="amount" class="form-control-label"><?= t('Amount'); ?>:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input name="amount" class="form-control inputmask" data-prefix="<?php echo currency(); ?>" id="amount" value="<?php set_value('amount'); ?>"/>
                </div>
            </div>
            <div class="row form-group" id="amount-total" <?php if(set_value('total') == 0 or set_value('total') == '') echo 'hidden="hidden"'; ?> >
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <span><?= t('Total'); ?>:</span>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <span id="amount-total-text"><?php echo set_value('total'); ?></span>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="col-lg-10 col-md-10 col-sm-8"></div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                <input type="submit" class="button big primary" name="submit" value="<?php echo $this->outputData['operation_text']; ?>"/>
            </div>
        </div>

    </form>
</div>