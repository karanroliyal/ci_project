<?php

if(!isset($_SESSION['email'])){
    header("location:".base_url()."indexcontroller");
}

?>

<!DOCTYPE html>
<head>
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="<?php echo base_url()."assets/css/bootstrap.min.css" ?>">
<link rel="stylesheet" href="<?php echo base_url()."assets/css/style.css" ?>">
<link rel="stylesheet" href="<?php echo base_url()."assets/css/bootstrap-icons.min.css" ?>">
<script src="<?php echo base_url()."assets/js/jquery.js" ?>"></script>
<script src="<?php echo base_url()."assets/js/sweet.alert.js" ?>"></script>
</head>
<body>

<input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>"  >


    
