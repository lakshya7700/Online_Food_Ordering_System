<?php

    include("../config/constants.php");
    //1. get the id of the admin to be deleted
    $id = $_GET['id'];

    //2. create SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    $res= mysqli_query($conn, $sql);

    if($res==TRUE)
    {
        //echo "Admin Deleted";
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";
        header('location:'.SITEURL."admin/manage-admin.php");
    }
    else
    {
        //echo "Failed to Delete Admin";
        $_SESSION['delete']="<div class='error'>Failed to Delete Admin. Try again later</div>";
        header('location:'.SITEURL."admin/manage-admin.php");
    }

    //3. redirect to manage admin page with message success or error

?>