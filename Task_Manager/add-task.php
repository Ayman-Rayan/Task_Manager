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
    <title>Task manager with php and sql </title>
</head>
<body>
<div class="wrapper">
<h1>Task manager</h1>
<a class="btn-secondary" href="<?php echo SITEURL ;?>">Home</a>   
<h3>Add TAsk Page </h3>
<p>
<?php
if(isset($_SESSION['add_fail']))
{
    echo $_SESSION['add_fail'];
    unset($_SESSION['add_fail']);
}


?>
</p>
<form action="" method="POST">
    <table class="tbl-half">
        <tr>
            <td>Task Name:</td>
            <td><input type="text" name="task_name" placeholder="Type your task name" required="required"/></td>
        </tr>

        <tr>
            <td>Task Description:</td>
            <td><textarea name="task_description" placeholder="Type your task description"></textarea></td>
        </tr>

        <tr>
            <td>Select List:</td>
            <td>
                <select name="list_id">

                <?php
                $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
                $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());
                $sql="SELECT * from tbl_lists";
                $res=mysqli_query($conn,$sql);

                if ($res==true) {
                    $count_rows=mysqli_num_rows($res);
                    if ($count_rows>0) {
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $list_id =$row['list_id'];
                            $list_name=$row['list_name'];
                            ?>
                    <option value="<?php echo $list_id; ?>"><?php echo $list_name ; ?></option>
                    
                            <?php
   }
                    }else
                    {
                        // display none as option
                          ?>
                          <option value="0">None</option>
                          <?php
                    }
                }
              ?> 
                   
                </select>
            </td>
        </tr>

        <tr>
            <td>priority:</td>
            <td>
                <select name="priority">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>Deadline:</td>
            <td><input type="date" name="deadline"></td>
        </tr>

        <tr>
            <td><input class="btn-primary btn-lg" type="submit" name="submit" value="SAVE"></td>
        </tr>
    </table>
</form>



</div>
</body>
</html>



<?php
// check wether the sav button is clicked or not 
if (isset($_POST['submit'])) 
{
    //echo "button clicked";
    // get the values from form 
    $task_name =$_POST['task_name'];
    $task_description=$_POST['task_description'];
    $list_id=$_POST['list_id'];
    $deadline=$_POST['deadline'];
    $priority=$_POST['priority'];

    // connect database
    $conn2=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

    //select database
    $db_select2=mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());

    //create sql query 
    $sql2="INSERT Into tbl_tasks SET
    task_name='$task_name',
    task_description='$task_description',
    list_id=$list_id,
    priority='$priority',
    deadline='$deadline'
    ";

   $res2=mysqli_query($conn2,$sql2);

   //check if its executed 
   if($res2==true){
       // query executed and task inserted succesfully 
       $_SESSION['add']="task addes sucessfully";
       header('location:'.SITEURL);
   }else{
       // failed to add task
       $_SESSION['add_fail']="failed to add task";
       header('location:'.SITEURL.'add-task.php');
   }
}



?>