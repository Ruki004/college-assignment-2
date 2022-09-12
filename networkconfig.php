<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "login_db";

$con=mysqli_connect("localhost","root","1234","login_db");

if(mysqli_connect_errno()){
    echo"failed to connect to mysql: ".mysqli_connect_error();//if no error 
    
}

?>
