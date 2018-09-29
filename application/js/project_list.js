var project_list;

(new (function Project_list() {
    var _this = project_list = this;
    var _siteUrl = "";

    this.init = function(siteUrl) {
        _siteUrl = siteUrl || "";

        pagination.init(
            _siteUrl + '/project/project_list',
            null,
            function () {
                jQuery(".progress-bar").loading();
                jQuery('[data-toggle="tooltip"]').tooltip();
            }
        );

        jQuery(".progress-bar").loading();
        jQuery('[data-toggle="tooltip"]').tooltip();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            e.preventDefault();
            var a = jQuery(this).data('tab');
            pagination.loadPage(jQuery(this).data('tab'), null, false, 1);
        });
    };

})());