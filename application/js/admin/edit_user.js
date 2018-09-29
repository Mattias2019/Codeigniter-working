/**
 * Created by geymur-vs on 05.08.17.
 */

var edit_user;

(new (function EditUser() {
    var _this = edit_user = this;

    this.init = function () {

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

                // m.post("/company/connect", data, function (data) {
                //     if (data.connected == 1) {
                //         $(checkbox).prop('checked', true);
                //     } else {
                //         $(checkbox).prop('checked', false);
                //     }
                //     location.reload();
                // });
            }
        );


        $("#edit-user-btn").click(function (e) {

            e.preventDefault();

            var user_id = $(this).attr('data-user-id');

            m.submit('#editUser', 'admin/users/editUser/' + user_id, function (data) {
                if (!data.error)
                {
                    m.toast.info(data.result.message);
                } else
                {
                    m.toast.error(data.result.message);
                }
            });

        });

        // $('#editUser').submit(function(e) {
        //
        //     e.preventDefault();
        //
        //     var user_id = $(this).attr('data-user-id');
        //
        //     $.ajax({
        //         type: "POST",
        //         url: "<?php echo admin_url('users/editUser'); ?>" + user_id,
        //         data: $("#editUser").serialize(),
        //         dataType: "html",
        //         success: function(data){
        //
        //             // var obj = jQuery.parseJSON( responce );
        //
        //             // if( !data.error === true ) {
        //             //     document.location.href = obj.redirect;
        //             //     m.toast.success('aaa');
        //             // }
        //         },
        //         error: function( jqXhr ) {
        //             if (jqXhr.status == 400) { //Validation error or other reason for Bad Request 400
        //                 m.toast.error('Error', 'Error');
        //             }
        //         }
        //     });
        //
        // });

        $("#advanced-options-btn").click(function (e) {
            _this.showHideDetails(e);
        });

        // trigger click to hide advanced options
        $( "#advanced-options-btn" ).trigger( "click" );
    };

    this.showHideDetails = function(e) {
        e.preventDefault();
        $(".advanced-options").toggle();
    }

})());