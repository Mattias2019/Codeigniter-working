<form action="<?php echo admin_url('payments/transaction/2'); ?>" method="post">
	<div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
		<div class="dashboard">

			<div class="row form-group">
                <?php echo form_error('type'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="type" class="form-control-label"><?= t('Type'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
					<select name="type" id="type" class="form-control">
						<option value="">-- <?= t('Select Type'); ?> --</option>
						<?php foreach($this->outputData['transaction_types'] as $transaction_type) { ?>
							<option value="<?php echo $transaction_type['id']; ?>" <?php if ($transaction_type['id'] == set_value('type')) echo 'selected="selected"'; ?>><?php echo $transaction_type['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<?php echo form_error('payment_method'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="payment_method" class="form-control-label"><?= t('Payment Method'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
					<select name="payment_method" id="payment_method" class="form-control">
						<option value="">-- <?= t('Select Method'); ?> --</option>
						<?php foreach($this->outputData['payment_methods'] as $payment_method) { ?>
							<option value="<?php echo $payment_method['id']; ?>" <?php if ($payment_method['id'] == set_value('payment_method')) echo 'selected="selected"'; ?>><?php echo $payment_method['title']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<?php echo form_error('user_name'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="user_id" class="form-control-label"><?= t('User (Enter Login)'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">-- <?= t('Select User'); ?> --</option>
                        <?php
                            foreach($this->outputData['users'] as $user) { ?>
                                <option value="<?php echo $user['id'] ?>"> <?php echo $user['user_name'] ?> </option>
                        <?php
                            }
                        ?>
                    </select>
				</div>
			</div>

            <div class="row form-group">
                <div class="col-sm-4 col-xs-12">
                    <label class="form-control-label"><?= t('User Balance'); ?>:</label>
                </div>
                <div class="col-sm-8 col-xs-12">
                    <label id="user_balance" class="form-control-label"></label>
                </div>
            </div>

			<div class="row form-group">
				<?php echo form_error('job_id'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="job_id" class="form-control-label"><?= t('Project'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
					<select name="job_id" id="job_id" class="form-control">
						<?php $this->load->view('admin/payments/transaction_add_projects'); ?>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<?php echo form_error('milestone_id'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="milestone_id" class="form-control-label"><?= t('Milestone'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
					<select name="milestone_id" id="milestone_id" class="form-control">
						<?php $this->load->view('admin/payments/transaction_add_milestones'); ?>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<?php echo form_error('amount'); ?>
				<div class="col-sm-4 col-xs-12">
					<label for="amount" class="form-control-label"><?= t('Amount'); ?>:</label>
				</div>
				<div class="col-sm-8 col-xs-12">
					<input name="amount" id="amount" class="form-control inputmask" data-prefix="<?php echo currency(); ?>" value="<?php echo set_value('amount'); ?>"/>
				</div>
			</div>

            <div class="row form-group">
                <div class="col-sm-4 col-xs-12">
                    <label class="form-control-label"><?= t('Fee'); ?>:</label>
                </div>
                <div class="col-sm-8 col-xs-12">
                    <label id="fee" class="form-control-label"></label>
                    <input type="hidden" id="project_fee" value="<?php echo set_value('project_fee'); ?>"/>
                    <input type="hidden" id="escrow_fee" value="<?php echo set_value('escrow_fee'); ?>"/>
                </div>
            </div>

			<div class="row form-group">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 col-xs-12">
					<input type="submit" name="submit" class="button big primary" value="<?= t('Add Transaction'); ?>"/>
				</div>
				<div class="col-sm-4"></div>
			</div>

		</div>
	</div>
</form>