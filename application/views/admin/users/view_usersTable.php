
<table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="users_table" role="grid">
    <thead data-field="" data-sort="">
        <tr role="row">
            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="group-checkable">
                    <span></span>
                </label>
            </th>
            <th rowspan="1" colspan="1"> <?= t('User ID');?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
            <th rowspan="1" colspan="1"> <?= t('Username');?> <span role="button" class="table-sort fa fa-sort" data-field="user_name" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Name/Company');?> <span role="button" class="table-sort fa fa-sort" data-field="name" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Email');?> <span role="button" class="table-sort fa fa-sort" data-field="email" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Role');?> <span role="button" class="table-sort fa fa-sort" data-field="role_id" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Rate');?> <span role="button" class="table-sort fa fa-sort" data-field="rate" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Reviews');?> <span role="button" class="table-sort fa fa-sort" data-field="num_reviews" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Balance');?> <span role="button" class="table-sort fa fa-sort" data-field="amount" data-sort=""> </th>
            <th rowspan="1" colspan="1"> <?= t('Action');?></th>
        </tr>
    </thead>

    <tbody>
        <?php $this->load->view('admin/users/view_usersTableBody', $this->outputData); ?>
    </tbody>
</table>