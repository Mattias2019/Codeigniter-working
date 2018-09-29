/**
 * Created by geymur-vs on 18.08.17.
 */
var view_categories;

(new (function ViewCategories() {
    var _this = view_categories = this;

    this.init = function (base_url) {

        pagination.init(
            base_url,
            function () {
                return {
                }
            },
            function () {
            },
            function () {
                // jQuery('#username, #role_id').change(function () {
                //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
                // });
            },
            '.categories-table'
        );

        // jQuery('#username, #role_id').change(function () {
        //     pagination.loadPage(1, jQuery('.users-table'), true, 1, '.users-table');
        // });
    };

})());
