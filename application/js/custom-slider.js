function initSlider(minValue, maxValue, maxLength) {

    var slider = jQuery("#js-slider-range");
    var rangeMin = jQuery("#js-slider-min");
    var rangeMax = jQuery("#js-slider-max");
    var rangeLabel = jQuery("#slider_label");

    var startMin = Number(minValue);
    if (isNaN(startMin)) {
        startMin = 0;
    }
    var startMax = Number(maxValue);
    if (isNaN(startMax)) {
        startMax = 0;
    }
    var totalMax = Number(maxLength);
    if (isNaN(maxLength)) {
        totalMax = 1000000;
    }

    rangeMin.val(startMin);
    rangeMax.val(startMax);

    if (startMax > 0) {
        rangeMin.removeClass('hidden');
        rangeMax.removeClass('hidden');
        rangeLabel.addClass('hidden');
    }
    else if (startMin == 0 && startMax == 0) {
        rangeMin.addClass('hidden');
        rangeMax.addClass('hidden');
        rangeLabel.removeClass('hidden');
    }

    slider.slider({
        range: true,
        min: 0,
        max: totalMax,
        values: [startMin, startMax],
        slide: function (event, ui) {
            rangeMin.val(ui.values[0]);
            rangeMax.val(ui.values[1]);
            if (ui.values[0] == 0 && ui.values[1] == 0) {
                rangeMin.addClass('hidden');
                rangeMax.addClass('hidden');
                rangeLabel.removeClass('hidden');
            } else {
                rangeMin.removeClass('hidden');
                rangeMax.removeClass('hidden');
                rangeLabel.addClass('hidden');
            }
        },
        stop: function (event, ui) {
            var to_amount = ui.values[1];
            var max = slider.slider("option", "max");
            if (to_amount == max) {
                slider.slider("option", "max", max * 2);
            }
        }
    });

    rangeMin.inputmask("decimal", {
        autoUnmask: true,
        groupSeparator: '.',
        digits: 0,
        autoGroup: true,
        prefix: '$',
        rightAlign: false
    });
    rangeMax.inputmask("decimal", {
        autoUnmask: true,
        groupSeparator: '.',
        digits: 0,
        autoGroup: true,
        prefix: '$'
    });

    rangeMin.change(function () {
        if (Number(rangeMin.val()) > Number(rangeMax.val())) {
            rangeMin.val(Number(rangeMax.val()));
        }
        if (Number(rangeMin.val()) < 0) {
            rangeMin.val(0);
        }
        slider.slider("values", [Number(rangeMin.val()), Number(rangeMax.val())]);
    });

    rangeMax.change(function () {
        if (Number(rangeMin.val()) > Number(rangeMax.val())) {
            rangeMax.val(Number(rangeMin.val()));
        }
        if (Number(rangeMax.val()) > slider.slider("option", "max")) {
            slider.slider("option", "max", Number(rangeMax.val()));
        }
        slider.slider("values", [Number(rangeMin.val()), Number(rangeMax.val())]);
    });

}