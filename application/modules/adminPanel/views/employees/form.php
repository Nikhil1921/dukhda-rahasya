<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <h5><?= $title ?> <?= $operation ?></h5>
</div>
<div class="card-body">
    <?= form_open() ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Name', 'name', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'id' => "name",
                        'name' => "name",
                        'maxlength' => 50,
                        'required' => "",
                        'value' => set_value('name') ? set_value('name') : (isset($data['name']) ? $data['name'] : '')
                    ]); ?>
                    <?= form_error('name') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Mobile no.', 'mobile', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'id' => "mobile",
                        'name' => "mobile",
                        'maxlength' => 10,
                        'required' => "",
                        'value' => set_value('mobile') ? set_value('mobile') : (isset($data['mobile']) ? $data['mobile'] : '')
                    ]); ?>
                    <?= form_error('mobile') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Email', 'email', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "email",
                        'id' => "email",
                        'name' => "email",
                        'maxlength' => 100,
                        'required' => "",
                        'value' => set_value('email') ? set_value('email') : (isset($data['email']) ? $data['email'] : '')
                    ]); ?>
                    <?= form_error('email') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Password', 'password', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "password",
                        'id' => "password",
                        'name' => "password",
                        'maxlength' => 100,
                        isset($data['password']) ? 'required' : '',
                    ]); ?>
                    <?= form_error('password') ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Package', 'pack_id', 'class="col-form-label"') ?>
                    <select name="pack_id" id="pack_id" class="form-control">
                        <option value="">Select package</option>
                        <?php foreach ($packages as $v): ?>
                            <option value="<?= e_id($v['id']) ?>" <?= set_value('pack_id') ? set_select('pack_id', e_id($v['id'])) : (isset($data['pack_id']) && $data['pack_id'] === $v['id'] ? 'selected' : '') ?>><?= $v['price'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <?= form_error('pack_id') ?>
                </div>
            </div>
            <div class="col-12"></div>
            <div class="col-6 col-md-3">
                <?= form_button([
                    'type'    => 'submit',
                    'class'   => 'btn btn-outline-primary btn-block col-12',
                    'content' => 'SAVE'
                ]); ?>
            </div>
            <div class="col-6 col-md-3">
                <?= anchor("$url", 'CANCEL', 'class="btn btn-outline-danger col-12"'); ?>
            </div>
        </div>
    <?= form_close() ?>
</div>