<?php $project = $this->outputData['project']; ?>
<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="col-xs-12">
                <div class="cls_page-title">
                    <h2><?= t('Project Details'); ?></h2>
                </div>
                <div class="dashboard-stat2 left_green project-title">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Project'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $project['job_name']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Client'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $this->outputData['client']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Description'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $this->outputData['project']['description']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Budget'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo currency().number_format($this->outputData['project']['budget_min']); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Due Date'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo date('Y/m/d', $this->outputData['project']['due_date']); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('Country'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $this->outputData['project']['country_name']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('State/Province'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $this->outputData['project']['state']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <span><b><?= t('City'); ?>:</b></span>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
                            <span><?php echo $this->outputData['project']['city']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row">
                        <?php if ($project['job_status'] < 3) { ?>
                            <div class="col-xs-3">
                                <a class="button big secondary" href="<?php echo site_url('project/quote?id='.$project['id']); ?>"><?= t('Quote'); ?></a>
                            </div>
                        <?php } elseif ($project['job_status'] == 4) { ?>
                            <div class="col-xs-3">
                                <a class="button big primary" href="<?php echo site_url('cancel/create?id='.$project['id']); ?>"><?= t('Open Case'); ?></a>
                            </div>
                            <?php if ($project['creator_id'] == $this->outputData['logged_in_user']->id) { ?>
                                <div class="col-xs-3">
                                    <a class="button big secondary" href="<?php echo site_url('project/close?id='.$project['id']); ?>"><?= t('Close Project'); ?></a>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($project['job_status'] >= 4 and $project['creator_id'] == $this->logged_in_user->id) { ?>
                            <div class="col-xs-3">
                                <a class="button big primary" href="<?php echo site_url('project/review?id='.$project['id']); ?>"><?= t('Review Project'); ?></a>
                            </div>
                        <?php } elseif ($project['job_status'] >= 4 and $project['employee_id'] == $this->logged_in_user->id) { ?>
                            <div class="col-xs-3">
                                <a class="button big primary" href="<?php echo site_url('project/invoice?project='.$project['id']); ?>"><?= t('Send Invoice'); ?></a>
                            </div>
                        <?php } ?>
                    </div>
            </div>

            <?php if (count($project['milestones']) > 0) { ?>

            <div class="col-xs-12">
                <div class="cls_page-title">
                    <h3><?= t('Project Milestones'); ?></h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead data-field="" data-sort="">
                        <tr>
                            <th><?= t('#'); ?></th>
                            <th><?= t('Milestone'); ?></th>
                            <th><?= t('Description'); ?></th>
                            <th><?= t('Budget'); ?></th>
                            <th><?= t('Start Date'); ?></th>
                            <th><?= t('Due Date'); ?></th>
                            <th><?= t('Completion'); ?></th>
                            <th><?= t('Status'); ?></th>
                            <th><?= t('Assigned To'); ?></th>
                            <th><?= t('Action'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $this->load->view('project/view_milestone_table'); ?>
                        </tbody>
                    </table>
                    <?php
                    $this->outputData['pagination'] = $this->outputData['milestones_pagination'];
                    $this->load->view('pagination', $this->outputData);
                    ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="cls_page-title">
                    <h3><?= t('Activity'); ?></h3>
                </div>
                <div id="milestones-chart" style="width: 100%; height: <?php echo count($this->outputData['milestones'])*100; ?>px"></div>
            </div>

            <?php } if (count($this->outputData['messages']) > 0) { ?>

            <div class="col-lg-8 col-md-9 col-sm-12 col-xs-12">
                <div class="cls_page-title">
                    <h3><?= t('Project Messages'); ?></h3>
                </div>
                <table class="table">
                    <thead data-field="" data-sort="">
                        <tr>
                            <th>
                                <span class="icon-svg-img"><?php echo svg('messages/from', TRUE) ?></span>&nbsp;
                                <?= t('From'); ?>&nbsp;
                                <span role="button" class="table-sort fa fa-sort" data-field="from_name" data-sort=""></span>
                            </th>
                            <th>
                                <span class="icon-svg-img"><?php echo svg('messages/from', TRUE) ?></span>&nbsp;
                                <?= t('To'); ?>&nbsp;
                                <span role="button" class="table-sort fa fa-sort" data-field="to_name" data-sort=""></span>
                            </th>
                            <th>
                                <span class="icon-svg-img"><?php echo svg('messages/subject', TRUE) ?></span>&nbsp;
                                <?= t('Subject'); ?>&nbsp;
                                <span role="button" class="table-sort fa fa-sort" data-field="subject" data-sort=""></span>
                            </th>
                            <th>
                                <span class="icon-svg-img"><?php echo svg('messages/data', TRUE) ?></span>&nbsp;
                                <?= t('Date/Time'); ?>&nbsp;
                                <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $this->load->view('project/view_messages'); ?>
                    </tbody>
                </table>
                <?php
                $this->outputData['pagination'] = $this->outputData['messages_pagination'];
                $this->load->view('pagination', $this->outputData);
                ?>
            </div>

            <?php } ?>

            <div class="col-xs-12">
                <div class="cls_page-title">
                    <h3><?= t('Project Attachments'); ?></h3>
                </div>
                <?php
                foreach ($project['attachments'] as $this->outputData['attachment'])
                {
                    $this->load->view('project/view_attachment', $this->outputData);
                }
                ?>
            </div>

        </div>
    </div>

    <script>

        function loadProgressBar()
        {
            jQuery(".progress-bar").loading();
        }

        function milestonesChart()
        {
            var chart = AmCharts.makeChart(
                "milestones-chart",
                {
                    "type": "serial",
                    "autoMargins": false,
                    "marginLeft": 300,
                    "marginRight": 0,
                    "categoryField": "category",
                    "dataDateFormat": "YYYY/MM/DD",
                    "rotate": true,
                    "colors": [
                        "#1E88E5"
                    ],
                    "plotAreaFillAlphas": 1,
                    "zoomOutButtonImage": "",
                    "zoomOutButtonRollOverAlpha": 0,
                    "zoomOutText": "",
                    "addClassNames": true,
                    "backgroundColor": "#ECEFF2",
                    "fontFamily": "Lato, sans-serif",
                    "fontSize": 16,
                    "categoryAxis": {
                        "gridPosition": "start",
                        "gridAlpha": 1,
                        "gridColor": "#ECEFF2",
                        "axisAlpha": 0,
                        "tickLength": 300
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "balloonText": "[[category]]",
                            "closeField": "close",
                            "cornerRadiusTop": 15,
                            "fillAlphas": 1,
                            "fixedColumnWidth": 30,
                            "id": "timeline",
                            "openField": "open",
                            "title": "timeline",
                            "type": "column"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "time",
                            "position": "top",
                            "stackType": "regular",
                            "type": "date",
                            "autoGridCount": true,
                            "axisAlpha": 0,
                            "boldPeriodBeginning": false,
                            "color": "#BDBDBD",
                            "gridAlpha": 1,
                            "gridColor": "#ECEFF2",
                            "markPeriodChange": false,
                            "minorGridAlpha": 1,
                            "minorGridEnabled": true,
                            "title": "",
                            "titleBold": false
                        }
                    ],
                    "allLabels": [],
                    "balloon": {},
                    "titles": [],
                    "dataProvider": <?php echo $this->outputData['milestones_chart']; ?>
                }
            );

            chart.addListener("drawn", function () {
                chart.clearLabels();
                var labels = $('#milestones-chart').find('.amcharts-category-axis .amcharts-axis-label');
                var l = labels.length;
                var data = chart.dataProvider;
                for (var i = 0; i < l; i++) {
                    var str = $(labels[i]).attr("transform");
                    var y = Number(str.substring(str.lastIndexOf(",")+1,str.lastIndexOf(")")));
                    if (!y) {
                        y = Number(str.substring(str.lastIndexOf(" ")+1,str.lastIndexOf(")")));
                    }
                    var label1 = chart.addLabel(10, y+10, data[i].category, "left", 16, "#000000", 0, 1, true);
                }
            });
        }

        jQuery(document).ready(function(){

            jQuery('[data-toggle="tooltip"]').tooltip();

            loadProgressBar();
            milestonesChart();

        });

    </script>

<?php $this->load->view('footer1'); ?>