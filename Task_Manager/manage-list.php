<?php
include('config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>style/style.css"/>
    <title>Task manager with php sql</title>
</head>
<body>
<div class="wrapper">
    <h1>TASK MANAGER</h1>
    <a  class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
    <h3> Manage List Page </h3>

    <?php
    // check if session is set 
    if(isset($_SESSION['add'])){
        //display message
        echo $_SESSION['add'];
        //remove message after display one time 
        unset($_SESSION['add']);
    }

    //check the session for delete 
    if (isset($_SESSION['delete'])) {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    //check session message for update 
    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    //check for delete fail 
    if (isset($_SESSION['delete_fail'])) {
        echo $_SESSION['delete_fail'];
        unset($_SESSION['delete_fail']);
    }

    ?>
    <!-- TAble to display  -->
    <div class="all-lists">
        <a  class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Add List</a>
        <table class="tbl-half">
            <tr>
                <th>S.N</th>
                <th>List Name</th>
                <th>Actions</th>
            </tr>
            <?php
            //connect the database
            $conn= mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
            //select database
            $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());
            //SQL query to display all data from database
            $sql="SELECT * from tbl_lists ";
            // execute the query 
            $res=mysqli_query($conn,$sql);
            //check if the query is executed or not 
            if($res==true){
                // work on display data 
                //echo "executed";

                //count the rows of data in database
                $count_rows = mysqli_num_rows($res);
                //create serial number variable
                $sn=1;

                 // check wether there is data in database or not
                 if ($count_rows>0) {
                     //there is data in database
                     while($row=mysqli_fetch_assoc($res)){
                         //getting the data from database
                         $list_id=$row['list_id'];
                         $list_name=$row['list_name'];
                         ?>
                         

                          <tr>
                           <td><?php echo $sn++; ?></td>
                            <td><?php echo $list_name; ?></td>
                          <td>
                           <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
                            <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                             </td>
                         </tr>


                         <?php
                     }
                 }
                 else{
                     //no data in database

                     ?>
                     <tr>
                        <td colspan="3">No List added yet</td>
                     </tr>

                     <?php
                 }
            }
            ?>
            
        </table>
    </div>
    </div>
</body>
</html>