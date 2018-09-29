var packages;

(new (function Packages() {

    var _this = packages = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/packages/viewSubscriptionUser',
            function () {
                return {
                    name: jQuery('#search_name').val(),
                    email: jQuery('#search_email').val(),
                    package_id: jQuery('#search_package').val()
                }
            },
            function () {
                $('.table tbody tr .delete').click(function (e) {

                    e.preventDefault();

                    _this.deleteUser($(this).attr('href'));
                });
                jQuery('[data-toggle="tooltip"]').tooltip();
            }
        );

        jQuery('#search_name,#search_email, #search_package').change(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        $('.table tbody tr .delete').click(function (e) {

            e.preventDefault();

            _this.deleteUser($(this).attr('href'));
        });
        jQuery('[data-toggle="tooltip"]').tooltip();

        var select2 = $('#user_id').select2({
            placeholder: "-- Select a user --",
            allowClear: true
        });
        $('.select2-container--bootstrap').addClass('select2-container--default').removeClass('select2-container--bootstrap');

        if (select2) {
            select2.data('select2').$selection.css('height', '36px');
        }
    };

    this.deleteUser = function(url) {

        m.dialog({
            header: m.t('Delete subscription user'),
            body: m.t('Do you wish to delete subscription user?'),
            btnOk: {
                label: m.t('Yes'),
                callback: function() {
                    m.post(
                        url,
                        null,
                        function() {
                            pagination.loadPage(0, jQuery('.table-responsive'), false, 0);
                        });
                }
            },
            btnCancel: {
                label: m.t('No')
            }
        });
    };

})());