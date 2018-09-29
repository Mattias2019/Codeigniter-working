/**
 * Created by geymur-vs on 18.08.17.
 */
var view_jobs;

(new (function ViewJobs() {

    var _this = view_jobs = this;

    var _siteUrl = "";

    this.init = function (adminUrl) {

        _siteUrl = adminUrl;

        $("#find-projects-btn").click(function (e) {

            e.preventDefault();

            pagination.loadPage(0, jQuery('.jobs-table'), true, 1, '.jobs-table');

        });

        $("#reset-find-projects-btn").click(function (e) {

            e.preventDefault();

            $('#id').val(null);
            $('#job_name').val(null);

            pagination.loadPage(0, jQuery('.jobs-table'), true, 1, '.jobs-table');

        });

        $('.jobs-table .table tbody tr .btn-delete').click(function (e) {

            e.preventDefault();

            _this.deleteJob($(this).attr('href'));
        });

        this.deleteJob = function (url) {
            m.dialog({
                header: m.t("delete-job"),
                body : m.t("ask-delete-job"),
                btnOk: {
                    label: m.t("ok"),
                    callback: function() {
                        m.post(
                            url, {},
                            function (response) {
                                pagination.loadPage(0, jQuery('.jobs-table'), true, 0, '.jobs-table');
                                m.toast.success(response.message);
                            }
                        );
                    }
                },
                btnCancel: function() {}
            });
        };

        pagination.init(
            adminUrl + '/skills/viewJobs',
            function () {
                return {
                    id: jQuery('#id').val(),
                    job_name: jQuery('#job_name').val()
                }
            },
            function () {
                $('.jobs-table .table tbody tr .btn-delete').click(function (e) {

                    e.preventDefault();

                    _this.deleteJob($(this).attr('href'));
                });
            },
            function () {
            },
            '.jobs-table'
        );

        // jQuery('#username, #role_id').change(function () {
        //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
        // });
    };

})());
