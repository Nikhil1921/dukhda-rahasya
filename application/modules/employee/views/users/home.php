<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col call-chat-sidebar col-sm-12">
            <div class="card">
                <div class="card-body chat-body">
                    <div class="chat-box">
                        <div class="chat-left-aside">
                            <div class="people-list" id="people-list">
                                <ul class="list">
                                    <li class="clearfix">
                                        <img class="rounded-circle user-image" src="../assets/images/user/1.jpg"
                                            alt="" />
                                        <div class="status-circle away"></div>
                                        <div class="about">
                                            <div class="name">Vincent Porter</div>
                                            <div class="status">Hello Name</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col call-chat-body">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row chat-box">
                        <div class="col pr-0 chat-right-aside">
                            <div class="chat">
                                <div class="chat-header clearfix">
                                    <img class="rounded-circle" src="../assets/images/user/8.jpg" alt="" />
                                    <div class="about">
                                        <div class="name">
                                            Kori Thomas
                                            <span class="font-primary f-12">Typing...</span>
                                        </div>
                                        <div class="status digits">Last Seen 3:55 PM</div>
                                    </div>
                                    <ul class="list-inline float-left float-sm-right chat-menu-icons">
                                        <li class="list-inline-item">
                                            <a href="#"><i class="icon-search"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="icon-clip"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="icon-headphone-alt"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#"><i class="icon-video-camera"></i></a>
                                        </li>
                                        <li class="list-inline-item toogle-bar">
                                            <a href="#"><i class="icon-menu"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="chat-history chat-msg-box custom-scrollbar">
                                    <ul>
                                        <li>
                                            <div class="message my-message">
                                                <img class="rounded-circle float-left chat-user-img img-30"
                                                    src="../assets/images/user/3.png" alt="" />
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">10:12 am</span>
                                                </div>
                                                Are we meeting today? Project has been already finished
                                                and I have results to show you.
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message other-message pull-right">
                                                <img class="rounded-circle float-right chat-user-img img-30"
                                                    src="../assets/images/user/12.png" alt="" />
                                                <div class="message-data">
                                                    <span class="message-data-time">10:14 am</span>
                                                </div>
                                                Well I am not sure. The rest of the team is not here
                                                yet. Maybe in an hour or so?
                                            </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message other-message pull-right">
                                                <img class="rounded-circle float-right chat-user-img img-30"
                                                    src="../assets/images/user/12.png" alt="" />
                                                <div class="message-data">
                                                    <span class="message-data-time">10:14 am</span>
                                                </div>
                                                Well I am not sure. The rest of the team
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message my-message mb-0">
                                                <img class="rounded-circle float-left chat-user-img img-30"
                                                    src="../assets/images/user/3.png" alt="" />
                                                <div class="message-data text-right">
                                                    <span class="message-data-time">10:20 am</span>
                                                </div>
                                                Actually everything was fine. I'm very excited to show
                                                this to our team.
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="chat-message clearfix">
                                    <div class="row">
                                        <div class="col-xl-12 d-flex">
                                            <div class="smiley-box bg-primary">
                                                <div class="picker">
                                                    <img src="../assets/images/smiley.png" alt="" />
                                                </div>
                                            </div>
                                            <div class="input-group text-box">
                                                <input class="form-control input-txt-bx" id="message-to-send"
                                                    type="text" name="message-to-send"
                                                    placeholder="Type a message......" />
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button">
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
        </div>
    </div>
</div>