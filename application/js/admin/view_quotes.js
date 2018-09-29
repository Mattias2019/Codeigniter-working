/**
 * Created by geymur-vs on 18.08.17.
 */
var view_quotes;

(new (function ViewQuotes() {

    var _this = view_quotes = this;

    var siteUrl;

    this.init = function (adminUrl) {

        _siteUrl = adminUrl;

        $("#find-quotes-btn").click(function (e) {

            e.preventDefault();

            pagination.loadPage(0, jQuery('.quotes-table'), true, 1, '.quotes-table');

        });

        $("#reset-find-quotes-btn").click(function (e) {

            e.preventDefault();

            $('#id').val(null);
            $('#name').val(null);

            pagination.loadPage(0, jQuery('.quotes-table'), true, 1, '.quotes-table');

        });

        $('.quotes-table .table tbody tr .btn-delete').click(function (e) {

            e.preventDefault();

            _this.deleteUser($(this).attr('href'));
        });

        this.deleteUser = function (url) {
            m.dialog({
                header: m.t("delete-user"),
                body : m.t("ask-delete-user"),
                btnOk: {
                    label: m.t("ok"),
                    callback: function() {
                        m.post(
                            url, {},
                            function () {
                                pagination.loadPage(0, jQuery('.users-table'), true, 0, '.users-table');
                            }
                        );
                    }
                },
                btnCancel: function() {}
            });
        };

        pagination.init(
            adminUrl + '/skills/viewQuotes',
            function () {
                return {
                    id: jQuery('#id').val(),
                    name: jQuery('#name').val()
                }
            },
            function () {
                $('.quotes-table .table tbody tr .btn-delete').click(function (e) {

                    e.preventDefault();

                    _this.deleteUser($(this).attr('href'));
                });
            },
            function () {
            },
            '.quotes-table'
        );

        // jQuery('#username, #role_id').change(function () {
        //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
        // });
    };

})());
