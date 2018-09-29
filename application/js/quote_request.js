var quote_request;

(new (function Quote_Request() {
    var _this = quote_request = this;
    var _siteUrl = "";

    this.init = function (siteUrl) {

        _siteUrl = siteUrl || "";

        var _slider = jQuery("#js-slider-range").slider({
            range: true,
            min: 0,
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
            _siteUrl + '/search/quote_request',
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
                _this.initButtons();
            }
        );

        jQuery('#submit').click(function () {
            pagination.loadPage(0, jQuery('.table-responsive'), true, 1);
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

        initSlider();

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
                callback: function () {
                    pagination.init(
                        _siteUrl + '/search/quote_request',
                        function () { return {}; },
                        function () {
                            _this.initButtons();
                        }
                    );
                }
            }
        });
    };

})());