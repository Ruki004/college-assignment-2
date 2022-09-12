<?php
include 'networkconfig.php';
session_start();
if(isset($_POST['submit'])){

   $email=mysqli_escape_string($con,$_POST['email']);
   $password=mysqli_escape_string($con,$_POST['password']); //input username
  
    
   $select = mysqli_query($con,"SELECT * FROM loginactivity WHERE EmailAddress='$email' and
   UserPassword='$password'")or die('query failed');

   if(mysqli_num_rows($select)>0){
    $row=mysqli_fetch_assoc($select);//fetch the data from database
    $_SESSION['user_id']=$row['Id'];//the id from dat base which primary keyed.|| wrong uppercase latter of Id.
    header('location:home.php');
}else{
    $message[]='Incorrect email or password';
}
}

?> 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<style>
</style>

<body>
   
<div class=form-container>

   <form action="" method="post" enctype="multipart/form-data">
      <h3 style="font-size: 50px;">Login</h3><!-- change here -->
      <div class=logo></div>
      <?php
      if(isset($message)){ //use this form field where user enter their profile and $message will display if user existed.
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <div class=form-size></div>
      <input type="email" name="email" placeholder="Enter email" class="box" style="color: azure;"  required>
      <input type="password" name="password" placeholder="Enter password" style="color: azure;" class="box" required>
      <input style="margin-left:10px;"type="submit" name="submit" value="Log In!" class="btn">
      <p style="color: azure;">Don't have a account? <a style="color: #FFFACD;" href="Register.php">Register Now!</a></p>
      </form></div>

</div>

</body>
</html>