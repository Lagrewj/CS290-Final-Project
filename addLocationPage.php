<?php
include 'storedInfo.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}
?>
<h1>Add a Location of your desired Winery</h1>
<form action="proc_addLocation.php" method="post">
  <fieldset>
    <div>
      <label>City:</label>
      <input type="text" name="city">
    </div>
    <div>
      <label>State:</label>
      <input type="text" name="state">
    </div>
    <div>
      <label>Country:</label>
      <input type="text" name="country">
    </div>
    <div>
      <input type="submit" name="action" value="Add Location">
    </div>
  </fieldset>
</form>

