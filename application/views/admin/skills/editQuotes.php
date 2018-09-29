<?php $this->load->view('header1'); ?>

<div class="edit-quote">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Quotation Manager</span>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span><?= t('Edit Quote'); ?></span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> Quotes
        <small><?= t('Edit Quote'); ?></small>
    </h1>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">

                    <?php
                        //Show Flash Message
                        if($msg = $this->session->flashdata('flash_message'))
                        {
                            echo $msg;
                        }
                    ?>

                   <?php
                        if(isset($quotes) and $quotes->num_rows()>0) {

                        $quote = $quotes->row();
                    ?>

                    <form role="form" name="manageQuotes" id="manageQuotes" class="form-horizontal" method="post" action="<?php echo admin_url('skills/manageQuotes/'.$quote->id)?>">

                        <div class="form-body">

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="quote_id">
                                    <?= t('Quote Id'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="quote_id" readonly value="<?php echo set_value('quote_id', $quote->id); ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="job_id">
                                    <?= t('Project Id'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="job_id" readonly value="<?php echo set_value('job_id', $quote->job_id); ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>

                            <div class="form-group form-md-line-input">
                                <label class="col-md-2 control-label" for="amount">
                                    <?= t('Amount'); ?>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="amount" value="<?php echo set_value('amount', $quote->amount); ?>">
                                    <div class="form-control-focus"> </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-4" align="left">
                                        <a href="#" onclick="history.go(-1);return false;">
                                            <a href="<?php echo admin_url('skills/viewQuotes') ?>">
                                                <button type="button" class="btn default"><?= t('Cancel');?></button>
                                            </a>
                                        </a>
                                        <input type="submit" name="manageQuote" class="btn green" value="<?= t('Submit'); ?>"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

			        <?php
			            }
		            ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('footer1'); ?>

<script type="text/javascript">
function formSubmit()
{
	document.manageBids.submit();
	//document.manageBids.action='<?php //echo admin_url('skills/manageBids'); ?>'; document.manageBids.submit();
}
</script>