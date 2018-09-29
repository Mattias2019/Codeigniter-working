
<div class="viewProjectForm">

    <input type="hidden" id="job_id" value="<?php echo $project['id']; ?>"/>

    <div class="row form-group">
        <div class="col-xs-12">
            <strong><?php echo $project['job_name']; ?>&nbsp;</strong>
            <span class="project-status <?php echo $project['status']['class']; ?>"><?php echo $project['status']['name']; ?>&nbsp;</span>
            <?php if ($project['is_urgent']) { ?>
                <span class="cls_urgent"><?= t('Urgent'); ?></span>
            <?php } ?>
            <?php if ($project['is_feature']) { ?>
                <span class="cls_fetur"><?= t('Featured'); ?></span>
            <?php } ?>
            <?php if ($project['is_private']) { ?>
                <span class="cls_prvt"><?= t('Private'); ?></span>
            <?php } ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <?php
            foreach ($project['attachments'] as $this->outputData['attachment'])
            {
                $this->load->view('project/view_attachment', $this->outputData);
            }
            ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <ul>
                <?php foreach ($project['categories_all'] as $category) { ?>
                    <li><?php echo $category['group_name'].': '.$category['category_name']; ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <span><?php echo $project['description']; ?></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <span><?= t('Budget'); ?>: <?php echo currency().number_format($project['budget_min']); ?></span>
        </div>
        <div class="col-xs-12">
            <span><?= t('Due In'); ?>: <?php echo $project['due_date'] > 0 ? date('Y-m-d', $project['due_date']) : ''; ?></span>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <span><?php echo $project['country_name']; ?></span>
        </div>
        <div class="col-xs-12">
            <span><?php echo $project['state']; ?></span>
        </div>
        <div class="col-xs-12">
            <span><?php echo $project['city']; ?></span>
        </div>
    </div>

    <?php if (isset($portfolio)) { ?>

    <div class="row">
        <div class="col-xs-12">

            <h3><?= t('Machinery Characteristics'); ?></h3>

            <div class="table-responsive">
                <table class="table" cellpadding="1" cellspacing="0" style="border:none;">
                    <thead>
                    <tr>
                        <th><?= t('Characteristics'); ?></th>
                        <th><?= t('Value'); ?></th>
                        <th><?= t('Unit'); ?></th>
                        <th><?= t('Remarks'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_merge($portfolio['standard_items'], $portfolio['custom_items']) as $item) { ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['value']; ?></td>
                            <td><?php echo $item['unit']; ?></td>
                            <td><?php echo $item['remarks']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <?php } ?>

    <?php if (count($reverse_reviews) > 0) { ?>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= t('Project Reviews'); ?></h3>
            <table>
                <tr>
                    <th><?= t('Total'); ?></th>
                    <th><div class="feedback-form-rating" data-rating="<?= $reverse_reviews['avg_rating']; ?>"></div></th>
                </tr>
                <?php foreach ($reverse_reviews['ratings'] as $rating) { ?>
                <tr>
                    <td><?= $rating['rating_category_name']; ?></td>
                    <td><div class="feedback-form-rating" data-rating="<?= $rating['rating']; ?>"></div></td>
                </tr>
                <?php } ?>
            </table>
            <br/>
            <p><?= $reverse_reviews['comments']; ?></p>
        </div>
    </div>

    <?php } ?>

    <?php if (count($project['milestones']) > 0) { ?>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= t('Project Milestones'); ?></h3>
            <div class="table-responsive" data-tab="1">
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
                        <?php if ($this->outputData['view_mode'] == 'false') { ?>
                        <th><?= t('Action'); ?></th>
                        <?php } ?>
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
    </div>

        <?php if ($project['job_status'] >= 4 and $project['job_status'] != 8) { ?>
        <div class="row">
            <div class="col-xs-12">
                <h3><?php echo t('Activity'); ?></h3>
                <div id="milestones-chart" style="width: 100%; height: <?php echo count($this->outputData['milestones'])*100; ?>px"></div>
            </div>
        </div>
        <?php } ?>

    <?php } ?>

    <?php if (isset($this->outputData['messages']) && count($this->outputData['messages']) > 0) { ?>

    <div class="row">
        <div class="col-xs-12">
            <h3><?= t('Project Messages'); ?></h3>
            <div class="table-responsive" data-tab="2">
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
        </div>
    </div>

    <?php } ?>

</div>

<script>
    function loadProgressBar()
    {
        jQuery(".progress-bar").loading();
    }

    function milestonesChart() {
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
                var y = Number(str.substring(str.lastIndexOf(",") + 1, str.lastIndexOf(")")));
                if (!y) {
                    y = Number(str.substring(str.lastIndexOf(" ") + 1, str.lastIndexOf(")")));
                }
                var label1 = chart.addLabel(10, y + 10, data[i].category, "left", 16, "#000000", 0, 1, true);
            }
        });
    }

    function changeMilestoneCompletion(e)
    {
        e.preventDefault();
        if (!jQuery(this).hasClass('disabled')) {
            var row = jQuery(this).closest('tr');
            row.find('.cls_round').addClass('hidden');
            row.find('.milestone-completion').removeClass('hidden');
            row.find('.button-completion').addClass('hidden');
            row.find('.button-close').addClass('hidden');
            row.find('.button-ok').removeClass('hidden');
            row.find('.button-cancel').removeClass('hidden');
            row.find('input[name=completion]').focus();
        }
    }

    function closeMilestone(e)
    {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('tr');
        var progress = row.find('.progress-bar');
        var status = row.find('.milestone-status');
        m.post(
            url,
            null,
            function () {
                // Disable buttons
                row.find('.button-completion').addClass('disabled');
                row.find('.button-close').addClass('disabled');
                // Set data
                status.removeClass('milestone-status-open');
                status.removeClass('milestone-status-overdue');
                status.addClass('milestone-status-closed');
                status.text(m.t('Closed'));
                progress.data('percent', 100);
                progress.data('color', '#e0e0e0, #1e88e5');
                progress.data('text-color', '#1e88e5');
                progress.loading();
            }
        );
    }

    function saveMilestoneCompletion(e)
    {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('tr');
        var progress = row.find('.progress-bar');
        var completion = row.find('input[name=completion]').val();
        var color = (completion == "0"?"#e0e0e0":"#1e88e5");
        m.post(
            url,
            {
                completion: row.find('input[name=completion]').val()
            },
            function () {
                // Show/hide
                row.find('.cls_round').removeClass('hidden');
                row.find('.milestone-completion').addClass('hidden');
                row.find('.button-completion').removeClass('hidden');
                row.find('.button-close').removeClass('hidden');
                row.find('.button-ok').addClass('hidden');
                row.find('.button-cancel').addClass('hidden');
                // Save data
                progress.data('percent', completion);
                progress.data('color', '#e0e0e0, ' + color);
                progress.data('text-color', color);
                progress.loading();
            }
        );
    }

    function cancelMilestoneCompletion(e)
    {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var progress = row.find('.progress-bar');
        // Show/hide
        row.find('.cls_round').removeClass('hidden');
        row.find('.milestone-completion').addClass('hidden');
        row.find('.button-completion').removeClass('hidden');
        row.find('.button-close').removeClass('hidden');
        row.find('.button-ok').addClass('hidden');
        row.find('.button-cancel').addClass('hidden');
        // Restore data
        row.find('input[name=completion]').val(progress.data('percent'));
    }

    jQuery(document).ready(function(){

        pagination.init(
            "<?php echo site_url('project/view'); ?>",
            function () {
                return {
                    id: jQuery('#job_id').val()
                }
            },
            function () {

                jQuery('[data-toggle="tooltip"]').tooltip();

                loadProgressBar();

                jQuery('.button-completion').click(changeMilestoneCompletion);
                jQuery('.button-close').click(closeMilestone);
                jQuery('.button-ok').click(saveMilestoneCompletion);
                jQuery('.button-cancel').click(cancelMilestoneCompletion);

            }
        );

        milestonesChart();

        jQuery('[data-toggle="tooltip"]').tooltip();

        loadProgressBar();

        jQuery('.button-completion').click(changeMilestoneCompletion);
        jQuery('.button-close').click(closeMilestone);
        jQuery('.button-ok').click(saveMilestoneCompletion);
        jQuery('.button-cancel').click(cancelMilestoneCompletion);

    });

</script>
