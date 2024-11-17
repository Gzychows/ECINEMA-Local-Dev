<?php
session_start();
require('includes/connect_db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $current_password = mysqli_real_escape_string($link, trim($_POST['current_password']));
    $new_password = mysqli_real_escape_string($link, trim($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($link, trim($_POST['confirm_password']));

    // Error handling
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'New passwords do not match.';
        header('Location: user_account.php');
        exit();
    }

    // Verify current password
    $q = "SELECT password FROM new_users WHERE id={$_SESSION['id']}";
    $r = mysqli_query($link, $q);

    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_assoc($r);
        $stored_password = $row['password'];

        // Check if the current password is correct (assuming it's hashed)
        if (hash('sha256', $current_password) === $stored_password) {
            // Update password
            $hashed_new_password = hash('sha256', $new_password);
            $update_q = "UPDATE new_users SET password='$hashed_new_password' WHERE id={$_SESSION['id']}";
            $update_r = mysqli_query($link, $update_q);

            if ($update_r) {
                $_SESSION['success'] = 'Password updated successfully!';
                header('Location: user_account.php');
                exit();
            } else {
                $_SESSION['error'] = 'Error updating password. Please try again.';
                header('Location: user_account.php');
                exit();
            }
        } else {
            // Incorrect password
            $_SESSION['error'] = 'Current password is incorrect.';
            header('Location: user_account.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'User not found.';
        header('Location: user_account.php');
        exit();
    }

    mysqli_close($link);
}
?>