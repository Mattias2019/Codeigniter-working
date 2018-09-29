/**
 * Created by geymur-vs on 18.08.17.
 */
var view_users;

(new (function ViewUsers() {

    var _this = view_users = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        $("#find-user-btn").click(function (e) {

            e.preventDefault();

            pagination.loadPage(0, jQuery('.users-table'), true, 1, '.users-table');

        });

        $("#reset-find-user-btn").click(function (e) {

            e.preventDefault();

            $('#username').val("");
            $('#role_id').val("");

            m.post(
                siteUrl + '/users/resetSearchFilter',
                {},
                function () {
                    pagination.loadPage(0, jQuery('.users-table'), true, 0, '.users-table');
                }
            );
        });

        $('.users-table .table tbody tr .btn-delete').click(function (e) {

            e.preventDefault();

            _this.deleteUser($(this).attr('href'));
        });

        pagination.init(
            siteUrl + '/users/viewUsers',
            function () {
                return {
                    username: jQuery('#username').val(),
                    role_id: jQuery('#role_id').val()
                }
            },
            function () {
                $('.users-table .table tbody tr .btn-delete').click(function (e) {

                    e.preventDefault();

                    _this.deleteUser($(this).attr('href'));
                });
            },
            function () {
            },
            '.users-table'
        );

        // jQuery('#username, #role_id').change(function () {
        //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
        // });
    };

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

})());
