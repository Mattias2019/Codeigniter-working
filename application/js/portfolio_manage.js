/**
 * Created by geymur-vs on 29.12.17.
 */

var portfolio_manage;

(new (function Portfolio_Manage() {

    var _this = portfolio_manage = this;
    var _siteUrl = "";

    this.init = function (siteUrl) {

        //Dropzone Configuration
        Dropzone.autoDiscover = false;

        _siteUrl = siteUrl || "";

        _this.createDropzone(jQuery(".dropzone"));

        jQuery('#manage-portfolio-form').submit(_this.launchSubmit);
        jQuery("#add-custom-item").click(_this.loadCustomItem);
        jQuery('.remove-custom-item').click(_this.removeCustomItem);
        jQuery('.delete-portfolio').click(_this.deletePortfolio);
        jQuery('.attachment-delete').click(_this.deleteAttachment);
        jQuery("input[name='category[]']").change(_this.loadItems);

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

        $('.machine_description').wysihtml5({
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

    this.createDropzone = function(element) {
        element.dropzone({
            url: _siteUrl + '/portfolio/upload_files',
            addRemoveLinks: true,
            dictDefaultMessage: "<span class='fa fa-paperclip'></span> " + m.t('Drop your files here'),
            maxFilesize: 500,
            maxThumbnailFilesize: 100,
            createImageThumbnails: true,
            maxFiles: 1,
            acceptedFiles: "image/*,.txt,.zip,.pdf,.doc,.docx,.xls,.xlsx",
            init: function () {
                this.on('error', function (file, response) {
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
                jQuery('.attachments').append(response);
                jQuery('.attachment-delete').click(_this.deleteAttachment);
                this.removeAllFiles();
            }
        });
    };

    this.loadCustomItem = function(e) {
        e.preventDefault();
        var nextCustomItem = $(".js-custom-items-tr").length + 1;
        if (isNaN(nextCustomItem)) {
            nextCustomItem = 0;
        }
        m.post(
            _siteUrl + '/portfolio/create_custom_item',
            {
                item: nextCustomItem
            },
            function (data) {
                jQuery('#items-custom-table').find('tbody').append(data.message);
                jQuery('.remove-custom-item:last').click(removeCustomItem);
            }
        );
    };

    this.removeCustomItem = function(e) {
        e.preventDefault();
        jQuery(this).closest('tr').remove();
    };

    this.launchSubmit = function(e) {
        // Set selected categories
        jQuery('#categories').val(jQuery("input[name='category[]']:checked").map(function () {
            return this.value;
        }).toArray());
    };

    this.deleteAttachment = function(e) {
        e.preventDefault();
        jQuery(this).closest('.attachment').remove();
    };

    this.loadItems = function() {
        m.post(
            _siteUrl + '/portfolio/get_standard_items',
            {
                categories: jQuery("input[name='category[]']:checked").map(function () {
                    return this.value;
                }).toArray()
            },
            function (data) {
                jQuery('#items-standard-table').find('tbody').html(data.message);
            }
        );
    };

    this.deletePortfolio = function(e) {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('.row');
        m.dialog({
            header: m.t('Delete portfolio'),
            body: m.t('Do you wish to delete portfolio?'),
            btnOk: {
                label: m.t('Yes'),
                callback: function () {
                    m.post(url, null, function (result) {
                        row.remove();
                    });
                }
            },
            btnCancel: {
                label: m.t('No')
            }
        });
    }

})());
