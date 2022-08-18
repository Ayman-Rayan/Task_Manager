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
    <title>Task manager with php mysql</title>
</head>
<body>
<div class="wrapper">
    <h1>Task Manager</h1>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
    <a  class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage lists</a>

    <h3>Add list page</h3>
    <p><?php 
    //check if the session is created or not 
     if (isset($_SESSION['add_fail'])) {
         //display session message  
         echo $_SESSION['add_fail'];
         //remove the message after displaying once 
         unset($_SESSION['add_fail']);
     }
    ?>
    </p>
    <!-- Form to add list -->
    <form  method="post" action="">
        <table class="tbl-half">
          <tr>
              <td>List Name:</td>
              <td><input required="required" placeholder="type list name here" type="text" name="list-name"/></td>
          </tr>
           <tr>
               <td>List description :</td>
               <td><textarea name="list-description"  placeholder="type list description here"></textarea></td>
           </tr>
           <tr>
               <td><input class="btn-primary btn-lg" type="Submit" value="Save" name="Submit"></td>
           </tr>
        </table>
    </form>
    </div>
</body>
</html>


<?php
//check whether the font is  submitted or not 
if(isset($_POST['Submit']))
{
  //  echo "form submitted";
  //get values from and save in variable
  $list_name=$_POST['list-name'];
  $list_description=$_POST['list-description'];
  //connect database
$conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

//check if its connected
 /*
 if ($conn==true) {
    echo 'database connected';
}
*/
$db_select=mysqli_select_db($conn,DB_NAME);
//check database is connected or not 
/*
if($db_select==true){
    echo 'database selected';
}
*/
//sql query to insert to database
 $sql="INSERT into tbl_lists SET 
list_name = '$list_name' ,
list_description='$list_description' ";
//execute query 

$res=mysqli_query($conn,$sql);
 if($res==true){
     //data inserted succesfully
     echo "Data Inserted";
     //redirect to manage list page 
     header('location:'.SITEURL.'manage-list.php');
     //create session to display message 
     $_SESSION['add']= "List added succesfully";
 }
 else{
     $_SESSION['add_fail']="Failed to add list";
     //echo "failed";
     // redirect to same page 
     header('location:'.SITEURL.'add-list.php');
 }
}







?>