
<table class="table table-striped table-bordered table-hover order-column dataTable no-footer" id="feedbacks_table" role="grid">
    <thead data-field="" data-sort="">
        <tr role="row">
            <th rowspan="1" colspan="1"> <?= t('Feedback ID');?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
            <th rowspan="1" colspan="1"> <?= t('Username');?> <span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Feedback time');?> <span role="button" class="table-sort fa fa-sort" data-field="time_stamp" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Browser');?> <span role="button" class="table-sort fa fa-sort" data-field="browser" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Language');?> <span role="button" class="table-sort fa fa-sort" data-field="language" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Feedback type');?> <span role="button" class="table-sort fa fa-sort" data-field="feedback_type_name" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Memo text');?> <span role="button" class="table-sort fa fa-sort" data-field="memo_text" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Page reference');?> <span role="button" class="table-sort fa fa-sort" data-field="page_reference" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Geo location');?> <span role="button" class="table-sort fa fa-sort" data-field="geo_location" data-sort=""> </th>
        </tr>
    </thead>

    <tbody>
        <?php $this->load->view('admin/feedback/view_feedbacksTableBody', $this->outputData); ?>
    </tbody>
</table>