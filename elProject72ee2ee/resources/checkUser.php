<?php

try{
  $dbConnection = new mysqli('localhost','root','','Users');

  if(isset($_POST['user']) && isset($_POST['pass'])){
    $user = $_POST['user'];
    $password = $_POST["pass"];
    $q_user = "SELECT pass FROM items where username ='$user' ";
    $select_result=$dbConnection->query($q_user);
    if($select_result->num_rows != 0){
      while($row = $select_result->fetch_assoc()){
        if($row["pass"]==$password) echo "login success";
        else echo "incorrect password";
      }
  }else echo"No such user.";
  }

else if( isset($_POST['user_in_reg']) && isset($_POST['pass_in_reg']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])){
  $user_in_reg=$_POST["user_in_reg"];
  $pass_in_reg=$_POST["pass_in_reg"];
  $first_name=$_POST["first_name"];
  $last_name=$_POST["last_name"];
  $email=$_POST["email"];
  $query ="SELECT username FROM items where  username='$user_in_reg'";
  $q_email="SELECT email FROM items where  email='$email'";
  $q_firstname="SELECT firstname FROM items where  firstname='$first_name'";
  $q_lastname="SELECT lastname FROM items where  lastname='$last_name'";
  $q_pass="SELECT pass FROM items where  pass='$pass_in_reg'";
  //echo "SELECT username FROM items where  username='$user_in_reg'";
  $select_result =$dbConnection->query($query);
  $select_email=$dbConnection->query($q_email);
  if($select_result->num_rows != 0)
  echo "this user_name is already existed";
   else if($select_email->num_rows != 0)
  echo "this email is already existed";
  else {
    $q1=  "INSERT INTO items(`firstname`,`lastname`,`pass`,`username`,`email`) VALUES('$first_name','  $last_name','$pass_in_reg','$user_in_reg',' $email')";
    if($dbConnection->query($q1) ===true)
    echo "New account is created successfully";
    else
      echo "Error:" ;
       }
}
}
catch(PDOException $e)
{
  echo 'failed'.$e.getMessage($e);

}



//registration screen.html (dB,validation)
//md5
//registerdB.php
//-----------------------

//Tool.html (generate html page,read roads page)
//show map.html (dB, include roads page)



?>
