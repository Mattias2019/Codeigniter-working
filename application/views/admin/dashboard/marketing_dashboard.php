
<?php $this->load->view('header1'); if(isset($countUsers)) { $countUsers = $countUsers->result_array(); } ?>

<script type="text/javascript">
    $(function () { dashboard.init(); });
</script>

    <div class="marketing-dashboard">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
        </div>

        <h1 class="page-title">
            Dashboard
        </h1>

        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?php echo $countUsers[0]['count'] ?>">
                                <?php echo $countUsers[0]['count'] ?>
                            </span>
                        </div>
                        <div class="desc"> Total Users </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="0">0</span>
                        </div>
                        <div class="desc"> Admin Balance </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="0">0</span>
                        </div>
                        <div class="desc"> Total Open Jobs </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="0">0</span>
                        </div>
                        <div class="desc"> Total Visitors Today </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-cursor font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">General Stats</span>
                        </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">
                                <i class="fa fa-repeat"></i> Reload </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number cpu_load" data-percent="55">
                                        <span>+55</span>% <canvas height="75" width="75"></canvas>
                                    </div>
                                    <a class="title" href="javascript:;"> CPU Load
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"> </div>
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number memory_used" data-percent="85">
                                        <span>+85</span>% <canvas height="75" width="75"></canvas></div>
                                    <a class="title" href="javascript:;"> Memory Used
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="margin-bottom-10 visible-sm"> </div>
                            <div class="col-md-4">
                                <div class="easy-pie-chart">
                                    <div class="number used_space" data-percent="46">
                                        <span>-46</span>% <canvas height="75" width="75"></canvas></div>
                                    <a class="title" href="javascript:;"> Used Space
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-cursor font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">All the projects on the map</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="worldmap-legend" class="worldmap-legend"></div>
                        <div class="worldmap-wrapper">
                            <div id="worldmap" class="worldmap"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-xs-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-money font-red"></i>
                            <span class="caption-subject font-red bold uppercase"> revenue </span>
                            <span class="caption-helper graph">current year stats...</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div id="marketing_chart" class="marketing_chart"></div>
                    </div>

                </div>
            </div>
        </div>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>
    </div>

<?php $this->load->view('footer1');