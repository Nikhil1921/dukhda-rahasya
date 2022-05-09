<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="error-wrapper">
    <div class="container">
        <img class="img-100" src="<?= base_url('assets/images/sad.png') ?>" alt="">
        <div class="error-heading">
            <h2 class="headline font-danger">404</h2>
        </div>
        <div class="col-md-8 offset-md-2">
            <p class="sub-content">The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.</p>
        </div>
        <div><a class="btn btn-danger-gradien btn-lg" href="<?= base_url(admin()) ?>">BACK TO HOME PAGE</a></div>
    </div>
</div>