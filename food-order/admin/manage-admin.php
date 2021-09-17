<?php include('partials/menu.php') ?>

        <!--main content section starts here -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>
                <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['user_not_found']))
                {
                    echo $_SESSION['user_not_found'];
                    unset($_SESSION['user_not_found']);
                }  
                
                if(isset($_SESSION['psw_not_match']))
                {
                    echo $_SESSION['psw_not_match'];
                    unset($_SESSION['psw_not_match']);
                } 

                if(isset($_SESSION['change_psw']))
                {
                    echo $_SESSION['change_psw'];
                    unset($_SESSION['change_psw']);
                }
                
                ?>
                
                <br><br><br>
                <!-- button to add admin-->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br><br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        $sql= "SELECT * FROM tbl_admin";
                        $res= mysqli_query($conn, $sql);

                        $sn=1;

                        if($res==TRUE)
                        {
                            $count= mysqli_num_rows($res);

                            if($count>0)
                            {
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    $id= $rows['id'];
                                    $full_name= $rows['full_name'];
                                    $username= $rows['username'];
                                    ?>
                                        <tr>
                                            <td><?php echo $sn++ ?></td>
                                            <td><?php echo $full_name ?></td>
                                            <td><?php echo $username ?></td>
                                            <td>
                                                <a href="<?php echo SITEURL; ?>/admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                                <a href="<?php echo SITEURL; ?>/admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                                <a href="<?php echo SITEURL; ?>/admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                            </td>
                                        </tr>                                        



                                    <?php
                                }
                            }
                            else
                            {

                            }
                        }
                    ?>


                </table>
                
            </div>
            
        </div>
        <!--main content section ends here -->
<?php include('partials/footer.php') ?>
      