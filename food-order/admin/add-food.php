<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
    
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Title of the Food"></td>
                </tr>

                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php 
                            
                                //create php code to display categories from database
                                //1. create sql to get all active categories from database
                                $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                                $res=mysqli_query($conn, $sql);

                                //count the rows to check whether we have categories or not
                                $count=mysqli_num_rows($res);

                                //if count is greater than zero, we have categories else we dont have any categories
                                if($count>0)
                                {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the detailes of the categories
                                        $id=$row['id'];
                                        $title=$row['title'];
                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //we dont have categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan='2'><input type="submit" name="submit" value="Add Food" class="btn-secondary"></td>
                </tr>

            </table>
        
        </form>

        <?php
        
        //check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //add the food in the database
            
            //1. get the data from form
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $category=$_POST['category'];

            //chech whether the featured and active button is checked or not

            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
            }
            else
            {
                $featured="No";//setting default value
            }
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
            }
            else
            {
                $active="No";//setting defaut value
            }

            //2. upload the image if selected
            //check whether the selected image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                //get the detais of the selected image
                $image_name=$_FILES['image']['name'];

                //check whether the image is selected or not and upload image only if selected
                if($image_name!="")
                {
                    //image is selected
                    //A. rename the image
                    $result=explode('.',$image_name);
                    $ext= end($result);

                    //create new name for the image
                    $image_name="Food-name-".rand(000,999).'.'.$ext;

                    //B. upload the image
                    //get the source path and the destination path 
                    //source path is the current location of the image
                    $src= $_FILES['image']['tmp_name'];

                    //destination path for the image to be uploaded
                    $dst="../images/food/".$image_name;

                    //finally upload the food image
                    $upload=move_uploaded_file($src, $dst);

                    //check whether image uploaded or not
                    if($upload==FALSE)
                    {
                        //Failed to upload image
                        //redirect to add food page with error message\
                        $_SESSION['upload']="<div class='error'>Failed to upload image</div>";
                        header("location:".SITEURL."admin/add-food.php");
                        //stop the process
                        die();
                    }
                }
            }
            else
            {
                //setting default value as blank
                $image_name="";
            }

            //3. insert into database
            //create sql query to save or add food
            $sql2="INSERT INTO tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'";

            //execute the query
            $res2=mysqli_query($conn, $sql2);


            //check whether data is inserted or not
            //4. redirect with message to manage food page
            if($res2==TRUE)
            {
                //data inserted
                $_SESSION['add']="<div class='success'>Food Added Successfully</div>";
                header("location:".SITEURL."admin/manage-food.php");
            }
            else
            {
                //data not inserted
                $_SESSION['add']="<div class'error'>Failed to add Food</div>";
                header("location:".SITEURL."admin/manage-food.php");
            }

            
        }
        
        ?>

    </div>
</div>

<?php include("partials/footer.php"); ?>