<?php
include 'storedInfo.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}
?>
<h1>Add a Wine</h1>
<form action="proc_add.php" method="post">
  <fieldset>
    <div>
      <label>Name:</label>
      <input type="text" name="name">
    </div>
    <div>
      <label>Type:</label>
      <input type="text" name="type">
    </div>
    <div>
      <label>Year:</label>
      <input type="text" name="year">
    </div>
	<div>
		<label>Location:</label>
		<select name="location"> <!-- Allows user to select from list of locations  -->
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
      <input type="submit" name="action" value="Add Wine">
    </div>
  </fieldset>
</form>

