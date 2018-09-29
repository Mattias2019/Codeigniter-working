<div class="container-fluid">

    <?php
    if (!array_key_exists('file', $this->outputData))
    {
        $post = $this->input->post();
        if (array_key_exists('id', $post ))
        {
            $this->outputData['file'] = $post;
        }
        else
        {
            $this->outputData['file'] = NULL;
        }
    }
    ?>

    <h2><?= t('File Manager'); ?></h2>

    <div class="dashboard border-top border-color-2">
        <form method="post" action="<?php echo site_url('file/index/'.$this->outputData['tab']); ?>" enctype="multipart/form-data" id="file-form">

            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

					<?php if ($this->outputData['tab'] == 1) { ?>

                        <div class="row form-group">
							<?php echo form_error('job_id'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="job_id" class="form-control-label"><?= t('Project'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <select name="job_id" id="job_id" class="form-control" <?php if ($this->outputData['file']['id'] != '' and (!isset($this->outputData['copy']))) echo 'disabled="diasbled"'; ?> >
                                    <option value="">-- <?= t('Select Project'); ?> --</option>
									<?php foreach ($this->outputData['projects'] as $project) { ?>
                                        <option value="<?php echo $project['id']; ?>" <?php if ($project['id'] == $this->outputData['file']['job_id']) echo 'selected'; ?> ><?php echo $project['job_name']; ?></option>
									<?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
							<?php echo form_error('milestone_id'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="milestone_id" class="form-control-label"><?= t('Milestone'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <select name="milestone_id" id="milestone_id" class="form-control" <?php if ($this->outputData['file']['id'] != '' and (!isset($this->outputData['copy']))) echo 'disabled="diasbled"'; ?> >
									<?php $this->load->view('file/milestone_list', $this->outputData); ?>
                                </select>
                            </div>
                        </div>

					<?php } ?>

                    <div class="row form-group">
						<?php echo form_error('expire_date'); ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label for="expire_date" class="form-control-label"><?= t('Expire Date'); ?></label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <?php $expire_date = is_numeric($this->outputData['file']['expire_date']) ?
                                $this->outputData['file']['expire_date'] :
                                strtotime($this->outputData['file']['expire_date']);
                            ?>
                            <input id="expire_date" name="expire_date" type="hidden" value="<?= $expire_date; ?>"/>
                            <input id="picker_date" class="form-control"/>
                        </div>
                    </div>

                    <div class="row form-group">
						<?php echo form_error('img_url'); ?>
                        <div class="col-xs-12">
                            <div class="dropzone" <?php if (isset($this->outputData['file']['id'])) echo 'hidden="hidden"' ?> ></div>
                            <div class="attachment">
								<?php $this->load->view('file/attachment'); ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div class="row form-group">
						<?php echo form_error('description'); ?>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label for="description" class="form-control-label"><?= t('Description'); ?></label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <textarea rows="5" name="description" id="description" class="form-control description"><?php echo $this->outputData['file']['description']; ?></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-lg-8 col-md-4 col-sm-8"></div>
                        <div class="col-lg-4 col-md-8 col-sm-4 col-xs-12">
                            <input type="hidden" name="copy" value="<?php echo isset($this->outputData['copy'])?1:0; ?>"/>
                            <input type="submit" name="submit" class="button big primary" value="<?= t(isset($this->outputData['copy'])?'Copy File':'Save File'); ?>"/>
                        </div>
                    </div>

                </div>

            </div>

        </form>
    </div>

</div>