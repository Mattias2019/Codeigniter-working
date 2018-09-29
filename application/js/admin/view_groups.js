/**
 * Created by geymur-vs on 18.08.17.
 */
var view_groups;

(new (function ViewGroups() {
    var _this = view_groups = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/skills/viewGroups',
            function () {
                return {
                }
            },
            function () {
                _this.initGroupButtons();
            },
            function () {
            },
            '.groups-table'
        );

        _this.initGroupButtons();
    };

    this.initGroupButtons = function () {

        $('.groups-table .table tbody tr .btn-edit').click(_this.editGroupRow);

        $('.groups-table .table tbody tr .btn-delete').click(_this.deleteGroup);

        $('.groups-table .table tbody tr .btn-save').click(_this.saveGroupRow);

        $('.groups-table .table tbody tr .btn-cancel').click(_this.cancelGroupRow);
    };

    this.cancelGroupRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        if (row.hasClass('new-row')) {

            row.remove();

            if ($('.groups-table .table tbody tr').length === 1) {
                $('.groups-table .table tbody .no-data-found').toggle();
            }
        }
        else {
            m.post(
                siteUrl + '/skills/refreshGroupRow',
                {
                    id: row.find('.id').text()
                },
                function (data) {
                    var newRow = jQuery(data.html);
                    row.replaceWith(newRow);
                    newRow.find('.btn-edit').click(_this.editGroupRow);
                    newRow.find('.btn-delete').click(_this.deleteGroup);
                    newRow.find('.btn-save').click(_this.saveGroupRow);
                    newRow.find('.btn-cancel').click(_this.cancelGroupRow);
                }
            );
        }
    };

    this.addGroupRow = function (e) {

        e.preventDefault();

        m.post(
            siteUrl + '/skills/addGroupRow',
            {},
            function (data) {

                var newRow = jQuery(data.html);

                $('.groups-table .table tbody tr:first').before(newRow);

                $('.groups-table .table tbody .no-data-found').toggle();

                newRow.find('.btn-save').click(_this.saveGroupRow);
                newRow.find('.btn-cancel').click(_this.cancelGroupRow);
            }
        );
    };

    this.editGroupRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/skills/editGroupRow',
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

                newRow.find('.btn-save').click(_this.saveGroupRow);
                newRow.find('.btn-cancel').click(_this.cancelGroupRow);
            }
        );
    };

    this.saveGroupRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/skills/saveGroup',
            {
                id: row.find('.id').text(),
                group_name: row.find('input[name=group_name]').val(),
                description: row.find('textarea[name=description]').val()
            },
            function (data) {
                var newRow = jQuery(data.html);
                row.replaceWith(newRow);
                newRow.find('.btn-edit').click(_this.editGroupRow);
                newRow.find('.btn-delete').click(_this.deleteGroup);
                newRow.find('.btn-save').click(_this.saveGroupRow);
                newRow.find('.btn-cancel').click(_this.cancelGroupRow);
            }
        );
    };

    this.deleteGroup = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.dialog({
            header: m.t("delete-group"),
            body : m.t("ask-delete-group"),
            btnOk: {
                label: m.t("ok"),
                callback: function() {
                    m.post(
                        siteUrl + '/skills/deleteGroup',
                        {
                            mode: 'delete',
                            id: row.find('.id').text()
                        },
                        function (response) {
                            pagination.loadPage(0, jQuery('.groups-table'), true, 0, '.groups-table');
                            _this.initGroupButtons();
                            m.toast.success(response.message);
                        }
                    );
                }
            },
            btnCancel: function() {}
        });
    };

})());
