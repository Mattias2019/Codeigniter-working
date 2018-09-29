var rss;

(new (function Rss() {
    var _this = rss = this;
    var _siteUrl = "";
    var _options ={};

    this.init = function(siteUrl, options) {

        _siteUrl = siteUrl || "";
        _options = options || {};

        pagination.init(
            _siteUrl + '/rss/index',
            null,
            function () {
                _this.initShowMore();
                $('.edit-feed').click(function (e) {
                    e.preventDefault();
                    var element = this;
                    _this.editFeed(element);
                });
                $('.delete-feed').click(function (e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    _this.deleteFeed(url);
                });
            },
            function () {
                initSlider(_options.budget_min, _options.budget_max);

                $('#rss-form').submit(_this.launchSubmit);

                $('#rss-add').click(_this.rssAdd);
                $('#rss-delete').click(_this.rssDelete);
                $('#rss-delete-all').click(_this.rssDeleteAll);

                $('[data-toggle="tooltip"]').tooltip();
            }
        );

        initSlider(_options.budget_min, _options.budget_max);

        $('#rss-form').submit(_this.launchSubmit);

        $("#rss-add").click(function (e) {
            e.preventDefault();
            _this.rssAdd();
        });

        $('#rss-delete').click(function (e) {
            e.preventDefault();
            _this.rssDelete();
        });

        $('#rss-delete-all').click(function (e) {
            e.preventDefault();
            _this.rssDeleteAll();
        });

        $('.edit-feed').click(function (e) {
            e.preventDefault();
            var element = this;
            _this.editFeed(element);
        });

        $('.delete-feed').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            _this.deleteFeed(url);
        });

        _this.initShowMore();

        $('[data-toggle="tooltip"]').tooltip();
    };

    this.rssAdd = function() {
        m.post(
            _siteUrl + '/rss/custom_select',
            {
                categories: $('#s1_select').find("input[name='category[]']:checked").map(function () {
                    return this.value;
                }).toArray()
            },
            function(data) {
                _this.reloadRightSelect(data.data);
            }
        );
    };

    this.rssDelete = function(e) {
        e.preventDefault();
        m.post(
            _siteUrl + '/rss/custom_select',
            {
                categories: $('#s2_select').find("input[name='category[]']:not(:checked)").map(function () {
                    return this.value;
                }).toArray()
            },
            function(data) {
                _this.reloadRightSelect(data.data);
            }
        );
    };

    this.rssDeleteAll = function(e) {

        e.preventDefault();
        m.post(
            _site_url + '/rss/custom_select',
            {
                categories: []
            },
            function(data) {
                _this.reloadRightSelect(data.data);
            }
        );
    };

    this.reloadLeftSelect = function(data) {
        $('#s1_select').replaceWith(data);
    };

    this.reloadRightSelect = function(data) {
        $('#s2_select').replaceWith(data);
    };

    this.launchSubmit = function()
    {
        // Set budget
        $('#budget_min').val($('#js-slider-min').val());
        $('#budget_max').val($('#js-slider-max').val());

        // Set selected categories
        $('#categories').val($('#s2_select').find("input[name='category[]']").map(function () {
            return this.value;
        }).toArray());
    };

    this.initShowMore = function() {
        var showChar = m.t('Show More'), hideChar = m.t('Show Less');
        $(".showmoretxt").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass("sample")) {
                $(this).removeClass("sample");
                $(this).text(showChar);
            } else {
                $(this).addClass("sample");
                $(this).text(hideChar);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    };

    this.deleteFeed = function(url) {
        m.dialog({
            header: m.t('Delete RSS feed'),
            body: m.t('Do you wish to delete RSS feed?'),
            btnOk: {
                label:m.t('Yes'),
                callback: function() {
                    m.post(
                        url,
                        null,
                        function(result) {
                            $('tr[data-id='+result.id+']').remove();
                        }
                    );
                }
            },
            btnCancel: {
                label: m.t('No')
            }
        });
    };

    this.editFeed = function(element) {

        var url = $(element).attr('href');
        var id = $(element).attr('data-feed-id');

        m.post(
            url,
            {
                id: id,
                segment: 2
            },
            function(data) {

                $('.index-custom-form').html(data.html);

                initSlider($('#budget_min').val(), $('#budget_max').val());

                _this.reloadLeftSelect(data.data1);
                _this.reloadRightSelect(data.data2);

                $('#rss-form').submit(_this.launchSubmit);

                $('#rss-add').click(_this.rssAdd);
                $('#rss-delete').click(_this.rssDelete);
                $('#rss-delete-all').click(_this.rssDeleteAll);

                $('[data-toggle="tooltip"]').tooltip();

                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        );
    }

})());
