<?php
session_start();

include 'storedInfo.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno . ") " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>View Your Wines</title>
    <link rel="stylesheet" href="smbStyle.css">
	<style>
  table, th, td {
    border: 1px solid black; <!-- table cell borders -->
    border-collapse: collapse;
	padding: 10px; <!-- table padding -->
}
  </style>
  </head>
  
  <body>
    <?php
    include 'header.php';
    ?>
    
    <div class="content">
	<h1>Your Current Wine List</h1> <!-- Printing wine list from database -->
	<table>
		<tr>
			<td>Winery Name </td>
			<td>Type </td>
			<td>Year </td>
		</tr>
		<?php
		if (isset($_SESSION['username'])) {
        
			if ($_POST != NULL && $_POST['action'] == "Show me my Wine") {
			  
				if (!($stmt = $mysqli->prepare("SELECT id, name, type, year
                                FROM wines WHERE author=?"))) {
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
					}
                            
				if (!$stmt->bind_param("i", $_SESSION['id'])) {
                    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
					}	
              
				if (!$stmt->execute()) {
                   echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
					}

				$outID = NULL;
				$outName = NULL;
				$outType = NULL;
				$outYear = NULL;
				
				if (!$stmt->bind_result($outID, $outName, $outType, $outYear)) {
					echo "Binding output parameters failed: (" . $stmt->errno
					. ") " . $stmt->error;
					}
              
				while ($stmt->fetch()) {
					echo "<tr>\n<td>\n" . $outName . "\n</td>\n<td>\n" . $outType . "\n</td>\n<td>\n" . $outYear . "\n</td>\n</tr>";
				}
			$stmt->close();
		}
      } else {
			echo 'You need to log in first<br>';
			echo '<a href="login.php">Login / Create Account</a>';
			}
      ?>
    </table>
	</div>  
  </body>
</html>