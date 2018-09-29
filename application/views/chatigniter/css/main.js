$(document).ready(function(){
/*----------------------------------------------------------------------
| Iniatiating the chat window with the appropriate HTML
------------------------------------------------------------------------*/
/*var chat_init = function(){
    $( "#chat-container" ).load(base+"chatigniter/users/");
}

chat_init();*/

/*----------------------------------------------------------------------
| Login function
------------------------------------------------------------------------*/
$(document).on('click', '#login', function(){
        dataString = $('#login-frm').serialize();
        $.ajax({
            type: "POST",
            url: base  + "chatigniter/auth",
            data: dataString,
            cache: false,
            beforeSend: function(){
             $("#login").html('<img src="assets/images/ajax-loader.gif" /> Connecting...');
         },
        success: function(response){
            if(response.success)
            {
                $(".message").html(success(response.message));
                $('#login-frm')[0].reset();
                //chat_init();
            }
            else
            {
                $(".message").html(error(response.message));
            }
            $("#login").html('<i class="fa fa-lock"></i> Login');
            highlightFields(response.errors);
        }});
return false;
});

$(document).on('click', '.goback', function(){
    //chat_init();
});
/*----------------------------------------------------------------------
| logout function
------------------------------------------------------------------------*/
$(document).on('click', '#logout', function(){
        $.ajax({
            type: "POST",
            url: base  + "chatigniter/auth/logout",
            cache: false,
            beforeSend: function(){},
            success: function(response){ /*chat_init();*/ }
        });
    return false;
});

/*----------------------------------------------------------------------
| Close the chat container
------------------------------------------------------------------------*/
$(document).on('click', '.chat-form-close', function(){
    $('#chat-container').toggle('slide', {
        direction: 'down'
    }, 500);
    $('#chat-box').hide();
});

/*----------------------------------------------------------------------
| Close the chat box window
------------------------------------------------------------------------*/
$(document).on('click','.chat-box-close', function(){
    $('#chat-box').hide();
    $('#chat-container .chat-group a').removeClass('active');
});

/*----------------------------------------------------------------------
| Display the chat container
------------------------------------------------------------------------*/
$('.btn-chat').click(function () {
    if($('#chat-box').is(':visible')){
        $('#chat-container').toggle('slide', {
            direction: 'down'
        }, 500);
        $('#chat-box').hide();
    } else{
        $('#chat-container').toggle('slide', {
            direction: 'down'
        }, 500);
        //chat_init();
    }
});
/*----------------------------------------------------------------------
| change status Function
------------------------------------------------------------------------*/
$(document).on('click', '.status-btn-group', function() {
    $(this).find('.btn').toggleClass('active');  
    if ($(this).find('.btn-success').size()>0) {
        $(this).find('.btn').toggleClass('btn-success');
        $.ajax({ url: base  + "chatigniter/users/toggle_status" , 
            success: function(response){
                if(response.status == 1){
                    $('#current_status').html('Online');
                    $('#current_status').removeClass('btn-danger').addClass('btn-success');
                }            
                else{
                    $('#current_status').html('Offline');
                    $('#current_status').removeClass('btn-success').addClass('btn-danger');
                }
        }});
    }    
    $(this).find('.btn').toggleClass('btn-default');
});
/*----------------------------------------------------------------------
| Registration Process
------------------------------------------------------------------------*/
$(document).on('click', '#create-account', function(){
    $( "#chat-container" ).load( base+"chatigniter/auth/register/");
    return false;
});
$(document).on('click', '#register', function(){
        dataString = $('#register-frm').serialize();
        $.ajax({
            type: "POST",
            url: base  + "chatigniter/auth/register",
            data: dataString,
            cache: false,
            beforeSend: function(){
             $("#register").html('<img src="assets/images/ajax-loader.gif" /> Connecting...');
         },
        success: function(response){
            if(response.success)
            {
                $(".message").html(success(response.message));
                $('#register-frm')[0].reset();
            }
            else
            {
                $(".message").html(error(response.message));
            }
            $("#register").html('<i class="fa fa-plus-circle"></i> Register');
            highlightFields(response.errors);
        }});
return false;
});

 $(document).on('click', '.dropdown-menu', function(e) {
    e.stopPropagation();
});

/*----------------------------------------------------------------------
| Editing profile process
------------------------------------------------------------------------*/
$(document).on('click', '#edit-profile', function(){
    $( "#chat-inner" ).load( base+"chatigniter/users/editProfile/");
    $('[data-toggle="dropdown"]').parent().removeClass('open');
    return false;
});

$(document).on("submit", "#profile-frm", function(e)
{
    e.preventDefault();
     dataString = new FormData(this);
        $.ajax({
            type: "POST",
            url: base  + "chatigniter/users/editProfile",
            data: dataString,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function(){
             $("#update-profile").html('<img src="assets/images/ajax-loader.gif" /> Connecting...');
         },
        success: function(response){
            if(response.success)
            {
                if(response.errors.avatar_error)
                    $(".message").html(error(response.errors.avatar_error));
                else{
                    $(".message").html(success(response.message));
                    $( "#chat-inner" ).load( base+"chatigniter/users/editProfile/");
                }
            }
            else
            {
                $(".message").html(error(response.message));
            }
            $("#update-profile").html('<i class="fa fa-plus-circle"></i> Update Profile');
            highlightFields(response.errors);

        }});
});

/*----------------------------------------------------------------------
| change password process
------------------------------------------------------------------------*/
$(document).on('click', '#change-password', function(){
    $( "#chat-inner" ).load( base+"chatigniter/users/changePassword/");
    $('[data-toggle="dropdown"]').parent().removeClass('open');
    return false;
});
$(document).on('click', '#update-password', function(){
        dataString = $('#changepassword-frm').serialize();
        $.ajax({
            type: "POST",
            url: base  + "chatigniter/users/changePassword",
            data: dataString,
            cache: false,
            beforeSend: function(){
             $("#update-password").html('<img src="assets/images/ajax-loader.gif" /> Connecting...');
         },
        success: function(response){
            if(response.success)
            {
                $(".message").html(success(response.message));
                $('#changepassword-frm')[0].reset();
            }
            else
            {
                $(".message").html(error(response.message));
            }
            $("#update-password").html('<i class="fa fa-plus-circle"></i> Change Password');
            highlightFields(response.errors);
        }});
return false;
});
/*----------------------------------------------------------------------
| Show Pop overs
------------------------------------------------------------------------*/
   var popOverSettings = {
        container: 'body',
        trigger:'hover',
        selector: '[data-toggle="popover"]',
        placement: 'left',
        html: true,
        content: function () {
            return $('#popover-content').html();
        }
    }

   $(document).on("mouseenter",'[data-toggle="popover"]',function(){
      image  = $(this).find('.profile-img-hidden').html();
      name   = $(this).find('.user-name').html();
      status = $(this).find('.user_status').html();
      $('#contact-image').empty().html(image);
      $('#contact-user-name').empty().html(name);
      $('#contact-user-status').empty().html(status);
      
      $(this).popover({
        placement:'left', 
        trigger: 'hover',
        container: 'body',
        selector: '[data-toggle="popover"]',
        html: true,
        content: function () {
            return $('#popover-content').html();
        }
      }).popover('show');

    }).on('mouseleave', '[data-toggle="popover"]', function() {
        $(this).popover('hide');
    });
});


/*----------------------------------------------------------------------
| Function to display error messages
------------------------------------------------------------------------*/
function error(message){
    var alert = '<div style="font-size:12px; margin-top:10px;" class="alert alert-danger alert-dismissable">\
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\
                <strong>Error ! </strong> ' + message + ' </div>';
    return alert;
}

/*----------------------------------------------------------------------
| Function to display success messages
------------------------------------------------------------------------*/

function success(message){
    var alert = '<div style="font-size:12px; margin-top:10px;" class="alert alert-success alert-dismissable">\
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\
                <strong>Success ! </strong> ' + message + ' </div>';
    return alert;
}
/*----------------------------------------------------------------------
| Function to highlight incorrect fields 
------------------------------------------------------------------------*/
function highlightFields(message){
    $('.form-group').removeClass('has-error');
    $('.error').remove();
    for (var key in message) {
        $('input[name="'+ key+'"]' ).parent().addClass('has-error');
        $('input[name="'+ key+'"]').after('<span class="error">' +message[key]+ '</span>');
    }
}


