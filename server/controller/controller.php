<?php

session_start();
include "../connection/Config.php";

// Register

if (isset($_POST['signUp'])) {
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword =$_POST['cpassword'];

    if (strlen($password) < 5 || strlen($password) > 15) {
        $_SESSION['msg'] = "<strong>Password</strong> at least 6 characters long";
        header("location:../../inc/SignUp.Php");
    }elseif (!preg_match("/\d/",$password)) {
        $_SESSION['msg'] = "<strong>Password</strong> at least 1 numeric character";
        header("location:../../inc/SignUp.Php");
    }elseif (!preg_match("/\W/", $password)) {
        $_SESSION['msg'] = "<strong>Password</strong> at least 1 special character";
        header("location:../../inc/SignUp.Php");
    }elseif ($password != $cpassword) {
        $_SESSION['msg'] = "<strong>Password</strong> doesn't match";
        header("location:../../inc/SignUp.Php");
    }else {
        $sql = "INSERT INTO info (Name, Email, Password) VALUES ('$name','$email','$password')";

        $query = mysqli_query($con, $sql);
        $_SESSION['successMsg'] = "Registration Successfully! Login Here";
        header("location:../../index.php");

    }

}


// Login 

if (isset($_POST['signIn'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM info WHERE Email='$email' AND Password='$password'";
    $query = mysqli_query($con,$sql);
    $count = mysqli_num_rows($query);

    if ($count > 0) {
        $_SESSION['name'] = $email;
        header("location:../../inc/Home.php");
    }else {
        $_SESSION['msg'] = "Invalid Email or Password";
        header("location:../../index.php");
    }

}

?>