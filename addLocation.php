<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Add Location</title>
    <link rel="stylesheet" href="smbStyle.css">
  </head>
  
  <body>
    <?php
    include 'header.php';
    ?>
    
    <div class="content">
      <?php
      if (isset($_SESSION['username'])) {
        include 'addLocationPage.php';
      } else {
        echo 'You need to log in first<br>';
        echo '<a href="login.php">Login / Create Account</a>';
      }
      ?>
    </div>
    
  </body>
</html>
