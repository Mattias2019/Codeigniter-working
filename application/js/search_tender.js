var tender;

(new (function Tender() {
    var _this = tender = this;
    var _siteUrl = "";
    var _options = {};

    this.init = function (siteUrl, options) {

        _siteUrl = siteUrl || "";
        _options = options || {};

        // timeToStr('.col-due-date');

        var _slider = jQuery("#js-slider-range").slider({
            range: true,
            min: 1,
            max: 100000,
            slide: function (event, ui) {
                jQuery("#js-slider-min").val(ui.values[0]);
                jQuery("#js-slider-max").val(ui.values[1]);
            }
        });
        jQuery("#js-slider-min").keyup(function () {
            _slider.slider("values", [jQuery(this).val(), jQuery("#js-slider-max").val()]);
        });
        jQuery("#js-slider-max").keyup(function () {
            _slider.slider("values", [jQuery("#js-slider-min").val(), jQuery(this).val()]);
        });

        pagination.init(
            _siteUrl + '/search/tender',
            function () {
                return {
                    keyword: jQuery('#keyword').val(),
                    categories: jQuery("input[name='category[]']:checked").map(function () {
                        return this.value;
                    }).toArray(),
                    budget_min: Number(jQuery("#js-slider-min").val()),
                    budget_max: Number(jQuery("#js-slider-max").val())
                }
            },
            function () {
                jQuery('[data-toggle="tooltip"]').tooltip();

                _this.initButtons();
            }
        );

        jQuery('#submit').click(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        initSlider();
        initShowMore();

        jQuery('[data-toggle="tooltip"]').tooltip();

        jQuery(".feedback-form-rating").each(function (key, data) {
            jQuery(data).rateYo({
                rating: jQuery(data).data('rating'),
                starWidth: "18px",
                readOnly: true
            });
        });

        $("#reset-filter-btn").click(function (e) {

            e.preventDefault();

            // clear keyword
            $('#keyword').val(null);

            // clear Categories
            $("input.sub_item").each(function () {
               $(this).prop("checked", false);
            });
            $("input.main_category").each(function () {
                $(this).prop("checked", false);
            });
            $(".result_box_area").empty();

            // reset slider
            initSlider();

            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
        });

        $("#double-budget-btn").click(function (e) {

            e.preventDefault();

            var rangeMin = $("#js-slider-min").val();
            var rangeMax = $("#js-slider-max").val();
            initSlider(rangeMin, rangeMax*2);
        });

        _this.initButtons();
    };

    this.initButtons = function () {

        $('.table-jobs .table tbody tr a.btn-job-info').click(function (e) {

            e.preventDefault();

            _this.showJobInfo($(this));
        });
    };

    this.showJobInfo = function (current_element) {

        var url = current_element.attr('href');
        var job_id = current_element.attr('data-job-id');

        $( "#dialog .modal-dialog" ).addClass( "modal-lg" );

        m.dialog({
            header: m.t("Project Details"),
            url: url,
            data: {'id': job_id},
            btnOk: {
                label: m.t("ok"),
                callback: function() {
                    pagination.init(
                        _siteUrl + '/search/tender',
                        function () {
                            // timeToStr('.col-due-date');
                            return {
                                keyword: jQuery('#keyword').val(),
                                categories: jQuery("input[name='category[]']:checked").map(function () {
                                    return this.value;
                                }).toArray(),
                                budget_min: Number(jQuery("#js-slider-min").val()),
                                budget_max: Number(jQuery("#js-slider-max").val())
                            }
                        },
                        function () {
                            jQuery('[data-toggle="tooltip"]').tooltip();

                            _this.initButtons();
                        }
                    );
                }
            }
        });
    };

    function initShowMore() {
        jQuery(function () {
            jQuery(".showmoretxt").click(function () {
                if (jQuery(this).hasClass("sample")) {
                    jQuery(this).removeClass("sample");
                    jQuery(this).text(_options['show_more']);
                } else {
                    jQuery(this).addClass("sample");
                    jQuery(this).text(_options['show_less']);
                }
                jQuery(this).parent().prev().toggle();
                jQuery(this).prev().toggle();
                return false;
            });
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