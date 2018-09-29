var transactions;

(new (function Transactions() {

    var _this = transactions = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/payments/transaction',
            function () {
                return {
                    id: jQuery('#js-search-id').val(),
                    type: jQuery('#js-search-type').val()
                }

            },
            function () {
                jQuery('.table-button').click(_this.transactionOperation);
            },
            function () {

                jQuery('#js-search-id, #js-search-type').change(function () {
                    pagination.loadPage(1, jQuery('.table-responsive'), true, 1);
                });

                jQuery('#type').change(_this.changeType);
                jQuery('#user_id').change(_this.changeUser);
                jQuery('#job_id').change(_this.changeProject);
                jQuery('#amount').change(_this.changeAmount);

                var select2 = $('#user_id').select2({
                    placeholder: "-- Select a user --",
                    allowClear: true
                });
                $('.select2-container--bootstrap').addClass('select2-container--default').removeClass('select2-container--bootstrap');

                if (select2) {
                    select2.data('select2').$selection.css('height', '36px');
                }

                setInputmask();
            }
        );

        jQuery('#js-search-id, #js-search-type').change(function () {
            pagination.loadPage(1, jQuery('.table-responsive'), true, 1);
        });

        jQuery('.table-button').click(_this.transactionOperation);

        jQuery('#type').change(_this.changeType);
        jQuery('#user_id').change(_this.changeUser);
        jQuery('#job_id').change(_this.changeProject);
        jQuery('#amount').change(_this.changeAmount);
    };

    this.changeType = function () {

        var type = jQuery(this).val();

        var payment_method = jQuery("#payment_method");
        var job_id = jQuery("#job_id");
        var milestone_id = jQuery("#milestone_id");
        var amount = jQuery("#amount");
        var fee = jQuery("#fee");
        var projectFee = jQuery("#project_fee");
        var escrowFee = jQuery("#escrow_fee");

        switch (type) {
            case "0": // Deposit
                payment_method.prop('disabled', false);
                job_id.prop('disabled', true);
                milestone_id.prop('disabled', true);
                amount.prop('disabled', false);
                fee.text('');
                break;
            case "1": // Withdraw
                payment_method.prop('disabled', false);
                job_id.prop('disabled', true);
                milestone_id.prop('disabled', true);
                amount.prop('disabled', false);
                fee.text('');
                break;
            case "2": // Project fee
                payment_method.prop('disabled', true);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', true);
                amount.prop('disabled', true);
                fee.text(projectFee.val());
                break;
            case "3": // Transfer
                payment_method.prop('disabled', true);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', false);
                amount.prop('disabled', false);
                fee.text(escrowFee.val());
                break;
            case "4": // Escrow request
                payment_method.prop('disabled', true);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', false);
                amount.prop('disabled', false);
                fee.text(escrowFee.val());
                break;
            case "5": // Escrow release
                payment_method.prop('disabled', true);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', false);
                amount.prop('disabled', true);
                fee.text('');
                break;
            case "6": // Escrow cancel
                payment_method.prop('disabled', true);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', false);
                amount.prop('disabled', true);
                fee.text('');
                break;
            default:
                payment_method.prop('disabled', false);
                job_id.prop('disabled', false);
                milestone_id.prop('disabled', false);
                amount.prop('disabled', false);
                fee.text('');
        }
    };

    this.changeUser = function () {

        var user_id = jQuery(this).val();
        m.post(
            siteUrl + '/payments/get_user_info',
            {
                user_id: user_id
            },
            function (data) {
                jQuery('#job_id').html(data.projects);
                jQuery('#user_balance').text(data.balance);
            }
        );
    };

    this.changeProject = function () {
        var id = jQuery(this).val();
        m.post(
            siteUrl + '/payments/get_project_info',
            {
                id: id
            },
            function (data) {
                jQuery('#milestone_id').html(data.milestones);
                var projectFee = jQuery('#project_fee');
                projectFee.val(data.fee);
                if (jQuery('#type').val() == 2) {
                    jQuery('#fee').text(projectFee.val());
                }
            }
        );
    };

    this.changeAmount = function () {

        var amount = jQuery(this).val();

        m.post(
            siteUrl + '/payments/get_escrow_fee',
            {
                amount: amount
            },
            function (data) {
                var escrowFee = jQuery('#escrow_fee');
                escrowFee.val(data.fee);
                var type = jQuery('#type').val();
                if (type == 3 || type == 4) {
                    jQuery('#fee').text(escrowFee.val());
                }
            }
        );
    };

    this.transactionOperation = function () {
        m.post(
            jQuery(this).attr('href'),
            {},
            function () {
                pagination.loadPage(0, jQuery('.table-responsive'), true, 0);
            }
        );
    }

})());
