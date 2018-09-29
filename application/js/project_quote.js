var projectQuote;

(new (function ProjectQuote() {
    var _this = projectQuote = this;
    var _siteUrl = "";
    var _options = {};

    this.init = function (siteUrl, options) {
        _siteUrl = siteUrl || "";
        _options = options || {};

        timeToStr('.col-due-date');

        jQuery('body').on('change', '.js-milestone-amount-input, .js-milestone-escrow, .js-milestone-platform', milestoneAmountInput);

        jQuery('#tabs').find('a').click(showTab);
        jQuery('.table-button').click(showHideMilestone);
        jQuery('.remove_current_milestone').click(removeMilestone);
        jQuery('#create-milestone').click(loadMilestonePost);
        jQuery('.milestone-name-input').change(changeName);
        jQuery('.milestone-description-input').change(changeDescription);
        jQuery('.milestone-amount-input').change(changeAmount);
        jQuery('.milestone-escrow').change(changeFeePost);
        jQuery('.js-clear-cost').click(clearCost);
        //jQuery('.amount-input, .price-input, .vat-input').change(changeMilestone);
        jQuery('.attachment-delete').click(deleteAttachment);

        createDropzone(jQuery('.dropzone'));

        jQuery(".js-due-date").each(function () {
            createDatepicker(this);
        });

        jQuery("#quote-form table tr").each(function () {
            createNumberInputs(this);
        });

        _this.initWysihtml5();
        $('iframe.wysihtml5-sandbox').wysihtml5_size_matters();
        $('.inbox-wysihtml5').focus();
        $('ul.wysihtml5-toolbar > li > a > i').removeClass('icon-font').addClass('fa fa-font');
    };


    function milestoneAmountInput() {
        var parent = jQuery(this).parents('.js-milestone');
        var amount = jQuery(parent).find('.js-milestone-amount-input');
        var platformFee = jQuery(parent).find('.js-milestone-platform-fee');
        var platform = jQuery(parent).find('.js-milestone-platform');


        var escrowFee = jQuery(parent).find('.js-milestone-escrow-fee');
        var escrow = jQuery(parent).find('.js-milestone-escrow');

        /*escrow*/
        if (jQuery(escrow).is(':checked')) {
            m.post(
                _siteUrl + '/project/feeCount', {
                    amount: jQuery(amount).val(),
                    type: 'escrow_fee'
                },
                function (data) {
                    jQuery(escrowFee).html('$' + data.data.feeCount);
                }
            );
        } else {
            jQuery(escrowFee).html('$0');
        }
        /*end escrow*/


        /*platform*/
        if (jQuery(platform).is(':checked')) {
            m.post(
                _siteUrl + '/project/feeCount', {
                    amount: jQuery(amount).val(),
                    type: 'platform_fee'
                },
                function (data) {
                    jQuery(platformFee).html('$' + data.data.feeCount);
                }
            );
        } else {
            jQuery(platformFee).html('$0');
        }
        /*end platform*/
    }

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

        $('.milestone-description-input').wysihtml5({
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

    function escrowCount() {

        if (jQuery(".js-escrow_required").is(':checked')) {
            m.post(
                _siteUrl + '/project/escrowCount', {
                    amount: jQuery(".js-milestone-amount-input").val()
                },
                function (data) {
                    var escrowFee = '$' + data.data.escrowFee;
                    jQuery('.js-milestone-fee').html(escrowFee);
                }
            );
        } else {
            var escrowFee = '$0';
            jQuery('.js-milestone-fee').html(escrowFee);
        }

    }

    function createNumberInputs(element) {
        var input = $(element).find('input.amount-input, input.price-input, input.vat-input');
        input.inputmask("decimal");
        input.change(changeCost);

        input = $(element).find('input.milestone-amount-input');
        input.inputmask("decimal");
        input.change(changeAmount);
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
        pickElem.datepicker('setDate', currTime > 0 ? new Date(currTime) : new Date());
    }


    function createDropzone(elements) {
        for (var i = 0; i < elements.length; i++) {
            var milestone = jQuery(elements[i]).data('milestone');
            var url;
            if (milestone == undefined) {
                url = _siteUrl + '/project/upload_files';
            } else {
                url = _siteUrl + '/project/upload_files?milestone=' + milestone;
            }
            jQuery(elements[i]).dropzone({
                url: url,
                addRemoveLinks: true,
                dictDefaultMessage: "<span class='fa fa-paperclip'></span>" + _options['drop-your-file-here'],
                maxFiles: 1,
                maxFilesize: 500,
                maxThumbnailFilesize: 100,
                createImageThumbnails: true,
                acceptedFiles:
                "image/*," +
                "text/plain," +
                "application/msword," +
                "application/msexcel," +
                "application/rar," +
                "application/zip," +
                "application/pdf," +
                ".doc, .docx, .xls, .xlsx, .pdf",

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
                    var attachments = jQuery(this.element).parent().find('.attachments');
                    attachments.append(response);
                    jQuery('.attachment-delete').click(deleteAttachment);
                    this.removeAllFiles();
                }
            });
        }
    }

    function showTab(e) {
        e.preventDefault();
        var tab = jQuery(this).closest('li').attr('id');
        var activeTab = jQuery('#tabs').find('li.active').attr('id');
        if (tab != activeTab) {
            jQuery('#' + activeTab).removeClass('active');
            jQuery('#' + activeTab + '-data').hide();
            jQuery('#' + tab).addClass('active');
            jQuery('#' + tab + '-data').show();
        }
    }

    function showHideMilestone(e) {
        e.preventDefault();
        var container = jQuery(this).closest('tr').next();
        container.toggle();
    }

    function loadMilestonePost(e) {
        e.preventDefault();
        var nextMilestone = Number(jQuery('tr:last').data('num')) + 1;
        if (isNaN(nextMilestone)) {
            nextMilestone = 1;
        }
        m.post(
            _siteUrl + '/project/quote_milestone', {
                milestone: nextMilestone
            },
            function (data) {
                jQuery('#table-summary').find('tbody').append(data.summary);
                jQuery('#table-labor').find('tbody').append(data.labor);
                jQuery('#table-material').find('tbody').append(data.material);
                jQuery('#table-third-party').find('tbody').append(data.third_party);
                jQuery('#table-travel').find('tbody').append(data.travel);

                jQuery('.table-button:last').click(showHideMilestone);
                jQuery('.remove_current_milestone:last').click(removeMilestone);

                jQuery('.milestone-name-input:last').change(changeName);
                jQuery('.milestone-description-input:last').change(changeDescription);
                //jQuery('.milestone-due_date-input:last').change(changeDueDate);
                jQuery('.milestone-amount-input:last').change(changeAmount);
                //jQuery('.amount-input:last-of-type, .price-input:last-of-type, .vat-input:last-of-type').change(changeMilestone);
                jQuery('.attachments:last').click(deleteAttachment);

                setInputmask();
                createDropzone(jQuery('.dropzone:last'));
                createDatepicker(jQuery('.js-due-date:last'));
                createNumberInputs(jQuery('#quote-form table tr'));
            }
        );
    }

    function removeMilestone(e) {
        e.preventDefault();
        // Get all rows with number in all tables
        var row = jQuery(this).closest('tr');
        var row2 = row.prev();
        var added = row.find('.milestone-added-input');
        var deleted = row.find('.milestone-deleted-input');
        var addedCur = row.find('.milestone-added-cur-input');
        var deletedCur = row.find('.milestone-deleted-cur-input');
        var num = row2.data('num');
        var rows = jQuery('tr[data-num=' + num + ']');
        // Remove milestone if it was added in this loop
        if (addedCur.val() == '1') {
            rows.remove();
        }
        // Unmark as deleted if it was marked
        else if (deletedCur.val() == '1') {
            deletedCur.val('0');
            rows.find('.milestone-deleted').remove();
            jQuery(this).find('span').text('Delete');
            if (added.val() == '1') {
                rows.find('.milestone-name').append('<span class="milestone-added">' + _options['milestone-added'] + '</span>');
            }
        }
        // Otherwise mark as deleted
        else {
            deletedCur.val('1');
            if (deleted.val() == '1') {
                rows.find('.milestone-name').append('<span class="milestone-deleted">' + _options['milestone-deleted'] + '</span>');
            } else {
                rows.find('.milestone-name').append('<span class="milestone-deleted">' + _options['deleted'] + '</span>');
            }
            rows.find('.milestone-added').remove();
            jQuery(this).find('span').text(_options['deleted']);
        }
    }

    function changeName() {
        var row = jQuery(this).closest('tr');
        var num = row.data('num');
        var rows = jQuery('tr[data-num=' + num + ']');
        rows.find('.milestone-name > strong').text(jQuery(this).val());
    }

    function changeDescription() {
        var row = jQuery(this).closest('tr');
        var num = row.data('num');
        var rows = jQuery('tr[data-num=' + num + ']');
        rows.find('.milestone-description').text(jQuery(this).val());
    }


    function changeAmount() {
        var row = jQuery(this).closest('tr');
        var num = row.data('num');
        var rows = jQuery('tr[data-num=' + num + ']');
        var value = jQuery(this).val();
        rows.find('.milestone-amount').text('$' + Number(value).toLocaleString());
        if (num > 0) {
            recalculateTotalsByMilestoneNumber(num, value);
        }
    }

    function changeFeePost() {
        var row = jQuery(this).closest('tr').data('num');
        var container = jQuery(this).closest('.quote-milestone-container');
        var checked = container.find('.milestone-escrow').is(':checked');
        var amount = Number(container.find('.milestone-amount-input').val());
        if (!checked || isNaN(amount)) {
            amount = 0;
        }
        // Post ajax
        jQuery.ajax({
            url: _siteUrl + '/project/get_escrow_fee',
            data: {
                row: row,
                amount: amount
            },
            success: changeFee
        });
    }

    function changeFee(response) {
        var data = JSON.parse(response);
        jQuery('tr[data-num=' + data.row + ']').find('.milestone-fee').text(data.amount);
    }

    function calcCost(row) {
        var amount = Number($(row).find('.amount-input').val());
        var price = Number($(row).find('.price-input').val());
        var vat = Number($(row).find('.vat-input').val());

        var sum = amount * price;
        var vat_sum = sum * vat / 100;
        return {
            amount: amount,
            price: price,
            sum: sum,
            vat_sum: vat_sum,
            total: sum + vat_sum
        };
    }

    function deleteAttachment(e) {
        e.preventDefault();
        jQuery(this).closest('.attachment').remove();
    }

    function clearCost() {
        var curRow = jQuery(this).closest('tr');
        $(curRow).find('input.table-input').val("");
        changeCost.call(this);
    }

    function changeCost() {
        var currency = _options['currency'] || "";
        var tbody = jQuery(this).closest('tbody');
        var cost = {amount: 0, price: 0, vat_sum: 0, total: 0};

        var totalRow = tbody.find("tr[data-num='0']");
        tbody.find("tr[data-num!='0']").each(function () {
            var t = calcCost(this);
            cost.amount += t.amount;
            cost.price += t.price;
            cost.vat_sum += t.vat_sum;
            cost.total += t.total;
            $(this).find('.cost-vat_sum').text(currency + Number(t.vat_sum).toLocaleString());
            $(this).find('.cost-total').text(currency + Number(t.total).toLocaleString());
            $(this).find('input.js-cost-vat').val(t.vat_sum);
            $(this).find('input.js-cost-total').val(t.total);
        });
        if (cost.total > 0) {
            totalRow.addClass('disabled-row');
            totalRow.find('input.table-input').prop('readonly', true);
            totalRow.find('input.js-cost-vat').val(cost.vat_sum);
            totalRow.find('input.js-cost-total').val(cost.total);
            totalRow.find('.amount-input').val(parseInt(cost.amount));
            totalRow.find('.price-input').val(cost.price);
            totalRow.find('.cost-vat_sum').text(currency + Number(cost.vat_sum).toLocaleString());
            totalRow.find('.cost-total').text(currency + Number(cost.total).toLocaleString());
        } else {
            totalRow.removeClass('disabled-row');
            totalRow.find('input.table-input').prop('readonly', false);
            var tProject = calcCost(totalRow);
            cost.amount += tProject.amount;
            cost.price += tProject.price;
            cost.vat_sum += tProject.vat_sum;
            cost.total += tProject.total;
            $(totalRow).find('.cost-vat_sum').text(currency + Number(tProject.vat_sum).toLocaleString());
            $(totalRow).find('.cost-total').text(currency + Number(tProject.total).toLocaleString());
            $(totalRow).find('input.js-cost-vat').val(tProject.vat_sum);
            $(totalRow).find('input.js-cost-total').val(tProject.total);
        }

        var curRow = jQuery(this).closest('tr');
        var curMilestoneNumber = curRow.attr('data-num');

        recalculateTotalsByMilestoneNumber(curMilestoneNumber);
    }

    function recalculateTotalsByMilestoneNumber(curMilestoneNumber, milestoneTotal) {
        // Change milestone totals on Summary tab
        milestoneTotal = milestoneTotal || 0;
        if (milestoneTotal === 0) {
            $('#quote-form .tab-data')
                .not(':first')
                .find('tr[data-num="' + curMilestoneNumber + '"] .js-cost-total').each(function () {
                var v = $(this).val();
                milestoneTotal += v ? parseFloat(v) : 0;
            });
            updateSummaryTab(curMilestoneNumber, milestoneTotal);
        }


        // Change project total on Summary tab
        var projectTotal = 0;
        $('#quote-form .tab-data')
            .not(':first')
            .find('tr[data-num="0"] .js-cost-total').each(function () {
            var v = $(this).val();
            projectTotal += v ? parseFloat(v) : 0;
        });

        $('#table-summary tr[data-num!="0"].js-data-block td .milestone-amount-input:not([readonly])').each(function () {
            var v = $(this).val();
            projectTotal += v ? parseFloat(v) : 0;
        });

        updateSummaryTab(0, projectTotal);
    }

    function updateSummaryTab(num, total) {
        var currency = _options['currency'] || "";
        var element = $('#quote-form .tab-data:first tr[data-num=' + num + '].js-data-block');
        element.find('.milestone-amount-input').prop('readonly', total > 0);
        element.find('.milestone-amount-input').val(total.toString());
        element.find('.milestone-amount-input').prop('value', total.toString());
        element = $('#quote-form .tab-data:first tr[data-num=' + num + '].js-row-block');
        element.find('.milestone-amount').text(currency + Number(total).toLocaleString());
    }

    function timeToStr(selector) {

        var target = $(selector);

        target.each(function () {

            var time = $(this).html().trim();
            var str = '';

            if (+time) {
                str = moment(time * 1000).format('YYYY/MM/DD');
            }

            $(this).html(str);
        });
    }

})());