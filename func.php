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
		echo "<tr>\n";
		foreach ($row as $item) {
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
}

?>