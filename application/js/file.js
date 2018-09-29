var file;

(new (function File() {
    var _this = file = this;
    var _siteUrl = "";

    this.init = function (siteUrl) {

        _siteUrl = siteUrl || "";

        timeToStr('.col-exp-date');

        //Dropzone Configuration
        Dropzone.autoDiscover = false;

        pagination.init(
            site_url + '/file/index',
            null,
            function () {
                timeToStr('.col-exp-date');
                jQuery('.file-delete').click(deleteFile);
            },
            function () {
                createDropzone(jQuery('.dropzone'));
                createDatepicker(jQuery('#picker_date'), jQuery("#expire_date"), changeExpireDate);
                jQuery('#job_id').change(getMilestones);
                jQuery('.attachment-delete').click(deleteAttachment);

                _this.initWysihtml5();
                $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
                $('.inbox-wysihtml5').focus();
                $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
            }
        );

        jQuery('.file-delete').click(deleteFile);

        jQuery('#job_id').change(getMilestones);
        jQuery('.attachment-delete').click(deleteAttachment);

        createDropzone(jQuery('.dropzone'));
        createDatepicker(jQuery('#picker_date'), jQuery("#expire_date"), changeExpireDate);

        jQuery('[data-toggle="tooltip"]').tooltip();

        _this.initWysihtml5();
        $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
        $('.inbox-wysihtml5').focus();
        $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');

        $('.projects-table tbody tr .btn-edit').click(function (e) {

            e.preventDefault();

            _this.editProjectRow(
                $(this).attr('href'),
                $(this).attr('data-id'),
                $(this).attr('data-project-id'),
                $(this).attr('data-milestone-id')
            );
        });

        $('.projects-table tbody tr .btn-copy').click(function (e) {

            e.preventDefault();

            _this.copyProjectRow(
                $(this).attr('href'),
                $(this).attr('data-id'),
                $(this).attr('data-project-id'),
                $(this).attr('data-milestone-id')
            );
        });
    };

    this.editProjectRow = function (url, id, job_id, milestone_id) {
        m.post(
            url,
            {
                id: id,
                job_id: job_id,
                milestone_id: milestone_id,
                action: 'edit',
                tab: 1
            },
            function (data) {
                $('.file-upload').html(data.data);

                createDropzone(jQuery('.dropzone'));
                createDatepicker(jQuery('#picker_date'), jQuery("#expire_date"), changeExpireDate);

                jQuery('[data-toggle="tooltip"]').tooltip();

                _this.initWysihtml5();
                $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
                $('.inbox-wysihtml5').focus();
                $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
            }
        );
    };

    this.copyProjectRow = function (url, id, job_id, milestone_id) {
        m.post(
            url,
            {
                id: id,
                job_id: job_id,
                milestone_id: milestone_id,
                action: 'copy',
                tab: 1
            },
            function (data) {
                $('.file-upload').html(data.data);

                createDropzone(jQuery('.dropzone'));
                createDatepicker(jQuery('#picker_date'), jQuery("#expire_date"), changeExpireDate);

                jQuery('[data-toggle="tooltip"]').tooltip();

                _this.initWysihtml5();
                $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
                $('.inbox-wysihtml5').focus();
                $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
            }
        );
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

        $('.description').wysihtml5({
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

    function changeExpireDate() {
        var to = $("#picker_date").datepicker('getDate');
        if (to != null) {
            $('#expire_date').val(to.getTime() / 1000);
        }
    }

    function createDropzone(element)
    {
        element.dropzone({
            url: site_url + '/file/upload',
            dictDefaultMessage: "<span class='fa fa-paperclip'></span> " + m.t("Drop your files here"),
            acceptedFiles:
                'image/*,'+
                'text/plain,'+
                'application/rar,'+
                'application/zip,'+
                'application/pdf,'+
                'application/docx,'+
                'application/msword,'+
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document,'+
                'application/xlsx,'+
                'application/vnd.ms-excel,'+
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            maxFiles: 1,
            maxFilesize: 500,
            maxThumbnailFilesize: 100,
            createImageThumbnails: true,
            accept: function(file, done) {
                console.log("uploaded");
                done();
            },
            init: function() {
                this.on('error', function(file, response) {

                    var errorMessage;
                    var dz = this;

                    if (response && file.status >= 400 && response.match(/<\/html>/)) {
                        errorMessage = file.statusText;
                    } else {
                        errorMessage = response;
                    }

                    dz.disable();
                    $(file.previewElement).find('.dz-error-message').text(errorMessage);
                    $(file.previewElement).click(function (e) {
                        dz.removeAllFiles(true);
                        dz.enable();
                    });
                });
                this.on("maxfilesexceeded", function(file){
                    this.removeFile(file);
                    m.toast.error(m.t("No more files please!"));
                });
            },
            success: function (file, response) {
                var attachment = jQuery(this.element).parent().find('.attachment');
                attachment.html(response);
                jQuery('.attachment-delete').click(deleteAttachment);
                this.removeAllFiles();
                element.hide();
            }
        });
    }

    function createDatepicker(element, refElement, onChange) {

        element.datepicker({
            format: 'dd M yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', onChange);

        var initial_date = new Date();
        if (refElement.val()) {
            initial_date = new Date(refElement.val() * 1000);
        }

        element.datepicker('setDate', initial_date);
    }

    function deleteAttachment(e)
    {
        e.preventDefault();
        var attachment = jQuery('.attachment');
        attachment.find('.attachment-image, .attachment-delete').remove();
        attachment.find('input').val('');
        jQuery('.dropzone').show();
    }

    function getMilestones() {
        var id = jQuery(this).val();
        m.post(
            _siteUrl + '/file/get_milestones',
            {
                id: id
            },
            function (data) {
                jQuery('#milestone_id').html(data.message);
            }
        );
    }

    function deleteFile(e) {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('tr');
        m.dialog({
            header: m.t('Delete file'),
            body: m.t('Do you wish to delete file?'),
            btnOk: {
                label: m.t('Yes'),
                callback: function() {
                    m.post(url, null, function(result) {
                        row.remove();
                    });
                }
            },
            btnCancel: {
                label: m.t('No')
            }
        });
    }

    function timeToStr(selector) {

        var target = $(selector);

        target.each(function () {

            var time = $(this).html().trim();
            var str = '';

            if(+time) {
                str = moment(time*1000).format('YYYY/MM/DD');
            }

            $(this).html(str);
        });
    }

})());