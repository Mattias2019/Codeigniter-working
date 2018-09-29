/**
 * Created by geymur-vs on 05.08.17.
 */

var m;
(new (function Main() {

    var _this = m = this;
    var _blockSelector = null;
    var _options = {};

    this.init = function (options) {

        _options = options || {};

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    };

    this.toast = {
        info: function (message, title) {
            toastr['info'](message, title);
        },
        success: function (message, title) {
            toastr['success'](message, title);
        },
        warning: function (message, title) {
            toastr['warning'](message, title);
        },
        error: function (message, title) {
            toastr['error'](message, title);
        }
    };

    this.post = function (url, post_data, callback, errorCallback) {
        $.ajax({
            url: url,
            data: post_data,
            dataType: "json",
            method: "POST",
        }).done(function (data) {

            if (_this.isset(data.error) && _this.isset(data.result)) {
                if (!data.error) {
                    callback(data.result);
                } else {
                    if ($.isFunction(errorCallback)) {
                        errorCallback(data.result);
                    } else {
                        _this.toast.error(data.result.message, 'error');
                    }

                }
            } else {
                _this.toast.error('server-wrong-response', 'error');
            }

        }).fail(function (xhr, status, err) {
            var response = xhr.statusText;
            if ($.isFunction(errorCallback)) {
                errorCallback({ message : response });
            } else {
                _this.toast.error(response, 'error');
            }
        });

    };

    /*
     * Submit form
     *
     * @param {selector} formId
     * @param {function} callback
     */
    // this.submit = function (formId, callback) {
    this.submit = function (formId, url, callback) {
        var form = $(formId);
        $.post(form.attr('action'), form.serialize(), function (data) {
            if (_this.isset(data) && _this.isset(data.result) && _this.isset(data.result.message)) {
                if ($.isFunction(callback)) {
                    callback(data);
                }
            } else {
                _this.toast.error('server-wrong-response', 'error');
            }
        }, "json");
    };

    this.blockUI = function (selector) {
        _blockSelector = selector;
        if(selector === undefined) {
            $.blockUI({
                    message: '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>',
                    animate: true,
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                }
            );
        } else {
            var el = $(selector);
            el.block({
                message: '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>',
                animate: true,
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }

            });
        }
    };

    this.unblockUI = function () {
        if (_blockSelector) {
            $(_blockSelector).unblock();
        } else {
            $.unblockUI();
        }
        _blockSelector = null;
    };

    this.isset = function (variables) {
        return (typeof (variables) != 'undefined' && variables != null);
    };

    this.ifset = function (variables, defValue) {
        return this.isset(variables) ? variables : defValue;
    };

    /**
     * Options can have following keys:
     * btnOk - callback
     * btnCancel - callback
     * url - upload dialog body from server. Server should return "html" key to fill dialog content.
     * data - post parameters (key/value array). It is using if url is specified.
     * header - header of dialog (text)
     * body - dialog body (HTML or text)
     * backdrop - block page while dialog is opened (true/false)
     * keyboard - close dialog by ESC (true/false)
     * before - callback, fire before opening dialog.
     * width, height - dialog width and height
     * onClosed - callback fire after dialog was closed
     */
    this.dialog = function (options) {
        if (_this.isset(options)) {
            var okCallback = null, closeCallback = null;
            var btnOk = options.btnOk || null;
            var btnCancel = options.btnCancel || null;
            var dataResult = null;
            var dialog = $('#dialog');
            if (options.selector)
                dialog = $(options.selector);

            if (options.url) {
                $.ajax({
                    url: options.url,
                    async: false,
                    data: options.data || null,
                    autoOpen: false,
                    dataType: "json",
                    method: "POST"
                }).done(function (data) {
                    if (_this.isset(data.error) && _this.isset(data.result)) {
                        dataResult = data.result;
                        if (data.error || !_this.isset(data.result.html)) {
                            options.header = _this.t('error');
                            options.body = data.result.message ? data.result.message : _this.t('error-response');
                            btnOk = null;
                        } else {
                            options.header = data.header ? data.header : options.header;
                            options.body = data.result.html;
                            if (_this.isset(data.result.actions)) {
                                dialog.find(".modal-footer .actions").html(data.result.actions);
                            }
                        }
                    }
                }).fail(function (data) {
                    options.header = _this.t('error');
                    options.body = data.result.message ? data.result.message : _this.t('error-response');
                });
            }

            if (options.size) {
                dialog.find(".modal-dialog").addClass(options.size);
            } // modal-sm modal-lg

            if (options.header) {
                dialog.find(".modal-header .modal-title").html(options.header);
                dialog.find(".modal-header").removeClass("hide");
            } else {
                dialog.find(".modal-header").addClass("hide");
            }

            dialog.find('#btnOk').addClass('hide');
            if (btnOk) {
                // re-enable the ok button:
                if (dialog.find('#btnOk').prop('disabled') == true)
                {
                    dialog.find('#btnOk').prop('disabled', false);
                }
                if (btnOk.label) {
                    dialog.find('#btnOk').text(btnOk.label);
                }
                dialog.find('#btnOk').removeClass('hide');
                dialog.find('#btnOk').unbind('click').click(function () {
                    okCallback = $.isFunction(btnOk) ? btnOk : btnOk.callback;
                    dialog.modal('hide');
                });
            }

            dialog.find('#btnCancel').addClass('hide');
            if (btnCancel) {
                dialog.find('#btnCancel').removeClass('hide');
                if (btnCancel.label) {
                    dialog.find('#btnCancel').text(btnCancel.label);
                }
                closeCallback = $.isFunction(btnCancel) ? btnCancel : btnCancel.callback;
            }

            dialog.find(".modal-body").html(options.body);

            dialog.unbind('hide.bs.modal').unbind('show.bs.modal');
            dialog.modal({
                backdrop: _this.ifset(options.backdrop, true),
                keyboard: _this.ifset(options.keyboard, true),
                show: false
            }).on('hide.bs.modal', function () {
                if ($.isFunction(okCallback)) {
                    var value = okCallback(dialog);
                    okCallback = null;
                    return value;
                } else if ($.isFunction(closeCallback)) {
                    var value = closeCallback(dialog);
                    closeCallback = null;
                    return value;
                }

                return true;
            }).on('shown.bs.modal', function (event) {
                if (options.before && $.isFunction(options.before)) {
                    dialog.find(".modal-body").find('*').off();
                    options.before(dataResult);
                }
            }).on('hidden.bs.modal', function () {
                dialog.off();
                dialog.find(".modal-body").html("");
                if (options.onClosed && $.isFunction(options.onClosed)) {
                    options.onClosed();
                }
            });
            dialog.modal('show');
        }
    };

    /**
     * Get property of CSS class
     *
     * @param prop
     * @param fromClass
     * @returns {*}
     */
    this.getCSS = function (prop, fromClass) {

        var $inspector = $("<div>").css('display', 'none').addClass(fromClass);
        $("body").append($inspector); // add to DOM, in order to read the CSS property
        try {
            return $inspector.css(prop);
        } finally {
            $inspector.remove(); // and remove from DOM
        }
    };

    this.t = function (key) {
        if (_this.isset(_options["strings"])) {
            return _this.ifset(_options["strings"][key], key);
        }
        return key;
    }

}

)());