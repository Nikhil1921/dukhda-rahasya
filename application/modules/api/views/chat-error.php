<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

    <head>
        <title><?= APP_NAME ?> | Chat</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" />
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" />
        <?= link_tag('assets/chat.css?v='.time(), 'stylesheet', 'text/css'); ?>
    </head>

    <body>
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-12 chat">
                    <div class="card">
                        <div class="card-header msg_head">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <?= img('assets/images/favicon.png', '', 'class="rounded-circle user_img"') ?>
                                    <span class="online_icon"></span>
                                </div>
                                <div class="user_info">
                                    <span><?= APP_NAME ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="user_info">
                                <span>Astrologer not available at this moment.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>