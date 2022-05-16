<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col call-chat-body">
    <div class="card-body p-0">
        <div class="row chat-box">
            <div class="col pr-0 chat-right-aside">
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="about">
                            <div class="name">
                                <?= $data['name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history chat-msg-box custom-scrollbar">
                        <ul class="messages_display">
                            <?php foreach($data['chats'] as $chat): 
                            echo ($chat['message_type'] === "Admin") ? '<li>
                                    <div class="message my-message text-right">
                                        <div class="message-data text-right">
                                            <span class="message-data-time">'.date('d-m-Y h:i a', $chat['created_at']).'</span>
                                        </div>
                                        '.$chat['message'].'
                                    </div>
                                </li>' : '<li class="clearfix">
                                    <div class="message other-message pull-right">
                                        <div class="message-data">
                                            <span class="message-data-time">'.date('d-m-Y h:i a', $chat['created_at']).'</span>
                                        </div>
                                        '.$chat['message'].'
                                    </div>
                                </li>';
                            endforeach ?>
                        </ul>
                    </div>
                    <div class="chat-message clearfix">
                        <div class="row">
                            <div class="col-xl-12 d-flex">
                                <div class="input-group text-box">
                                    <input class="form-control input-txt-bx" id="message-to-send"
                                        type="text" name="message-to-send"
                                        placeholder="Type a message......" />
                                    <div class="input-group-append">
                                        <button type="submit" id="send-btn" class="btn btn-primary" type="button">
                                            SEND
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>