<?php


$title = "Login";
include_once "templates/header.php" 

?>


<div class="container login-page-wrapper">

    <div class="row login-main align-items-center">
        <input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>">

        <div class="col-md-6 col-sm-6">
            <img src="<?php echo base_url() . 'assets/images/login-image.png' ?>" width="100%" alt="login-image">
        </div>
        <div class="col-md-6 col-sm-6 login-form">

            <form id="loginForm">

                <img class="mb-3" src="<?php echo base_url() . 'assets/images/logo.png' ?>" width="45%" alt="logo">

                <div class="mb-3">
                    <label for="emailId" class="form-label">Email</label>
                    <input type="text" class="form-control" id="emailId" name="email">
                    <small class="text-danger error"></small>
                </div>
                <div class="mb-3">
                    <label for="passwordId" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordId" name="password">
                    <small class="text-danger error"></small>
                </div>
                <div class="mt-3 mb-3">
                    <button type="button" class="btn btn-primary" onclick="loginMe()">Login</button>
                </div>
                <div class="alert alert-success d-none" role="alert">
                </div>
                <div class="alert alert-danger d-none" role="alert">
                </div>

            </form>

        </div>

    </div>


</div>




<script src="<?php echo base_url() . "assets/js/login.js" ?>"></script>
<?php include_once "templates/footer.php" ?>