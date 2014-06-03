<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Database Project</title>
    </head>
    <body>
	<div align="center">
	<?php 
		error_reporting(0);
		
		if(isset($_POST['type'], $_POST['one'], $_POST['two'])) {
			if($_POST['type'] != '' && $_POST['one'] != '' && $_POST['two'] != '') {
			
				echo '<h1>Result</h1>';
				include('./func.php'); 
			
				$query = $_POST['type']." ".$_POST['one']." FROM ".$_POST['two'];
			
				if(isset($_POST['three'])) {
					if($_POST['three'] != '') {
						$query = $query." WHERE ".$_POST['three'];
					}
				}
				page($query);
			} else {
				display_interface();
			}
		}
		else if(isset($_POST['insert_one'], $_POST['insert_two'])) {
			if($_POST['insert_two'] != '') {
				echo '<h1>Result</h1>';
				include('./func.php'); 
			
				$query = "INSERT INTO ".$_POST['one']." VALUES ".$_POST['two'];
			 
				page($query);
			} else {
				display_interface();
			}
		}
		else if(isset($_POST['query'])) {
			if($_POST['query'] != '') {
				echo '<h1>Result</h1>';
				include('./func.php'); 
				page($_POST['query']);
			} else {
				display_interface();
			}
		}
		else {
			display_interface();
		}
		
		function display_interface() {
			echo '<h1>Interface</h1>
			<br/><br/>
			<h2>Select/Delete query</h2>
			<form method="post" action="index.php">
				<select name="type">
					<option value="SELECT">SELECT</option>
					<option value="DELETE">DELETE</option>
				</select>
				<input type="text" name="one" /> FROM 
				<input type="text" name="two" /> WHERE
				<input type="text" name="three" />
				<input type="submit" value="Send" />
			</form><br/>
			
			<h2>Insert query</h2>
			<form method="post" action="index.php">
				INSERT INTO <input type="text" name="insert_one" />
				VALUES <input type="text" name="insert_two" />
				<input type="submit" value="Send" />
			</form><br/>
			
			<h2>Other query</h2>
			<form action="index.php" method="POST">
			<label>General SQL query</label> : <input type="text" name="query" />
			<input type="submit" value="Send" />
			</form>
			';
		}
	?>
	</div>
    </body>
</html>