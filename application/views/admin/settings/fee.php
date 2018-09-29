<?php $this->load->view('header1'); ?>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <h2><?= t('Fee Modulator'); ?></h2>
            <h3><?= t($base_controller == 'paymentSettings/escrowFee' ? 'Escrow Fee' : 'Platform Fee'); ?></h3>

            <?php flash_message(); ?>

            <div class="dashboard">
                <div class="row">

                    <div class="col-sm-4 col-xs-12">
                        <form method="post" action="<?php echo admin_url($base_controller); ?>"
                              enctype="multipart/form-data">

                            <?php if (isset($fees)) foreach ($fees as $i => $fee) { ?>
                                <div class="row form-group">
                                    <?php echo form_error('fee[' . $fee['id'] . '][amount]'); ?>
                                    <?php echo form_error('fee[' . $fee['id'] . '][percent]'); ?>
                                    <div class="col-lg-3 col-xs-12">
                                        <label class="form-control-label"><?= t('Linear fee') . ' ' . ($i + 1); ?></label>
                                    </div>
                                    <div class="col-lg-4 col-xs-10">
                                        <?php if (set_value('amount', $fee['min_amount']) > 0) { ?>
                                            <input name="fee[<?php echo $fee['id']; ?>][amount]" class="form-control"
                                                   value="<?php echo set_value('amount', $fee['min_amount']); ?>"/>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-1 col-xs-2">
                                        <?php if (set_value('amount', $fee['min_amount']) > 0) { ?>
                                            <label class="form-control-label"><?php echo currency() ?></label>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-3 col-xs-10">
                                        <input name="fee[<?php echo $fee['id']; ?>][percent]" class="form-control"
                                               value="<?php echo set_value('percent', $fee['fee_percent']); ?>"/>
                                    </div>
                                    <div class="col-lg-1 col-xs-2">
                                        <label class="form-control-label">%</label>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="row form-group">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4 col-xs-12">
                                    <input type="submit" name="submit" class="button big primary"
                                           value="<?= t('Submit'); ?>"/>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>

                        </form>
                    </div>

                    <div class="col-sm-8 col-xs-12">
                        <div class="row">
                            <div id="fee_graph" class="fee_graph"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <style>

        .fee_graph {
            height: 400px;
        }

        @media only screen and (max-width: 512px) {
            .fee_graph {
                height: 200px;
            }
        }

    </style>

    <script>

        feeGraph();

        function feeGraph() {

            var chart = AmCharts.makeChart("fee_graph",
                {
                    "type": "xy",
                    "sequencedAnimation": false,
                    "fontFamily": "Lato, sans-serif",
                    "trendLines": [],
                    "graphs": [
                        {
                            "bullet": "round",
                            "bulletAlpha": 0,
                            "id": "GraphValues",
                            "lineColor": "#BDBDBD",
                            "lineThickness": 3,
                            "xAxis": "XAxis",
                            "xField": "x",
                            "yAxis": "YAxis_value",
                            "yField": "y_value"
                        },
                        {
                            "bullet": "round",
                            "bulletAlpha": 0,
                            "id": "GraphPercents",
                            "lineColor": "#1E88E5",
                            "lineThickness": 3,
                            "xAxis": "XAxis",
                            "xField": "x",
                            "yAxis": "YAxis_percent",
                            "yField": "y_percent"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "XAxis",
                            "logarithmic": true,
                            "maximum": <?=$fees[count($fees) - 2]['min_amount']?>,
                            "minimum": <?=$fees[0]['min_amount']?>,
                            "position": "bottom",
                            "gridColor": "#FFFFFF"
                        },
                        {
                            "id": "YAxis_value",
                            "maximum": <?=$chart_data[count($chart_data) - 1]['y_value']?>,
                            "minimum": 0
                        },
                        {
                            "id": "YAxis_percent",
                            "maximum": <?=$fees[0]['fee_percent']?>,
                            "minimum": 0,
                            "position": "right",
                            "recalculateToPercents": true,
                            "gridColor": "#FFFFFF"
                        }
                    ],
                    "allLabels": [],
                    "balloon": {},
                    "titles": [],
                    "dataProvider": <?=json_encode($chart_data)?>
                }
            );

        }

    </script>

<?php $this->load->view('footer1'); ?>