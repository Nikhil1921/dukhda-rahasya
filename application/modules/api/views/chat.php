<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <title><?= APP_NAME ?> | Chat</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" />

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
                                    <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                                    <span class="online_icon"></span>
                                </div>
                                <!-- <div class="user_info">
                                    <span>Khalid</span>
                                    <p><?= count($chats) ?> Messages</p>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body msg_card_body">
                        <?php foreach($chats as $chat): 
                            echo ($chat['message_type'] === "Admin") ? 
                            '<div class="d-flex justify-content-start mb-4">
                                <div class="img_cont_msg">
                                    <img src="'.base_url('assets/images/profile.png').'" class="rounded-circle user_img_msg" />
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
                                                <img src="'.base_url('assets/images/profile.png').'" class="rounded-circle user_img_msg" />
                                            </div>
                                        </div>';
                        endforeach ?>
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
                                <img src="<?= base_url('assets/images/profile.png') ?>" class="rounded-circle user_img_msg" />
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
                                    <img src="<?= base_url('assets/images/profile.png') ?>" class="rounded-circle user_img_msg" />
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
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            background: #7F7FD5;
            background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
            background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
        }
        
        .chat {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        
        .card {
            height: 95vh;
            width: 100%;
            border-radius: 15px !important;
            background-color: rgba(0, 0, 0, 0.4) !important;
        }
        
       
        
        .msg_card_body {
            overflow-y: auto;
        }
        
        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border-bottom: 0 !important;
        }
        
        .card-footer {
            border-radius: 0 0 15px 15px !important;
            border-top: 0 !important;
        }
        
        .container {
            align-content: center;
        }
        
        .type_msg {
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 0 !important;
            color: white !important;
            overflow: hidden;
            padding: 2rem;
            font-size: 2rem;
        }
        
        .type_msg:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
        
        .send_btn {
            border-radius: 0 15px 15px 0 !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
            border: 0 !important;
            color: white !important;
            cursor: pointer;
            font-size: 2rem;
            padding: 2.5rem;
        }
        
        .user_img {
            height: 70px;
            width: 70px;
            border: 1.5px solid #f5f6fa;
        }
        
        .user_img_msg {
            height: 4rem;
            width: 4rem;
            border: 1.5px solid #f5f6fa;
        }
        
        .img_cont {
            position: relative;
            height: 70px;
            width: 70px;
        }
        
        .img_cont_msg {
            height: 40px;
            width: 40px;
        }
        
        .online_icon {
            position: absolute;
            height: 15px;
            width: 15px;
            background-color: #4cd137;
            border-radius: 50%;
            bottom: 0.2em;
            right: 0.4em;
            border: 1.5px solid white;
        }
        
        .user_info {
            margin-top: auto;
            margin-bottom: auto;
            margin-left: 15px;
        }
        
        .user_info span {
            font-size: 20px;
            color: white;
        }
        
        .user_info p {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .msg_cotainer {
            margin-top: auto;
            margin-bottom: auto;
            margin-left: 10px;
            border-radius: 25px;
            background-color: #82ccdd;
            padding: 10px;
            position: relative;
            font-size: 1.9rem;
        }
        
        .msg_cotainer_send {
            margin-top: auto;
            margin-bottom: auto;
            margin-right: 10px;
            border-radius: 25px;
            background-color: #78e08f;
            padding: 10px;
            position: relative;
            font-size: 1.9rem;
        }
        
        .msg_time {
            position: absolute;
            left: 0;
            bottom: -15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
        }
        
        .msg_time_send {
            position: absolute;
            right: 0;
            bottom: -15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 10px;
        }
        
        .msg_head {
            position: relative;
        }
    </style>

</html>