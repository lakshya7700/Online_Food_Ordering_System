<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        
        ?>
        <br><br>

        <!--add category form starts here-->

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td><input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td><input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Add Category" class="btn-secondary"></td>
                </tr>

            </table>
        </form>

        <!--add category form ends here-->

        <?php
        
        //check whether the submit button is clicked or not

        if(isset($_POST['submit']))
        {
            //echo "clicked";

            //get the value from the form
            $title = $_POST['title'];
            

            //for radio input we need to check whether the button is selected or not

            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
                
            }
            else
            {
                //setting default value
                $featured="No";
               
            }
            //similarly for active radio button
            if(isset($_POST['active']))
            {
                $active=$_POST['active'];
                
            }
            else
            {
                $active="No";
                
            }

            if(isset($_FILES['image']['name']))
            {
                //upload the image
                //to upload the image we need image name, source path and destination
                $image_name=$_FILES['image']['name'];

                //upload the image if only the image is selected or not
                if($image_name !="")
                {

                    //auto rename our image
                    //get the extension of the image like (jpg, ing, gif, etc)
                    $ext= end(explode('.',$image_name));

                    //rename the image
                    $image_name="Food_Category_".rand(000,999).'.'.$ext;

                    $source_path=$_FILES['image']['tmp_name'];

                    $destination_path="../images/category/".$image_name;

                    //uploading the image
                    $upload= move_uploaded_file($source_path, $destination_path);

                    //check whether the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message 
                    if($upload==FALSE)
                    {
                        $_SESSION['upload']="<div class='error'>Failed to Upload Image<div/>";
                        //redirect to add category
                        header("location:".SITEURL."admin/add-category.php");
                        //stop the process
                        die();
                    }
                }    
            }
            else
            {
                $image_name="";    
            }


            //create SQL query to insert category into database
            $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";
            
            //3. execute the query and save in database
            $res = mysqli_query($conn, $sql);

            //4. check whether the query is executed or not and the data is stored or not
            if($res==TRUE)
            {
                //query executed and category added
                
                $_SESSION['add']="<div class='success'>Category Added Successfully<div/>";
                //redirect to manage category
                header("location:".SITEURL."admin/manage-category.php");
            
            }
            else
            {
              
                //failed to add category
                $_SESSION['add']="<div class='error'>Failed to Add Category<div/>";
                //redirect to add category
                header("location:".SITEURL."admin/add-category.php");
            }
            
        }
        
        ?>

    </div>
</div>



<?php include("partials/footer.php"); ?>