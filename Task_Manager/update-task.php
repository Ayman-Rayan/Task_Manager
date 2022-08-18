<?php
 include('config/constants.php');

 //check the task id in url

 if (isset($_GET['task_id'])) {
     // get the values from database 
     $task_id=$_GET['task_id'];

     // connect database
     $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

     //select
     $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

     // create sql query
     $sql="SELECT * from tbl_tasks where task_id=$task_id";

     // exec  query 
     $res=mysqli_query($conn,$sql);

     // check if query is executed successfully
     if ($res==true) {
         $row=mysqli_fetch_assoc($res);

         // get individual value
         $task_name=$row['task_name'];
         $task_description=$row['task_description'];
         $list_id=$row['list_id'];
         $priority=$row['priority'];
         $deadline=$row['deadline'];

     }
 }
 else{
     //redirect 
     header('location:'.SITEURL);
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>style/style.css"/>
    <title>Task Manager with php and my sql</title>
</head>
<body>
<div class="wrapper">
<h1>Task Manager</h1>

<p>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
</p>

<h3>Update Task Page </h3>
<p>
    <?php
    if (isset($_SESSION['update_fail'])) {
        echo $_SESSION['update_fail'];
        unset($_SESSION['update_fail']);
    }
?>
    
</p>
<form action="" method="POST">
    <table class="tbl-half">
        <tr>
            <td>Task Name:</td>
            <td><input type="text" name="task_name" value="<?php echo $task_name ;?>" required="required"></td>
        </tr>

        <tr>
            <td>task description:</td>
            <td>
                <textarea 
                 name="task_description">
                <?php echo $task_description ; ?>
                </textarea>
                
            </td>
        </tr>

        <tr>
            <td>Select List :</td>
            <td>
                <select name="list_id" >
                    <?php
                    //connect 
                   $conn2=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                   //select
                   $db_select2=mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());

                   //create query
                   $sql2="SELECT * from tbl_lists";

                   // exec

                   $res2 = mysqli_query($conn2,$sql2);

                   //check if its executed successfully
                   if ($res2==true) {
                       $count_rows2=mysqli_num_rows($res2);
                       
                 if ($count_rows2>0) {
                     // lists are added 
                     while ($row2=mysqli_fetch_assoc($res2)) {
                         // get individual value 
                         $list_id_db=$row2['list_id'];
                         $list_name=$row2['list_name'];
                         ?>
                         <option <?php if($list_id_db==$list_id)
                         {echo "selected='selected'";
                         } ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>
                     <?php
                     }
                 }
                 else
                 {
                     // no lists added
                     // display none as option
                     ?>
                     <option  <?php if($list_id=0){
                         echo "selected='selected'";
                         } ?> value="0">None</option>
                     <?php
                 }

          }
                    ?>
                    
                </select>
            </td>
        </tr>

        <tr>
            <td>Priority</td>
            <td>
                <select name="priority">
                    <option <?php if ($priority=="High") {
                        echo "selected='selected'";
                    } ?> value="High">High</option>
                    <option <?php if ($priority=="Medium") {
                        echo "selected='selected'";
                    } ?> value="Medium">Medium</option>
                    <option <?php if ($priority=="Low") {
                        echo "selected='selected'";
                    } ?> value="Low">Low</option>
                </select>
            </td>
        </tr>
          
        <tr>
            <td>Deadline:</td>
            <td><input type="date" name="deadline" value="<?php echo $deadline ; ?>"></td>
        </tr>

        <tr>
            <td><input class="btn-primary btn-lg" type="submit" value="update" name="submit" ></td>
        </tr>
    </table>
</form>    


</div>
</body>
</html>

<?php
   
   //check if the buuton is clicked

   if (isset($_POST['submit'])) {
      // get the values from form

      $task_name=$_POST['task_name'];
      $task_description=$_POST['task_description'];
      $list_id=$_POST['list_id'];
      $priority=$_POST['priority'];
      $deadline=$_POST['deadline'];


       // coonect 

       $conn3=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
       //select 
       $db_select3=mysqli_select_db($conn3,DB_NAME) or die(mysqli_error());

       //create query

       $sql3= "UPDATE tbl_tasks SET 
       task_name='$task_name',
       task_description='$task_description',
       list_id='$list_id',
       priority='$priority',
       deadline='$deadline'
       where task_id=$task_id";

       //exec
$res3=mysqli_query($conn3,$sql3);

//check wether the query is executed 
if($res3==true){
    //query up task up 
    $_SESSION['update']="task updated successfully";
    header('location:'.SITEURL);

}
else{
    //fail down
    $_SESSION['update_fail']="failed to update task";
    header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
}
 
}


?>
