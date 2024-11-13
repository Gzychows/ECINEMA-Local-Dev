<!-- NAVBAR-->
<?php
include 'includes/navbar.php';
?>


<?php
# DISPLAY COMPLETE REGISTRATION PAGE.
# Check form submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Connect to the database.
    require('includes/connect_db.php');

    # Initialize an error array.
    $errors = array();

    # Check for a first name.
    if (empty($_POST['username'])) {
        $errors[] = 'Enter your name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['username']));
    }

    # Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'Enter your email address.';
    } else {
        $e = mysqli_real_escape_string($link, trim($_POST['email']));
    }

    # Check for a password and matching input passwords.
    if (!empty($_POST['pass1'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Passwords do not match.';
        } else {
            $p = mysqli_real_escape_string($link, trim($_POST['pass1']));
        }
    } else {
        $errors[] = 'Enter your password.';
    }

    # Check if the checkbox is ticked (agree to terms).
    if (!isset($_POST['agreeTerms'])) {
        $errors[] = 'You must agree to the terms and conditions.';
    }

    # Check if email address already registered.
    if (empty($errors)) {
        $q = "SELECT id FROM new_users WHERE email='$e'";
        $r = @mysqli_query($link, $q);
        if (mysqli_num_rows($r) != 0)
            $errors[] =
                'Email address already registered. 
	<a class="alert-link" href="login.php">Sign In Now</a>';
    }

    # On success register user inserting into 'new_users' database table.
    if (empty($errors)) {
        $q = "INSERT INTO new_users (username, email, password) 
	VALUES ('$fn', '$e', SHA2('$p',256))";
        $r = @mysqli_query($link, $q);
        if ($r) {
            echo '
	<p>You are now registered.</p>
	<a class="alert-link" href="login.php">Login</a>';
        }

        # Close database connection.
        mysqli_close($link);
        exit();
    }
    # Or report errors.
    else {
        echo '<h4>The following error(s) occurred:</h4>';
        foreach ($errors as $msg) {
            echo " - $msg<br>";
        }
        echo '<p>or please try again.</p><br>';
        # Close database connection.
        mysqli_close($link);
    }
}

?>

<head>
    <title>Register</title>
</head>

<main class="container px-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center my-4">Register</h2>
                <form action="register.php" method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Enter username" value="<?php if (isset($_POST['username']))
                                echo $_POST['username']; ?>" required>
                        <div class="invalid-feedback">Please enter a valid username.</div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email"
                            value="<?php if (isset($_POST['email']))
                                echo $_POST['email']; ?>" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <div class="form-group">
                        <label for="pass1">Password</label>
                        <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Password"
                            value="<?php if (isset($_POST['pass1']))
                                echo $_POST['pass1']; ?>" required>
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>

                    <div class="form-group">
                        <label for="pass2">Confirm Password</label>
                        <input type="password" class="form-control" id="pass2" name="pass2"
                            placeholder="Confirm password" value="<?php if (isset($_POST['pass2']))
                                echo $_POST['pass2']; ?>" required>
                        <div class="invalid-feedback">Passwords must match.</div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="agreeTerms" name="agreeTerms" required>
                        <label class="form-check-label" for="agreeTerms">Agree to terms and conditions</label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>


<!-- FOOTER -->
<?php
include 'includes/footer.php';
?>