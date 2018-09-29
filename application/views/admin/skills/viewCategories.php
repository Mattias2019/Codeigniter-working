<?php $this->load->view('header1'); ?>

<script type="text/javascript">
    var base_url = '<?php echo $base_url;?>';
    $(function () { view_categories.init(base_url); });
</script>

<div class="view-categories">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Categories</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">
        <?= t('categories'); ?>
    </h1>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-12" align="right">
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo admin_url('skills/addCategory')?>"><i class="fa fa-plus"></i> <?= t('add_category'); ?></a>
                </div>
                <div class="btn-group">
                    <button id="del_users" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                        Delete selected Categories
<!--                        <a name="delete" href="javascript: document.managecategory.action='--><?php //echo admin_url('skills/deleteCategory/'); ?><!--'; document.managecategory.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="--><?php //echo image_url('delete-new.png'); ?><!--" alt="Delete" title="Delete" /></a></div>-->
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="categories-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="categories_table" role="grid">
            <thead>
                <tr role="row">
                    <th width="5%" class="sorting_disabled" rowspan="1" colspan="1" aria-label="">
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input type="checkbox" class="category-checkable">
                            <span></span>
                        </label>
                    </th>

                    <th width="6%" rowspan="1" colspan="1"> <?= t('Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""></span> </th>
                    <th rowspan="1" colspan="1"> <?= t('category_name'); ?> <span role="button" class="table-sort fa fa-sort" data-field="category_name" data-sort=""></span> </th>
                    <th rowspan="1" colspan="1"> <?= t('group'); ?> <span role="button" class="table-sort fa fa-sort" data-field="" data-sort=""></span> </th>
                    <th rowspan="1" colspan="1"> <?= t('status'); ?> <span role="button" class="table-sort fa fa-sort" data-field="is_active" data-sort=""></span> </th>
                    <th width="10%" rowspan="1" colspan="1"> <?= t('logo'); ?> </th>
                    <th width="10%" rowspan="1" colspan="1"> <?= t('created'); ?> <span role="button" class="table-sort fa fa-sort" data-field="created" data-sort=""></span> </th>
                    <th width="6%" rowspan="1" colspan="1"> <?= t('action'); ?> </th>

                </tr>

            </thead>

            <tbody>
                <?php $this->load->view('admin/skills/viewCategoriesTableBody', $this->outputData); ?>
            </tbody>

		</table>

        <?php $this->load->view('pagination', $this->outputData); ?>

    </div>

</div>

<?php $this->load->view('footer1'); ?>
