<?php $this->load->view('header'); ?>

    <div class="container">
        <?php
        $msg = new \Plasticbrain\FlashMessages\FlashMessages();
        ?>
        <?= $msg->display($msg::SUCCESS) ?>
        <?= $msg->display($msg::ERROR) ?>
    </div>

<?php $this->load->view('footer'); ?>