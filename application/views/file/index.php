<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <?php flash_message(); ?>

        <div class="clearfix">

            <ul class="nav nav-tabs" id="tabs">
                <?php if (isEntrepreneur()) { ?>
                <li <?php if ($this->outputData['view'] == 'file/projects') echo 'class="active"'; ?> >
                    <a href="#" class="tab" data-tab="1"><?= t('Projects'); ?></a>
                </li>
                <?php } ?>
                <li <?php if ($this->outputData['view'] == 'file/templates') echo 'class="active"'; ?> >
                    <a href="#" class="tab" data-tab="2"><?= t('Templates'); ?></a>
                </li>
                <li <?php if ($this->outputData['view'] == 'file/terms') echo 'class="active"'; ?> >
                    <a href="#" class="tab" data-tab="3"><?= t('Terms and Conditions'); ?></a>
                </li>
            </ul>

            <div class="content" id="content">
                <?php $this->load->view($this->outputData['view']); ?>
            </div>

        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>