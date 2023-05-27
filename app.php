<?php require_once('controllers/authController.php'); ?>

<!DOCTYPE html>
<html>

<head>
  <title>App - SmarboLab</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link href="styles/main.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>

<body>
  <div class="container">
      <nav class="top-nav" id="navBar"></nav>
    <main>
      <?php if(!isset($_SESSION['id'])): ?>
      <div class="logged-out-box main-child">
        <h1 id="child">You are logged out.</h1>
        <p id="child" class="message" style="text-align: center;">It seems you are currently not logged in to an account.<br>Please log in to access the rest of the site.</p>
        <a href="login.php" class="button" id="child">Log In</a>
        <a href="signup.php" class="button" id="child">Sign Up</a>
      </div>
      <? endif; ?>
      
    </main>
  </div>
  <!-- Navbar Script -->
  <script src="scripts/navbar.js"></script>
</body>

</html>
