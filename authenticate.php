<?php
ini_set('display_errors', 'On');
header("Content-Type: text/plain");

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: login.php");
} else if ($_POST['username'] == NULL) {
    echo 'You must enter a username.';
} else if ($_POST['password'] == NULL) {
    echo 'You must enter a password.';
} else {
    include 'storedInfo.php';
    
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
             ") " . $mysqli->connect_error;
    }
    
    if (!($stmt = $mysqli->prepare("SELECT username, password FROM 
                                    user WHERE username=?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    
    if (!$stmt->bind_param("s", $_POST['username'])) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    
    $outName = NULL;
    $outPassword = NULL;
    if (!$stmt->bind_result($outName, $outPassword)) {
        echo "Binding output parameters failed: (" . $stmt->errno . ") " 
              . $stmt->error;
    }
    
    if ($stmt->fetch()) {
        if ($_POST['password'] === $outPassword) {
            $stmt->close();
            session_start();
            $_SESSION['username'] = $_POST['username'];
            
            //get the id of the user
            if (!($stmt = $mysqli->prepare("SELECT id FROM user 
                                            WHERE username=?"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            if (!$stmt->bind_param("s", $_SESSION['username'])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            $outID = NULL;
            if (!$stmt->bind_result($outID)) {
                echo "Binding output parameters failed: (" . $stmt->errno . ") " 
                      . $stmt->error;
            }
            $stmt->fetch();
            $_SESSION['id'] = $outID;
            $stmt->close();

            echo 'Login Successful';
        } else {
            echo 'That password is incorrect.';
        }
    } else {
        echo 'That account does not exist.';
        $stmt->close();
    }
}
?>