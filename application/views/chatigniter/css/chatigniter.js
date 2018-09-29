/*
|-------------------------------------------------------------------------
| Copyright (c) 2013 
| This script may be used for non-commercial purposes only. For any
| commercial purposes, please contact the author at sammkaranja@gmail.com
|-------------------------------------------------------------------------
*/

/*
|-------------------------------------------------------------------------
| Funtion to trigger the refresh event
|-------------------------------------------------------------------------
*/
bootChat();

/*----------------------------------------------------------------------
| Function to display individual chatbox
------------------------------------------------------------------------*/

$(document).on('click', '[data-toggle="popover"]', function(){
															
		if($(this).hasClass('team_online_li'))
		$('#chat-menu-toggle').click();
		
        $(this).popover('hide');
        $('ul.chat-box-body').empty();
        user = $(this).find('input[name="user_id"]').val();
        $(this).find('span[rel="'+user+'"]').text('');

        load_thread(user);

        var offset = $(this).offset(); 
        var h_main = $('#chat-container').height();
        var h_title = $("#chat-box > .chat-box-header").height();
        var top = ($('#chat-box').is(':visible') ? (offset.top - h_title - 40) : (offset.top + h_title - 20));
        if((top + $('#chat-box').height()) > h_main){ top = h_main -  $('#chat-box').height();}
        $('#chat-box').css({'top': top});
        if(!$('#chat-box').is(':visible')){
            $('#chat-box').toggle('slide',{
                direction: 'right'
            }, 500);
        }
        $('.chat-box-body').slimScroll({ height: '300px' });
        // FOCUS INPUT TExT WHEN CLICK
        $("#chat-box .chat-textarea input").focus();
});
/*----------------------------------------------------------------------
| Function to send message
------------------------------------------------------------------------*/
$(document).on('keypress', '.chat-textarea input', function(e){
        var txtarea = $(this);
        var message = txtarea.val();
        if(message !== "" && e.which == 13){
            txtarea.val('');
            // save the message 
            $.ajax({ type: "POST", url: base  + "chat/save_Chatmessage", data: {message: message, user : user},cache: false,
                success: function(response){
                    msg = response.message;
                    li = '<li class=" bubble '+ msg.type +'"><div class="profile-img"><img src="'+msg.avatar+'" class="avt img-responsive"></div>\
                    <div class="message">\
                    <span class="chat-arrow"></span>\
                    <a href="javascript:void(0)" class="chat-name">'+msg.name+'</a>&nbsp;\
                    <span class="chat-datetime">at '+msg.time+'</span>\
                    <span class="chat-body">'+msg.body+'</span></div></li>';

                    $('ul.chat-box-body').append(li);

                    $('ul.chat-box-body').animate({scrollTop: $('ul.chat-box-body').prop("scrollHeight")}, 500);
                }
            });
        }
});

/*----------------------------------------------------------------------------------------------------
| Function to load messages
-------------------------------------------------------------------------------------------------------*/
function bootChat()
{
    refresh = setInterval(function()
    {
	    $.ajax(
            {
                type: 'GET',
                url: base + "chat/ChatMsgupdates/",
                async: true,
                cache: false,
                success: function (data) {
                    if (data.success) {
                        thread = data.messages;
                        senders = data.senders;
                        $.each(thread, function () {
                            if ($("#chat-box").is(":visible")) {
                                chatbuddy = $("#chat_buddy_id").val();
                                if (this.sender == chatbuddy) {
                                    li = '<li class="' + this.type + '"><div class="profile-img"><img src="' + this.avatar + '" class="avt img-responsive"></div>\
                                    <div class="message">\
                                    <span class="chat-arrow"></span>\
                                    <a href="javascript:void(0)" class="chat-name">' + this.name + '</a>&nbsp;\
                                    <span class="chat-datetime">at ' + this.time + '</span>\
                                    <span class="chat-body">' + this.body + '</span></div></li>';
                                    $('ul.chat-box-body').append(li);
                                    $('ul.chat-box-body').animate({scrollTop: $('ul.chat-box-body').prop("scrollHeight")}, 500);
                                    //Mark this message as read
                                    $.ajax({type: "POST", url: base + "chat/mark_ChatMsgRead", data: {id: this.msg}});
                                }
                                else {
                                    from = this.sender;
                                    $.each(senders, function () {
                                        if (this.user == from) {
                                            $(".chat-group").find('span[rel="' + from + '"]').text(this.count);
                                        }
                                    });
                                }
                            }
                            else {
                                from = this.sender;
                                $.each(senders, function () {
                                    if (this.user == from) {
                                        $(".chat-group").find('span[rel="' + from + '"]').text(this.count);
                                    }
                                });

                            }
                        });

                        //var audio = new Audio('assets/notify/notify.mp3').play();
                    }
                },
                error: function (XMLHttpRequest, textstatus, error) {
                    console.log(error);
                }
            }
        );
    }, 2000);

    // Check contact status
    refresh_contact = setInterval(function () {
        jQuery.ajax({
            type: 'POST',
            url : base + "chat/check_contact_status/",
            async : true,
            cache : false,
            data: {
                users: jQuery('.chat-group').find("input[name=user_id]").map(function () {
                    return this.value;
                }).toArray()
            },
            success: function (data) {
                var users = JSON.parse(data);
                for (var i = 0; i < users.length; i++)
                {
                    var symbol = jQuery('.chat-group').find("input[value="+users[i].id+"]").parent().find('.user-status');
                    if (users[i].online)
                    {
                        symbol.removeClass('is-offline');
                        symbol.addClass('is-online');
                    }
                    else
                    {
                        symbol.removeClass('is-online');
                        symbol.addClass('is-offline');
                    }
                }
            }
        });
    }, 10000);
}

/*----------------------------------------------------------------------
| Function to load threaded messages or user conversation
------------------------------------------------------------------------*/
var limit = 1;
function load_thread(user, limit){
        //send an ajax request to get the user conversation 
       $.ajax({ type: "POST", url: base + "chat/Chatmessages", data: {user : user, limit:limit },cache: false,
        success: function(response){
        if(response.success){
			
            buddy = response.buddy;
            status = buddy.status == 1 ? 'Online' : 'Offline';
            statusClass = buddy.status == 1 ? 'user-status is-online' : 'user-status is-offline';

            $('#chat_buddy_id').val(buddy.id);
            $('.display-name', '#chat-box').html(buddy.name);
            //$('#chat-box > .chat-box-header > small').html(status);
            $('#chat-box > .chat-box-header > span.user-status').removeClass().addClass(statusClass);

            $('ul.chat-box-body').html('');
            if(buddy.more){
             $('ul.chat-box-body').append('<li id="load-more-wrap" style="text-align:center"><a onclick="javascript: load_thread(\''+buddy.id+'\', \''+buddy.limit+'\')" class="btn btn-xs btn-info" style="width:100%;padding:3px 5px;font-size:14px;">View older messsages('+buddy.remaining+')</a></li>');
            }
 

                thread = response.thread;
                $.each(thread, function() {
                  li = '<li class="'+ this.type +'"><div class="profile-img"><img src="'+this.avatar+'" class="avt img-responsive"></div>\
                    <div class="message">\
                    <span class="chat-arrow"></span>\
                    <a href="javascript:void(0)" class="chat-name">'+this.name+'</a>&nbsp;\
                    <span class="chat-datetime">at '+this.time+'</span>\
                    <span class="chat-body">'+this.body+'</span></div></li>';

                    $('ul.chat-box-body').append(li);
                });
                if(buddy.scroll){
                    $('ul.chat-box-body').animate({scrollTop: $('ul.chat-box-body').prop("scrollHeight")}, 500);
                }
                
            }
        }});
}


/*
|----------------------------------------------------------------------------
| End of file
|----------------------------------------------------------------------------
*/

