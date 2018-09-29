var project;

(new (function Project() {
    var _this = project = this;
    var _siteUrl = "";
    var _typeAjaxSearchUser = "";

    this.init = function (siteUrl, typeAjaxSearchUser) {

        _siteUrl = siteUrl || "";
        _typeAjaxSearchUser = typeAjaxSearchUser || "";

        //Dropzone Configuration
        Dropzone.autoDiscover = false;

        jQuery("#js-autocomplete-ajax").autocomplete({
            source: function (request, response) {
                var data = {
                    "name": request.term,
                    "type": _typeAjaxSearchUser
                };
                m.post(_siteUrl + "/account/findUserByNameOrEmail", data,
                    function (result) {
                        response(result);
                    }
                );
            },
            minLength: 2,
            select: function (event, ui) {
                jQuery("#js-invite_suppliers").val(ui.item.value);
                jQuery("#js-autocomplete-ajax").val(ui.item.label);
                ui.item.value = ui.item.label;
            }
        });

        createDropzone(jQuery(".dropzone"));

        jQuery(".js-due-date").each(function () {
            createDatepicker(this);
        });


        jQuery('#submit-draft, #submit-new, #submit-publish').click(launchSubmit);
        jQuery("#add_milestone").click(loadMilestone);
        jQuery('.remove_current_milestone').click(removeMilestone);
        jQuery('.delete-project').click(deleteDraft);
        jQuery('.attachment-delete').click(deleteAttachment);

        jQuery('#open_days').change(function () {
            jQuery('#open_days_changed').val(1);
        });


        $('#picker_date').datepicker({
            format: 'dd M yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', changeDueDate);
        $('#picker_date').datepicker('setDate', new Date($("#due_date").val() * 1000));
        var currTime = $("#due_date").val() * 1000;
        $('#picker_date').datepicker('setDate', currTime>0?new Date(currTime):new Date());

        _this.initWysihtml5();
        $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
        $('.inbox-wysihtml5').focus();
        $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');

        jQuery(".rating").each(function (key, data) {
            jQuery(data).rateYo({
                rating: jQuery(data).parent().find('.rating-value').val(),
                starWidth: "16px",
                ratedFill: jQuery(data).hasClass('review-rating') ? "#1e88e5" : "#ffca28",
                normalFill: "#e0e0e0",
                readOnly: true
            });
        });

        $("#find-supplier-btn").click(function (e) {

            e.preventDefault();

            pagination.loadPage(0, jQuery('.suppliers-table'), true, 1, '.suppliers-table');
            _this.initButtons();

        });

        $("#invite-supplier-btn").click(function (e) {

            e.preventDefault();

            m.post(
                _siteUrl + '/project/inviteSupplier',
                {
                    project_id: $(this).attr('data-project-id'),
                    suppliersList: $('.suppliers-table').find("input[name='suppliersList[]']:checked").map(function () {
                        return this.value;
                    }).toArray()
                },
                // refresh invited suppliers
                function (data)
                {
                    $('.invited-suppliers-list-body').html(data.html);

                    jQuery(".rating").each(function (key, data) {
                        jQuery(data).rateYo({
                            rating: jQuery(data).parent().find('.rating-value').val(),
                            starWidth: "16px",
                            ratedFill: jQuery(data).hasClass('review-rating') ? "#1e88e5" : "#ffca28",
                            normalFill: "#e0e0e0",
                            readOnly: true
                        });
                    });

                    pagination.loadPage(0, jQuery('.suppliers-table'), true, 1, '.suppliers-table');
                    // m.toast.success(data.message);
                    _this.initButtons();
                },
                // invite failed
                function (data)
                {
                    m.toast.error(data.message);
                }
            );

        });

        pagination.init(
            siteUrl + '/project/getSuppliersList',
            function () {
                return {
                    supplier_name: jQuery('#supplier_name').val()
                }
            },
            function () {
                _this.initButtons();
            },
            function () {
            },
            '.suppliers-table'
        );

        _this.initButtons();
    };

    this.initButtons = function() {

        $(".suppliers-table .table tbody tr .view-supplier-info-btn").click(function (e) {

            e.preventDefault();

            _this.viewSupplierInfo(this);
        });

        $(".invited-suppliers-list .invited-suppliers-list-body .supplier .supplier-body .view-invited-supplier-info-btn").click(function (e) {

            e.preventDefault();

            _this.viewSupplierInfo(this);
        });
    };

    this.viewSupplierInfo = function (element) {

        var url = $(element).attr('href');
        var supplier_id = $(element).attr('data-supplier-id');

        m.dialog({
            header: m.t("Supplier Info"),
            url: url,
            data: {'supplier_id': supplier_id},
            btnOk: {
                label: m.t("ok")
            }
        });

        jQuery(".supplier_rating").each(function (key, data) {
            jQuery(data).rateYo({
                rating: jQuery(data).parent().find('.rating-value').val(),
                starWidth: "16px",
                ratedFill: jQuery(data).hasClass('review-rating') ? "#1e88e5" : "#ffca28",
                normalFill: "#e0e0e0",
                readOnly: true
            });
        });
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

        $('.project_description').wysihtml5({
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

    function changeDueDate() {
        var to = $("#picker_date").datepicker('getDate');
        if (to != null) {
            $('#due_date').val(to.getTime() / 1000);
        }
    }
    function createDropzone(elements)
    {
        for (var i = 0; i < elements.length; i++) {

            var milestone = jQuery(elements[i]).data('milestone');
            var url;
            var proj_id = $('#post_project_frm').find('input[name="id"]').val();
            var proj_param = proj_id ? '/'+proj_id : '';

            if (milestone == undefined) {
                url = site_url + "/project/upload_files" + proj_param;
            } else {
                url = site_url + "/project/upload_files" + proj_param + "?milestone=" + milestone;
            }

            jQuery(elements[i]).dropzone({
                url: url,
                addRemoveLinks: true,
                dictDefaultMessage: "<span class='fa fa-paperclip'></span>" + m.t('Drop your files here'),
                maxFiles: 1,
                maxFilesize: 500,
                maxThumbnailFilesize: 100,
                createImageThumbnails: true,
                acceptedFiles: "image/*,text/plain,application/msword,application/msexcel,application/rar,application/zip,application/pdf",
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
                    var attachments = jQuery(this.element).parent().find('.attachments');
                    attachments.append(response);
                    this.removeAllFiles();
                    jQuery('.attachment-delete:last').click(deleteAttachment);
                }
            });
        }
    }

    function createDatepicker(element) {
        var pickElem = $(element).find('.js-picker-date');
        pickElem.datepicker({
            format: 'dd M yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function () {
            var to = $(element).children('.js-picker-date').datepicker('getDate');
            if (to != null) {
                $(element).children('.milestone_due_date').val(to.getTime() / 1000);
            }
        });
        var currTime = $(element).children('.milestone_due_date').val() * 1000;
        pickElem.datepicker('setDate', currTime>0?new Date(currTime):new Date());
    }

    function loadMilestone(e)
    {
        e.preventDefault();
        var nextMilestone = Number(jQuery('.milestone').length) + 1;
        if (isNaN(nextMilestone)) {
            nextMilestone = 1;
        }

        var form_data = $('#post_project_frm').serialize();

        m.post(
            _siteUrl + '/project/create_milestone',
            {
                milestone: nextMilestone,
                form_data: form_data
            },
            function (data)
            {
                jQuery('.milestone-wrapper').append(data.data);
                createDropzone(jQuery('.dropzone:last'));
                setInputmask();
                jQuery('.remove_current_milestone:last').click(removeMilestone);
                createDatepicker(jQuery('.js-due-date:last'));
            }
        );
    }

    function removeMilestone(e)
    {
        e.preventDefault();
        jQuery(this).closest('.milestone').remove();
    }

    function launchSubmit()
    {
        // Set selected categories
        jQuery('#category').val(jQuery("input[name='category[]']:checked").map(function () {
            return this.value;
        }).toArray());

        // Set submit type
        var submit = jQuery('#form-submit');
        var id = jQuery(this).attr('id');
        switch (id) {
            case 'submit-draft':
                submit.val('draft');
                break;
            case 'submit-new':
                submit.val('new');
                break;
            case 'submit-publish':
                submit.val('publish');
                break;
        }
        submit.click();
    }

    function deleteAttachment(e)
    {
        e.preventDefault();
        jQuery(this).closest('.attachment').remove();
    }

    function deleteDraft(e) {
        e.preventDefault();
        var url = jQuery(this).attr('href');
        var row = jQuery(this).closest('.row');
        m.dialog({
            header: 'Delete project',
            body: 'Do you wish to delete project?',
            btnOk: {
                label:'Yes',
                callback: function() {
                    m.post(url, null, function(result) {
                        row.remove();
                        // If it is current project, clear the ID
                        var inputId = jQuery('input[name=id]');
                        if (inputId.val() == result.id) {
                            inputId.val('');
                        }
                    });
                }
            },
            btnCancel: {
                label:'No'
            }
        });
    }

})());