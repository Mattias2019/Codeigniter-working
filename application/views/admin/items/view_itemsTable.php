
<table class="table table-striped table-bordered table-hover order-column dataTable no-footer" id="items_table" role="grid">
    <thead data-field="" data-sort="">
        <tr role="row">
            <th width="10%" rowspan="1" colspan="1"> <?= t('Item ID');?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
            <th rowspan="1" colspan="1"> <?= t('Item Name');?> <span role="button" class="table-sort fa fa-sort" data-field="name" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Unit');?> <span role="button" class="table-sort fa fa-sort" data-field="unit" data-sort=""> </th>
            <th width="10%" rowspan="1" colspan="1"> <?= t('Action');?></th>
        </tr>
    </thead>

    <tbody>
        <?php $this->load->view('admin/items/view_itemsTableBody', $this->outputData); ?>
    </tbody>
</table>