<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-body">
    <div class="text-center">
        <h4><?= ucwords($title) ?></h4>
        <h6>Enter your OTP to change password</h6>
    </div>
    <?= form_open('', '', 'class="theme-form"') ?>
    <div class="form-group">
        <?= form_label('Your OTP', 'otp', 'class="col-form-label pt-0"') ?>
        <?= form_input([
            'class' => "form-control",
            'type' => "text",
            'id' => "otp",
            'name' => "otp",
            'maxlength' => 6,
            'required' => "",
            'value' => set_value('otp')
        ]); ?>
        <?= form_error('otp') ?>
    </div>
    <div class="form-group form-row mt-3 mb-0">
        <?= form_button([
            'type'    => 'submit',
            'class'   => 'btn btn-outline-primary btn-block',
            'content' => 'Check OTP'
        ]); ?>
    </div>
    <?= form_close() ?>
</div>