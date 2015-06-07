<?php
ini_set('display_errors', 'On');
header("refresh:3;url=addWine.php", true);
include 'storedInfo.php';
session_start();

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}

//------------------------------------------------------------------------------
//adding a wine
if ($_POST != NULL && $_POST['action'] == "Add Wine") {
    //check for values in required fields
    if ($_POST['name'] == NULL) {
        echo 'Name is a required field. Try again. <br>';
    }
    if ($_POST['type'] == NULL) {
        echo 'Type is a required field. Try again. <br>';
    }

    if ($_POST['name'] != NULL && $_POST['type'] != NULL) {
        
        //make sure a wine by that name doesn't already exist
        if (!($stmt = $mysqli->prepare("SELECT name FROM wines 
                                        WHERE name=?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        if (!$stmt->bind_param("s", $_POST['name'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        $outName = NULL;
        if (!$stmt->bind_result($outName)) {
            echo "Binding output parameters failed: (" . $stmt->errno . ") " 
                  . $stmt->error;
        }
        
        if ($stmt->fetch()) {
            echo 'A wine by that name already exists. Try again.';
        } else {
            $stmt->close();
        
            //perform the insertion
            if (!($stmt = $mysqli->prepare("INSERT INTO wines(name, type,  
                                            year, author, lid) VALUES (?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
            $name = $_POST['name'];
            $type = $_POST['type'];
            $year = $_POST['year'];
			$location = $_POST['location'];
            
            if (!$stmt->bind_param("ssiii", $name, $type, $year, $_SESSION['id'], $location)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") "
                     . $stmt->error;
            }
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
            } else {
                echo 'You have successfully added a wine.<br>';
            }
            
            $stmt->close();
        }
    }
}



echo '<br><br>You will be redirected back in 3 seconds. If not, click <a href="addWine.php">here</a>.';
?>