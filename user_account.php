<?php
# Access session.
session_start(); ?>

<head>
	<title>Account Details</title>
</head>

<?php

# Redirect if not logged in.
if (!isset($_SESSION['id'])) {
	require('login_tools.php');
	load();
}

# Open database connection.
require('includes/connect_db.php');

# Retrieve items from 'users' database table.
$q = "SELECT * FROM new_users WHERE id={$_SESSION['id']}";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0) {
	# Include navbar at the top.
	include 'includes/navbar.php';

	echo '
	<div class="container my-4">
    ';

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$date = $row["created_at"];
		$day = substr($date, 8, 2);
		$month = substr($date, 5, 2);
		$year = substr($date, 0, 4);

		echo '  
        <h1 class="text-center">' . htmlspecialchars($row['username']) . '</h1>
        <hr>
        <p>User ID : EC2024/' . htmlspecialchars($row['id']) . '</p>
        <hr>
        <p>Email : ' . htmlspecialchars($row['email']) . '</p>
        <hr>
        <p>Registration Date : ' . $day . '/' . $month . '/' . $year . '</p>
        <hr>
        ';
	}

	# Close database connection.
	mysqli_close($link);

	echo '
    </div>
    ';

	# Include footer at the bottom.
	include 'includes/footer.php';

}
?>