<?php
# PROCESS LOGIN ATTEMPT.

# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Open database connection.
    require('includes/connect_db.php');

    # Get connection, load, and validate functions.
    require('login_tools.php');

    # Check login.
    list($check, $data) = validate($link, $_POST['email'], $_POST['password']);

    # On success set session data and display logged in page.
    if ($check) {
        # Access session.
        session_start();
        $_SESSION['id'] = $data['id'];
        $_SESSION['firstname'] = $data['firstname'];
        load('index.php');
    }
    # Or on failure set error message as a string.
    else {
        session_start();  # Ensure session is started
        $_SESSION['error'] = implode(", ", $data);  # Convert array to string if it's an array
    }

    # Close database connection.
    mysqli_close($link);
}

# Redirect to login page if there's an error.
include('login.php');
?>