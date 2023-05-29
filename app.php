<?php require_once('controllers/authController.php'); ?>

<!DOCTYPE html>
<html>

<head>
  <title>App - SmarboLab</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
  <link href="styles/main.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <div class="container">
    <nav class="top-nav" id="navBar"></nav>
    <main>
      <!-- If user is not logged in -->
      <?php if(!isset($_SESSION['username'])): ?>
      <div class="logged-out-box main-child">
        <h1 id="child">You are logged out.</h1>
        <p id="child" class="message" style="text-align: center;">It seems you are currently not logged in to an account.<br>Please log in to access the rest of the site.</p>
        <a href="login.php" class="button" id="child">Log In</a>
        <a href="signup.php" class="button" id="child">Sign Up</a>
      </div>
      <?php endif; ?>
      <!--- If user is logged in  --->
      <!-- Error messages -->
      <?php if(count($errors) > 0): ?>
        <div class="error-message">
          <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <!-- Success messages -->
      <?php if(count($completeds) > 0): ?>
        <div class="success-message">
          <?php foreach($completeds as $complete): ?>
            <li><?php echo $complete; ?></li>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if(isset($_SESSION['username'])): ?>
        <div class="app-box">
          <div class="app-box-topbar">Hello, <?php echo $_SESSION['username']; ?>.</div>
          <div class="app-box-topbar logout"><a href="app.php?logout=1">Log Out</a></div>
          <div class="app-box-container">
            <div class="item-1 item">
              <h1 class="title">Overview</h1>
              <h6>Balance:</h6><br>
              <p><?php echo $_SESSION['sb_bal']; ?>SB</p><br>
              <p><?php echo $_SESSION['cs_bal']; ?>CS</p><br><br>
              <h6><?php echo $_SESSION['missions_complete'];?> Missions Completed.</h6>
              </div>
              <div class="item-2 item">
                <h1 class="title">Transfer</h1>
                <form action="app.php" method="post" class="transfer-form">
                  <div>
                    <select name="currency" class="currencies-select">
                      <option value="smarbobits">SB</option>
                      <option value="crystalshards">CS</option>
                    </select>
                    <input type="number" name="amount" placeholder="Amount" class="amount" value="">
                    <label for="reciever">--------&gt;</label>
                    <input type="text" name="reciever" placeholder="Reciever's Username" class="reciever" value="">
                    <button type="submit" name="transfer-btn" class="transfer-btn">Send</button>
                  </div>
                </form>
              </div>
            <div class="item-3 item"><h1 class="title">Swap</h1></div>
            <div class="item-4 item"><h1 class="title">Missions</h1></div>
          </div>
        </div>
      <?php endif; ?>
    </main>
  </div>
  <!-- Navbar Script -->
  <script src="scripts/navbar.js"></script>
  <!-- Script to remove Confirm Resubmission popup on refresh. -->
  <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
</body>

</html>
