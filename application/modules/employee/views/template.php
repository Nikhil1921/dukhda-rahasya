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
        <?php if(isset($datatable)): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/datatables.css') ?>">
        <?php endif ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/feather-icon.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/select2.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/back/css/date-picker.css') ?>">
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
            <div class="page-main-header">
                <div class="main-header-right row">
                    <div class="mobile-sidebar d-block">
                        <div class="media-body text-right switch-sm">
                        <label class="switch"><a href="javascript:;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-align-left" id="sidebar-toggle"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg></a></label>
                        </div>
                    </div>
                    <div class="nav-right col p-0">
                        <ul class="nav-menus">
                            <li></li>
                            <li class="onhover-dropdown" id="get-pending-tests"></li>
                            <li class="onhover-dropdown">
                                <div class="media align-items-center">
                                    <?= img(['class' => "align-self-center pull-right img-50 rounded-circle", 'src' => "assets/images/user.png"]) ?>
                                </div>
                                <ul class="profile-dropdown onhover-show-div p-20">
                                    <li><?= anchor(admin('profile'), '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Edit Profile') ?></li>
                                    <li><?= anchor(admin('logout'), '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Logout') ?></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="d-lg-none mobile-toggle pull-right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></div>
                    </div>
                </div>
            </div>
            <div class="page-body-wrapper">
                <div class="page-sidebar">
                    <div class="sidebar custom-scrollbar">
                        <div class="sidebar-user text-center">
                            <div><?= img(['src' => 'assets/images/user.png', 'class' => "img-60 rounded-circle"]) ?></div>
                            <h6 class="mt-3 f-14"><?= $this->user->name ?></h6>
                            <p>EMPLOYEE</p>
                        </div>
                        <ul class="sidebar-menu">
                            <li>
                                <?= anchor(admin('dashboard'), '<i data-feather="home"></i><span> Dashboard</span>', 'class="sidebar-header '.($name === 'dashboard' ? 'active' : '').'"') ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="page-body">
                    <div class="container-fluid">
                        <div class="page-header">
                            <div class="row">
                                <div class="col">
                                    <div class="">
                                        <ol class="breadcrumb float-right">
                                            <li class="breadcrumb-item"><?= anchor(admin('dashboard'), '<i data-feather="home"></i></a>') ?></li>
                                            <?php if (! isset($operation)): ?>
                                              <li class="breadcrumb-item active"><?= $title ?></li>
                                            <?php else: ?>
                                              <li class="breadcrumb-item"><?= anchor($url, ucwords($title)) ?></li>
                                            <?php endif ?>
                                            <?php if (isset($operation)): ?>
                                              <li class="breadcrumb-item active"><?= $operation ?></li>
                                            <?php endif ?>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $name != 'dashboard' ? '<div class="card">' : ''  ?>
                                    <?= $contents ?>
                                <?= $name != 'dashboard' ? '</div>' : ''  ?>
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
        <input type="hidden" id="base_url" value="<?= base_url(admin()) ?>" />
        <input type="hidden" name="admin" value="<?= ADMIN ?>" />
        <?php if(isset($datatable)): ?>
        <input type="hidden" name="dataTableUrl" value="<?= base_url($datatable) ?>" />
        <script src="<?= base_url('assets/back/js/datatable/datatables/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatable-extension/dataTables.buttons.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatable-extension/buttons.colVis.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatable-extension/buttons.bootstrap4.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatable-extension/buttons.html5.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatable-extension/buttons.print.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datatable/datatables/datatable.custom.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/sweet-alert/sweetalert.min.js') ?>"></script>
        <?php endif ?>
        <script src="<?= base_url('assets/back/js/datepicker/date-picker/datepicker.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datepicker/date-picker/datepicker.en.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/datepicker/date-picker/datepicker.custom.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/config.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/select2/select2.full.min.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/select2/select2-custom.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/editor/ckeditor/ckeditor.js') ?>"></script>
        <script src="<?= base_url('assets/back/js/script.js') ?>"></script>
    </body>
</html>