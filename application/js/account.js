var account;

(new (function Account() {
    var _this = account = this;
    var _siteUrl = "";
    var _typeAjaxSearchUser = "";
    this.init = function (siteUrl, typeAjaxSearchUser) {
        _siteUrl = siteUrl || "";
        _typeAjaxSearchUser = typeAjaxSearchUser || "";
        //
        // jQuery("#js-autocomplete-ajax").autocomplete({
        //     source: availableTags
        // });
        jQuery("#js-autocomplete-ajax").autocomplete({
            source: function (request, response) {
                var data = {
                    "name": request.term,
                    "type": _typeAjaxSearchUser

                };
                m.post(_siteUrl + "/account/findUserByNameOrEmail", data,
                    function (result) {
                        response(result);
                    }
                );
            },
            minLength: 2,
            select: function (event, ui) {
                jQuery("#user_id").val(ui.item.value);
                jQuery("#js-autocomplete-ajax").val(ui.item.label);
                ui.item.value = ui.item.label;
            }

        });


    };


})());