<?php
$this->outputData['segment'] = 1;
?>

<div class="col-xs-12">
    <h2><?= t(isEntrepreneur()?'Payment Calendar':'Revenue Calendar'); ?></h2>
</div>
<div class="clearfix"></div>

<?php $this->load->view('finance/header_summary', $this->outputData); ?>
<?php $this->load->view('finance/calendar_chart', $this->outputData); ?>
<?php $this->load->view('finance/calendar_calendar', $this->outputData); ?>