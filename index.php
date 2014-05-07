<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Database Project</title>
    </head>
    <body>
	<div align="center">
	<?php 
		//error_reporting(0);
		
		if(isset($_POST['query'])) {
			echo '<h1>Result</h1>';
			include('./func.php'); 
			page($_POST['query']);
		}
		else {
			echo '<h1>Interface</h1><form action="index.php" method="POST">
			<label>SQL query</label> : <input type="text" name="query" />
			<input type="submit" value="Send" />
			</form>';
		}
	?>
	</div>
    </body>
</html>