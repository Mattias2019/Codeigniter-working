<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <?php flash_message(); ?>

        <ul class="nav nav-tabs" id="tabs">
            <?php if (isEntrepreneur()) { ?>
            <li <?php if ($this->outputData['view'] == 'finance/calendar') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="1"><?= t('Payment Calendar'); ?></a>
            </li>
            <?php } ?>
            <?php if (isProvider()) { ?>
            <li <?php if ($this->outputData['view'] == 'finance/calendar') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="1"><?= t('Revenue Calendar'); ?></a>
            </li>
            <?php } ?>
            <li <?php if ($this->outputData['view'] == 'finance/invoice') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="2"><?= t('Invoices'); ?></a>
            </li>
            <li <?php if ($this->outputData['view'] == 'finance/tax') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="3"><?= t('Tax Manager'); ?></a>
            </li>
            <li <?php if ($this->outputData['view'] == 'finance/deposit') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="4"><?= t('Deposit'); ?></a>
            </li>
            <li <?php if ($this->outputData['view'] == 'finance/transfer') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="5"><?= t('Transfer'); ?></a>
            </li>
            <li <?php if ($this->outputData['view'] == 'finance/withdraw') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="6"><?= t('Withdraw'); ?></a>
            </li>
            <li <?php if ($this->outputData['view'] == 'finance/escrow') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="7"><?= t('Escrow'); ?></a>
            </li>
			<?php if (isEntrepreneur() && empty($this->config->item('disable_escrow'))) { ?>
            <li <?php if ($this->outputData['view'] == 'finance/escrow') echo 'class="active"'; ?> >
                <a href="#" class="tab" data-tab="7"><?= t('Escrow'); ?></a>
            </li>
			<?php } ?>
        </ul>

        <div class="content" id="content">
            <?php $this->load->view($this->outputData['view']); ?>
        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>