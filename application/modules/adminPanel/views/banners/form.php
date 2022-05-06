<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <h5><?= $title ?> <?= $operation ?></h5>
</div>
<div class="card-body">
    <?= form_open_multipart('', '', ['image' => isset($data['banner']) ? $data['banner'] : '']) ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= form_label('Title', 'title', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "text",
                        'id' => "title",
                        'name' => "title",
                        'maxlength' => 100,
                        'required' => "",
                        'value' => set_value('title') ? set_value('title') : (isset($data['title']) ? $data['title'] : '')
                    ]); ?>
                    <?= form_error('title') ?>
                </div>
            </div>
            <div class="col-md-<?= (isset($data['banner'])) ? 4 : 6 ?>">
                <div class="form-group">
                    <?= form_label('Image <span class="text-danger">(Size should be 1920*500)</span>', 'image', 'class="col-form-label"') ?>
                    <?= form_input([
                        'class' => "form-control",
                        'type' => "file",
                        'id' => "image",
                        'accept' => "image/jpeg, image/jpg, image/png",
                        'name' => "image",
                    ]); ?>
                </div>
            </div>
            <?php if (isset($data['banner'])): ?>
                <div class="col-md-2">
                    <?= img(['src' => $this->path.$data['banner'], 'width' => '100%', 'height' => '70']); ?>
                </div>
            <?php endif ?>
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