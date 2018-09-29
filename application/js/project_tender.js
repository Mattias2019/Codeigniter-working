var tender;

(new (function Tender() {
    var _this = tender = this;
    var _siteUrl = "";
    var _options ={};

    this.init = function(siteUrl, options) {
        _siteUrl = siteUrl || "";
        _options = options || {};

        timeToStr('.col-due-date,.col-deadline');

        pagination.init(
            _siteUrl + '/project/tender',
            null,
            function () {

                timeToStr('.col-due-date,.col-deadline');

                jQuery('.button-quotes').click(showHideDetails);
                jQuery('.button-portfolio').click(showPortfolio);
                jQuery('[data-toggle="tooltip"]').tooltip();
                jQuery('.table-row td').not('.js-actions').click(showPopover);
                jQuery('.has-popover').popover('destroy').removeClass('has-popover');
                jQuery('.popover').remove();
            }
        );

        jQuery('.button-quotes').click(showHideDetails);
        jQuery('.button-portfolio').click(showPortfolio);
        jQuery('[data-toggle="tooltip"]').tooltip();
        jQuery('.table-row td').not('.js-actions').click(showPopover);
    };

    function showHideDetails(e) {
        e.preventDefault();
        var container = jQuery(this).closest('tr').next();
        container.toggle();
    }

    function showPortfolio(e) {
        var checkboxes = jQuery('.check-compare:checked');
        if (checkboxes.length > 0) {
            var compareString = '';
            checkboxes.each(function () {
                compareString += jQuery(this).val() + ',';
            });
            jQuery(this).attr('href', _siteUrl+'/search/machinery?compare='+compareString);
        }
    }

    function showPopover(e) {
        e.preventDefault();
        var x = e.pageX;
        var y = e.pageY;
        var row = jQuery(this).closest('tr');
        var id = jQuery(row).data('id');
        // Load popover
        m.post(
            _siteUrl + "/project/project_info", { id: id },
            function (data) {
                // Remove old popover
                jQuery('.has-popover').popover('destroy').removeClass('has-popover');
                jQuery('.popover').remove();
                // Add new popover
                row.addClass('has-popover');
                row.popover({
                    container: 'body',
                    html: true,
                    placement: 'top',
                    content: data.data
                }).popover('show');
                // Change popover position
                var popover = jQuery('.popover');
                popover.css('left', x - 20);
                popover.css('top', y - popover.height() - 5);
                popover.find('.arrow').css('left', 20);
                // Remove on click
                popover.click(function () {
                    jQuery('.has-popover').popover('destroy').removeClass('has-popover');
                    jQuery(this).remove();
                });
            }
        );
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