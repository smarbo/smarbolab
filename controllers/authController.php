<?php

session_start();

require 'config/db.php';

$errors = array();
$username = "";
$email = "";

//if user click sign up
if(isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    // validation
    if(empty($username)) {
        $errors['username'] = "Username required.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Invalid email address.";
    }
    if(empty($email)) {
        $errors['email'] = "Email required.";
    }
    if(empty($password)) {
        $errors['password'] = "Password required.";
    }
    if($password !== $passwordConf) {
        $errors['password'] = "The passwords do not match.";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if($userCount > 0) {
        $errors['email'] = "Email already registered.";
    }

    // signup process
    if(count($errors) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;
        $smarboBitsBalance = 1000;
        $crystalShardsBalance = 100;

        $sql = "INSERT INTO users (username, email, verified, token, password, sb_balance, cs_balance) VALUES (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdssii', $username, $email, $verified, $token, $password, $smarboBitsBalance, $crystalShardsBalance);
        $stmt->execute();

        // login user
        $user_id = $conn->insert_id;
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['verified'] = $verified;
        $_SESSION['sb_bal'] = $smarboBitsBalance;
        $_SESSION['cs_bal'] = $crystalShardsBalance;
        // set flash message
        $_SESSION['message'] = "You are now logged in.";
        $_SESSION['alert-class'] = "alert-success";
        header('location: app.php');
        exit();
    }

}

// if user clicks login button
if(isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validation
    if(empty($username)) {
        $errors['username'] = "Username required.";
    }
    if(empty($password)) {
        $errors['password'] = "Password required.";
    }

    if(count($errors) === 0){
        // search the db for a user with the username or email
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if(password_verify($password, $user['password'])){
            // login success
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = $user['verified'];
            $_SESSION['sb_bal'] = $user['sb_balance'];
            $_SESSION['cs_bal'] = $user['cs_balance'];
            // redirect to app.php
            header('location: app.php');
            exit();

        } else{
            $errors['login_fail'] = "Incorrect details.";
        }
    }

    
}


// logout user
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    unset($_SESSION['sb_bal']);
    unset($_SESSION['cs_bal']);
    header('location: app.php');
    exit();
}