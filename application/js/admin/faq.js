/**
 * Created by geymur-vs on 18.08.17.
 */
var faq;

(new (function Faq() {
    var _this = faq = this;

    var siteUrl;

    this.init = function (adminUrl) {

        siteUrl = adminUrl;

        pagination.init(
            siteUrl + '/faq/viewFaqs',
            function () {
                return {
                }
            },
            function () {
                _this.initFaqCategoryButtons();
            },
            function () {
            },
            '.faq-categories-table'
        );

        pagination.init(
            siteUrl + '/faq/viewFaqs',
            function () {
                return {
                }
            },
            function () {
                _this.initFaqButtons();
            },
            function () {
            },
            '.faqs-table'
        );

        $('#btn_add_faq_categories').click(_this.addFaqCategoryRow);
        $('#btn_add_faq').click(_this.addFaqRow);

        _this.initFaqCategoryButtons();
        _this.initFaqButtons();
    };

    this.initFaqCategoryButtons = function () {

        $('.faq-categories-table .table tbody tr .btn-edit').click(_this.editFaqCategoryRow);

        $('.faq-categories-table .table tbody tr .btn-delete').click(_this.deleteFaqCategory);

        $('.faq-categories-table .table tbody tr .btn-save').click(_this.saveFaqCategoryRow);

        $('.faq-categories-table .table tbody tr .btn-cancel').click(_this.cancelFaqCategoryRow);
    };

    this.initFaqButtons = function () {

        $('.faqs-table .table tbody tr .btn-edit').click(_this.editFaqRow);

        $('.faqs-table .table tbody tr .btn-delete').click(_this.deleteFaq);

        $('.faqs-table .table tbody tr .btn-save').click(_this.saveFaqRow);

        $('.faqs-table .table tbody tr .btn-cancel').click(_this.cancelFaqRow);
    };

    this.addFaqCategoryRow = function (e) {

        e.preventDefault();

        m.post(
            siteUrl + '/faq/addFaqCategoryRow',
            {},
            function (data) {

                var newRow = jQuery(data.html);

                $('.faq-categories-table .table tbody tr:first').before(newRow);

                $('.faq-categories-table .table tbody .no-data-found').toggle();

                newRow.find('.btn-save').click(_this.saveFaqCategoryRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqCategoryRow);
            }
        );
    };

    this.saveFaqCategoryRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/faq/saveFaqCategory',
            {
                id: row.find('.id').text(),
                category_name: row.find('input[name=category_name]').val()
            },
            function (data) {
                var newRow = jQuery(data.html);
                row.replaceWith(newRow);
                newRow.find('.btn-edit').click(_this.editFaqCategoryRow);
                newRow.find('.btn-delete').click(_this.deleteFaqCategory);
                newRow.find('.btn-save').click(_this.saveFaqCategoryRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqCategoryRow);

                m.toast.success(data.message);
            }
        );
    };

    this.cancelFaqCategoryRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        if (row.hasClass('new-row')) {

            row.remove();

            if ($('.faq-categories-table .table tbody tr').length === 1) {
                $('.faq-categories-table .table tbody .no-data-found').toggle();
            }
        }
        else {
            m.post(
                siteUrl + '/faq/refreshFaqCategoryRow',
                {
                    id: row.find('.id').text()
                },
                function (data) {
                    var newRow = jQuery(data.html);
                    row.replaceWith(newRow);
                    newRow.find('.btn-edit').click(_this.editFaqCategoryRow);
                    newRow.find('.btn-delete').click(_this.deleteFaqCategory);
                    newRow.find('.btn-save').click(_this.saveFaqCategoryRow);
                    newRow.find('.btn-cancel').click(_this.cancelFaqCategoryRow);
                }
            );
        }
    };

    this.cancelFaqRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        if (row.hasClass('new-row')) {

            row.remove();

            if ($('.faqs-table .table tbody tr').length === 1) {
                $('.faqs-table .table tbody .no-data-found').toggle();
            }
        }
        else {
            m.post(
                siteUrl + '/faq/refreshFaqRow',
                {
                    id: row.find('.id').text()
                },
                function (data) {
                    var newRow = jQuery(data.html);
                    row.replaceWith(newRow);
                    newRow.find('.btn-edit').click(_this.editFaqRow);
                    newRow.find('.btn-delete').click(_this.deleteFaq);
                    newRow.find('.btn-save').click(_this.saveFaqRow);
                    newRow.find('.btn-cancel').click(_this.cancelFaqRow);
                }
            );
        }
    };

    this.addFaqRow = function (e) {

        e.preventDefault();

        m.post(
            siteUrl + '/faq/addFaqRow',
            {},
            function (data) {

                var newRow = jQuery(data.html);

                $('.faqs-table .table tbody tr:first').before(newRow);

                $('.faqs-table .table tbody .no-data-found').toggle();

                newRow.find('.btn-save').click(_this.saveFaqRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqRow);
            }
        );
    };

    this.editFaqRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/faq/editFaqRow',
            {
                mode: 'update',
                id: row.find('.id').text()
            },
            function (data) {

                var newRow = jQuery(data.html);

                row.replaceWith(newRow);

                // Show/hide buttons
                newRow.find('.btn-edit, .btn-delete').addClass('hidden');
                newRow.find('.btn-save, .btn-cancel').removeClass('hidden');

                newRow.find('.btn-save').click(_this.saveFaqRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqRow);
            }
        );
    };

    this.saveFaqRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');
        var is_frequent;

        if (row.find('input[name=is_frequent]').is(':checked')) {
            is_frequent = 1;
        }
        else {
            is_frequent = 0;
        }

        m.post(
            siteUrl + '/faq/saveFaq',
            {
                id: row.find('.id').text(),
                faq_category_id: row.find('select[name=faq_category_id]').val(),
                question: row.find('textarea[name=question]').val(),
                answer: row.find('textarea[name=answer]').val(),
                is_frequent: is_frequent
            },
            function (data) {
                var newRow = jQuery(data.html);
                row.replaceWith(newRow);
                newRow.find('.btn-edit').click(_this.editFaqRow);
                newRow.find('.btn-delete').click(_this.deleteFaq);
                newRow.find('.btn-save').click(_this.saveFaqRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqRow);

                m.toast.success(data.message);
            }
        );
    };

    this.editFaqCategoryRow = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/faq/editFaqCategoryRow',
            {
                mode: 'update',
                id: row.find('.id').text()
            },
            function (data) {

                var newRow = jQuery(data.html);

                row.replaceWith(newRow);

                // Show/hide buttons
                newRow.find('.btn-edit, .btn-delete').addClass('hidden');
                newRow.find('.btn-save, .btn-cancel').removeClass('hidden');

                newRow.find('.btn-save').click(_this.saveFaqCategoryRow);
                newRow.find('.btn-cancel').click(_this.cancelFaqCategoryRow);
            }
        );
    };

    this.deleteFaqCategory = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/faq/deleteFaqCategory',
            {
                mode: 'delete',
                id: row.find('.id').text()
            },
            function () {
                pagination.loadPage(0, jQuery('.faq-categories-table'), true, 0, '.faq-categories-table');
                pagination.loadPage(0, jQuery('.faqs-table'), true, 0, '.faqs-table');

                _this.initFaqCategoryButtons();
                _this.initFaqButtons();
            }
        );
    };

    this.deleteFaq = function (e) {

        e.preventDefault();

        var row = $(this).closest('tr');

        m.post(
            siteUrl + '/faq/deleteFaq',
            {
                mode: 'delete',
                id: row.find('.id').text()
            },
            function () {
                pagination.loadPage(0, jQuery('.faqs-table'), true, 0, '.faqs-table');
                _this.initFaqButtons();
            }
        );
    };

})());
