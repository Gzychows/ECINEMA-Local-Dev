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

# Retrieve items from 'new_users' table.
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

		# Handle missing data by providing a default value.
		$username = isset($row['username']) ? htmlspecialchars($row['username']) : 'No username set';
		$first_name = isset($row['firstname']) ? htmlspecialchars($row['firstname']) : 'No first name set';
		$last_name = isset($row['surname']) ? htmlspecialchars($row['surname']) : 'No last name set';
		$email = isset($row['email']) ? htmlspecialchars($row['email']) : 'No email set';

		# Display user details.
		echo '
        <p>User ID : EC2024/' . htmlspecialchars($row['id']) . '</p>
        <hr>
        <p>Email : ' . $email . '</p>
        <hr>
        <p>First Name : ' . $first_name . '</p>
        <hr>
        <p>Last Name : ' . $last_name . '</p>
        <hr>
        <p>Registration Date : ' . $day . '/' . $month . '/' . $year . '</p>
        <hr>
        ';

		# Display success or error messages if they exist
		if (isset($_SESSION['success'])) {
			echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
			unset($_SESSION['success']);
		} elseif (isset($_SESSION['error'])) {
			echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
			unset($_SESSION['error']);
		}

		# Form to change password
		echo '
        <h3>Change Password</h3>
        <form action="update_account.php" method="POST">
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
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