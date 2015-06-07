<?php
ini_set('display_errors', 'On');
header("refresh:6;url=updateWine.php", true);
include 'storedInfo.php';
session_start();

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}

//------------------------------------------------------------------------------
//Updating a Module
if ($_POST != NULL && $_POST['action'] == "Update Wine") {
    $updateID = $_POST['update_id'];
    $newName = $_POST['update_name'];
    $newType = $_POST['update_type'];
    $newYear = $_POST['update_year'];
	$newLocation = $_POST['update_location'];
    
    if ($newName != NULL) {
        echo "Made it to update name clause <br>";
        if (!($stmt = $mysqli->prepare("UPDATE wines SET name = ? WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("si", $newName, $updateID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") "
                 . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            echo 'You have successfully updated the wine name.<br>';
        }
    }
    if ($newType != NULL) {
        if (!($stmt = $mysqli->prepare("UPDATE wines SET type = ? WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("si", $newType, $updateID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") "
                 . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            echo 'You have successfully updated the wine type.<br>';
        }
    }
    if ($newYear != NULL) {
        if (!($stmt = $mysqli->prepare("UPDATE wines SET year = ? WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ii", $newYear, $updateID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") "
                 . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            echo 'You have successfully updated the wine year.<br>';
        }
    }
	    if ($newLocation != NULL) {
        if (!($stmt = $mysqli->prepare("UPDATE wines SET lid = ? WHERE id = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("ii", $newLocation, $updateID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") "
                 . $stmt->error;
        }
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        } else {
            echo 'You have successfully updated the wine location.<br>';
        }
    }
        $stmt->close();
}
echo '<br><br>You will be redirected back in 6 seconds. If not, click <a href="updateWine.php">here</a>.';
?>