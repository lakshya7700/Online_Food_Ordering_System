<?php

    //include constants folder
    include('../config/constants.php');

    //echo "delete category";
    //check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get the value and delete
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the physical image file if available
        if($image_name=!"")
        {
            //image is available, removing it 
            $path="../images/category/".$image_name;
            $remove=unlink($path);

            //if failed to remove image add an error message and stop the process
            if($remove=FALSE)
            {
                $_SESSION['remove']="<div class='error'>Failed to remove Category Image</div>";
                header("location:".SITEURL.'admin/manage-category.php');
                die();
            }
        }

        //delete data from database
        //SQL query to delete the data from database
        $sql="DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res=mysqli_query($conn,$sql);

        //check whether the data is deleted or not
        if($res==TRUE)
        {
            //set success message and redirect it to manage-category page
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";
            header("location:".SITEURL.'admin/manage-category.php');

        }
        else
        {
            //set error message and redirect to manage-category page
            $_SESSION['delete']="<div class='error'>Failed to Delete Category.</div>";
            header("location:".SITEURL.'admin/manage-category.php');
        }

    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>