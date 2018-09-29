var finance;

(new (function Finance() {
    var _this = finance = this;
    var _siteUrl = "";

    this.init = function (siteUrl) {
        _siteUrl = siteUrl || "";
        jQuery('input.js-wire').change(function() {
            jQuery('.js-wire-fields').removeClass('hidden');
        });
        jQuery('input.js-paypal').change(function() {
            jQuery('.js-wire-fields').addClass('hidden');
        });
        pagination.init(
            site_url + '/finance',
            function () {
                var date_begin = jQuery('#invoice-filter-start-date').val();
                var date_end = jQuery('#invoice-filter-end-date').val();
                return {
                    date_begin: isNaN(date_begin)?'':date_begin,
                    date_end: isNaN(date_end)?'':date_end
                };
            },
            null,
            function (data) {
                jQuery('[data-toggle="tooltip"]').tooltip();
                var amount = jQuery('input[name=amount]');
                if (amount.length > 0) {
                    amount.change(calcTotal);
                }
                jQuery('#job_id').change(changeProject);
                jQuery('#milestone_id').change(changeMilestone);
                jQuery('input[name=payment_method]').change(changePaymentMethod);
                setInputmask();
                if (chart != undefined) {
                    chart.validateNow();
                }
                if (calendar != undefined) {
                    calendar.validateNow();
                }
                createDatepicker(jQuery('#invoice-filter-start-date-picker'), jQuery('#invoice-filter-start-date'), changeStartDate);
                createDatepicker(jQuery('#invoice-filter-end-date-picker'), jQuery('#invoice-filter-end-date'), changeEndDate);
            }
        );

        jQuery('[data-toggle="tooltip"]').tooltip();

        var amount = jQuery('input[name=amount]');
        if (amount.length > 0) {
            amount.change(calcTotal);
        }

        var inputJobId = jQuery('#job_id');
        var inputMilestoneId = jQuery('#milestone_id');
        var inputPaymentMethod = jQuery('input[name=payment_method]');

        inputJobId.change(changeProject);
        inputMilestoneId.change(changeMilestone);
        inputPaymentMethod.change(changePaymentMethod);

        // Load project
        if (inputJobId.val() != '') {
            changeProject();
        }
        if (inputPaymentMethod.val() != '') {
            changePaymentMethod();
        }

        createDatepicker(jQuery('#invoice-filter-start-date-picker'), jQuery('#invoice-filter-start-date'), changeStartDate);
        createDatepicker(jQuery('#invoice-filter-end-date-picker'), jQuery('#invoice-filter-end-date'), changeEndDate);
    };

    function createDatepicker(element, refElement, onChange) {
        element.datepicker({
            format: 'dd M yyyy',
            autoclose: true,
            todayHighlight: true
        });
        element.datepicker('setDate', new Date(refElement.val() * 1000));
        element.on('changeDate', onChange);
    }

    function changeStartDate(e) {
        var to = $("#invoice-filter-start-date-picker").datepicker('getDate');
        if (to != null) {
            $('#invoice-filter-start-date').val(to.getTime() / 1000);
        }
        pagination.loadPage(0, jQuery('.table-responsive'), false, 0);
    }

    function changeEndDate(e) {
        var to = $("#invoice-filter-end-date-picker").datepicker('getDate');
        if (to != null) {
            $('#invoice-filter-end-date').val(to.getTime() / 1000);
        }
        pagination.loadPage(0, jQuery('.table-responsive'), false, 0);
    }

    function calcTotal() {
        if (jQuery('input[name=operation]').val() == 'escrow') {
            m.post(
                site_url + '/finance/get_escrow_total',
                {
                    amount: jQuery('input[name=amount]').val()
                },
                function (data) {
                    var amountTotal = jQuery('#amount-total');
                    if (data.data == "") {
                        amountTotal.hide();
                    } else {
                        amountTotal.show();
                    }
                    jQuery('#amount-total-text').text(data.data);
                    jQuery('input[name=total]').val(data.data);
                }
            );
        }
    }

    function changeProject() {
        var id = jQuery('#job_id').val();
        m.post(
            site_url + '/finance/get_project_info',
            {
                project: id
            },
            function (data)
            {
                jQuery('#milestone_id').html(data.milestones);
                jQuery('#reciever_id').html(data.recievers);
                jQuery('#project-due-input').val(data.due);
                jQuery('#project-due').html(data.due);
            }
        );
    }

    function changeMilestone() {
        var id = jQuery('#milestone_id').val();
        var url;
        if (id == '') {
            url = site_url + '/finance/get_project_info';
        } else {
            url = site_url + '/finance/get_milestone_info';
        }
        m.post(
            url,
            {
                project: jQuery('#job_id').val(),
                milestone: id
            },
            function (data)
            {
                jQuery('#project-due-input').val(data.due);
                jQuery('#project-due').html(data.due);
            }
        );
    }

    function changePaymentMethod() {
        var method = jQuery('input[name=payment_method]:checked').val();
        // Paypal Withdraw
        if (method == 1 && jQuery('input[name=operation]').val() == 'withdraw') {
            jQuery('#paypal-email-container').removeClass('hidden');
        } else {
            jQuery('#paypal-email-container').addClass('hidden');
        }
    }

})());