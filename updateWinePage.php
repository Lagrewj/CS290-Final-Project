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
		<label>New Location:</label>
		<select name="update_location"> <!-- Allows user to select from list of locations  -->
<?php
if(!($stmt = $mysqli->prepare("SELECT location.id, location.city, location.state, location.country FROM location"))){
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if(!$stmt->execute()){
	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
if(!$stmt->bind_result($id, $city, $state, $country)){
	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
while($stmt->fetch()){
	echo '<option value=" '. $id . ' "> ' . $city . " " . $state . " " . $country . '</option>\n';
}
$stmt->close();
?>
		</select>
	</div>
    <div>
       <input type="submit" name="action" value="Update Wine">
    </div>

  </fieldset>
</form>


