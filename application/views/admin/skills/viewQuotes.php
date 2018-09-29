<?php $this->load->view('header1'); ?>

<div class="view-quotes">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('View Quotes'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('View Quotes'); ?>
    </h1>
    <?php
        //if(isset($projects)) pr($projects->result());
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <form class="form" role="form">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo set_value('id', $view_quotes_filter["id"]); ?>">
                    <label for="id"><?= t('Quote Id'); ?></label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="input-group">

                        <div class="input-group-control">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', $view_quotes_filter["name"]); ?>">
                            <label for="id"><?= t('Quote Name'); ?></label>
                        </div>

                        <span class="input-group-btn btn-right">
                            <button id="find-quotes-btn" name="find-quotes-btn" class="btn green"><i class="fa fa-search"></i> <?= t('filter_results');?> </button>
                        </span>

                        <span class="input-group-btn btn-right">
                            <button id="reset-find-quotes-btn" name="reset-find-quotes-btn" class="btn red"><i class="fa fa-remove"></i> <?= t('reset_filter');?> </button>
                        </span>

                    </div>
                </div>
            </div>

        </div>
    </form>

<!--    <ul>-->
<!--        <li><a href="--><?php //echo admin_url('skills/searchBids');?><!--"><b>--><?php //echo t('Search'); ?><!--</b></a></li>-->
<!--        <li class="clsNoBorder"><a href="--><?php //echo admin_url('skills/viewQuotes');?><!--"><b>--><?php //echo t('View All'); ?><!--</b></a></li>-->
<!--    </ul>-->

    <div class="table quotes-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="bids_table" role="grid">
            <thead>
                <tr role="row">

                    <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox" class="category-checkable">
                            <span></span>
                        </label>
                    </th>

                    <th><?= t('Sl.No'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""> </th>
                    <th><?= t('Job Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_id" data-sort=""> </th>
                    <th><?= t('Job Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="job_name" data-sort=""> </th>
                    <th><?= t('User Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="user_id" data-sort=""> </th>
                    <th><?= t('User Name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""> </th>
                    <th><?= t('Amount'); ?> <span role="button" class="table-sort fa fa-sort" data-field="bid_amount" data-sort=""> </th>
                    <th><?= t('Date'); ?> <span role="button" class="table-sort fa fa-sort" data-field="bid_time" data-sort=""> </th>
                    <th><?= t('action'); ?></th>

                </tr>

            </thead>

            <tbody>
                <?php $this->load->view('admin/skills/viewQuotesTableBody', $this->outputData); ?>
            </tbody>

		</table>

        <?php $this->load->view('pagination', $this->outputData); ?>

    </div>

</div>

<?php $this->load->view('footer1'); ?>

