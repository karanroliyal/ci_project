<?php $title = "Layout";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="row natigation_main_wrapper align-items-center my-bg-p">
        <div class="col-md-2">
            <img src="<?= base_url() . "assets/images/logo.png" ?>" class="logo" width="95%" alt="logo">
        </div>
        <div class="col-md-10 row justify-content-between align-items-center">
            <div class="col-md-2">
                <i class="bi bi-list text-light"></i>
            </div>
            <div class="col-md-2 d-flex align-items-center profile_section">
                <small class="text-light user-name">karan rawat</small>
                <img class="user-profile-image rounded-circle" title="karan rawat" src="<?= base_url()."profiles/pro1.webp"?>" alt="<?="karan"?>">
            </div>
        </div>
    </div>

    <div class="row sidebar_content_main_wrapper my-bg-b">

        <div class="col-md-2 sidebar_wrapper">
            side bar
        </div>
        <div class="col-md-10 content_wrapper">
            dashboard
        </div>

    </div>



</div>



<script src="<?php echo base_url() . "assets/js/login.js" ?>"></script>
<?php include_once "templates/footer.php" ?>