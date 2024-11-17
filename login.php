<?php
include 'includes/navbar.php';
?>

<head>
    <title>Log In</title>
</head>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center my-4">Login</h1>

            <!-- Display success or error messages above the email field -->
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

            <form action="login_action.php" method="post" class="needs-validation">
                <!-- Error message is now above the email field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email"
                        required>
                    <div class="invalid-feedback">
                        Please enter a valid email.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password"
                        name="password" required>
                    <div class="invalid-feedback">
                        Please enter your password.
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
<?php
include 'includes/footer.php';
?>