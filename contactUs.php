<?php
session_start();

include 'includes/navbar.php';
?>

<head>
    <title>Contact Us</title>
</head>

<div class="container">
    <h1 class="text-center my-4">Contact Us</h1>

    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']); // Clear the message after displaying
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>

    <form action="contact_action.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">Please enter your name.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            <div class="invalid-feedback">Please enter your message.</div>
        </div>

        <div class="text-center contact-button">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
</div>

<!-- FOOTER -->
<?php
include 'includes/footer.php';
?>