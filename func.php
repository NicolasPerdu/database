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

function page($query) {

	$conn = connexion();
	
	if(!$conn)
		return;
	
	$stid = oci_parse($conn, $query);
	
	$r = oci_execute($stid);
	
	if(!$r) {
		echo '<p>Error: SQL query invalid.<br/>
		<a href="index.php">Try another query</a></p>';
		exit;
	}

	echo "<table>\n";
	
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		//print_r($row);
		echo "<tr>\n";
		foreach ($row as $key => $value)	{
			$val = ($value !== null ? htmlentities($value, ENT_QUOTES) : "&nbsp;");
			if($key == "RELEASEID") {
				echo '    <td>
				<form action="index.php" method="post">
				<input type="hidden" name="query" value="select * from track where releaseid = '.$val.'">
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