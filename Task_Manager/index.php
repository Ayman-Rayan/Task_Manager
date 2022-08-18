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
    <title>task manager with php and mysql</title>
</head>
<body>
    <div class="wrapper">
    <h1>Task Manager</h1>

    <!-- Menu -->
    <div class="menu">

    <a href="<?php echo SITEURL; ?>">Home </a>
    <?php
     // displaying lists in menu
     $conn2=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
     $db_select2=mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());
     $sql2="SELECT * from tbl_lists";
     $res2=mysqli_query($conn2,$sql2);

     if ($res2==true) {
         //display 
         while ($row2=mysqli_fetch_assoc($res2)) {
             $list_id=$row2['list_id'];
             $list_name=$row2['list_name'];
?>
<a href="<?php echo SITEURL;?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name ?></a>

<?php
         }
     }

    ?>

   
 <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
    </div>

    <!-- Tasks -->
    <p>
        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
          unset($_SESSION['update']);
        }
        if (isset($_SESSION['delete_fail'])) {
            echo $_SESSION['delete_fail'];
            unset($_SESSION['delete_fail']);
        }
        ?>
    </p>
    
    <div class="all-tasks">

    <a class="btn-primary" href="<?php SITEURL; ?>add-task.php">Add Task</a>
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Task Name</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
            
            <?php
             // connect 
             $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
             //select 
             $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());
            // create query 
            $sql="SELECT * from tbl_tasks";
            //exec query
            $res=mysqli_query($conn,$sql);
           
            //create serial number
            $sn=1;

            // check if the query is executed 
            if ($res==true) {
                //display the task from database
                // count the tasks on database
                $count_rows=mysqli_num_rows($res);

                 // check whether there is a database or not 
                 if ($count_rows>0) {
                     //data in database
                     while ($row=mysqli_fetch_assoc($res)) {
                         $task_id=$row['task_id'];
                         $task_name=$row['task_name'];
                         $priority=$row['priority'];
                         $deadline=$row['deadline'];
                         ?>
                         <tr>
                <td><?php echo $sn++.':'; ?></td>
                <td><?php echo $task_name; ?></td>
                <td><?php echo $priority; ?></td>
                <td><?php echo $deadline; ?></td>
                <td>
                    <a class="btn-update" href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id ; ?>">Update</a>
                    <a class="btn-delete" href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                </td>
            </tr>
                         <?php
                     }

                 } 
                 else
                 {
                     // no data in database
                 ?>
                    <tr>
                        <td colspan="5">No Task added yet.</td>
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