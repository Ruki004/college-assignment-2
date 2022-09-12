<?php
include 'networkconfig.php';
session_start();
$user_id =$_SESSION['user_id'];
if(!isset($user_id)){//if no id is set go back to login 
    header('location:login.php');
};
if(isset($_POST['delete_profile'])){//cannot use"()" ($_GET as we want to get the logout btn.)
    $delete=mysqli_query($con,"DELETE FROM loginactivity WHERE Id='$user_id' ")or die('query failed');
        unset($_SESSION);
        unset($user_id);//reset/destroy variable (user_id)
        session_destroy();//after each termination must inc a header file e.g login.php
        header('location:login.php');
    
};
if(isset($_POST['update_profile'])){
    //to update profile. 
    $old_email=$_POST['old_email'];
    $old_name=$_POST['old_name'];
    $update_name=mysqli_escape_string($con,$_POST['update_name']);
    $update_email=mysqli_escape_string($con,$_POST['update_email']);
    mysqli_query($con,"UPDATE loginactivity SET Username='$update_name',EmailAddress='$update_email' WHERE Id='$user_id' ")or die('query failed');
    if($update_name!=$old_name){
        $message[]='Name Change Successfully';


    }else{
        //blank
    }
    if($update_email!=$old_email){//change email notification!!!
        $message[]='you changed your email';
    }else{
           //blank
    }
     
  
    $old_pass=$_POST['old_pass'];//here also need md5   //md5 Message Digest Algorithm family which was created
    // to verify the integrity of any message or file that is hashed
    $update_pass=mysqli_escape_string($con,$_POST['update_pass']);
    $new_pass=mysqli_escape_string($con,$_POST['new_pass']);
    $confirm_pass=mysqli_escape_string($con,$_POST['confirm_pass']);
    if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
    if(($update_pass!=$old_pass)){
        $message[]='old password not match';
    }elseif($new_pass !=$confirm_pass){
        $message[]='confrim password not match';

    }else{
        mysqli_query($con,"UPDATE loginactivity SET UserPassword='$confirm_pass' WHERE Id='$user_id' ")
    or die('query failed');
    $message[]='password changed succesfully';


    }


    //md5 Message Digest Algorithm family which was created to verify the integrity of any message or file that is hashed
}
$update_image = $_FILES['update_image']['name'];
$update_image_size = $_FILES['update_image']['size'];
$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
$update_image_folder = 'upload_img/'.$update_image;

if(!empty($update_image)){
   if($update_image_size > 2000000){
      $message[] = 'image is too large';
   }else{
      $image_update_query = mysqli_query($con, "UPDATE loginactivity SET Img = '$update_image' WHERE Id = '$user_id'") or die('query failed');
      if($image_update_query){
         move_uploaded_file($update_image_tmp_name, $update_image_folder);
      }
      $message[] = 'image updated succssfully!';
   }
}

//to delete profile 
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <link rel="stylesheet" href="style.css">

</head>
 
<body>
<div class=update-pro>
<?php
$select=mysqli_query($con,"SELECT * FROM loginactivity WHERE Id = '$user_id'") or die('query failed');
 if(mysqli_num_rows($select)>0){
    $fetch=mysqli_fetch_assoc($select);//to find user. 
    
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <?php
    if($fetch['Img']==''){

        echo '<img src="default-avatar.png">'; 
    }
    else{
        echo '<img src="upload_img/'.$fetch['Img'].'">';
    }
    if(isset($message)){ //use this form field where user enter their profile and $message will display if user existed.
        foreach($message as $message){
           echo '<div class="message">'.$message.'</div>';
        }
        }

    ?>
  <div class=flex>
   <div class=inputBox>
            <span> Username :</span>
            <input type="hidden" name="old_email" value="<?php echo $fetch['EmailAddress']; ?>">
            <input type="hidden" name="old_name" value="<?php echo $fetch['Username']; ?>">
            <input type="text" name="update_name" value="<?php echo $fetch['Username']?>" class=box>
            <span > Email :</span>
            <input type="text" name="update_email" value="<?php echo $fetch['EmailAddress']?>" class=box>
            <span> Update Your Profile Picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class=box>
        </div>
        <div class=inputBox>
            <input type="hidden" name="old_pass" value="<?php echo $fetch['UserPassword']; ?>" re>
            <span>Old Password : </span>
            <input type="password" name="update_pass" placeholder="Enter previous password" class="box">
            <span>New Password : </span>
            <input type="password" name="new_pass" placeholder="Enter new password" class="box" >
            <span>Confirm Password : </span>
            <input type="password" name="confirm_pass" placeholder="Confirm password" class="box">

        </div>
    </div>
    <input type="submit" onclick="return confirm('Update Profile?')" value="Update profile" name="update_profile" style="margin-top: auto;" class=update-btn>
    <div style="margin-top: 15px;"></div>
    <a href="home.php" class="delete-btn">Back</a>
    <input type="submit" onclick="return confirm('Are you sure you want to delete your account?')" value="Delete profile" name="delete_profile" class=delete-btn2>
   

 
    </form>
</div>
</body>
</html>

