<?php

function connexion() {
	$username = '';
	$password = '';
	$host = 'localhost/XE';
	return oci_connect($username, $password, $host);
}

function page() {
	echo '<p>Content of the database</p>';
	
	$conn = connexion();
	
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	
	$req = 'SELECT * FROM employees';
	
	$stid = oci_parse($conn, $req);
	oci_execute($stid);

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