<?php
$chart_data = [];
foreach($this->outputData['months'] as $n => $month)
{
	$chart_data[] = [
		"contracted" => $month['contracted'],
        "escrow" => $month['escrow'],
        "pending" => $month['pending'],
        "paid" => $month['paid'],
        "delayed" => $month['delayed'],
        "dispute" => $month['disputed'],
        "total" => $month['total'],
        "month" => $n
	];
}
$chart_data = json_encode($chart_data);
?>

<div id="spending-chart" style="width: 100%; height: 400px"></div>

<script type="text/javascript">

    var chart;

    spendingChart();

    function spendingChart() {

        var data = <?php echo $chart_data; ?>;

        chart = AmCharts.makeChart("spending-chart",
            {
                "type": "serial",
                "categoryField": "month",
                "dataDateFormat": "YYYYMM",
                "autoMargins": false,
                "marginLeft": 100,
                "marginRight": 0,
                "backgroundColor": "#ECEFF2",
                "plotAreaFillAlphas": 1,
                "colors": [
                    "#eceff2",
                    "#8616ad",
                    "#1e88e5",
                    "#83c145",
                    "#b21c17",
                    "#ffd03f",
                    "#bdbdbd"
                ],
                "addClassNames": true,
                "fontFamily": "Lato, sans-serif",
                "fontSize": 16,
                "categoryAxis": {
                    "dateFormats": [
                        {
                            "period": "MM",
                            "format": "MMM YYYY"
                        }
                    ],
                    "gridPosition": "start",
                    "minPeriod": "MM",
                    "parseDates": true,
                    "position": "top",
                    "axisAlpha": 0,
                    "boldPeriodBeginning": false,
                    "markPeriodChange": false,
                    "showFirstLabel": false,
                    "gridColor": "#ECEFF2",
                    "gridAlpha": 1,
                    "color": "#BDBDBD"
                },
                "trendLines": [],
                "graphs": [
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "contracted",
                        "markerType": "circle",
                        "title": "<?= t('Contracted Payment'); ?>",
                        "type": "column",
                        "valueField": "contracted"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "escrow",
                        "markerType": "circle",
                        "title": "<?= t('In Escrow'); ?>",
                        "type": "column",
                        "valueField": "escrow"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "pending",
                        "markerType": "circle",
                        "title": "<?= t('Pending'); ?>",
                        "type": "column",
                        "valueField": "pending"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "paid",
                        "markerType": "circle",
                        "title": "<?= t('Paid'); ?>",
                        "type": "column",
                        "valueField": "paid"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "delayed",
                        "markerType": "circle",
                        "title": "<?= t('Delayed'); ?>",
                        "type": "column",
                        "valueField": "delayed"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "fillAlphas": 1,
                        "id": "dispute",
                        "markerType": "circle",
                        "title": "<?= t('Dispute'); ?>",
                        "type": "column",
                        "valueField": "dispute"
                    },
                    {
                        "balloonText": "[[title]]: [[value]]",
                        "bullet": "round",
                        "bulletSize": 16,
                        "id": "total",
                        "title": "<?= t('Total'); ?>",
                        "valueField": "total"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                        "stackType": "regular",
                        "axisColor": "#ECEFF2",
                        "gridColor": "#ECEFF2",
                        "gridAlpha": 1,
                        "tickLength": 100
                    }
                ],
                "balloon": {},
                "legend": {
                    "enabled": true,
                    "align": "right",
                    "equalWidths": false,
                    "markerType": "circle",
                    "position": "top",
                    "useGraphSettings": true,
                    "valueWidth": 0
                },
                "titles": [],
                "dataProvider": data
            }
        );

        chart.addListener("drawn", function () {
            chart.clearLabels();
            chart.addLabel(10, -2, "<?= t('Spendings'); ?>", "left", 16, "#000000", 0, 1, true);
            var labels = $('#spending-chart').find('.amcharts-value-axis .amcharts-axis-label');
            var l = labels.length;
            for (var i = 1; i < l; i++) {
                var prevStr = $(labels[i-1]).attr("transform");
                var str = $(labels[i]).attr("transform");
                var prevY = Number(prevStr.substring(prevStr.lastIndexOf(",")+1,prevStr.lastIndexOf(")")));
                if (!prevY) {
                    prevY = Number(prevStr.substring(prevStr.lastIndexOf(" ")+1,prevStr.lastIndexOf(")")));
                }
                var y = Number(str.substring(str.lastIndexOf(",")+1,str.lastIndexOf(")")));
                if (!y) {
                    y = Number(str.substring(str.lastIndexOf(" ")+1,str.lastIndexOf(")")));
                }
                chart.addLabel(10, (prevY+y)/2, "<?php echo currency(); ?>" + $(labels[i]).find('tspan').text());
            }
        });
    }
</script>