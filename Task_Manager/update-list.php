<?php
include('config/constants.php');
//Get the current values of selected list
if (isset($_GET['list_id'])) {
    //get the list id value 
    $list_id=$_GET['list_id'];
    //connect database
    $conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());
    //select database
    $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

    //query to get values from database
    $sql="SELECT * from tbl_lists where list_id=$list_id";

    //execute query
    $res= mysqli_query($conn,$sql);

    //check wether the query executed succesfully or not 
    if ($res==true) {
        // get the values from database
        $row=mysqli_fetch_assoc($res); // value is in array
       //printing $row array
        // print_r($row);

        //create individual variable to save the data
        $list_name=$row['list_name'];
        $list_description=$row['list_description'];
    }
    else{
        //go back to manage lists page 
        header('location:'.SITEURL.'manage-list.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SITEURL; ?>style/style.css"/>
    <title>Tsk manager with php and mysql</title>
</head>
<body>
<div class="wrapper">
    <h1>TASK MANAGER</h1>
   
        <a class="btn-secondary" href="<?php echo SITEURL;?>">Home</a>
        <a class="btn-secondary" href="<?php echo SITEURL;?>manage-list.php">Manage Lists</a>
    
    

    <h3>Update List Page</h3>
    <p>
        <?php
        //check wether the session is det or not 
        if(isset($_SESSION['update_fail'])){
            echo $_SESSION['update_fail'];
            unset($_SESSION['update_fail']);
        }
        ?>
    </p>
    <form action="" method="POST">
        <table class="tbl-half">
            <tr>
                <td>List Name:</td>
                <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required="required"/></td>
            </tr>

            <tr>
                <td>List Description:</td>
                <td><textarea name="list_description" >
                    <?php echo $list_description; ?>
                </textarea></td>
            </tr>

            <tr>
                <td><input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE"></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>

<?php

//check wether the update button is clicked or not 
if(isset($_POST['submit'])){
    //echo "button clicked";

    //get updated values from our form

    $list_name=$_POST['list_name'];
    $list_description=$_POST['list_description'];

    //connect the database 
    $conn2=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

    //select the database
    $db_select2=mysqli_select_db($conn2,DB_NAME);

    //query to update list
     $sql2="UPDATE tbl_lists SET 
    list_name='$list_name',
    list_description='$list_description'
    WHERE list_id=$list_id";

//execute the query
$res2=mysqli_query($conn2,$sql2);

//check wether query is executed 
if($res2==true){
    // Update succesfull
    $_SESSION['update']="list updated successfully ";
    
    //redirect to maange list page 
    header('location:'.SITEURL.'manage-list.php');
}
else{
    //failes to update 
    //set session message
    $_SESSION['update_fail']="something went wrong";

    //redirect 
    header('location:'.SITEURL.'update-list.php?list_id=$list_id'.$list_id);
}

}
?>