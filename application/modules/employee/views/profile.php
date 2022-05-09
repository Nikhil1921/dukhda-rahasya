<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
    <div class="card-header">
        <h5><?= $title ?> <?= $operation ?></h5>
    </div>
    <div class="card-body">
        <?= form_open() ?>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <?= form_label('Your Name', 'name', 'class="col-form-label"') ?>
                        <?= form_input([
                            'class' => "form-control",
                            'type' => "text",
                            'id' => "name",
                            'name' => "name",
                            'maxlength' => 255,
                            'required' => "",
                            'value' => $this->user->name
                        ]); ?>
                        <?= form_error('name') ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= form_label('Your Email', 'email', 'class="col-form-label"') ?>
                        <?= form_input([
                            'class' => "form-control",
                            'type' => "email",
                            'id' => "email",
                            'name' => "email",
                            'maxlength' => 255,
                            'required' => "",
                            'value' => $this->user->email
                        ]); ?>
                        <?= form_error('email') ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= form_label('Your Mobile', 'mobile', 'class="col-form-label"') ?>
                        <?= form_input([
                            'class' => "form-control",
                            'type' => "text",
                            'id' => "mobile",
                            'name' => "mobile",
                            'maxlength' => 10,
                            'required' => "",
                            'value' => $this->user->mobile
                        ]); ?>
                        <?= form_error('mobile') ?>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <?= form_label('Password', 'password', 'class="col-form-label"') ?>
                        <?= form_input([
                            'class' => "form-control",
                            'type' => "password",
                            'id' => "password",
                            'name' => "password",
                            'maxlength' => 255
                        ]); ?>
                        <?= form_error('password') ?>
                    </div>
                </div>
                <div class="col-12"></div>
                <div class="col-3">
                    <?= form_button([
                        'type'    => 'submit',
                        'class'   => 'btn btn-outline-primary btn-block',
                        'content' => 'UPDATE'
                    ]); ?>
                </div>
                <div class="col-3">
                    <?= anchor("$url", 'CANCEL', 'class="btn btn-outline-danger col-12"'); ?>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>