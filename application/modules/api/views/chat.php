<!DOCTYPE html>
    <head>
        <title></title>	
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>	
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>	
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js"></script>
        <style>
        .messages_display {height: 300px; overflow: auto;}		
        .messages_display .message_item {padding: 0; margin: 0; }		
        .chat_left_img {
            padding-left: 20px;
        }

        .alert-success {
            color: #ffffff;
            background-color: #23519c;
            border-color: #23519c;
            font-size: 40px;
        }

        .form_ {
            position: relative;
        }

        .formm {
            position: relative;
            outline: none;
            padding: 13px;
            width: 100%;
        }

        .fa-telegram {
            position: absolute;
            top: 9px;
            border: 1px solid;
            border-radius: 50%;
            width: 33px;
            height: 33px;
            line-height: 30px;
            color: #ffffff;
            right: 9px;
            text-align: center;
            font-size: 30px;
            background: #23519c;
        }

        .messages_display {
            overflow: auto;
            height:85vh;
        }

        .input_message {
            display: block;
            width: 100%;
            font-size:30px !important;
            height: 34px;
            padding: 31px 27px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }

        .input_send_btn {
            padding: 9px 8px;
            font-size: 30px;
        }

        </style>
    </head>
    <body>
        <br />
        <!--Form Start-->
        <div class = "container-fluid">
            <div class="row">	
            <div class = "col-md-6 col-md-offset-3 chat_box" id="chatbox">						
                <div class = "messages_display">
                    <?php foreach($chats as $chat): 
                    echo ($chat['message_type'] !== "Admin") ? '<div class="col-xs-12 row">
                            <div class="col-xs-11 text-right">
                                <div class="alert alert-success">'.$chat['message'].' <br> '.date('d-m-Y h:i a', $chat['created_at']).'</div>
                            </div>
                            <div class="col-xs-1">
                                 <img class="" src="'.base_url('assets/images/profile.png').'" alt="user"/> 
                            </div>
                        </div>' : '<div class="col-xs-12 row">
                            <div class="col-xs-1">
                                <img class="" src="'.base_url('assets/images/profile.png').'" alt="user"/> 
                            </div>
                            <div class="col-xs-11">
                                <div class="alert alert-success">'.$chat['message'].' <br> '.date('d-m-Y h:i a', $chat['created_at']).'</div>
                            </div>
                        </div>';
                    endforeach ?>
                </div>
                <br />					
                <div class = "form_ col-xs-10" style="position: relative; bottom: 0;">
                    <input type="text" class = "input_message form-control" placeholder="Enter Message">
                </div>
                <div class = "form-group input_send_holder col-xs-2"  style="position: relative; bottom: 0;">
                    <input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send input_send_btn" />		
                </div>
            </div>
            </div>	
        </div>
        <!--form end-->

        <script type="text/javascript">
            var pusher = new Pusher('1bcc03ffc88b92ba0906', {
                cluster: 'ap2',
                encrypted: true
            });
            
            var channel = pusher.subscribe('<?= e_id($id) ?>_channel');

            channel.bind('my-event',
                function(data) {
                    let msg = data.sender !== 'ME' ? `<div class="col-xs-12 row">
                            <div class="col-xs-1">
                                <img class="" src="<?= base_url('assets/images/profile.png') ?>" alt="user"/> 
                            </div>
                            <div class="col-xs-11">
                                <div class="alert alert-success">${data.message} <br> ${data.dt}</div>
                            </div>
                        </div>` : `<div class="col-xs-12 row">
                            <div class="col-xs-11 text-right">
                                <div class="alert alert-success">${data.message} <br> ${data.dt}</div>
                            </div>
                            <div class="col-xs-1">
                                <img class="" src="<?= base_url('assets/images/profile.png') ?>" alt="user"/> 
                            </div>
                        </div>`;
                    $('.messages_display').append(msg);
                    $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send input_send_btn" />');
                    $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
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

            $('body').on('click', '.chat_box .input_send', function(e) {
                e.preventDefault();

                var message = $('.chat_box .input_message').val();
                if (message !== '') {
                    var chat_message = {
                        message: message
                    }
                    ajaxCall(chat_message);
                    $('.chat_box .input_message').val('');
                    $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary btn-block input_send_btn" disabled />');
                }
            });

            $('.chat_box .input_message').enterKey(function(e) {
                e.preventDefault();
                $('.chat_box .input_send').click();
            });

            $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
        </script>
    </body>
</html>