<?php $this->load->view('header1'); ?>

    <h2>View Transactions</h2>

            <?php flash_message(); ?>

            <ul id="tabs" class="nav nav-tabs">
                <li class="active">
                    <a href="#" class="tab" data-tab="1"><?= t('View All'); ?></a>
                </li>
                <li>
                    <a href="#" class="tab" data-tab="2"><?= t('Add Transaction'); ?></a>
                </li>
            </ul>

            <div class="container-fluid content" id="content">
                <?php $this->load->view($this->outputData['view']); ?>
            </div>

<?php $this->load->view('footer1'); ?>