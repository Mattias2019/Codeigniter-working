<?php $this->load->view('header1'); ?>

    <ul class="nav nav-tabs tabs-up" id="friends">
        <li <?php if ($this->outputData['view'] == 'account/settings/user_account') echo 'class="active"'; ?>>
            <a
                    href="<?php echo site_url().'/account/edit'?>"
                    data-id = "1"
                    data-target="#user_account"
                    class="tab"
                    data-toggle="tab_ajax">
                <?php echo t('account')?>
            </a>
        </li>
        <li <?php if ($this->outputData['view'] == 'account/settings/bank_info') echo 'class="active"'; ?>>
            <a
                    href="<?php echo site_url().'/account/edit'?>"
                    data-id = "2"
                    data-target="#bank_account"
                    class="tab"
                    data-toggle="tab_ajax">
                <?php echo t('bank')?>
            </a>
        </li>
        <li <?php if ($this->outputData['view'] == 'account/settings/paypal') echo 'class="active"'; ?>>
            <a
                    href="<?php echo site_url().'/account/edit'?>"
                    data-id = "3"
                    data-target="#paypal"
                    class="tab"
                    data-toggle="tab_ajax">
                <?php echo t('paypal')?>
            </a>
        </li>
    </ul>

    <div class="content" id="content">
        <?php $this->load->view($this->outputData['view']); ?>
    </div>

    <script>

        $('[data-toggle="tab_ajax"]').click(function(e) {
            account_edit.launchSubmit();
            var url = $(this).attr('href');
            var segment = $(this).attr('data-id');
            if(segment != 1){
                $.ajax({
                    method: "POST",
                    url: url,
                    data: 'segment='+segment,
                    success: function(data) {
                        var data = JSON.parse(data);
                        if(!data.error){
                            $("#content").html(data.html);
                            init_drop_down();

                        }
                    }
                });
            } else {
                location.href=url;
            }


            $(this).tab('show');

            return false;
        });
    </script>


    <?php flash_message(); ?>



<?php $this->load->view('footer1'); ?>