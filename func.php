<?php

function connexion() {
	$username = 'db2014_g29';
	$password = 'db2014_g29';
	$host = 'icoracle.epfl.ch';
	$str = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST='.$host.')(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME = srso4.epfl.ch)))';
	
	$conn = oci_connect($username, $password, $str);
	
	if (!$conn) {
		$e = oci_error();
		echo $e['message'];
	}
	
	return $conn;
}

function get_database($query) {
	$words = explode(" ", $query);
	$b = false;
	
	foreach($words as $value) {
		if($b) {
			return strtolower($value);
		}
		if($value == "from") {
			$b = true;
		}
	}
}

function page($query) {

	$conn = connexion();
	
	if(!$conn)
		return;
	
	$stid = oci_parse($conn, $query);
	
	$r = oci_execute($stid);
	
	if(!$r) {
		echo '<p><strong>'.$query.'</strong><br/>
		Error: SQL query invalid.<br/>
		<a href="index.php">Try another query</a></p>';
		exit;
	}
	$db_query = get_database($query);
	echo "<table>\n";
	
	$head = false;
	
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		echo "<tr>\n";
		if(!$head) {
			echo "<tr>\n";
			$keys = array_keys($row);
			foreach ($keys as $v) {
				echo'<td><strong>'.$v.'</strong></td>';
			}
			echo "</tr>\n";
			$head = true;
		}
		
		foreach ($row as $key => $value)	{
			$val = ($value !== null ? htmlentities($value, ENT_QUOTES) : "&nbsp;");
			if($key == "MEDIUMID" && $db_query == "medium") {
				echo '    <td>
				<form action="index.php" method="post">
				<input type="hidden" name="query" value="select * from track where mediumid = '.$val.'">
				<input type="submit" value="'.$val.'" />
				</form></td>';
			}
			else if($key == "RELEASEID" && $db_query == "release") {
				echo '    <td>
				<form action="index.php" method="post">
				<input type="hidden" name="query" value="select * from medium where releaseId = '.$val.'">
				<input type="submit" value="'.$val.'" />
				</form></td>';
			} else {
				echo "    <td>" . $val . "</td>\n";
			}
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}

?>