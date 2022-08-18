<?php 
include('config/constants.php');

// check whether list_id is assigned or not 
if (isset($_GET['list_id']))
{
    // delete list from database

    //get the list_id value from URL or get method
    $list_id=$_GET['list_id'];

 //connect the database 
 $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
 
 // select database
 $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());
 
 // write query to delete list from database 
   $sql="DELETE from tbl_lists where list_id= $list_id";

  //execute query 
  $res=mysqli_query($conn,$sql);

  //check if succesfully exec
  if ($res==true) {
      //query executed ==list is deleted
      $_SESSION['delete']="list deleted succesfully";
      //redirect to manage list pages
      header('location:'.SITEURL.'manage-list.php');
  }
  else{
      //failed to delete list 
      $_SESSION['delete_fail']="failed to delete list ";
      header('location:'.SITEURL.'manage-list.php');
  }
}
else{
    //redirect to manage list page 
    header('location:'.SITEURL.'manage-list.php');
}

?>