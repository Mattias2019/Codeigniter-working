/**
 * Created by geymur-vs on 05.10.17.
 */

var edit_category;

(new (function EditCategory() {

    var _this = edit_category = this;

    var _siteUrl = "";

    this.init = function (adminUrl) {

        _siteUrl = adminUrl;

        _this.createDropzone();

        jQuery('#delete_logo').click(function (e) {

            e.preventDefault();

            _this.deleteLogo();
        });
    };

    this.createDropzone = function() {

        jQuery('.dropzone').dropzone({
            url: _siteUrl + "/skills/upload_file",
            dictDefaultMessage: "<span class='fa fa-camera'></span>",
            maxFiles: 1,
            maxFilesize: 500,
            maxThumbnailFilesize: 100,
            createImageThumbnails: true,
            resizeWidth: 300,
            resizeHeight: 300,
            resizeMethod: "crop",
            acceptedFiles: "image/jpg, image/jpeg, image/png",
            init: function() {
                this.on('error', function(file, response) {
                    var errorMessage;
                    if (response && file.xhr.status >= 400 && response.match(/<\/html>/)) {
                        errorMessage = file.xhr.statusText;
                    } else {
                        errorMessage = response;
                    }
                    $(file.previewElement).find('.dz-error-message').text(errorMessage);
                });
            },
            success: function (file, response) {
                var data = JSON.parse(response);
                jQuery('#attachment_name').val(data.attachment_name);
                jQuery('#attachment_url').val(data.attachment_url);
                jQuery('#delete_logo').removeClass('disabled');
            }
        });
    };

    this.deleteLogo = function () {

        var image = jQuery('.logo-image');
        var dropzone = jQuery('.dropzone');
        if (image.is(':visible')) {
            image.hide();
            dropzone.show();
        } else {
            Dropzone.forElement('.dropzone').removeAllFiles();
        }
        jQuery('#attachment_name').val('');
        jQuery('#attachment_url').val('');
        jQuery('#delete_logo').addClass('disabled');
    }

})());