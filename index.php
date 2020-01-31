<?php
session_start();

$servername   = "localhost";
$username     = "root";
$password     = null;
$dbName     = "regformcc";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>







<?php

include('db.php');

if (isset($_POST['save_user'])) {
  
  $type           	 = $_POST['type'];
  $username          = $_POST['username'];
  $password          = $_POST['password'];
  $email 			       = $_POST['email']
  $university        = $_POST['university'];
  $department        = $_POST['department'];
  $hscbatch          = $_POST['hscbatch'];
  $has_warning       = 0;

  //Form Validation Starts
    
    if(empty($username)) {

      $usernameErr = "Username is required";
      $has_warning = 1;
      redirect_form($usernameErr, 'warning');

    }else {
      
      $username = form_input($username);

      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
        $usernameErr = "Only letters and white space allowed";
        $has_warning = 1;
        redirect_form($usernameErr, 'warning');
      }
if(empty($password)) {

      $passwordErr = "Password is required";
      $has_warning = 1;
      redirect_form($passwordErr, 'warning');

    }else {
      
      $password = form_input($password);

      // check if name only contains letters and whitespace
      if (!preg_match("#[0-9]+#",$password)) // 
      {
        $passwordErr = "Password is not correct";
        $has_warning = 1;
        redirect_form($passwordErr, 'warning');
      }

    }
    
    if(empty($email)) {

      $emailErr = "Email is required";
      $has_warning = 1;
      redirect_form($emailErr, 'warning');

    } else {

      $email = form_input($email);
      
      // check if e-mail address is well-formed
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
      {
        $emailErr = "Invalid email format";
        $has_warning = 1;
        redirect_form($emailErr, 'warning');
      }

    }

    //if(empty($university)) {

     // $universityErr = "University is required";
     // $has_warning = 1;
     // redirect_form($universityErr, 'warning');

     //}else {
      
     // $university = form_input($university);

      // check if name only contains letters and whitespace
     // if (!preg_match("/^[a-zA-Z ]*$/", $university)) {
     //  $universityErr = "University name unselected";
     //   $has_warning = 1;
     //   redirect_form($universityErr, 'warning');
      }

      //if(empty($department)) {

      //$departmentErr = "Department is required";
     // $has_warning = 1;
     // redirect_form($departmentErr, 'warning');

   // }else {
      
    //  $department = form_input($department);

      // check if name only contains letters and whitespace
     // if (!preg_match("/^[a-zA-Z ]*$/", $department)) {
      // $departmentErr = "Department name unselected";
      //  $has_warning = 1;
      //  redirect_form($departmentErr, 'warning');
      //}

       if(empty($hscbatch)) {

      $hscbatchErr = "Hscbatch is required";
       $has_warning = 1;
      redirect_form($hscbatchErr, 'warning');

     }else {
      
       $hscbatch = form_input($hscbatch);

        check if name only contains letters and whitespace
       if (!preg_match('/^[0-9]*$/', $hscbatch)) {
       $hscbatchErr = "Hscbatch empty";
        $has_warning = 1;
        redirect_form($hscbatchErr, 'warning');
       }

  //Form Validation Ends

  //DB Insert
    /* disable autocommit */
    $conn->autocommit(FALSE);
    
    if($has_warning != 1) {

      $query          = "INSERT INTO `user-info`(name, email, about_user) VALUES ('$name', '$email', '$about')";
      $result         = mysqli_query($conn, $query);
      
      if(!$result) {
        
        /* Rollback */
        $conn->rollback();

        die("User Added Failed. Please Try Again." . $result->error);
      }

    }

    /* commit insert */
    $conn->commit();

    $message = "User Added Successfully.";

    redirect_form($message, 'success');
  //DB Insert Ends

}

//Form Data Sanitize
function form_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function redirect_form($message, $type){

  $_SESSION['message']          = $message;
  $_SESSION['message_type']     = $type;

  header('Location: index.php');

}

?>
