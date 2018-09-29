<?php $this->load->view('header1'); ?>

    <h2><?= t('rss_feeds'); ?></h2>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <ul id="tabs" class="nav nav-tabs">
                <li <?php if ($this->outputData['view'] == 'rss/index_all') echo 'class="active"' ?> >
                    <a href="#" class="tab" data-tab="1"><?= t('Tender Feed'); ?></a>
                </li>
                <li <?php if ($this->outputData['view'] == 'rss/index_custom') echo 'class="active"' ?> >
                    <a href="#" class="tab" data-tab="2"><?= t('Custom Tender Feed'); ?></a>
                </li>
            </ul>

            <div id="content" class="content">
                <?php $this->load->view($this->outputData['view']); ?>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>