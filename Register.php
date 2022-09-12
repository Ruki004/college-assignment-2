<?php
include 'networkconfig.php';
if(isset($_POST['SignMe'])){


   $name=mysqli_escape_string($con,$_POST['name']);
   $email=mysqli_escape_string($con,$_POST['email']);
   $password=mysqli_escape_string($con,$_POST['password']);
   $cpass=mysqli_escape_string($con,$_POST['cpassword']);
   $image=$_FILES['image']['name'];
   $image_size=$_FILES['image']['size'];
   $image_tmp_name=$_FILES['image']['tmp_name'];
   $image_folder='upload_img/'.$image;//folder to save image
    
   $select = mysqli_query($con,"SELECT * FROM loginactivity WHERE EmailAddress='$email' and
   UserPassword='$password'")or die('query failed');

   if(mysqli_num_rows($select)>0){
      $message[] ='user already exist';

   }while(mysqli_num_rows($select)<=0){
      if($password!=$cpass){
         $message[]='Confirm password does not matched!';
      }elseif($image_size>2000000){
         $message[]='Image size is too large';
      }else{
         $insert=mysqli_query($con,"INSERT INTO loginactivity (Username,UserPassword,EmailAddress,Img)VALUES('$name','$password','$email','$image')")or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name,$image_folder);
            header('location:home.php');//go to login page. 
            $message[]='registered successsfully';
         
         }else{
            $message[]='registration failed';

         }
      }
      break;
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
      <h3 style="font-size: 50px;">Sign Up Now !</h3>
      <?php
      if(isset($message)){ //use this form field where user enter their profile and $message will display if user existed.
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="Enter username" class="box" style="color: azure;" required>
      <input type="email" name="email" placeholder="Enter email" class="box" style="color: azure;" required>
      <input type="password" name="password" placeholder="Enter password" class="box"style="color: azure;" required>
      <input type="password" name="cpassword" placeholder="Confirm password" class="box" style="color: azure;" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" style="color: azure;"  >
      <input type="submit" name="SignMe" value="Sign Me In!" class="btn">
      <p style="color: azure;">Already have an account? <a style="color: #FFFACD;" href="login.php">Login now</a></p>
      </form>

</div>

</body>
</html>