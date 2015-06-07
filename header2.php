<div class="banner1">
  Wine Database
</div>
<div class="loginBar1">
  <?php
  if (isset($_SESSION['username'])) {
      echo 'Hi ' . "$_SESSION[username]" . '!';
      echo '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
      echo '<a href="logout.php">logout</a>';
  }
  else {
      echo '<a href="login.php">Login / Create Account</a>';
  }
  ?>
  &nbsp;&nbsp;&nbsp;
</div>
<div class="navbar1">
  <a href="addWine.php">Add Wine</a><br>
  <a href="viewWine.php">View Wine</a><br>
  <a href="updateWine.php">Update Wine</a><br>
  <a href="addLocation.php">Add Winery Location</a><br>
  <a href="Places_GoogleMaps.php">Google Maps Directions</a><br>
</div>