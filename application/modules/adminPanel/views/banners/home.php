<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <div class="row">
        <div class="col-md-9">
            <h5><?= $title ?> <?= $operation ?></h5>
        </div>
        <div class="col-md-3">
            <?= form_open_multipart("$url/upload") ?>
                <?= form_label("<i class='fa fa-upload'></i> Upload", 'image', 'class="btn btn-outline-success btn-sm float-right"'); ?>
                <?= form_input([
                    'style' => "display:none;",
                    'type' => "file",
                    'id' => "image",
                    'accept' => "image/jpeg, image/jpg, image/png",
                    'name' => "image",
                    'onchange' => 'this.form.submit()'
                ]); ?>
            <?= form_close() ?>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="datatable table table-striped table-bordered nowrap">
            <thead>
                <th class="target">Sr.</th>
                <th class="target">Banner</th>
                <th class="target">Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>