<?php $this->load->view('header1'); ?>

<div class="clsInnerpageCommon">
    <div class="clsInnerCommon">

        <?php flash_message(); ?>

        <div class="cls_page-title clearfix">
            <h2><?= t('Manage Static Pages'); ?></h2>
        </div>

        <div class="table-responsive">

            <table id="table-pages" class="display clsmember table" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th><?= t('URL'); ?></th>
                    <th><?= t('Name'); ?></th>
                    <th><?= t('Title'); ?></th>
                    <th><?= t('Active'); ?></th>
                    <th><?= t('Created'); ?></th>
                    <th><?= t('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->outputData['pages'] as $this->outputData['page']) {
                    $this->load->view('admin/page/index_table', $this->outputData);
                } ?>
                </tbody>
            </table>

        </div>

        <div class="container-fluid">
            <div class="col-lg-9 col-md-9 col-sm-8"></div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <input type="button" class="button big primary" id="button-new" value="<?= t('Add New Page'); ?>"/>
            </div>
        </div>

    </div>
</div>

<style>

    .editable-text {
        min-height: 1em;
    }

</style>

<script type="text/javascript">

    function editRow(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var hiddenRow = row.next();
        row.find('input').prop('disabled', false);
        row.find('.button-edit, .button-delete').addClass('hidden');
        row.find('.button-save, .button-cancel').removeClass('hidden');
        hiddenRow.removeClass('hidden');
        hiddenRow.find('.editable-text').attr('contenteditable', true);
    }

    function newRow(e) {
        e.preventDefault();
        m.post(
            "<?php echo admin_url('pages/refresh_row'); ?>",
            null,
            function (result) {
                var newRow = jQuery(result.data);
                jQuery('#table-pages').find('tbody').append(newRow);
                newRow.find('input').prop('disabled', false);
                newRow.find('.button-edit, .button-delete').addClass('hidden');
                newRow.find('.button-save, .button-cancel').removeClass('hidden');
                newRow.find('.button-save').click(saveRow);
                newRow.find('.button-cancel').click(cancelEditRow);
                newRow.filter('tr.hidden').removeClass('hidden');
                newRow.find('.editable-text').attr('contenteditable', true);
            }
        );
    }

    function saveRow(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var hiddenRow = row.next();
        m.post(
            "<?php echo admin_url('pages/save_row'); ?>",
            {
                id: row.find('input[name=id]').val(),
                url: row.find('input[name=url]').val(),
                name: row.find('input[name=name]').val(),
                page_title: row.find('input[name=page_title]').val(),
                is_active: row.find('input[name=is_active]').is(':checked')?1:0,
                content: hiddenRow.find('.editable-text').html()
            },
            function (result) {
                var newRow = jQuery(result.data);
                row.replaceWith(newRow);
                hiddenRow.remove();
                newRow.find('.button-edit').click(editRow);
                newRow.find('.button-save').click(saveRow);
                newRow.find('.button-cancel').click(cancelEditRow);
                newRow.find('.button-delete').click(deleteRow);
            }
        );
    }

    function cancelEditRow(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var hiddenRow = row.next();
        var id = row.find('input[name=id]').val();
        if (id == '') {
            row.remove();
        } else {
            m.post(
                "<?php echo admin_url('pages/refresh_row'); ?>",
                {
                    url: row.find('input[name=url]').val()
                },
                function (result) {
                    var newRow = jQuery(result.data);
                    row.replaceWith(newRow);
                    hiddenRow.remove();
                    newRow.find('.button-edit').click(editRow);
                    newRow.find('.button-save').click(saveRow);
                    newRow.find('.button-cancel').click(cancelEditRow);
                    newRow.find('.button-delete').click(deleteRow);
                }
            );
        }
    }

    function deleteRow(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var id = row.find('input[name=id]').val();
        m.dialog({
            header: '<?= t('Delete page'); ?>',
            body: '<?= t('Do you wish to delete page?'); ?>',
            btnOk: {
                label:'<?= t('Yes'); ?>',
                callback: function() {
                    m.post(
                        "<?php echo admin_url('pages/delete_row'); ?>",
                        {
                            id: id
                        },
                        function(result) {
                            row.remove();
                        }
                    );
                }
            },
            btnCancel: {
                label:'<?= t('No'); ?>'
            }
        });
    }

    function checkGroup(e) {
        var row = jQuery(this).closest('tr');
        row.find('input[name='+jQuery(this).attr('name')+']').prop('checked', false);
        jQuery(this).prop('checked', true);
    }

    jQuery(document).ready(function () {

        jQuery('.button-edit').click(editRow);
        jQuery('.button-save').click(saveRow);
        jQuery('.button-cancel').click(cancelEditRow);
        jQuery('.button-delete').click(deleteRow);

        jQuery('#button-new').click(newRow);

    });

</script>

<?php $this->load->view('footer1'); ?>