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

        if($stmt->execute()){
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
        } else{
            $errors['db_error'] = "Database error: Failed to register account.";
        }
    }

}