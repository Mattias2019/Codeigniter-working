var pagination;
(new (function Pagination() {

    pagination = this;
    var parentController;
    var additionalParameters;
    var tabCallback;
    var tableCallback;

    // Initialization
    this.init = function (parentController, additionalParameters, tableCallback, tabCallback, table_class) {

        pagination.parentController = parentController;
        if (additionalParameters !=  null && additionalParameters != undefined) {
            pagination.additionalParameters = additionalParameters;
        } else {
            pagination.additionalParameters = function () { return {}; };
        }
        if (tableCallback !=  null && tableCallback != undefined) {
            pagination.tableCallback = tableCallback;
        } else {
            pagination.tableCallback = function () {};
        }
        if (tabCallback !=  null && tabCallback != undefined) {
            pagination.tabCallback = tabCallback;
        } else {
            pagination.tabCallback = function () {};
        }

        pagination.initTab();

        pagination.initPagination(table_class);

        pagination.sortPage(table_class);
        // Used on most pages
        jQuery('[data-toggle="tooltip"]').tooltip();

    };

    this.initSelect = function (table_class) {

        if (typeof table_class === "undefined" || table_class === null) {
            table_class = '.table-responsive';
        }
        var table = jQuery(table_class);

        $('.pagination-limit-select').unbind();

        table.find('.pagination-limit-select').change(function (event) {
            event.preventDefault();
            pagination.loadPage(0, table, true, 0, table_class);
        });
    };

    // Tabbing functionality
    this.initTab = function () {

        jQuery('.tab').click(function (e) {
            e.preventDefault();
            pagination.loadPage(jQuery(this).data('tab'), null, false, 1);
            jQuery(this).closest('ul').find('li').removeClass('active');
            jQuery(this).parent().addClass('active');
        });

    };

    // Pagination functionality
    this.initPagination = function(table_class, table_name) {

        if (typeof table_class === "undefined" || table_class === null) {
            table_class = '.table-responsive';
        }
        var table = jQuery(table_class);

        table.find('.pagination-container').find('a').click(function (event) {
            event.preventDefault();
            jQuery(this).closest('.pagination-container-inner').data('page', jQuery(this).data('page'));
            pagination.loadPage(0, jQuery(this).closest(table_class), true, 0, table_class);
        });

        pagination.initSelect(table_class);
    };

    // Table sorting functionality
    this.sortPage = function(table_class) {

        if (typeof table_class === "undefined" || table_class === null) {
            table_class = '.table-responsive';
        }

        jQuery(table_class+' .table').find('.table-sort').click(function () {

            var tableSort = jQuery(this).closest('thead');

            // This sort
            switch (jQuery(this).data('sort')) {
                case '':
                    jQuery(this).data('sort', 'asc');
                    jQuery(this).removeClass('fa-sort');
                    jQuery(this).addClass('fa-sort-asc');
                    tableSort.data('field', jQuery(this).data('field'));
                    tableSort.data('sort', 'asc');
                    break;
                case 'asc':
                    jQuery(this).data('sort', 'desc');
                    jQuery(this).removeClass('fa-sort-asc');
                    jQuery(this).addClass('fa-sort-desc');
                    tableSort.data('field', jQuery(this).data('field'));
                    tableSort.data('sort', 'desc');
                    break;
                case 'desc':
                    jQuery(this).data('sort', '');
                    jQuery(this).removeClass('fa-sort-desc');
                    jQuery(this).addClass('fa-sort');
                    tableSort.data('field', '');
                    tableSort.data('sort', '');
                    break;
            }

            // Other sorts
            var current = this;
            jQuery('.table').find('.table-sort').each(function (index, value) {
                if (jQuery(value).data('field') != jQuery(current).data('field')) {
                    jQuery(value).data('sort', '');
                    jQuery(value).removeClass('fa-sort-asc');
                    jQuery(value).removeClass('fa-sort-desc');
                    jQuery(value).addClass('fa-sort');
                }
            });

            pagination.loadPage(0, jQuery(this).closest(table_class), true, 0, table_class);
        });
    };

    // Loading page from ajax
    this.loadPage = function(segment, table, tableOnly, page, table_class) {

        if (segment == 0) {
            segment = table.data('tab');
        }
        if (page == 0) {
            page = table.find('.pagination-container-inner').data('page');
        }

        var data = {
            segment: segment,
            table_only: tableOnly,
            page: page,
            page_rows: table == null ? null : table.find('.pagination-limit-select').val(),
            field: table == null ? null : table.find('thead').data('field'),
            order: table == null ? null : table.find('thead').data('sort'),
            table_class: table_class,
            table_id: table == null ? null : table.find('table').attr('id'),
        };
        jQuery.extend(data, pagination.additionalParameters());

        m.post(
            pagination.parentController,
            data,
            function (data) {
                if (data.type == "table") {

                    if (table == undefined) {
                        table = jQuery('.table-responsive');
                    }
                    table.find('tbody').html(data.data);
                    table.find('.pagination-container-inner').html(data.pagination);
                    pagination.initPagination(table_class);
                    pagination.tableCallback(data);
                    // Used on most pages
                    jQuery('[data-toggle="tooltip"]').tooltip();
                }
                else {
                    jQuery('#content').html(data.data);
                    pagination.initPagination(table_class);
                    pagination.sortPage(table_class);
                    pagination.tableCallback(data);
                    pagination.tabCallback(data);
                    // Used on most pages
                    jQuery('[data-toggle="tooltip"]').tooltip();
                }
            }
        );

    };

})());