/**
 * Created by geymur-vs on 05.08.17.
 */

var add_user;

(new (function AddUser() {
    var _this = add_user = this;

    this.init = function () {

        $("#password-switch").bootstrapSwitch('state',false);

        $("#password-switch").bootstrapSwitch({
            onInit: function (event, state) {
                if ($(this).is(':checked')) {
                    $("#password").prop('readonly', true);
                }
                else {
                    $("#password").prop('readonly', false);
                }
            }
        });

        $("#password-switch").on('switchChange.bootstrapSwitch',

            function (event, state) {

                var checkbox = this;

                if ($(checkbox).is(':checked')) {
                    $("#password").prop('readonly', true);
                }
                else {
                    $("#password").prop('readonly', false);
                }
            }
        );
    };

})());