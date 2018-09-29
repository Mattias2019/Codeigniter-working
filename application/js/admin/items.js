/**
 * Created by geymur-vs on 18.08.17.
 */
var items;

(new (function Items() {
    var _this = items = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/items/viewItems',
            function () {
                return {
                }
            },
            function () {
                _this.initItemsButtons();
            },
            function () {
            },
            '.items-table'
        );

        $('#btn_add_item').click(_this.addItemRow);

        _this.initItemsButtons();

        $('#groups_tree').jstree({
            'core' : {
                'data' : {
                    "url" : siteUrl + '/items/populateGroupsTree',
                    "dataType" : "json" // needed only if you do not supply JSON headers
                },
                "themes" : {
                    "responsive": false
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "plugins" : [
                "state",
                "types",
                "unique",
                "wholerow",
                "changed",
                "themes"
            ]
        });

        $('#add_tree_item').click(_this.addTreeItem);

        $('#delete_tree_item').click(_this.deleteTreeItem);

        $('#refresh_tree').click(_this.refreshTree);
    };

    this.addTreeItem = function () {

        var category_id;
        var selected_nodes = $("#groups_tree").jstree().get_selected(true);

        $.each(selected_nodes, function( index, value ) {

            if (value.data.name === 'category') {
                parentNode = value;
                category_id = value.data.id;
            }
            else if (value.data.name === 'item') {

                // get parent node
                var parentNode = $('#groups_tree').jstree().get_node("[id="+value.parent+"]");

                if (parentNode && parentNode.data.name === 'category') {
                    category_id = parentNode.data.id;
                }
            }

            if (category_id) {

                m.dialog({
                    header: parentNode.text,
                    url: siteUrl + '/items/manageCategoryItems',
                    data: {'category_id': category_id},
                    before: function(data) {
                        $('#category_items').multiSelect({
                            selectableHeader: "<div class='custom-header'>Selectable items</div>",
                            selectionHeader: "<div class='custom-header'>Already selected</div>"
                        });
                        $('#category_items').multiSelect('select', data.category_items);
                    },
                    btnOk: {
                        label: m.t("submit"),
                        callback: function(data) {
                            var selected_values = $('#category_items').val();
                            m.post(
                                siteUrl + '/items/updateMachineryStandardItemCategories',
                                {
                                    category_id: parentNode.data.id,
                                    category_items: selected_values
                                },
                                function (data) {
                                    $("#groups_tree").jstree("refresh",value.parent);
                                    m.toast.success(data.message);
                                }
                            );
                        }
                    },
                    btnCancel: {
                        label: m.t("cancel"),
                        callback: function(data) {
                        }
                    }
                });
            }
        });
    };

    this.deleteTreeItem = function () {

        var selected_nodes = $("#groups_tree").jstree(true).get_selected('full',true);
        $.each(selected_nodes, function( index, value ) {

            if (value.data.name === 'item') {

                // get parent node
                var parentNode = $('#groups_tree').jstree().get_node("[id="+value.parent+"]");

                if (parentNode && parentNode.data.name === 'category') {

                    // delete item from category
                    m.post(
                        siteUrl + '/items/deleteItemFromCategory',
                        {
                            category_id: parentNode.data.id,
                            item_id: value.data.id
                        },
                        function (data) {
                            $("#groups_tree").jstree("remove",value.id);
                            $("#groups_tree").jstree("refresh",value.parent);
                            m.toast.success(data.message);
                        }
                    );
                }
            }
        });
    };

    this.refreshTree = function () {
        $('#groups_tree').jstree("refresh");
    };

    this.initItemsButtons = function () {

        $('.items-table .table tbody tr .btn-edit').click(_this.editItemRow);

        $('.items-table .table tbody tr .btn-delete').click(_this.deleteItem);

        $('.items-table .table tbody tr .btn-save').click(_this.saveItemRow);

        $('.items-table .table tbody tr .btn-cancel').click(_this.cancelItemRow);
    };

    this.addItemRow = function (e) {

        e.preventDefault();

        m.post(
            siteUrl + '/items/addItemRow',
            {},
            function (data) {

                var newRow = jQuery(data.html);

                $('.items-table .table tbody tr:first').before(newRow);

                $('.items-table .table tbody .no-data-found').toggle();

                newRow.find('.btn-save').click(_this.saveItemRow);
                newRow.find('.btn-cancel').click(_this.cancelItemRow);
            }
        );
    };

    this.saveItemRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/items/saveItemRow',
            {
                id: row.find('.id').text(),
                name: row.find('input[name=name]').val(),
                unit: row.find('input[name=unit]').val()
            },
            function (data) {
                var newRow = jQuery(data.html);
                row.replaceWith(newRow);
                newRow.find('.btn-edit').click(_this.editItemRow);
                newRow.find('.btn-delete').click(_this.deleteItem);
                newRow.find('.btn-save').click(_this.saveItemRow);
                newRow.find('.btn-cancel').click(_this.cancelItemRow);

                m.toast.success(data.message);
            },
            function (data) {
                m.toast.error(data.message);
            }
        );
    };

    this.cancelItemRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        if (row.hasClass('new-row')) {

            row.remove();

            if ($('.items-table .table tbody tr').length === 1) {
                $('.items-table .table tbody .no-data-found').toggle();
            }
        }
        else {
            m.post(
                siteUrl + '/items/refreshItemRow',
                {
                    id: row.find('.id').text()
                },
                function (data) {
                    var newRow = jQuery(data.html);
                    row.replaceWith(newRow);
                    newRow.find('.btn-edit').click(_this.editItemRow);
                    newRow.find('.btn-delete').click(_this.deleteItem);
                    newRow.find('.btn-save').click(_this.saveItemRow);
                    newRow.find('.btn-cancel').click(_this.cancelItemRow);
                }
            );
        }
    };

    this.editItemRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/items/editItemRow',
            {
                mode: 'update',
                id: row.find('.id').text()
            },
            function (data) {

                var newRow = jQuery(data.html);

                row.replaceWith(newRow);

                // Show/hide buttons
                newRow.find('.btn-edit, .btn-delete').addClass('hidden');
                newRow.find('.btn-save, .btn-cancel').removeClass('hidden');

                newRow.find('.btn-save').click(_this.saveItemRow);
                newRow.find('.btn-cancel').click(_this.cancelItemRow);
            }
        );
    };

    this.deleteItem = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/items/deleteItem',
            {
                mode: 'delete',
                id: row.find('.id').text()
            },
            function (data) {
                pagination.loadPage(0, jQuery('.items-table'), true, 0, '.items-table');

                _this.initItemsButtons();

                m.toast.success(data.message);
            }
        );
    };

})());
