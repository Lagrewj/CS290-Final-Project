<?php
include 'storedInfo.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL:(" . $mysqli->connect-errno .
         ") " . $mysqli->connect_error;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Wine in the Database</title>
  <style>
  table, th, td {
    border: 1px solid black; <!-- table cell borders -->
    border-collapse: collapse;
	padding: 10px; <!-- table padding -->
}
  </style>
</head>
<body>
<div>
<h1>All Current Wine List</h1> <!-- Printing wine list from database -->
	<table>
		<tr>
			<td>Winery Name </td>
			<td>Type </td>
			<td>Year </td>
		</tr>
<?php
if (!($stmt = $mysqli->prepare("SELECT name, type, year
                                FROM wines"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") "
          . $mysqli->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") "
          . $mysqli->error;
}

$outName = NULL;
$outType = NULL;
$outYear = NULL;
if (!$stmt->bind_result($outName, $outType, $outYear)) {
    echo "Binding output parameters failed: (" . $stmt->errno
          . ") " . $stmt->error;
}

while ($stmt->fetch()) {
    echo "<tr>\n<td>\n" . $outName . "\n</td>\n<td>\n" . $outType . "\n</td>\n<td>\n" . $outYear . "\n</td>\n</tr>";
}

$stmt->close();
?>
	</table>
</div>
<h1>View Your Wine</h1>
<form action="proc_viewWine.php" method="post">
  <fieldset>
      <input type="submit" name="action" value="Show me my Wine">
  </fieldset>
</form>