/**
 * Created by geymur-vs on 18.08.17.
 */
var view_bans;

(new (function viewBans() {

    var _this = view_bans = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/users/viewBans',
            function () {
                return {
                }
            },
            function () {
                _this.initBanButtons();
            },
            function () {
            },
            '.bans-table'
        );

        $('#add_ban_btn').click(_this.addBanRow);

        _this.initBanButtons();
    };

    this.initBanButtons = function () {

        $('.bans-table .table tbody tr .btn-edit').click(_this.editBanRow);

        $('.bans-table .table tbody tr .btn-delete').click(_this.deleteBan);

        $('.bans-table .table tbody tr .btn-save').click(_this.saveBanRow);

        $('.bans-table .table tbody tr .btn-cancel').click(_this.cancelBanRow);
    };

    this.addBanRow = function (e) {

        e.preventDefault();

        m.post(
            siteUrl + '/users/addBanRow',
            {},
            function (data) {

                var newRow = jQuery(data.html);

                $('.bans-table .table tbody tr:first').before(newRow);

                $('.bans-table .table tbody .no-data-found').toggle();

                newRow.find('.btn-save').click(_this.saveBanRow);
                newRow.find('.btn-cancel').click(_this.cancelBanRow);
            }
        );
    };

    this.cancelBanRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        if (row.hasClass('new-row')) {

            row.remove();

            if ($('.bans-table .table tbody tr').length === 1) {
                $('.bans-table .table tbody .no-data-found').toggle();
            }
        }
        else {
            m.post(
                siteUrl + '/users/refreshBanRow',
                {
                    id: row.find('.id').text()
                },
                function (data) {
                    var newRow = jQuery(data.html);
                    row.replaceWith(newRow);
                    newRow.find('.btn-edit').click(_this.editBanRow);
                    newRow.find('.btn-delete').click(_this.deleteBan);
                    newRow.find('.btn-save').click(_this.saveBanRow);
                    newRow.find('.btn-cancel').click(_this.cancelBanRow);
                }
            );
        }
    };

    this.editBanRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/users/editBanRow',
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

                newRow.find('.btn-save').click(_this.saveBanRow);
                newRow.find('.btn-cancel').click(_this.cancelBanRow);
            }
        );
    };

    this.saveBanRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/users/saveBan',
            {
                id: row.find('.id').text(),
                ban_type_id: row.find('select[name=ban_type_id]').val(),
                ban_value: row.find('input[name=ban_value]').val()
            },
            function (data) {
                var newRow = jQuery(data.html);
                row.replaceWith(newRow);
                newRow.find('.btn-edit').click(_this.editBanRow);
                newRow.find('.btn-delete').click(_this.deleteBan);
                newRow.find('.btn-save').click(_this.saveBanRow);
                newRow.find('.btn-cancel').click(_this.cancelBanRow);
            }
        );
    };

    this.deleteBan = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/users/deleteBan',
            {
                mode: 'delete',
                id: row.find('.id').text()
            },
            function () {
                pagination.loadPage(0, jQuery('.bans-table'), true, 0, '.bans-table');
                _this.initBanButtons();
            }
        );
    };

})());
