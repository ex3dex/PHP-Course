<html>
<head>
	<title>Hello...</title>

	<meta charset="utf-8">

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
	<?php echo "<h1>Hi! I'm happy</h1>"; ?>

	<?php
	$username = 'root';
	$password = 'mishatestpass';
	$dbname = 'docker';
	$host = 'postgres';
	$dbh = new PDO("pgsql:dbname=$dbname;host=$host", $username, $password );

	?>
</div>
</body>
</html>