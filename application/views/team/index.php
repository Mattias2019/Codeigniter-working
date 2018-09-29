<?php $this->load->view('header1'); ?>

<?php
    if (isset($this->outputData['member'])) {
        $new_member = false;
    }
    else {
        $new_member = true;
    }
?>
    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="col-md-8 col-sm-8 col-xs-12">

                <div class="cls_page-title clearfix">
                    <h2><?= t('Add Existing User To Your Team'); ?></h2>
                </div>

                <div class="dashboard border-top border-color-2 container-fluid">
                    <form id="team-form" action="<?php echo site_url('team/index'); ?>" method="post">

                        <input type="hidden" name="id" id="id" value="<?php echo set_value('id', !$new_member?$this->outputData['member']['id']:null); ?>"/>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row form-group">
                                    <?php echo form_error('name'); ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="name"
                                               class="form-control-label"><?= t('Full Name or Email:'); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                        <input name="nameAjax" id="js-autocomplete-ajax" class="form-control"
                                               value="<?php echo set_value('name',!$new_member?$this->outputData['member']['name']:null); ?>" <?php if (!$new_member) echo 'disabled="disabled"'; ?> />
                                        <input type="hidden"
                                               value="<?php echo set_value('user_id',!$new_member?$this->outputData['member']['user_id']:null); ?>"
                                               id="user_id" name="user_id"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row form-group">
                                    <?php echo form_error('group_id'); ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="group_id"
                                               class="form-control-label"><?= t('Group:'); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <select name="group_id" id="group_id" class="form-control">
                                            <option value="">-- <?= t('Select Group'); ?> --</option>
                                            <?php foreach ($this->outputData['groups'] as $group) { ?>
                                                <option value="<?php echo $group['id']; ?>" <?php if (set_value('group_id',!$new_member?$this->outputData['member']['group_id']:null) == $group['id']) echo 'selected="selected"'; ?> ><?php echo $group['group_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row form-group">
                                    <?php echo form_error('job_title'); ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="job_title"
                                               class="form-control-label"><?= t('Job Title:'); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <input name="job_title" id="job_title" class="form-control"
                                               value="<?php echo set_value('job_title',!$new_member?$this->outputData['member']['job_title']:null); ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row form-group">
                                    <?php echo form_error('telephone'); ?>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <label for="telephone"
                                               class="form-control-label"><?= t('Telephone:'); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                        <input name="telephone" id="telephone" class="form-control"
                                               value="<?php echo set_value('telephone', !$new_member?$this->outputData['member']['telephone']:null); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row form-group">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="pull-right">
                                            <a class="clear-all">
                                                <span class="icon-svg-img">
                                                    <?php echo svg('table-buttons/delete-inverse', TRUE); ?>
                                                </span>&nbsp;<?= t('Clear All'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <input type="submit" name="submit" class="button big primary"
                                               value="<?= t(!$new_member ? 'Update User' : 'Add New User'); ?>"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="cls_page-title clearfix">
                    <h2><?= t('Invite a team member by mail'); ?></h2>
                </div>

                <div class="dashboard border-top border-color-2 container-fluid">
                    <form id="team-form" action="<?php echo site_url('team/index'); ?>" method="post">

                        <div class="row form-group">
                            <?php echo form_error('invite_email'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="invite_email" class="form-control-label"><?= t('Email:'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="invite_email" id="invite_email" class="form-control"/>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('invite_group_id'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="invite_group" class="form-control-label"><?= t('Group:'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <select name="invite_group_id" id="invite_group_id" class="form-control">
                                    <option value="">-- <?= t('Select Group'); ?> --</option>
                                    <?php foreach ($this->outputData['groups'] as $group) { ?>
                                        <option value="<?php echo $group['id']; ?>" <?php if (set_value('group_id', !$new_member?$this->outputData['member']['group_id']:null) == $group['id']) echo 'selected="selected"'; ?> ><?php echo $group['group_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="row form-group">
                            <?php echo form_error('invite_subject'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="invite_subject"
                                       class="form-control-label"><?= t('Subject:'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <input name="invite_subject" id="invite_subject" class="form-control"
                                       value="<?php pifset($this->outputData['mail'], 'subject'); ?>"/>
                            </div>
                        </div>

                        <div class="row form-group">
                            <?php echo form_error('invite_text'); ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <label for="invite_text"
                                       class="form-control-label"><?= t('Invitation:'); ?></label>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                <textarea rows="3" name="invite_text" id="invite_text"
                                          class="form-control"><?php pifset($this->outputData['mail'], 'custom_message'); ?></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="pull-right">
                                    <a class="clear-all"><span
                                                class="icon-svg-img"><?php echo svg('table-buttons/delete-inverse', TRUE); ?></span>&nbsp;<?= t('Clear All'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <input type="submit" name="submit_invite" class="button big primary"
                                       value="<?= t('Send'); ?>"/>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

            <div class="col-xs-12">

                <div class="cls_page-title clearfix">
                    <h2><?= t('Manage Your Company Team'); ?></h2>
                </div>

                <div class="dashboard border-top border-primary container-fluid">

                    <div class="col-md-1 col-sm-1 col-xs-3">
                        <div class="form-group">
                            <label for="search_name" class="form-control-label"><?= t('Full Name'); ?>:</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-9">
                        <div class="form-group">
                            <input name="search_name" id="search_name" class="form-control"/>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-3">
                        <div class="form-group">
                            <label for="search_group" class="form-control-label"><?= t('Group'); ?>:</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-9">
                        <div class="form-group">
                            <select name="search_group" id="search_group" class="form-control">
                                <option value="">-- <?= t('Select Group'); ?> --</option>
                                <?php foreach ($this->outputData['groups'] as $group) { ?>
                                    <option value="<?php echo $group['id']; ?>"><?php echo $group['group_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-3">
                        <div class="form-group">
                            <label for="search_email" class="form-control-label"><?= t('Email'); ?>:</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-9">
                        <div class="form-group">
                            <input name="search_email" id="search_email" class="form-control"/>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table" width="100%" cellspacing="0">
                        <thead data-field="" data-sort="">
                            <tr>
                                <th><?= t('Pic'); ?></th>
                                <th><?= t('Full Name'); ?><span role="button" class="table-sort fa fa-sort"
                                                                       data-field="full_name" data-sort=""></span></th>
                                <th><?= t('Group'); ?><span role="button" class="table-sort fa fa-sort"
                                                                   data-field="g.group_name" data-sort=""></span></th>
                                <th><?= t('Telephone'); ?><span role="button" class="table-sort fa fa-sort"
                                                                       data-field="m.telephone" data-sort=""></span></th>
                                <th><?= t('Email Address'); ?><span role="button" class="table-sort fa fa-sort"
                                                                           data-field="u.email" data-sort=""></span></th>
                                <th><?= t('Job Title'); ?><span role="button" class="table-sort fa fa-sort"
                                                                       data-field="m.job_title" data-sort=""></span></th>
                                <th><?= t('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->load->view('team/index_table'); ?>
                        </tbody>
                    </table>
                    <?php $this->load->view('pagination', $this->outputData); ?>
                </div>

            </div>

        </div>
    </div>

    <script>

        function deleteMember(e) {
            e.preventDefault();
            var url = jQuery(this).attr('href');
            m.dialog({
                header: '<?= t('Delete member'); ?>',
                body: '<?= t('Do you wish to delete team member?'); ?>',
                btnOk: {
                    label: '<?= t('Yes'); ?>',
                    callback: function () {
                        m.post(url, null, function (result) {
                            jQuery('tr[data-id=' + result.id + ']').remove();
                        });
                    }
                },
                btnCancel: {
                    label: '<?= t('No'); ?>'
                }
            });
        }

        function clearAll(e) {
            e.preventDefault();
            jQuery(this).closest('form').find('input[type!=submit]').val('');
            jQuery(this).closest('form').find('select').val('');
            jQuery(this).closest('form').find('textarea').val('');
        }

        jQuery(document).ready(function () {

            pagination.init(
                "<?php echo site_url('team/index'); ?>",
                function () {
                    return {
                        search_name: jQuery('#search_name').val(),
                        search_group: jQuery('#search_group').val(),
                        search_email: jQuery('#search_email').val()
                    }
                },
                function () {
                    jQuery('.delete-member').click(deleteMember);
                }
            );

            jQuery('#search_name, #search_group, #search_email').change(function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
            });

            jQuery('.delete-member').click(deleteMember);

            jQuery('[data-toggle="tooltip"]').tooltip();
            jQuery('.clear-all').click(clearAll);

        });

    </script>

<?php $this->load->view('footer1'); ?>