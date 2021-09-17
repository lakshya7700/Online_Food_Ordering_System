<?php include("partials/menu.php"); ?>

<?php

    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id=$_GET['id'];

        $sql2="SELECT * FROM tbl_food WHERE id=$id";

        $res2=mysqli_query($conn, $sql2);

        $count2=mysqli_num_rows($res2);
        
        if($count2==1)
        {
            $row2=mysqli_fetch_assoc($res2);

            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];
        }
        

        
    }
    else
    {
        //redirect to manage food
        header("location:".SITEURL."admin/manage-food.php");
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
    
            <table class="tbl-30">

                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            //check whether image is available or not
                            if($current_image=="")
                            {
                                //image not available
                                echo "<div class='error'>IMage not Available</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?> " width="100px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>

                        <select name="category">

                            <?php
                            
                                //query to get active category
                                $sql="SELECT *FROM tbl_category WHERE active='Yes'";
                                $res=mysqli_query($conn, $sql);

                                $count=mysqli_num_rows($res);

                                if($count>0)
                                {
                                    //category available
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title=$row['title'];
                                        $category_id=$row['id'];

                                        //echo "<option value='$category_id'>$category_title</option>";
                                        ?>
                                        <option <?php if($current_category==$category_id) { echo "selected"; } ?> value='<?php echo $category_id; ?>'><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    //category not available
                                    echo "<option value='0'>Category not available</option>";
                                }
                            
                            ?>

                        </select>

                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=='Yes') {echo 'checked'; };?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=='No') {echo 'checked'; };?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=='Yes') {echo 'checked'; };?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=='No') {echo 'checked'; };?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
    
        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //1. get all the detailes from the form
                $id=$_POST['id'];
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image=$_POST['current_image'];
                $category=$_POST['category'];

                $featuresd=$_POST['featured'];
                $active=$_POST['active'];

                //2. upload the image if selected
                //check whether the upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //upload button clicked
                    //A. uploading new image

                    $image_name=$_FILES['image']['name'];

                    //check whether the file is available or not
                    if($image_name!="")
                    {
                        //image name available
                        //rename the image
                        $result= explode('.',$image_name);
                        $ext= end($result);
                        $image_name="Food-Name-".rand(000,999).'.'.$ext;

                        //get the source and destination path respectively
                        $src_path=$_FILES['image']['tmp_name'];
                        $dest_path="../images/food/".$image_name;

                        $upload= move_uploaded_file($src_path, $dest_path);

                        //check whether the image is uploaded or not
                        if($upload==FALSE)
                        {
                            //failed to upload
                            $_SESSION['upload']="<div class='error'>Faied to upload image.</div>";
                            header("location:".SITEURL."admin/manage-food.php");
                            die();
                        }
                        
                        //3. remove the image if new image is uploaded and current image exists
                        //B. remove current image if available
                        if($current_image!="")
                        {
                            $remove_path="../images/food/".$current_image;
                            $remove=unlink($remove_path);

                            if($remove==FALSE)
                            {
                                $_SESSION['remove-failed']="<div class='error'>Failed to remove Image</div>";
                                header("location:".SITEURL."admin/manage-food");
                                die();
                            }
                        }

                    }
                    else
                    {
                        //image not available
                    }
                }
                else
                {
                    $image_name=$current_image;
                }

                //4. update the food in database
                $sql3="UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

                $res3=mysqli_query($conn, $sql3);

                if($res3==TRUE)
                {
                    $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                    header("location:".SITEURL."admin/manage-food.php");
                }
                else
                {
                    //failed to update food
                    $_SESSION['update']="<div class='error'>Failed to Update Category.</div>";
                    header("location:".SITEURL."admin/manage-food.php");
                }

                //redirect to manage food with session message
            }
        
        ?>

    </div>
</div>

<?php include("partials/footer.php"); ?>