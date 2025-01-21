<?php $title = "Layout";
include_once "templates/header.php" ?>

<div class="project-layout-main-wrapper">

    <div class="d-flex natigation_main_wrapper align-items-center bg-primary-my">
        <div class="col-md-2">
            <img src="<?= base_url() . "assets/images/logo.png" ?>" class="logo" width="75%"  alt="logo">
        </div>
        <div class="col-md-10 row justify-content-between align-items-center">
            <div class="col-md-2">
                <i class="bi bi-list text-light"></i>
            </div>
            <div class="col-md-2 d-flex align-items-center profile_section">
                <small class="text-light user-name"><b>karan rawat</b></small>
                <img class="user-profile-image rounded-circle" title="karan rawat" src="<?= base_url()."profiles/pro1.webp"?>" alt="<?="karan"?>">
            </div>
        </div>
    </div>

    <div class="row sidebar_content_main_wrapper ">

        <div class="col-md-2 sidebar_wrapper ">
            
            <div class="sidebar row my-bg-b" >
                <div class="d-flex flex-column master-links">
                    <a href="<?=base_url()."dashboardcontroller"?>" id="dashoard"><i class="bi bi-collection-fill"></i> Dashboard</a>
                    <a href="#"><i class="bi bi-person-fill-add"></i> User master</a>
                    <a href="#"><i class="bi bi-people-fill"></i> Client master</a>
                    <a href="#"><i class="bi bi-cart-plus-fill"></i> Item master</a>
                    <a href="#"><i class="bi bi-file-earmark-text-fill"></i> Invoice</a>
                </div>
                 <div class="logout-link">
                    <a  onclick="logout()" ><i class="bi bi-box-arrow-left"></i> Logout</a>
                 </div>
            </div>    


        </div>
        <div class="col-md-10 content_wrapper">
            layout
        </div>

    </div>



</div>



<?php include_once "templates/footer.php" ?>