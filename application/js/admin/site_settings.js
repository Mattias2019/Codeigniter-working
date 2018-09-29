/**
 * Created by geymur-vs on 05.08.17.
 */

var site_settings;

(new (function SiteSettings() {
    var _this = site_settings = this;

    this.init = function () {

        $('#site_status').change(function() {
            // this will contain a reference to the checkbox
            if (this.checked) {
                $(this).prop('value', '1');
            } else {
                // the checkbox is now no longer checked
                $(this).prop('value', '0');
            }
        });
    };

})());