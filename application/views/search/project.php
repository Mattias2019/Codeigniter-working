<?php
    $this->load->view('header1');

    $config = (array)$this->config;
    $sidebar_menu = $config['config']['menu']['sidebar'];
?>
    <h2>
        <?php
            $sidebar_menu_label = get_menu_label_by_resource($sidebar_menu, $parent_controller);
            echo $sidebar_menu_label?$sidebar_menu_label:t('Search Results');
        ?>
    </h2>

    <div class="clsInnerpageCommon">
        <div class="clsInnerCommon">

            <?php flash_message(); ?>

            <div class="dashboard border-left container-fluid">

                <div class="row">

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="keyword" class="form-control-label"><?= t('Keyword'); ?>: </label>
                            <input class="form-control" id="keyword" value="<?php echo set_value('keyword'); ?>"/>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-control-label"><?= t('Categories'); ?>: </label>
                            <?php $this->load->view('multiselect'); ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <?php echo form_error('budget_min'); ?>
                            <?php echo form_error('budget_max'); ?>
                            <input type="hidden" id="budget_min" name="budget_min"/>
                            <input type="hidden" id="budget_max" name="budget_max"/>

                            <label class="form-control-label" for="amount"><?= t('Budget'); ?>:</label>
                            <button class="double-budget-btn" name="double-budget-btn" id="double-budget-btn">
                                <img src="/application/css/images/2x.png">
                            </button>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php $this->load->view('custom-slider'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="submit" class="form-control-label"></label>
                            <input type="submit" id="submit" class="button big primary"
                                   value="<?= t('Refresh'); ?>"/>
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label for="reset-filter-btn" class="form-control-label"></label>
                            <input type="button" id="reset-filter-btn" class="button big primary"
                                   value="<?= t('Reset'); ?>"/>
                        </div>
                    </div>

                </div>

            </div>

            <div id="table-jobs" class="table-responsive table-jobs">
                <table class="display clsmember table" width="100%" cellspacing="0">
                    <thead data-field="" data-sort="">
                        <tr>
                            <th><?= t('Status'); ?></th>
                            <th><?= t('Country'); ?> <span role="button" class="table-sort fa fa-sort"
                                                                  data-field="country_name" data-sort=""></span></th>
                            <th><?= t('City'); ?> <span role="button" class="table-sort fa fa-sort" data-field="city"
                                                               data-sort=""></span></th>
                            <th><?= t('Creator'); ?></th>
                            <th><?= t('Job Name'); ?> <span role="button" class="table-sort fa fa-sort"
                                                                   data-field="job_name" data-sort=""></span></th>
                            <th><?= t('Job Type'); ?></th>
                            <th><?= t('Budget'); ?> <span role="button" class="table-sort fa fa-sort"
                                                                 data-field="budget_min, budget_max" data-sort=""></span>
                            </th>
                            <th width="5%"><?= t('Quotes'); ?></th>
                            <th><?= t('Quote Due Date'); ?>
                                <span role="button" class="table-sort fa fa-sort" data-field="enddate" data-sort=""></span>
                            </th>
                            <th width="5%"><?= t('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $this->load->view('search/project_table');?>
                    </tbody>
                </table>
                <?php $this->load->view('pagination', $this->outputData); ?>
            </div>
        </div>
    </div>

    <style>
        .cls_slectp > p {
            float: left;
            line-height: 80px;
            padding-right: 15px;

        }

        .cls_slecton.mod_fix {
            float: left;
            width: 75%;
        }

        .morectnt span {
            display: none;
        }

        .tooltipcls {
            position: relative;
            display: inline-block;
            /*border-bottom: 1px dotted black;*/
        }

        .tooltipcls .tooltiptextcls {
            background-color: #fafafa;
            border-radius: 6px;
            box-shadow: 0 0 4px #0a0a0a;
            color: #73737d;
            padding: 10px;
            position: absolute;
            text-align: center;
            visibility: hidden;
            width: 300px;
            z-index: 1;
        }

        #group_form ul li {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0 !important;
            border: medium none;
            float: none;
            height: auto;
            text-align: left !important;
        }

        #group_form ul li:hover {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            height: auto;
        }

        #main {
            padding: 15px;
        }

        .thumbs {
            float: left;
            border: #000 solid 1px;
            margin-bottom: 20px;
            margin-right: 20px;
        }

        .clsmember thead td {
            background: #f4f4f4;
            border: 1px solid #e3e3e3 !important;
        }

        .clsmember tbody table, .clsmember tbody td {
            background: #fff;
            border: 1px solid #e3e3e3 !important;
            padding: 5px;
            text-align: left;
        }

        .seach_border {
            margin: 10px;
        }

        .showmoretxt {
            display: block;
            text-align: right;
            width: 100%;
        }

        .cls_scnd-div-part .cls_row-div > span {
            float: left;
            width: 28%;
        }

        input.select0.styled.main_category {
            height: auto;
            position: absolute;
            width: 6% !important;
        }

        .table-responsive {
            overflow: visible;
        }

        .table-responsive table {
            border-collapse: separate;
        }

        .project-button {
            background-size: cover;
            display: inline-block;
            height: 32px;
            width: 32px;
        }

        .svg-projects-inner {
            fill: #bdbdbd;
        }

        .active .svg-projects-inner {
            fill: #1e88e5;
        }

        .project-button:hover .svg-table-inner {
            fill: #1e88e5;
        }

    </style>

<?php $this->load->view('footer1'); ?>