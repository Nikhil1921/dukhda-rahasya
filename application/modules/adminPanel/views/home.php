<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('employees')) ?>'">
        <div class="card">
            <div class="card-body">
                <div class="chart-widget-dashboard">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0 f-w-600">
                                <span class="counter"><?= $this->main->counter('employees', ['is_deleted' => 0]) ?></span>
                            </h5>
                            <p>Total employees</p>
                        </div>
                        <i class="fa fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('users')) ?>'">
        <div class="card">
            <div class="card-body">
                <div class="chart-widget-dashboard">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0 f-w-600">
                                <span class="counter"><?= $this->main->counter('users', ['is_deleted' => 0]) ?></span>
                            </h5>
                            <p>Total Users</p>
                        </div>
                        <i class="fa fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" onclick="window.location.href = '<?= base_url(admin('payments')) ?>'">
        <div class="card">
            <div class="card-body">
                <div class="chart-widget-dashboard">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="mt-0 mb-0 f-w-600">
                                <span class="counter"><?= $this->main->counter('purchased_plans', ['is_approved' => 0]) ?></span>
                            </h5>
                            <p>Payment approvals</p>
                        </div>
                        <i class="fa fa-money fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>