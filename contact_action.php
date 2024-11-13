<?php
// Start session for accessing session variables
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: contactUs.php");
        exit();
    }

    // Email recipient
    $to = "prodigy5445@gmail.com";

    // Email subject
    $subject = "New Contact Us Message from $name";

    // Email body
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        $_SESSION['success'] = "Your message has been sent successfully!";
    } else {
        $_SESSION['error'] = "Sorry, there was an error sending your message. Please try again later.";
    }

    // Redirect back to contact page
    header("Location: contactUs.php");
    exit();
} else {
    // If the form was not submitted correctly, redirect back to the contact page
    header("Location: contactUs.php");
    exit();
}
?>