<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= APP_NAME ?> | <?= ucwords($title) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/fontawesome.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/icofont.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/themify.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/flag-icon.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/feather-icon.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/style.css') ?>">
    <link id="color" rel="stylesheet" href="<?= base_url('assets/back/css/light-1.css') ?>" media="screen">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/responsive.css') ?>">
  </head>
  <body>
    <div class="loader-wrapper">
      <div class="loader bg-white">
        <div class="whirly-loader"> </div>
      </div>
    </div>
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <div class="authentication-main">
          <div class="row">
            <div class="col-md-12">
              <div class="auth-innerright">
                <div class="authentication-box">
                  <div class="card mt-4">
                    <?= $contents ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="error_msg" value="<?= $this->session->error ?>" />
    <input type="hidden" name="success_msg" value="<?= $this->session->success ?>" />
    <script src="<?= base_url('assets/back/js/jquery-3.2.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/bootstrap/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/bootstrap/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/icons/feather-icon/feather.min.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/icons/feather-icon/feather-icon.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/sidebar-menu.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/notify/bootstrap-notify.min.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/config.js') ?>"></script>
    <script src="<?= base_url('assets/back/js/script.js') ?>"></script>
  </body>
</html>