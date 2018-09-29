<?php $this->load->view('header1'); ?>

    <h2><span><?= t('View My Projects'); ?></span></h2>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

			<?php flash_message(); ?>

            <ul id="tabs" class="nav nav-tabs">
                <li <?php if ($this->outputData['view'] == 'project/list_active') echo 'class="active"'; ?> >
                    <a href="#active" data-toggle="tab" data-tab="1">
                        <div class="project-svg"><?php echo svg('projects/active', TRUE); ?></div>
                        <div class="project-label-number"><?php echo $this->outputData['number_active']; ?></div>
                        <div class="project-label"><?= t('Active Projects'); ?></div>
                    </a>
                </li>

                <?php if (isProvider()) { ?>
                    <li <?php if ($this->outputData['view'] == 'project/list_won') echo 'class="active"'; ?> >
                        <a href="#won" data-toggle="tab" data-tab="2">
                            <div class="project-svg"><?php echo svg('projects/won', TRUE); ?></div>
                            <div class="project-label-number"><?php echo $this->outputData['number_won']; ?></div>
                            <div class="project-label"><?= t('Won Quotes'); ?></div>
                        </a>
                    </li>
                    <li <?php if ($this->outputData['view'] == 'project/list_pending') echo 'class="active"'; ?> >
                        <a href="#pending" data-toggle="tab" data-tab="3">
                            <div class="project-svg"><?php echo svg('projects/pending', TRUE); ?></div>
                            <div class="project-label-number"><?php echo $this->outputData['number_pending']; ?></div>
                            <div class="project-label"><?= t('Pending Quotes'); ?></div>
                        </a>
                    </li>
                <?php } ?>

                <li <?php if ($this->outputData['view'] == 'project/list_completed') echo 'class="active"'; ?> >
                    <a href="#completed" data-toggle="tab" data-tab="4">
                        <div class="project-svg"><?php echo svg('projects/completed', TRUE); ?></div>
                        <div class="project-label-number"><?php echo $this->outputData['number_completed']; ?></div>
                        <div class="project-label"><?= t('Completed Projects'); ?></div>
                    </a>
                </li>
                <li <?php if ($this->outputData['view'] == 'project/list_canceled') echo 'class="active"'; ?> >
                    <a href="#canceled" data-toggle="tab" data-tab="5">
                        <div class="project-svg"><?php echo svg('projects/canceled', TRUE); ?></div>
                        <div class="project-label-number"><?php echo $this->outputData['number_canceled']; ?></div>
                        <div class="project-label"><?= t('Canceled Projects'); ?></div>
                    </a>
                </li>
            </ul>

            <div class="content" id="content">
                <div class="tab-content">
                    <div id="active" class="tab-pane <?php if ($this->outputData['view'] == 'project/list_active') echo 'active'; ?>">
                        <?php $this->load->view('project/list_active', $this->outputData); ?>
                    </div>

                    <?php if (isProvider()) { ?>
                        <div id="won" class="tab-pane <?php if ($this->outputData['view'] == 'project/list_won') echo 'active'; ?>">
                            <?php $this->load->view('project/list_won', $this->outputData); ?>
                        </div>
                        <div id="pending" class="tab-pane <?php if ($this->outputData['view'] == 'project/list_pending') echo 'active'; ?>">
                            <?php $this->load->view('project/list_pending', $this->outputData); ?>
                        </div>
                    <?php } ?>

                    <div id="completed" class="tab-pane <?php if ($this->outputData['view'] == 'project/list_completed') echo 'active'; ?>">
                        <?php $this->load->view('project/list_completed', $this->outputData); ?>
                    </div>
                    <div id="canceled" class="tab-pane <?php if ($this->outputData['view'] == 'project/list_canceled') echo 'active'; ?>">
                        <?php $this->load->view('project/list_canceled', $this->outputData); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php $this->load->view('footer1'); ?>