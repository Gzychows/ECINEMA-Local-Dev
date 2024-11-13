<!-- NAVBAR-->
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
            <form action="login_action.php" method="post" class="needs-validation">
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