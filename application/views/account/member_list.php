<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                <div class="cls_page-title clearfix">
                    <h2>
                        <span class="clsMyOpen"><?= t(($this->outputData['mode'] == 'favorite') ? 'Add user to favorites' : 'Add user to banned list'); ?></span>
                    </h2>
                </div>

                <div class="dashboard border-top <?php echo ($this->outputData['mode'] == 'favorite') ? 'border-color-2' : 'border-danger'; ?> container-fluid">
                    <form method="post" name="form-add"
                          action="<?php echo site_url('account/' . (($this->outputData['mode'] == 'favorite') ? 'favorite_members' : 'banned_members')); ?>">
                        <?php echo form_error('name'); ?>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="name"
                                       class="form-control-label"><?= t('Full Name or Email:'); ?></label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <input style="position: inherit; z-index: 2; background: transparent;"
                                       name="nameAjax" id="js-autocomplete-ajax" class="form-control"
                                       value=""/>
                                <input type="hidden"
                                       value=""
                                       id="user_id" name="user_id"/>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <input type="submit" name="submit" class="button big primary"
                                       value="<?= t('Add Member'); ?>"/>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-xs-12">

                <div class="cls_page-title clearfix">
                    <h2>
                        <span class="clsMyOpen"><?= t(($this->outputData['mode'] == 'favorite') ? 'Manage favorite members' : 'Manage banned members'); ?></span>
                    </h2>
                </div>

                <div class="dashboard border-left container-fluid">

                    <div class="col-md-1 col-sm-1 col-xs-3">
                        <div class="form-group">
                            <label for="ratings" class="form-control-label"><?= t('Rating'); ?>:</label>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-9">
                        <div class="form-group">
                            <select name="ratings" id="ratings" class="form-control">
                                <option value=""><?= t('Select'); ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-1 col-xs-3">
                        <div class="form-group">
                            <label class="form-control-label"><?= t('Skill'); ?>:</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-9">
                        <div class="form-group">
                            <?php $this->load->view('multiselect'); ?>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2"></div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <input class="button big primary" type="button" id="search"
                                   value="<?= t('New Search'); ?>"/>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table" width="100%" cellspacing="0">
                        <thead data-field="" data-sort="">
                            <tr>
                                <th><?= t('Member Name'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                                               data-field="name" data-sort=""></span></th>
                                <th><?= t('Rating'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort"
                                                                          data-field="user_rating" data-sort=""></span></th>
                                <th><?= t('Categories'); ?></th>
                                <th><?= t('Account'); ?></th>
                                <th><?= t('Portfolio Details'); ?></th>
                                <th><?= t('Actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $this->load->view('account/member_list_table'); ?>
                        </tbody>
                    </table>
                    <?php $this->load->view('pagination'); ?>
                </div>

            </div>

        </div>

    </div>

    <script>

        function initShowMore() {
            var showChar = "<?= t('Show More'); ?>", hideChar = "<?= t('Show Less'); ?>";
            jQuery(".showmoretxt").click(function (e) {
                e.preventDefault();
                if (jQuery(this).hasClass("sample")) {
                    jQuery(this).removeClass("sample");
                    jQuery(this).text(showChar);
                } else {
                    jQuery(this).addClass("sample");
                    jQuery(this).text(hideChar);
                }
                jQuery(this).parent().prev().toggle();
                jQuery(this).prev().toggle();
                return false;
            });
        }

        function deleteMember(e) {
            e.preventDefault();
            var url = jQuery(this).attr('href');
            m.dialog({
                header: '<?= t('Remove from List'); ?>',
                body: '<?= t('Do you wish to remove member from list?'); ?>',
                btnOk: {
                    label: '<?= t('Yes'); ?>',
                    callback: function () {
                        m.post(url,
                            null,
                            function () {
                                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
                            }
                        );
                    }
                },
                btnCancel: {
                    label: '<?= t('No'); ?>'
                }
            });
        }

        jQuery(document).ready(function () {

            jQuery('#search').click(function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
            });

            pagination.init(
                "<?php echo site_url(($this->outputData['mode'] == 'favorite') ? 'account/favorite_members' : 'account/banned_members'); ?>",
                function () {
                    return {
                        rating: jQuery('#ratings').val(),
                        categories: jQuery("input[name='category[]']:checked").map(function () {
                            return this.value;
                        }).toArray()
                    }
                },
                function () {
                    jQuery('.delete-member').click(deleteMember);
                    initShowMore();
                }
            );

            jQuery('.delete-member').click(deleteMember);
            initShowMore();

            jQuery('[data-toggle="tooltip"]').tooltip();

        });

    </script>

<?php $this->load->view('footer1'); ?>