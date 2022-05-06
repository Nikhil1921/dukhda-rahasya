<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-body">
    <div class="text-center">
        <h4><?= ucwords($title) ?></h4>
        <h6>Enter your new password </h6>
    </div>
    <?= form_open('', '', 'class="theme-form"') ?>
    <div class="form-group">
        <?= form_label('Password', 'password', 'class="col-form-label"') ?>
        <?= form_input([
            'class' => "form-control",
            'type' => "password",
            'id' => "password",
            'name' => "password",
            'maxlength' => 255,
            'required' => ""
        ]); ?>
        <?= form_error('password') ?>
    </div>
    <div class="form-group form-row mt-3 mb-0">
        <?= form_button([
            'type'    => 'submit',
            'class'   => 'btn btn-outline-primary btn-block',
            'content' => 'Change Password'
        ]); ?>
    </div>
    <?= form_close() ?>
</div>