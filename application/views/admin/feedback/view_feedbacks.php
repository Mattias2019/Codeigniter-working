<?php $this->load->view('header1');?>

<div class="view-feedbacks">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Feedback</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> View Feedback</h1>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <form class="form" role="form">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="input-group">

                        <div class="input-group-control">
                            <select class="form-control" id="feedback_type_id">
                                <option value="" selected></option>
                                <?php
                                if(isset($feedback_types) and $feedback_types->num_rows()>0) {
                                    foreach ($feedback_types->result() as $feedback_type) {
                                        ?>
                                        <option value="<?php echo $feedback_type->feedback_type_id; ?>" <?php if (set_value('feedback_type_id', $view_feedback_filter["feedback_type_id"]) == $feedback_type->feedback_type_id) echo "selected"; ?>> <?php echo $feedback_type->feedback_type_name ?> </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <label for="feedback_type_id" class="control-label">Feedback type</label>
                        </div>

                        <span class="input-group-btn btn-right">
                            <button id="find-feedback-btn" name="find-feedback-btn" class="btn green"><i class="fa fa-search"></i> <?= t('filter_results');?> </button>
                        </span>

                        <span class="input-group-btn btn-right">
                            <button id="reset-find-feedback-btn" name="reset-find-feedback-btn" class="btn red"><i class="fa fa-remove"></i> <?= t('reset_filter');?> </button>
                        </span>

                    </div>
                </div>
            </div>

            <div class="col-md-8" align="right">
                <div class="form-group form-md-line-input">
                    <div class="btn-group">
<!--                        <button id="export-as-excel-btn" name="export-as-excel-btn" class="btn blue"><i class="fa fa-file-excel-o"></i> Export as Excel </button>-->
                        <a id="export-as-excel-btn" href="<?php echo admin_url('feedback/exportFeedbackToExcel')?>" class="btn blue"> <i class="fa fa-file-excel-o"></i> Export as Excel </a>
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div class="feedbacks-table">
            <?php $this->load->view('admin/feedback/view_feedbacksTable', $this->outputData); ?>
        <?php $this->load->view('pagination', $this->outputData); ?>
    </div>

</div>

<?php $this->load->view('footer1'); ?>