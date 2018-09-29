function receive_notification(id) {
    console.log(id);
    $.ajax({
        type: 'GET',
        url: '/account/set_notified',
        data: {
            id: 4
        }
    });
}

/*
var notifications;
(new (function Notifications() {

    notifications = this;

    this.init = function () {
        jQuery('#notifications').click(this.viewNotifications);
    };

    this.viewNotifications = function () {
        var notifications = jQuery('#notifications');
        notifications.find('#unread-notifications').addClass('hidden');
        notifications.next().find('.unread').each(function () {
            jQuery(this).removeClass('unread');
            m.post(
                site_url+'/account/notify',
                {
                    id: jQuery(this).data('id')
                }
            );
        });
    };

})());

// TODO Move to main.init
jQuery(document).ready(function () {
    notifications.init();
});*/
