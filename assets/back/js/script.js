(function($) {
    "use strict";
    $(".mobile-toggle").click(function() {
        if ($(".nav-menus").hasClass('open')) {
            $('#right_side_bar').removeClass('show');
            $('.form-control-plaintext').removeClass('open');
        }
        $(".nav-menus").toggleClass("open");
    });
    $(".mobile-search").click(function() {
        $(".form-control-plaintext").toggleClass("open");
    });
    $(".bookmark-search").click(function() {
        $(".form-control-search").toggleClass("open");
    });
    $(".filter-toggle").click(function() {
        $(".product-sidebar").toggleClass("open");
    });
    $(".toggle-data").click(function() {
        $(".product-wrapper").toggleClass("sidebaron");
    });
    $(".form-control-plaintext").keyup(function(e) {
        if (e.target.value) {
            $("body").addClass("offcanvas");
        } else {
            $("body").removeClass("offcanvas");
        }
    });
    $(".form-control-search").keyup(function(e) {
        if (e.target.value) {
            $(".page-wrapper").addClass("offcanvas-bookmark");
        } else {
            $(".page-wrapper").removeClass("offcanvas-bookmark");
        }
    });
})(jQuery);

$('.loader-wrapper').fadeOut('slow', function() {
    $(this).hide();
});

$(window).on('scroll', function() {
    if ($(this).scrollTop() > 600) {
        $('.tap-top').fadeIn();
    } else {
        $('.tap-top').fadeOut();
    }
});
$('.tap-top').click(function() {
    $("html, body").animate({
        scrollTop: 0
    }, 600);
    return false;
});

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}
(function($, window, document, undefined) {
    "use strict";
    var $ripple = $(".js-ripple");
    $ripple.on("click.ui.ripple", function(e) {
        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find(".c-ripple__circle");
        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;
        $circle.css({
            top: y + "px",
            left: x + "px"
        });
        $this.addClass("is-active");
    });
    $ripple.on(
        "animationend webkitAnimationEnd oanimationend MSAnimationEnd",
        function(e) {
            $(this).removeClass("is-active");
        });
})(jQuery, window, document);

$(".chat-menu-icons .toogle-bar").click(function() {
    $(".chat-menu").toggleClass("show");
});


// active link
// custom code start here

var url = $("#base_url").val();
if ($('input[name="error_msg"]').val() != '') {
    flash_msg("Error", $('input[name="error_msg"]').val(), "danger");
}
if ($('input[name="success_msg"]').val() != '') {
    flash_msg("Success", $('input[name="success_msg"]').val(), "success");
}

function flash_msg(title, message, type) {
    $.notify({
        title: title,
        message: message
    }, {
        type: type,
        allow_dismiss: false,
        newest_on_top: false,
        mouse_over: false,
        showProgressbar: false,
        spacing: 10,
        timer: 2000,
        placement: {
            from: 'top',
            align: 'center'
        },
        offset: {
            x: 30,
            y: 30
        },
        delay: 1000,
        z_index: 10000,
        animate: {
            enter: 'animated flash',
            exit: 'animated flash'
        }
    });
}

var script = {
    delete: function(id) {
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#" + id).submit();
                } else {
                    return;
                }
            })
        return;
    }
};

const submitForm = (form, button) => {
    $.ajax({
        url: $(form).attr("action"),
        type: $(form).attr("method"),
        data: new FormData(form),
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async: false,
        beforeSend: function () {
            $(button).attr("disabled", true);
        },
        success: function (result) {
            if (result.error == true){
                flash_msg("", result.message, "danger");
                $(button).attr("disabled", false);
            }else{
                form.reset();
                flash_msg("Success : ", result.message, "success");
                setInterval(function () { location.reload(); }, 1000);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $(button).attr("disabled", false);
            flash_msg('Error : ', "Something is not going good.", 'danger');
        },
    });
};

if($('input[name=chat-id]').length > 0){
    var pusher = new Pusher("1bcc03ffc88b92ba0906", {
        cluster: "ap2",
        encrypted: true,
    });

    var channel = pusher.subscribe(`${$("input[name=chat-id]").val()}_channel`);

    var isOldTitle = true;
    var oldTitle = document.getElementsByTagName("title")[0].innerHTML;
    var newTitle = "You have new message";
    var interval = null;
    
    function changeTitle() {
      document.title = isOldTitle ? oldTitle : newTitle;
      isOldTitle = !isOldTitle;
    }

    $(window).focus(function () {
        clearInterval(interval);
        $("title").text(oldTitle);
    });

    channel.bind("my-event", function (data) {
        let msg =
          data.sender === "Admin"
            ? `<li>
                    <div class="message my-message text-right">
                        <div class="message-data text-right">
                            <span class="message-data-time">${data.dt}</span>
                        </div>
                        ${data.message}
                    </div>
                </li>`
            : `<li class="clearfix">
                    <div class="message other-message pull-right">
                        <div class="message-data">
                            <span class="message-data-time">${data.dt}</span>
                        </div>
                        ${data.message}
                    </div>
                </li>`;

        $(".messages_display").append(msg);

        if (data.sender !== "Admin") interval = setInterval(changeTitle, 700);

        $("#send-btn").attr('disabled', false);

        $(".chat-history").scrollTop($(".chat-history")[0].scrollHeight);
    });

    channel.bind("pusher:subscription_succeeded", function (members) {});

    function ajaxCall(data) {
        $.ajax({
            type: "POST",
            data: data,
        });
    }

    $.fn.enterKey = function (fnc) {
        return this.each(function () {
            $(this).keypress(function (ev) {
            var keycode = ev.keyCode ? ev.keyCode : ev.which;
            if (keycode == "13") {
                fnc.call(this, ev);
            }
            });
        });
    };

    $("body").on("click", "#send-btn", function (e) {

        e.preventDefault();

        var message = $("#message-to-send").val();

        if (message !== "") {
            var chat_message = {
                message: message,
                user: $("input[name=chat-id]").val(),
            };
            ajaxCall(chat_message);
            $("#message-to-send").val("");
            $("#send-btn").attr("disabled", true);
        }
    });

    $("#message-to-send").enterKey(function (e) {
        e.preventDefault();
        $("#send-btn").click();
    });

    $(".chat-history").scrollTop($(".chat-history")[0].scrollHeight);
}

// custom code end here