var base = site_url + "/";

$(document).ready(function () {

    'use strict';

    //set up some basic options for the feedback_me plugin
    var fm_options = {
        title_label: "PROVIDE FEEDBACK",
        trigger_label: "FEEDBACK",
        position: "right-bottom",
        name_label: "Fourth Hokage Name",
        name_placeholder: "Minato Namikaze",
        name_required: true,
        message_label: "Suggestion",
        message_placeholder: "Type your message here..",
        message_required: true,
        show_radio_button_list: true,
        radio_button_list_required: true,
        radio_button_list_title: "Choose",
        show_asterisk_for_required: true,
        feedback_url: site_url + "/account/feedback",
        custom_params: {
            current_url: window.location.href
        }
    };
    //init feedback_me plugin
    fm.init(fm_options);

    // chat slide
    $("body").on("mousemove",function(event) {
        if (event.pageX > window.screen.availWidth - 100) {
            $("#chat-menu-toggle").addClass('on');
            $(".feedback_trigger.right-bottom.fm_clean").addClass('on');
        } else {
            $("#chat-menu-toggle").removeClass('on');
            $(".feedback_trigger.right-bottom.fm_clean").removeClass('on');
        }
    });

});