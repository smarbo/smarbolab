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

        $sql = "INSERT INTO users (username, email, verified, token, password) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdss', $username, $email, $verified, $token, $password);
        $stmt->execute();

        // login user
        $user_id = $conn->insert_id;
        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['verified'] = $verified;
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
            // redirect to app.php
            header('location: app.php');
            exit();

        } else{
            $errors['login_fail'] = "Incorrect details.";
        }
    }

    
}