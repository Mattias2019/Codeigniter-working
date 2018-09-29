<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">

        <?php flash_message(); ?>

        <div class="page-content-wrapper col-md-12">
            <div class="page-content1 col-md-8">

                <?php if (isEntrepreneur()) { ?>

                <h2><?= t('Actions'); ?></h2>

                <div class="row">
                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard border-left border-color-2">
                            <a href="<?php echo site_url('finance/invoice'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <span class="dashboard-text-big text-color-2" data-counter="counterup" data-value="<?php echo count($this->outputData['invoices']); ?>"></span>
                                        <span class="text-uppercase">&nbsp;<?= t('Invoices'); ?></span>
                                    </div>
                                    <div class="progress bg-color-2">
                                    <span style="width: 76%;" class="progress-bar bg-color-2">
                                    </span>
                                    </div>
                                    <p></p>
                                </div>
                                <div class="progress-info">
                                    <div class="status">
                                        <p>
                                            <span class="dashboard-text-big"><?php echo currency(); ?></span>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_paid']); ?>"></span>
                                            <span class="text-uppercase">&nbsp;<?= t('Paid'); ?></span>
                                        </p>
                                        <p>
                                            <span class="dashboard-text-big"><?php echo currency(); ?></span>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_due']); ?>"></span>
                                            <span class="text-uppercase">&nbsp;<?= t('Due'); ?></span>
                                        </p>
                                        <p>
                                            <span class="dashboard-text-big"><?php echo currency(); ?></span>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_overdue']); ?>"></span>
                                            <span class="text-uppercase">&nbsp;<?= t('Overdue'); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">

                        <div class="dashboard border-left border-danger">
                            <a href="<?php echo site_url('cancel/index'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div>
                                            <span class="dashboard-text-big text-danger" data-counter="counterup" data-value="<?php echo count($this->outputData['cases']); ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Unresolved Disputes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-danger">
                                        <span style="width: 76%;" class="progress-bar bg-danger"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="dashboard border-left border-color-3">
                            <a href="<?php echo site_url('project/tender'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div>
                                            <span class="dashboard-text-big text-color-3" data-counter="counterup" data-value="<?php echo count($this->outputData['quotes']); ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Tender inbox'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-color-3">
                                        <span style="width: 76%;" class="progress-bar bg-color-3"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="dashboard border-left border-primary">
                            <a href="<?php echo site_url('project/project_list'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div>
                                            <span class="dashboard-text-big text-primary" data-counter="counterup" data-value="<?php echo $this->outputData['to_review']; ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Clients to be reviewed'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-primary">
                                        <span style="width: 76%;" class="progress-bar bg-primary"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12 cls_displaywid">
                        <div class="dashboard border-left border-color-4">
                            <a href="<?php echo site_url('project/project_list'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <span class="dashboard-text-big text-color-4" data-counter="counterup" data-value="<?php echo count($this->outputData['projects']); ?>">0</span>
                                        <span class="text-uppercase">&nbsp;<?= t('Project Timing'); ?></span>
                                    </div>
                                    <div class="progress bg-color-4">
                                        <span style="width: 76%;" class="progress-bar bg-color-4"></span>
                                    </div>
                                    <p></p>
                                </div>
                                <div class="progress-info">
                                    <div class="status">
                                        <p>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo $this->outputData['active_milestones']; ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Active Milestones'); ?></span>
                                        </p>
                                        <p>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo $this->outputData['due_milestones']; ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Due Milestones'); ?></span>
                                        </p>
                                        <p>
                                            <span class="dashboard-text-big" data-counter="counterup" data-value="<?php echo $this->outputData['to_review']; ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Clients to be reviewed'); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

                <h2><?= t('Finance'); ?></h2>

                <div class="row">
                    <div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard border-top border-color-2">

                            <form id="year-form" method="post" action="<?php echo site_url('account/dashboard'); ?>" enctype="multipart/form-data">
                                <div class="display">
                                    <div class="form-group">
                                        <span><?= t('Choose Year'); ?>:</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="year" class="yrselectdesc form-control" data-selected="<?php echo $this->outputData['year']; ?>"></select>
                                            <span class="dashboard-date-calendar"><?php echo svg("other/calendar", TRUE); ?></span>
                                        </div>
                                    </div>
                                    <p></p>
                                </div>
                            </form>

                            <a href="<?php echo site_url('finance/index'); ?>">
                                <div class="progress-info">
                                    <div class="status">
                                        <p>
                                        <span class="dashboard-text-big text-color-2">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_paid']); ?>">0</span>
                                        </span>
                                            <span class="text-uppercase">&nbsp;<?= t('Paid'); ?></span>
                                        </p>
                                        <p>
                                        <span class="dashboard-text-big text-color-6">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_due']); ?>">0</span>
                                        </span>
                                            <span class="text-uppercase">&nbsp;<?= t('Due'); ?></span>
                                        </p>
                                        <p>
                                        <span class="dashboard-text-big text-color-6">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_overdue']); ?>">0</span>
                                        </span>
                                            <span class="text-uppercase">&nbsp;<?= t('Overdue'); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-9 col-sm-6 col-xs-12">

                        <?php if (empty($this->config->item('disable_escrow'))) { ?>
                        <div class="dashboard border-left border-danger">
                            <a href="<?php echo site_url('finance/escrow'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div class="dashboard-text-big text-danger">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_escrow']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase"><?= t('Escrow account'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>

                        <div class="dashboard border-left border-color-6">
                            <a href="<?php echo site_url('finance/deposit'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div class="dashboard-text-big text-color-6">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['balance']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase"><?= t('Deposit account'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="dashboard border-left border-color-4">
                            <a href="<?php echo site_url('cancel/index'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div class="dashboard-text-big text-color-4">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_dispute']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase"><?= t('In dispute'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

				<?php } elseif (isProvider()) { ?>

                <h2><?= t('Payments'); ?></h2>

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="dashboard border-top border-color-2">

                            <form id="year-form" method="post" action="<?php echo site_url('account/dashboard'); ?>" enctype="multipart/form-data">
                                <div class="display">
                                    <div class="form-group">
                                        <span><?= t('Choose Year'); ?>:</span>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="year" class="yrselectdesc form-control" data-selected="<?php echo $this->outputData['year']; ?>"></select>
                                            <span class="dashboard-date-calendar"><?php echo svg("other/calendar", TRUE); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <a href="<?php echo site_url('finance/index'); ?>">
                                <div class="progress-info">
                                    <div class="status">
                                        <div class="dashboard-text-big text-color-2 text-center">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_paid']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase text-center"><?= t('Earnings/Payments'); ?></div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>

                    <div class="col-lg-6 col-md-9 col-sm-6 col-xs-12">

						<?php if (empty($this->config->item('disable_escrow'))) { ?>
                        <div class="dashboard border-left border-danger">
                            <a href="<?php echo site_url('finance/escrow'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div class="dashboard-text-big text-danger">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['invoice_escrow']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase"><?= t('Escrow account'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>

                        <div class="dashboard border-left border-color-6">
                            <a href="<?php echo site_url('finance/deposit'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div class="dashboard-text-big text-color-6">
                                            <span><?php echo currency(); ?></span>
                                            <span data-counter="counterup" data-value="<?php echo number_format($this->outputData['balance']); ?>">0</span>
                                        </div>
                                        <div class="text-uppercase"><?= t('Deposit account'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>

                <h2><?= t('Actions'); ?></h2>

                <div class="row">

                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard bordered-left border-color-2">
                            <a href="<?php echo site_url('finance/invoice'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <span class="dashboard-text-big text-color-2" data-counter="counterup" data-value="<?php echo count($this->outputData['invoices']); ?>">0</span>
                                        <span class="text-uppercase">&nbsp;<?= t('Invoices'); ?></span>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-color-2">
                                        <span style="width: 76%;" class="progress-bar bg-color-2"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard border-left border-danger">
                            <a href="<?php echo site_url('cancel/index'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div>
                                            <span class="dashboard-text-big text-danger" data-counter="counterup" data-value="<?php echo count($this->outputData['cases']); ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Unresolved Disputes'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-danger">
                                        <span style="width: 76%;" class="progress-bar bg-danger"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                        <div class="dashboard border-left border-primary">
                            <a href="<?php echo site_url('project/project_list'); ?>">
                                <div class="display">
                                    <div class="number">
                                        <div>
                                            <span class="dashboard-text-big text-primary" data-counter="counterup" data-value="<?php echo $this->outputData['to_review']; ?>">0</span>
                                            <span class="text-uppercase">&nbsp;<?= t('Clients to be reviewed'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-info">
                                    <div class="progress bg-primary">
                                        <span style="width: 76%;" class="progress-bar bg-primary"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

			    <?php } ?>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <?php $this->load->view('account/dashboard_map'); ?>
                    </div>
                </div>

                <h2><?= t('Projects'); ?></h2>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet box">
                            <div class="panel-group accordion" id="accordion3">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">
                                                <?php echo svg('dashboard/active-projects', TRUE); ?>
                                                <span class="panel-title"><?= t('Active Projects'); ?></span>
                                                <span class="badge"><?php echo count($this->outputData['projects']); ?></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_1" class="panel-collapse collapse in">
                                        <table class="table table-striped">
                                            <colgroup>
                                                <col width="4%"/>
                                                <col width="10%"/>
                                                <col width="20%"/>
                                                <col width="35%"/>
                                                <col width="19%"/>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><?= t('#'); ?></th>
                                                <th><?= t('Name'); ?></th>
                                                <th><?= t('Description'); ?></th>
                                                <th><?= t('Amount'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($this->outputData['projects'] as $i => $project) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><a href="<?php echo site_url('project/view?id=').$project['id']; ?>"><?php echo $project['job_name']; ?></a></td>
                                                    <td><?php echo $project['description']; ?></td>
                                                    <td><?php echo currency().number_format($project['budget_min']); ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2">
												<?php echo svg('dashboard/job-offers', TRUE); ?>
                                                <span class="panel-title"><?= t('Quotes Inbox'); ?></span>
                                                <span class="badge"><?php echo count($this->outputData['quotes']); ?></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_2" class="panel-collapse collapse">
                                        <table class="table table-striped">
                                            <colgroup>
                                                <col width="4%"/>
                                                <col width="10%"/>
                                                <col width="20%"/>
                                                <col width="35%"/>
                                                <col width="19%"/>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><?= t('#'); ?></th>
                                                <th><?= t('Name'); ?></th>
                                                <th><?= t('Description'); ?></th>
                                                <th><?= t('Amount'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php foreach ($this->outputData['quotes'] as $i => $quote) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><a href="<?php echo site_url('project/tender'); ?>"><?php echo $quote['job_name']; ?></a></td>
                                                    <td><?php echo $quote['description']; ?></td>
                                                    <td><?php echo currency().number_format($quote['amount']); ?></td>
                                                </tr>
											<?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3">
												<?php echo svg('dashboard/open-inv', TRUE); ?>
                                                <span class="panel-title"><?= t('Open Invoices'); ?></span>
                                                <span class="badge"><?php echo count($this->outputData['invoices']); ?></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_3" class="panel-collapse collapse">
                                        <table class="table table-striped">
                                            <colgroup>
                                                <col width="4%"/>
                                                <col width="10%"/>
                                                <col width="20%"/>
                                                <col width="20%"/>
                                                <col width="20%"/>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th><?= t('#'); ?></th>
                                                <th><?= t('Name'); ?></th>
                                                <th><?= t('Amount'); ?></th>
                                                <th><?= t('Billing Date'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
											<?php foreach ($this->outputData['invoices'] as $i => $invoice) { ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php echo $i+1; ?></td>
                                                    <td><a href="<?php echo site_url('finance/invoice_pdf?project=').$invoice['job_id']; ?>"><?php echo $invoice['job_name']; ?></td>
                                                    <td><?php echo currency().number_format($invoice['amount']); ?></td>
                                                    <td><?php echo date('Y/m/d', $invoice['billing_date']); ?></td>
                                                </tr>
											<?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet-body">
                            <div class="tabbable-custom">

                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab" class="text-uppercase"><?= t('Client Review'); ?></a>
                                    </li>
                                    <li>
                                        <a href="#tab_5_2" data-toggle="tab" class="text-uppercase"><?= t('Unresolved Disputes'); ?></a>
                                    </li>
                                </ul>

                                <div class="tab-content content">

                                    <div class="tab-pane active" id="tab_5_1">
                                        <div class="row">
                                            <div class="col-md-12 cls_slider1">
                                                <div id="quote-carousel">
                                                    <?php foreach ($this->outputData['reviews'] as $key => $review) { ?>
                                                        <div class="item <?php if ($key == 0) echo 'active'; ?>">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                                    <img class="img-circle" src="<?php echo $review['reviewer_logo']; ?>">
                                                                    <p class="quote-author"><?php echo $review['reviewer_name']; ?></p>
                                                                </div>
                                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                                    <p class="quote-body"><?php echo $review['comments']; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab_5_2">
                                        <?php foreach ($this->outputData['cases'] as $case) { ?>
                                            <p><a href="<?php echo site_url('cancel?id='.$case['job_id']); ?>"><?php echo $case['job_name'].': '.$case['case_type_name']; ?></a></p>
                                        <?php } ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="page-right-content col-md-4">

				<?php $this->load->view('account/index_rating'); ?>

                <div class="row">

                    <div class="col-xs-12">

                        <div class="tabbable tabbable-tabdrop">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab1" data-toggle="tab" class="uppercase"><?= t('News'); ?></a>
                                </li>
                                <li>
                                    <a href="#tab2" data-toggle="tab" class="uppercase"><?= t('Reviews'); ?></a>
                                </li>
                            </ul>
                            <div class="tab-content content">
                                <div class="tab-pane active" id="tab1">
                                    <ul class="news-list">
                                        <?php $this->load->view('account/dashboard_news', $this->outputData); ?>
                                    </ul>
                                    <p class="load-more load-more-news">
                                        <a>
                                            <span><?= t('Load More'); ?></span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    </p>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <ul class="reviews-list">
										<?php $this->load->view('account/dashboard_reviews', $this->outputData); ?>
                                    </ul>
                                    <p class="load-more load-more-reviews">
                                        <a>
                                            <span><?= t('Load More'); ?></span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>

        function showNewsReviews(e) {
            jQuery(this).find('.news-body, .reviews-body').toggleClass('hidden');
            jQuery(this).find('.news-body-full, .reviews-body-full').toggleClass('hidden');
        }

        function loadMoreNews(e) {
            var offset = jQuery('.news-list').find('li').length;
            m.post(
                "<?php echo site_url('account/dashboard_load_news'); ?>",
                {
                    offset: offset
                },
                function (data) {
                    jQuery('.news-list').append(data.news);
                    jQuery('.news-item').click(showNewsReviews);
                }
            );
        }

        function loadMoreReviews(e) {
            var offset = jQuery('.reviews-list').find('li').length;
            m.post(
                "<?php echo site_url('account/dashboard_load_reviews'); ?>",
                {
                    offset: offset
                },
                function (data) {
                    jQuery('.reviews-list').append(data.reviews);
                    jQuery('.reviews-item').click(showNewsReviews);
                }
            );
        }

        $(document).ready(function () {

            makeMap();

            jQuery('#quote-carousel').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 513,
                        settings: {
                            arrows: false
                        }
                    }
                ]
            });

            var year_select = jQuery('.yrselectdesc');
            year_select.yearselect({order: 'desc'});
            year_select.change(function () {
                jQuery('#year-form').submit();
            });

            var dt = new Date();
            $(".datetime").text((("0" + dt.getHours()).slice(-2)) + ":" + (("0" + dt.getMinutes()).slice(-2)) + " " + (("0" + (dt.getDate() + 1)).slice(-2)) + "/" + (("0" + dt.getMonth()).slice(-2)) + "/" + (dt.getFullYear()));

            jQuery(".rating").each(function (key, data) {
                jQuery(data).rateYo({
                    rating: jQuery(data).parent().find('.rating-value').val(),
                    starWidth: "16px",
                    ratedFill: jQuery(data).hasClass('review-rating')?"#1e88e5":"#ffca28",
                    normalFill: "#e0e0e0",
                    readOnly: true
                });
            });

            jQuery('.news-item, .reviews-item').click(showNewsReviews);
            jQuery('.load-more-news').click(loadMoreNews);
            jQuery('.load-more-reviews').click(loadMoreReviews);

        });

    </script>

<?php $this->load->view('footer1'); ?>