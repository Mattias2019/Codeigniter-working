
    <table id="faq_categories_table" class="table table-bordered table-checkable table-hover ordered" width="100%">

        <thead>

            <tr role="row" class="heading">

                <th width="5%" class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="faq-checkable">
                        <span></span>
                    </label>
                </th>

                <th width="7%" rowspan="1" colspan="1"> <?= t('id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span></th>
                <th rowspan="1" colspan="1"> <?= t('faq_category_name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="category_name" data-sort=""></span> </th>
                <th width="10%" rowspan="1" colspan="1"> <?= t('created'); ?> <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span></th>
                <th width="7%" rowspan="1" colspan="1"> <?= t('action'); ?></th>

            </tr>

        </thead>

        <tbody>

            <?php $this->load->view('admin/faq/viewFaqCategoriesTableBody', $this->outputData); ?>

        </tbody>

    </table>
