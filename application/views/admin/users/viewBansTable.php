
<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="bans_table" role="grid">
    <thead data-field="" data-sort="">
        <tr role="row">
            <th width="5%" class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="group-checkable">
                    <span></span>
                </label>
            </th>
            <th width="10%" rowspan="1" colspan="1"> <?= t('Ban ID');?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
            <th rowspan="1" colspan="1"> <?= t('Ban Type');?> <span role="button" class="table-sort fa fa-sort" data-field="ban_type" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Ban Value');?> <span role="button" class="table-sort fa fa-sort" data-field="ban_value" data-sort=""> </th>
            <th width="10%" rowspan="1" colspan="1"> <?= t('Ban Time');?> <span role="button" class="table-sort fa fa-sort" data-field="ban_time" data-sort=""> </th>
            <th width="6%" rowspan="1" colspan="1"> <?= t('Options');?> </th>
        </tr>
    </thead>

    <tbody>
        <?php $this->load->view('admin/users/viewBansTableBody', $this->outputData); ?>
    </tbody>
</table>
