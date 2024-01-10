<?php

require '../database/connection.php';

ob_start();
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);

  if(isset($username)&&isset($password)){
    if(!empty($username)&&!empty($password)){

        if($username == "admin" && $password == md5("admin123")){
            $_SESSION['username'] = "admin";
            $_SESSION['status'] = "admin";
            echo 'ok';
        } else {
            $q = "SELECT * FROM customers WHERE username='$username' AND password='$password'";
            $resultCustomers = $conn->query($q);

            $q = "SELECT * FROM sellers WHERE username='$username' AND password='$password'";
            $resultSellers = $conn->query($q);

            $q = "SELECT * FROM menagers WHERE username='$username' AND password='$password'";
            $resultMenagers = $conn->query($q);
            
            if($resultCustomers->num_rows == 1){
                $_SESSION['username'] = $username;
                $_SESSION['status'] = "customer";
                echo 'ok';
            } else if($resultSellers->num_rows == 1){
                $_SESSION['username'] = $username;
                $_SESSION['status'] = "seller";
                echo 'ok';
            } else if($resultMenagers->num_rows == 1){
                $_SESSION['username'] = $username;
                $_SESSION['status'] = "menager";
                echo 'ok';
            } else {
                echo 'Incorrect username or password!';
            }
        }
    } else {
      echo "All fields must be filled in!";
    }
  } else {
    echo "All fields must be filled in!";
  }

 ?>
