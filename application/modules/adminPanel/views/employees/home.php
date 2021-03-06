<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card-header">
    <div class="row">
        <div class="col-md-8">
            <h5><?= $title ?> <?= $operation ?></h5>
        </div>
        <div class="col-md-4">
            <?= anchor("$url/add-update", '<span class="fa fa-plus"></span> Add new', 'class="btn btn-outline-success btn-sm float-right"'); ?>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="datatable table table-striped table-bordered nowrap">
            <thead>
                <th class="target">Sr.</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th class="target">Action</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>