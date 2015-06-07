<?php
include 'storedInfo.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}
?>
<h1>Update one of your Wines</h1>
<form action="proc_updateWine.php" method="post">
  <fieldset>
    <div>
      <label>Choose Wine to Update:</label>
      <select name="update_id">
<?php
if (!($stmt = $mysqli->prepare("SELECT id, name
                                FROM wines WHERE author=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") "
          . $mysqli->error;
}
if (!$stmt->bind_param("i", $_SESSION['id'])) {
    echo "Binding parameters failed: (" . $stmt->errno . ") "
         . $stmt->error;
}
if (!$stmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") "
          . $mysqli->error;
}

$outID = NULL;
$outName = NULL;
if (!$stmt->bind_result($outID, $outName)) {
    echo "Binding output parameters failed: (" . $stmt->errno
          . ") " . $stmt->error;
}

while ($stmt->fetch()) {
    echo '<option value=' . "$outID" . '>'
          . "$outName" . '</option>';
}

$stmt->close();
?>
      </select>
    <div>
      <label>New Name:</label>
      <input type="text" name="update_name">
    </div>
    <div>
      <label>New Type:</label>
      <input type="text" name="update_type">
    </div>
    <div>
      <label>New Year:</label>
      <input type="number" name="update_year" min="1900" max="2017">
    </div>

    <div>
       <input type="submit" name="action" value="Update Wine">
    </div>

  </fieldset>
</form>


