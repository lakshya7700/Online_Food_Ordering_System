<?php

    //Authorization - Access Control
    //check whether the user is logged in 
    if(!isset($_SESSION['user'])) //if user session is not set
    {
        //user is not logged in
        //redirect to login page with message
        $_SESSION['no-login-message']="<div class='error text-center'>Please log in to Access Admin Panel</div>";
        //redirect to login page
        header("location:".SITEURL.'admin/login.php');
    }

?>