/**
 * Created by geymur-vs on 29.12.17.
 */

var account_edit;

(new (function Account_Edit() {

    var _this = account_edit = this;
    var _siteUrl = "";

    this.init = function (siteUrl) {

        //Dropzone Configuration
        Dropzone.autoDiscover = false;

        _siteUrl = siteUrl || "";

        _this.createDropzone($('.dropzone'));

        jQuery('#user-form').submit(_this.launchSubmit);

        jQuery('#delete_logo').click(_this.deleteLogo);

        // Generate secure password
        jQuery('#GenPasswordModal').on('show.bs.modal', _this.generateSecurePassword);

        jQuery('#use_secure_pwd').click(function() {
            jQuery('#GenPasswordModal').modal('hide');
            jQuery('#pick_password').val(jQuery('#suggest_password').val());
        });

        _this.initWysihtml5();
        $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
        $('.inbox-wysihtml5').focus();
        $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
    };

    this.initWysihtml5 = function () {

        var myCustomTemplates = {
            emphasis : function(locale) {
                return "<li>" +
                    "<div class='btn-group'>" +
                    "<a class='btn default' data-wysihtml5-command='bold' title='" + locale.emphasis.bold + "'>" +
                    "<i class='fa fa-bold'></i>" +
                    "</a>" +
                    "<a class='btn default' data-wysihtml5-command='italic' title='" + locale.emphasis.italic + "'>" +
                    "<i class='fa fa-italic'></i>" +
                    "</a>" +
                    "<a class='btn default' data-wysihtml5-command='underline' title='" + locale.emphasis.underline + "'>" +
                    "<i class='fa fa-underline'></i>" +
                    "</a>" +
                    "</div>" +
                    "</li>";
            }
        };

        $('.profile_desc').wysihtml5({
            "stylesheets": ["/application/plugins/bootstrap-wysihtml5/wysiwyg-color.css"],
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": false, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": false, //Button to change color of font
            customTemplates: myCustomTemplates
        });
    };

    // transform cropper dataURI output to a Blob which Dropzone accepts
    this.dataURItoBlob = function(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: 'image/jpeg' });
    };

    this.createDropzone = function(element)
    {
        element.dropzone({
            url: _siteUrl + '/account/upload_file',
            dictDefaultMessage: "<span class='fa fa-camera'></span>",
            maxFiles: 1,
            maxFilesize: 500,
            maxThumbnailFilesize: 100,
            createImageThumbnails: true,
            resizeWidth: 300,
            resizeHeight: 300,
            resizeMethod: "crop",
            clickable: true,
            acceptedFiles: "image/jpg, image/jpeg, image/png",
            init: function() {
                this.on('error', function(file, response) {
                    var errorMessage;
                    if (response && file.status === 'error' && response.match(/<\/html>/)) {
                        errorMessage = response;
                    } else {
                        errorMessage = response;
                    }
                    $(file.previewElement).find('.dz-error-message').text(errorMessage);

                    jQuery('#delete_logo').removeClass('disabled');
                });

                // listen to thumbnail event
                this.on('thumbnail', function (file) {

                    // ignore files which were already cropped and re-rendered
                    // to prevent infinite loop
                    if (file.cropped) {
                        return;
                    }

                    // cache filename to re-assign it to cropped file
                    var cachedFilename = file.name;

                    // remove not cropped file from dropzone (we will replace it later)
                    this.removeFile(file);

                    var dropzone_ = this;

                    // initialize FileReader which reads uploaded file
                    var reader = new FileReader();
                    reader.onloadend = function () {

                        var image_file = reader.result;

                        var $img;

                        var croppable = false;

                        // modal
                        m.dialog({
                            header: m.t("Crop Image"),
                            url: _siteUrl+'/account/crop_image',
                            data: {image_file: image_file},
                            btnOk: {
                                label: m.t("Upload"),
                                callback: function () {

                                    var croppedCanvas;
                                    var roundedCanvas;

                                    if (!croppable) {
                                        return;
                                    }

                                    // Crop
                                    croppedCanvas = $img.cropper('getCroppedCanvas');

                                    // Round
                                    roundedCanvas = getRoundedCanvas(croppedCanvas);

                                    // get cropped image data
                                    var blob = roundedCanvas.toDataURL();

                                    // transform it to Blob object
                                    var newFile = _this.dataURItoBlob(blob);

                                    // set 'cropped to true' (so that we don't get to that listener again)
                                    newFile.cropped = true;

                                    // assign original filename
                                    newFile.name = cachedFilename;

                                    // add cropped file to dropzone
                                    dropzone_.addFile(newFile);

                                    // upload cropped file with dropzone
                                    dropzone_.processQueue();
                                }
                            },
                            btnCancel: {
                                label: m.t('Cancel'),
                                callback: function () {
                                }
                            },
                            before: function(data) {

                                $img = $('.crop-image-container img');

                                // initialize cropper for uploaded image
                                $img.cropper({
                                    ready: function () {

                                        croppable = true;

                                        var cropBoxData = $img.cropper('getCropBoxData');

                                        var x_offset;
                                        var y_offset;

                                        if (cropBoxData.height > cropBoxData.width) {

                                            y_offset = (cropBoxData.height - cropBoxData.width) / 2;
                                            cropBoxData.top = cropBoxData.top + y_offset;

                                            cropBoxData.height = cropBoxData.width;
                                        }
                                        else if (cropBoxData.width > cropBoxData.height) {

                                            x_offset = (cropBoxData.width - cropBoxData.height) / 2;
                                            cropBoxData.left = cropBoxData.left + x_offset;

                                            cropBoxData.width = cropBoxData.height;
                                        }

                                        $img.cropper('setCropBoxData', cropBoxData);
                                    }
                                });
                            }
                        });
                    };

                    // read uploaded file (triggers code above)
                    reader.readAsDataURL(file);
                });
            },
            success: function (file, response) {
                var data = JSON.parse(response);
                jQuery('#logo').val(data.logo);
                jQuery('#img_logo').val(data.img_logo);
                jQuery('#delete_logo').removeClass('disabled');
            }
        });

        function getRoundedCanvas(sourceCanvas) {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var width = sourceCanvas.width;
            var height = sourceCanvas.height;
            canvas.width = width;
            canvas.height = height;
            context.beginPath();
            context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI);
            context.strokeStyle = 'rgba(0,0,0,0)';
            context.stroke();
            context.clip();
            context.drawImage(sourceCanvas, 0, 0, width, height);
            return canvas;
        }
    };

    this.deleteLogo = function() {
        var image = jQuery('.logo-image');
        var dropzone = jQuery('.dropzone');
        if (image.is(':visible')) {
            image.hide();
            dropzone.show();
        } else {
            Dropzone.forElement('.dropzone').removeAllFiles();
        }
        jQuery('#logo').val('');
        jQuery('#img_logo').val('');
        jQuery('#delete_logo').addClass('disabled');
    };

    this.generateSecurePassword = function () {

        var special = true;
        var iteration = 0;
        var password = "";
        var randomNumber;
        if(special == undefined){
            special = false;
        }
        while(iteration < 8){
            randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
            if(!special){
                if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
                if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
                if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
                if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
            }
            iteration++;
            password += String.fromCharCode(randomNumber);
        }

        jQuery('#suggest_password').val(password);

    };

    this.launchSubmit = function ()
    {
        // Set selected categories
        jQuery('#categories').val(jQuery("input[name='category[]']:checked").map(function () {
            return this.value;
        }).toArray());
    }

})());
