var header;

(new (function Header() {
    var _this = header = this;

    this.init = function() {

        var rating = jQuery('.workflow-rating');
        rating.rateYo({
            rating: rating.data('rating') > 0 ? rating.data('rating') : 0,
            starWidth: "10px",
            ratedFill: "#ffca28",
            normalFill: "#e0e0e0",
            readOnly: true
        });

    };

})());

jQuery(document).ready(function (e) {
    header.init();
});