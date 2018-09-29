var machinery;

(new (function Machinery() {

    var _this = machinery = this;
    var _siteUrl = "";
    var _options = {};

    this.init = function (siteUrl, options) {

        _siteUrl = siteUrl || "";
        _options = options || {};

        _this.updatePortfolio(true);
        jQuery(window).resize(_this.updatePortfolio);

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

        initSlider();

        $("#double-budget-btn").click(function (e) {

            e.preventDefault();

            var rangeMin = $("#js-slider-min").val();
            var rangeMax = $("#js-slider-max").val();
            initSlider(rangeMin, rangeMax*2);
        });

        jQuery('#submit').click(function (e) {
            e.preventDefault();
            _this.loadPage();
        });

        jQuery('.load-more').find('a').click(function (e) {
            e.preventDefault();
            _this.loadMore();
        });

        var itemsForCompare = [];
        var itemsForCompareMax = 5;

        jQuery(".machinery-compare").change(function () {
            if (this.checked) {
                if (itemsForCompare.length < itemsForCompareMax) {
                    itemsForCompare.push(this.id);
                    // Add caution tooltip for any non-checked checkboxes
                    if (itemsForCompare.length == itemsForCompareMax) {
                        jQuery('.machinery-compare:not(:checked)').parent().attr('title', 'Only ' + itemsForCompareMax + ' items may be selected');
                    }
                } else {
                    this.checked = false;
                }
            } else {
                itemsForCompare.splice(itemsForCompare.indexOf(this.id), 1);
                // Remove caution tooltips
                if (itemsForCompare.length < itemsForCompareMax) {
                    jQuery('.machinery-compare-container').attr('title', '');
                }
            }
        });

        jQuery('#compare').click(function (e) {
            e.preventDefault();
            _this.compare();
        });

    };

    this.loadPage = function() {
        m.post(
            _siteUrl + '/search/machinery',
            {
                offset: 0,
                keyword: jQuery('#keyword').val(),
                categories: jQuery("input[name='category[]']:checked").map(function () {
                    return this.value;
                }).toArray(),
                budget_min: Number(jQuery("#js-slider-min").val()),
                budget_max: Number(jQuery("#js-slider-max").val())
            },
            function (data) {
                jQuery('.machinery-gallery').html(data.table);
                _this.updatePortfolio(true);
                if (data.count_all == jQuery('.machinery-item-container').length) {
                    jQuery('.load-more').addClass('hidden');
                } else {
                    jQuery('.load-more').removeClass('hidden');
                }
                jQuery('.request-quote').click(_this.request);
            }
        );
    };

    this.loadMore = function () {
        var offset = jQuery('.machinery-item-container').length;
        m.post(
            _siteUrl + '/search/machinery',
            {
                offset: offset,
                keyword: jQuery('#keyword').val(),
                categories: jQuery("input[name='category[]']:checked").map(function () {
                    return this.value;
                }).toArray(),
                budget_min: Number(jQuery("#js-slider-min").val()),
                budget_max: Number(jQuery("#js-slider-max").val())
            },
            function (data) {
                jQuery('.machinery-gallery').append(data.table);
                _this.updatePortfolio(true);
                if (data.count_all == jQuery('.machinery-item-container').length) {
                    jQuery('.load-more').addClass('hidden');
                } else {
                    jQuery('.load-more').removeClass('hidden');
                }
                jQuery('.request-quote').click(_this.request);
            }
        );
    };

    this.compare = function () {
        m.post(
            _siteUrl + '/search/machinery',
            {
                compare: jQuery(".machinery-compare:checked").map(function () {
                    return this.id.substr(this.id.indexOf('-') + 1);
                }).toArray()
            },
            function (data) {
                jQuery('.machinery-gallery').html(data.table);
                _this.updatePortfolio(true);
                if (data.count_all == jQuery('.machinery-item-container').length) {
                    jQuery('.load-more').addClass('hidden');
                } else {
                    jQuery('.load-more').removeClass('hidden');
                }
                jQuery('.request-quote').click(_this.request);
            }
        );
    };

    this.request = function (e) {
        e.preventDefault();
        m.post(
            _siteUrl + '/search/send_quote_request?id=' + jQuery(this).data('id'),
            null,
            function (response) {
                m.toast.success(response.message);
            }
        );
    };

    this.updatePortfolio = function(initial) {
        var item = jQuery('.machinery-item');
        var height = item.width();
        item.css({'height': height + 'px'});
        jQuery('.machinery-characteristics').css({'max-height': (2 * height) + 'px'});
        if (initial) {
            jQuery('.machinery-item-container').addClass('in');
        }
    };
    
})());