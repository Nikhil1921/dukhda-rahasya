<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <title><?= APP_NAME ?> | Chat</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" />
        <?= link_tag('assets/chat.css?v='.time(), 'stylesheet', 'text/css'); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-12 chat">
                    <div class="card">
                        <div class="card-header msg_head">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <?= img($astrologer->image, '', 'class="rounded-circle user_img"') ?>
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span><?= $astrologer->name ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body msg_card_body">
                            <?php foreach($chats as $chat): 
                                echo ($chat['message_type'] === "Admin") ? 
                                '<div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        '.img($astrologer->image, '', 'class="rounded-circle user_img"').'
                                    </div>
                                    <div class="msg_cotainer">
                                        '.$chat['message'].'
                                        <span class="msg_time">'.date('d-m-Y h:i a', $chat['created_at']).'</span>
                                    </div>
                                </div>' : '<div class="d-flex justify-content-end mb-4">
                                                <div class="msg_cotainer_send">
                                                    '.$chat['message'].'
                                                    <span class="msg_time_send">'.date('d-m-Y h:i a', $chat['created_at']).'</span>
                                                </div>
                                                <div class="img_cont_msg">
                                                    '.img($profile['image'], '', 'class="rounded-circle user_img_msg"').'
                                                </div>
                                            </div>';
                            endforeach ?>
                            <div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <?= img($astrologer->image, '', 'class="rounded-circle user_img"') ?>
                                </div>
                                <div class="msg_cotainer">
                                    Welcome to <?= APP_NAME ?>
                                    <span class="msg_time"><?= date('d-m-Y h:i a') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="input-group">
                                <textarea name="" class="form-control type_msg" placeholder="Type your message..."></textarea>
                                <div class="input-group-append">
                                    <span class="input-group-text send_btn"><i class="fas fa-location-arrow"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var pusher = new Pusher('1bcc03ffc88b92ba0906', {
                cluster: 'ap2',
                encrypted: true
            });
            
            var channel = pusher.subscribe('<?= e_id($id) ?>_channel');

            channel.bind('my-event',
                function(data) {
                    let msg = data.sender !== 'ME' ? `
                        <div class="d-flex justify-content-start mb-4">
                            <div class="img_cont_msg">
                                <?= img($astrologer->image, '', 'class="rounded-circle user_img"') ?>
                            </div>
                            <div class="msg_cotainer">
                                ${data.message}
                                <span class="msg_time">${data.dt}</span>
                            </div>
                        </div>` : `
                            <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                    ${data.message}
                                    <span class="msg_time_send">${data.dt}</span>
                                </div>
                                <div class="img_cont_msg">
                                    <?= img($profile['image'], '', 'class="rounded-circle user_img_msg"') ?>
                                </div>
                            </div>`;

                    $('.msg_card_body').append(msg);
                    $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
                });

            channel.bind('pusher:subscription_succeeded', function(members) {

            });
            
            function ajaxCall(ajax_data) {
                $.ajax({
                    type: "POST",
                     headers: {
                        "Authorization":"<?= $id ?>",
                    },
                    data: ajax_data
                });
            }

            $.fn.enterKey = function(fnc) {
                return this.each(function() {
                    $(this).keypress(function(ev) {
                        var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                        if (keycode == '13') {
                            fnc.call(this, ev);
                        }
                    });
                });
            }

            $('body').on('click', '.send_btn', function(e) {
                e.preventDefault();

                var message = $('.type_msg').val();
                if (message !== '') {
                    var chat_message = {
                        message: message
                    }
                    ajaxCall(chat_message);

                    $('.type_msg').val('');
                }
            });

            $('.type_msg').enterKey(function(e) {
                e.preventDefault();
                $('.send_btn').click();
            });

            $(".msg_card_body").scrollTop($(".msg_card_body")[0].scrollHeight);
        </script>
    </body>
</html>