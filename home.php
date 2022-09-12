<?php
include 'networkconfig.php';
session_start();
$user_id =$_SESSION['user_id'];//if the user from login page id are equal.
if(!isset($user_id)){
    header('location:login.php');
};
if(isset($_GET['logout'])){//cannot use"()" ($_GET as we want to get the logout btn.)
    unset($user_id);//reset/destroy variable (user_id)
    session_destroy();//after each termination must inc a header file e.g login.php
    header('location:login.php');

}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="style.css">


</head>
<body>
<div class ="container">

<div class="profile">
<?php
if(isset($message)){ //use this form field where user enter their profile and $message will display if user existed.
    foreach($message as $message){
       echo '<div class="message">'.$message.'</div>';
    }
 }
$select=mysqli_query($con,"SELECT * FROM loginactivity WHERE Id = '$user_id'") or die('query failed');
 if(mysqli_num_rows($select)>0){
    $fetch=mysqli_fetch_assoc($select);
    $message[]='User Already Exist';
    
    
    
}
if($fetch['Img']==''){

    echo '<img src="default-avatar.png">'; 
}else{
    echo '<img src="upload_img/'.$fetch['Img'].'">';
}

?>

<h3><?php echo $fetch['Username']; ?></h3>
<div style="margin-top:15px;"></div>
<div class="update-btn">
<a href="Profile.php" style="color: azure;">Update Profile</a></div>
<a style="margin-top: 10px;"href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn" style="background-color:#dd5e89;">Logout</a>
<p style="margin-top: 8px;">Switch Account <a href="login.php"><a1>Login</a1></a> or <a href="Register.php"><a1>Register</a1></a></p>


</div>






</div>





</body>
</html>