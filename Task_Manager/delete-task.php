<?php 
 include('config/constants.php');

 //check task id 
 if (isset($_GET['task_id'])) {
     //delete the task from database
     // get the task id 
     $task_id=$_GET['task_id'];

     // connect database
     $conn =mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

     // select
     $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

     // sql query
     $sql="DELETE from tbl_tasks where task_id=$task_id";

     // exec
     $res=mysqli_query($conn,$sql);

     //check if the query 
     if ($res==true) {
         // query executed sucessfully task deleted
         $_SESSION['delete']="task deleted sucessfully";
         header('location:'.SITEURL);
     }
     else{
         //failed

         $_SESSION['delete_fail']="fail to delete task";

         //redirect
         header('location:'.SITEURL);

     }
 }
 else{
     //redirect 
     header('location:'.SITEURL);
 }

?>