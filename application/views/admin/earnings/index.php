<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
	<div class="clsInnerCommon">

		<h2><?= t('Earnings Report');?></h2>

		<?php flash_message(); ?>

		<div class="dashboard">

			<div class="row form-group">
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
					<label for="period" class="form-control-label"><?= t('Show earnings for'); ?>:</label>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
					<select id="period" class="form-control">
						<option value="day"><?= t('Day'); ?></option>
						<option value="week"><?= t('Week'); ?></option>
						<option value="month"><?= t('Month'); ?></option>
						<option value="quarter"><?= t('Quarter'); ?></option>
						<option value="year"><?= t('Year'); ?></option>
					</select>
				</div>
			</div>

			<div class="row form-group">

				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
					<div id="earnings-chart" class="chart"></div>
				</div>

                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <h3><?= t('Platform Fees'); ?></h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead data-field="" data-sort="">
                            <tr>
                                <th><?= t('Date/Time'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="transaction_time" data-sort=""></span></th>
                                <th><?= t('Amount'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""></span></th>
                                <th><?= t('User'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""></span></th>
                                <th><?= t('Fee Type'); ?>&nbsp;<span role="button" class="table-sort fa fa-sort" data-field="type_name" data-sort=""></span></th>
                            </tr>
                            </thead>
                            <tbody>
							    <?php $this->load->view('admin/earnings/index_table', $this->outputData); ?>
                            </tbody>
                        </table>
                        <?php $this->load->view('pagination', $this->outputData); ?>
                    </div>
                </div>

			</div>

		</div>

	</div>
</div>

<style>

	.chart {
		height: 400px;
	}
	@media only screen and (max-width: 512px) {
		.chart {
			height: 200px;
		}
	}

</style>

<script>

	function buildChart(data, dateFormat, minPeriod) {

        var chart = AmCharts.makeChart("earnings-chart",
            {
                "type": "serial",
                "categoryField": "time",
                "dataDateFormat": dateFormat,
                "colors": [
                    "#1E88E5"
                ],
                "sequencedAnimation": false,
                "startDuration": 1,
                "fontFamily": "Lato, sans-serif",
                "fontSize": 14,
                "categoryAxis": {
                    "gridPosition": "start",
                    "minPeriod": minPeriod,
                    "parseDates": true
                },
                "trendLines": [],
                "graphs": [
                    {
                        "fillAlphas": 1,
                        "id": "earnings",
                        "title": "<?= t('Earnings'); ?>",
                        "type": "column",
                        "valueAxis": "amount",
                        "valueField": "amount"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "amount",
                        "title": "<?= t('Amount'); ?>"
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "titles": [],
                "dataProvider": data
            }
		);

        AmCharts.checkEmptyData = function(chart) {
            if (0 == chart.dataProvider.length) {
                chart.addLabel(0, '50%', '<?= t('The chart contains no data'); ?>', 'center');
                chart.validateNow();
            }
        };

        AmCharts.checkEmptyData(chart);
    }

    jQuery(document).ready(function () {

        var period = jQuery('#period');

        pagination.init(
            "<?php echo admin_url('earnings/index'); ?>",
            function() {
                return {
                    period: period.val()
                };
            },
            function (data) {
                buildChart(JSON.parse(data.earnings_chart), data.date_format, data.min_period);
            }
        );

        buildChart(
			<?php if (isset($earnings_chart)) echo $earnings_chart; ?>,
			"<?php if (isset($date_format)) echo $date_format; ?>",
            "<?php if (isset($min_period)) echo $min_period; ?>"
		);

        period.change(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });
    })

</script>

<?php $this->load->view('footer1'); ?>