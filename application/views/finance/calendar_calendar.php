<?php
$calendar_data = [];
foreach($this->outputData['transactions'] as $transaction)
{
	$calendar_data[] = [
		"project" => $transaction['job_name'],
        "milestone" => "",
        "sum" => currency().number_format($transaction['amount']),
        "projectBegin" => date('Y-m-d', $transaction['start_date']),
        "projectEnd" => date('Y-m-d', $transaction['enddate']),
        "begin" => date('Y-m-d', set_value('date_begin')),
        "end" => date('Y-m-d', set_value('date_end')),
        "label" => $transaction['payment_status']['status'],
        "labelBegin" => date('Y-m-d', $transaction['start_date']),
        "labelEnd" => date('Y-m-d', $transaction['enddate']),
        "class" => $transaction['payment_status']['class'],
        "color" => "",
        "invoiceDate" => date('Y-m-d', $transaction['billing_date'])
    ];
}
$calendar_data = json_encode($calendar_data);
?>

<div id="spending-calendar" style="width: 100%; height: 400px"></div>

<script type="text/javascript">

    var calendar;

    spendingCalendar();

    function spendingCalendar() {

        // Set colors
        var data = <?php echo $calendar_data; ?>;
        if (data != null) {
            for (var i = 0; i < data.length; i++) {
                data[i].color = m.getCSS('background-color', data[i].class);
            }
        }

        calendar = AmCharts.makeChart("spending-calendar", {
            "type": "serial",
            "autoMargins": false,
            "marginLeft": 300,
            "marginRight": 0,
            "categoryField": "project",
            "dataDateFormat": "YYYY-MM-DD",
            "rotate": true,
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
                    "balloonText": "<?= t('Beginning'); ?>: [[projectBegin]]\n<?= t('End'); ?>: [[projectEnd]]",
                    "bulletBorderThickness": 1,
                    "closeField": "projectEnd",
                    "columnWidth": 1,
                    "fillAlphas": 0.2,
                    "fillColorsField": "color",
                    "fixedColumnWidth": 80,
                    "gapPeriod": 1,
                    "id": "projects",
                    "lineAlpha": 0,
                    "openField": "projectBegin",
                    "title": "Projects",
                    "type": "column"
                },
                {
                    "balloonText": "<?= t('Beginning'); ?>: [[projectBegin]]\n<?= t('End'); ?>: [[projectEnd]]",
                    "closeField": "labelEnd",
                    "color": "#FFFFFF",
                    "cornerRadiusTop": 10,
                    "fillAlphas": 1,
                    "fillColorsField": "color",
                    "fixedColumnWidth": 40,
                    "id": "projectLabels",
                    "labelText": "[[label]]\n[[invoiceDate]]",
                    "lineAlpha": 0,
                    "minDistance": 0,
                    "openField": "labelBegin",
                    "title": "Project Labels",
                    "type": "column"
                }
            ],
            "guides": [],
            "valueAxes": [
                {
                    "id": "time",
                    "maximumDate": "<?php echo date('Y-m-d', set_value('date_end')); ?>",
                    "minimumDate": "<?php echo date('Y-m-d', set_value('date_begin')); ?>",
                    "position": "top",
                    "stackType": "regular",
                    "type": "date",
                    "autoGridCount": false,
                    "axisAlpha": 0,
                    "boldPeriodBeginning": false,
                    "color": "#BDBDBD",
                    "dateFormats": [
                        {
                            "period": "DD",
                            "format": "DD"
                        }
                    ],
                    "gridAlpha": 1,
                    "gridColor": "#ECEFF2",
                    "gridCount": "<?php echo set_value('date_diff'); ?>",
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
            "dataProvider": data
        });

        calendar.addListener("drawn", function () {
            calendar.clearLabels();
            calendar.addLabel(10, 0, "<?php echo strtoupper(t('Payment Calendar')); ?>", "left", 16, "#000000", 0, 1, true);
            var labels = $('#spending-calendar').find('.amcharts-category-axis .amcharts-axis-label');
            var l = labels.length;
            var data = calendar.dataProvider;
            for (var i = 0; i < l; i++) {
                // Draw labels
                var str = $(labels[i]).attr("transform");
                var y = Number(str.substring(str.lastIndexOf(",")+1,str.lastIndexOf(")")));
                if (!y) {
                    y = Number(str.substring(str.lastIndexOf(" ")+1,str.lastIndexOf(")")));
                }
                var label1 = calendar.addLabel(10, y, data[i].project, "left", 16, "#000000", 0, 1, true);
                if (data[i].milestone != "") {
                    var label2 = chart.addLabel(chart.labels[calendar.labels.length-1].node.getBBox().width + 12, y, "/ " + data[i].milestone);
                }
                var label3 = calendar.addLabel(10, y+20, data[i].sum, "left", 16, data[i].color, 0, 1, true);
                var label4 = calendar.addLabel(100, y+22, data[i].projectBegin + ' - ' + data[i].projectEnd, "left", 14, "#bdbdbd");
            }
        });
    }
</script>