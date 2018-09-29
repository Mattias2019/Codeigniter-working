var inbox;

(new (function Inbox() {
    var _this = inbox = this;

    var content = $('.inbox-content');

    this.init = function(adminUrl) {
        _this.initWysihtml5();
        $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
        $('.inbox-wysihtml5').focus();
        $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
    };

    this.initWysihtml5 = function () {
        $('.inbox-wysihtml5').wysihtml5({
            "stylesheets": ["/application/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
        });
    };

})());