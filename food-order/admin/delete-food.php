<?php

    //include constants page
    include("../config/constants.php");

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete

        //1. get id and image name
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //2. remove the image if available
        //check whether image is available or not and delete only if available
        if($image_name!="")
        {
            //it has image and need to remove from folder
            $path="../images/food/".$image_name;

            //remove image file from folder
            $remove=unlink($path);
            if($remove==FALSE)
            {
                //failed to remove image
                $_SESSION['upload']="<div class='error'>Failed to remove image</div>";
                header("location:".SITEURL."admin/manage-food.php");
                die();
            }
        }

        //3. delete food from database
        $sql="DELETE FROM tbl_food WHERE id=$id";
        $res=mysqli_query($conn, $sql);

        //4. redirect to manage food page
        if($res==TRUE)
        {
            //food delete
            $_SESSION['delete']="<div class='success'>Food Deleted Successfully</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }
        else
        {
            $_SESSION['delete']="<div class='error'>Failed to delete food</div>";
            header("location:".SITEURL."admin/manage-food.php");
        }


        
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorize']="<div class='error'>Unauthorized Access</div>";
        header("location:".SITEURL."admin/manage-food.php");
    }

?>