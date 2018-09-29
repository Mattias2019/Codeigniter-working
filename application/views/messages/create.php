<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

		<?php flash_message(); ?>

        <h2><?= t('Post Message'); ?></h2>

        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">
            <div class="dashboard border-top border-primary">
                <form method="post" action="<?php echo site_url('messages/create'); ?>">

                    <div class="row form-group">
                        <div class="col-sm-3 col-xs-12">
                            <label class="form-control-label"><?= t('From'); ?>:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <label class="form-control-label"><?php echo $this->outputData['logged_in_user']->full_name; ?></label>
                        </div>
                    </div>

                    <div class="row form-group">
						<?php echo form_error('job_id'); ?>
                        <div class="col-sm-3 col-xs-12">
                            <label class="form-control-label" for="job_id"><?= t('Project'); ?>:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <select class="form-control" name="job_id" id="job_id">
                                <option value="" class="list-default"><?= t('Select Project'); ?></option>
								<?php foreach ($this->outputData['projects'] as $project) { ?>
                                    <option value="<?php echo $project['id']; ?>" <?php if (set_value('job_id') == $project['id']) echo 'selected="selected"'; ?> ><?php echo $project['job_name']; ?></option>
								<?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
						<?php echo form_error('to_id'); ?>
                        <div class="col-sm-3 col-xs-12">
                            <label class="form-control-label" for="to_id"><?= t('To'); ?>:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <select class="form-control" name="to_id" id="to_id">
                                <option value="" class="list-default"><?= t('Everyone'); ?></option>
								<?php if (array_key_exists('to', $this->outputData)) foreach ($this->outputData['to'] as $to) { ?>
                                    <option value="<?php echo $to['id']; ?>" <?php if (set_value('to_id') == $to['id']) echo 'selected="selected"'; ?> ><?php echo $to['full_name']; ?></option>
								<?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
						<?php echo form_error('subject'); ?>
                        <div class="col-sm-3 col-xs-12">
                            <label class="form-control-label" for="subject"><?= t('Subject'); ?>:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <input class="form-control" name="subject" id="subject" value="<?php echo set_value('subject'); ?>"/>
                        </div>
                    </div>

                    <div class="row form-group">
						<?php echo form_error('message'); ?>
                        <div class="col-sm-3 col-xs-12">
                            <label class="form-control-label" for="message"><?= t('Message'); ?>:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <textarea class="form-control" rows="10" name="message" id="message"><?php echo set_value('message'); ?></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-9"></div>
                        <div class="col-sm-3 col-xs-12">
                            <input class="button big primary" type="submit" name="submit" value="<?= t('Submit'); ?>"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>

    function loadUsersPost()
    {
        jQuery.ajax({
            url: 'get_connected_users',
            data: {
                id: jQuery('#job_id').val()
            },
            success: loadUsers
        });
    }

    function loadUsers(response)
    {
        var list = jQuery('#job_id');
        var list_to = jQuery('#to_id');
        list_to.children(':not(:first)').remove();
        if (response != "")
        {
            var data = JSON.parse(response);
            for (var i = 0; i < data.length; i++)
            {
                list_to.append('<option value="'+data[i].id+'">'+data[i].full_name+'</option>');
            }
        }
    }

    jQuery(document).ready(function () {
        jQuery('#job_id').change(loadUsersPost);
    });

</script>

<?php $this->load->view('footer1'); ?>