<?php include('partials/menu.php'); ?>

<div class='main-content'>
     <div class='wrapper'>
         <h1>Add Admin</h1>

         <br><br>

         <form action="" method='POST'>

            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

         </form>

     </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
    //Process the value from form and save it in database

    //check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //button clicked
        //echo "Button Clicked";

        //1. get data from form
        $full_name= $_POST['full_name'];
        $username= $_POST['username'];
        $password= md5($_POST['password']); //password encrypted with md5

        //2. SQL querry to save the data in the database
        $sql= "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //executing query and saving data into database
        $res= mysqli_query($conn, $sql) or die(mysqli_error());

        //check whether the data is inserted or not and show appropriate message
        if($res==TRUE)
        {
            //data inserted
            //echo 'data inserted';
            //create a session variable to display message
            $_SESSION['add']= "<div class='success'>Admin Added Successfully</div>";
            //REDIRECT PAGE
            header('location:'.SITEURL."admin/manage-admin.php");
        }
        else
        {
            //data not inserted
            //echo 'data not inserted';
            $_SESSION['add']= "<div class='error'>Failed to Add Admin</div>";
            //REDIRECT PAGE
            header('location:'.SITEURL."admin/add-admin.php");
        }
    }

?>