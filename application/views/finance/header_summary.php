<div class="dashboard-stat2 top_green container-fluid">
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="col-xs-4">
                <label for="invoice-filter-start-date-picker" class="form-control-label"><?= t('Select Period'); ?>: </label>
            </div>
            <div class="col-xs-4">
                <input type="hidden" id="invoice-filter-start-date" class="form-control" value="<?php echo set_value('date_begin'); ?>">
                <input id="invoice-filter-start-date-picker" class="form-control"/>
            </div>
            <div class="col-xs-4">
                <input type="hidden" id="invoice-filter-end-date" class="form-control" value="<?php echo set_value('date_end'); ?>">
                <input id="invoice-filter-end-date-picker" class="form-control"/>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="form-control-label">
                <strong><?= t('Total Amount'); ?>: </strong>
                <strong class="text-color-2"><?php echo currency().number_format($this->outputData['total_amount']); ?></strong>
            </label>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="col-xs-6 no-padding">
                <a href="<?php echo site_url($this->outputData['view']=='finance/tax'?'finance/exportTaxToExcelAction':'finance/exportInvoiceToExcelAction').'?date_begin='.set_value('date_begin').'&date_end='.set_value('date_end'); ?>" class="button big primary outline"><img src="<?php echo image_url('excel.png'); ?>"> Export as Excel</a>
            </div>
            <div class="col-xs-6 no-padding">
                <a href="<?php echo site_url('finance/invoice_all_pdf').'?date_begin='.set_value('date_begin').'&date_end='.set_value('date_end'); ?>" class="button big primary outline"><img src="<?php echo image_url('download.png'); ?>"> Download All</a>
            </div>
        </div>

    </div>
</div>