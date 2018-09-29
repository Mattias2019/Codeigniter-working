/**
 * Created by geymur-vs on 18.08.17.
 */
var view_emailTemplates;

(new (function ViewEmailTemplates() {

    var _this = view_emailTemplates = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/emailSettings/index',
            function () {
                return {
                }
            },
            function () {
            },
            function () {
            },
            '.email-templates-table'
        );

        // jQuery('#username, #role_id').change(function () {
        //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
        // });
    };

})());
