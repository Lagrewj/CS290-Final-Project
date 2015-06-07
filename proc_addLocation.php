<?php
ini_set('display_errors', 'On');
header("refresh:3;url=addLocation.php", true);
include 'storedInfo.php';
session_start();

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}

//------------------------------------------------------------------------------
//adding a location
if ($_POST != NULL && $_POST['action'] == "Add Location") {
    //check for values in required fields
    if ($_POST['city'] == NULL) {
        echo 'City is a required field. Try again. <br>';
    }
    if ($_POST['state'] == NULL) {
        echo 'Type is a required field. Try again. <br>';
    }

    if ($_POST['city'] != NULL && $_POST['state'] != NULL) {
        
        //make sure the location doesn't already exist
        if (!($stmt = $mysqli->prepare("SELECT city FROM location 
                                        WHERE city=?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        if (!$stmt->bind_param("s", $_POST['city'])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        if (!$stmt->execute()) {
            echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        $outCity = NULL;
        if (!$stmt->bind_result($outName)) {
            echo "Binding output parameters failed: (" . $stmt->errno . ") " 
                  . $stmt->error;
        }
        
        if ($stmt->fetch()) {
            echo 'A city by that name already exists. Try again.';
        } else {
            $stmt->close();
        
            //perform the insertion
            if (!($stmt = $mysqli->prepare("INSERT INTO location(city, state, country  
                                            ) VALUES (?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            
            if (!$stmt->bind_param("sss", $city, $state, $country)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") "
                     . $stmt->error;
            }
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
            } else {
                echo 'You have successfully added a location.<br>';
            }
            
            $stmt->close();
        }
    }
}



echo '<br><br>You will be redirected back in 3 seconds. If not, click <a href="addLocation.php">here</a>.';
?>