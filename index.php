<?php
$localhost = 'localhost';
$root = 'root';
$password = '';           
$db = 'voltvoyagelogin';                         
$con = mysqli_connect($localhost, $root, $password, $db); 
/*/mysqli_connect('localhost', 'my_username', 'my_password', 'my_db');/ */

if ($con)
{
   // echo "ok";       
    }
if(isset($_POST['submit']))     
{    
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    
    
    $loginsert = mysqli_query($con, "INSERT INTO  voyagelogin(username,password)  VALUES ('$username','$password')");
      if($loginsert)
      {
          echo "<b> form submitted!! </b>";           
          //header("location:index.php");
      }
      else
      { 
         echo "form not submitted" /*. mysqli_error($con)*/;  
          }    
} 
?> 