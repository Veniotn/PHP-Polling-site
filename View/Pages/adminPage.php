<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin panel</title>
  <link rel="stylesheet" href="../CSS/adminScreen.css">
  <link rel="stylesheet" href="../CSS/basicStyles.css">
</head>

<body>
<div class="topSection">
  <h1 id="headerMessage">Admin Panel</h1>
  <h1 id="pollingResultsMessage">Polling results</h1>
  <form action="./adminPage.php" method="post">
    <button type="submit" id="fixIssuesButton">Fix issues</button>
  </form>
</div>

<?php include '../../Controller/adminScreen.php'?>
</body>
</html>