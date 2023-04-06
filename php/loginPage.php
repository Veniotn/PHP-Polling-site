<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>
  <meta charset="UTF-8">
  <title>NSCC 2023 Polling!</title>
  <link rel="stylesheet" type="text/css" href="../CSS/loginStyles.css">
  <link rel="stylesheet" type="text/css" href="../CSS/basicStyles.css">
</head>
<body>
<h1 id="headerMessage">Login Screen</h1>
<form action="login.php" method="post">
<label for="username">Username:</label>
<input type="text" id="username" name="username" required placeholder="<?php if (isset($_SESSION['error'])){
    echo $_SESSION['error']; unset($_SESSION['error']);
} ?>"><br>
<label for="password">Password:</label>
<input type="password" id="password" name="password" required><br>
<input type="submit" value="Login">
</form>
<button id="createAccountButton"  onclick="location.href='../php/createAccountScreen.php'">Create Account</button>
</body>
</html>
