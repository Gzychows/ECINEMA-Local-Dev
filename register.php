<?php
session_start();
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

    # Check for a First Name
    if (empty($_POST['firstname'])) {
        $errors[] = 'Enter your First Name.';
    } else {
        $fn = mysqli_real_escape_string($link, trim($_POST['firstname']));
    }

    # Check for a Surname.
    if (empty($_POST['surname'])) {
        $errors[] = 'Enter your Surname.';
    } else {
        $sn = mysqli_real_escape_string($link, trim($_POST['surname']));
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
        if (mysqli_num_rows($r) != 0) {
            $errors[] = 'Email address already registered. 
            <a class="alert-link" href="login.php">Sign In Now</a>';
        }
    }

    # On success register user inserting into 'new_users' database table.
    if (empty($errors)) {
        $q = "INSERT INTO new_users (firstname, surname, email, password) 
        VALUES ('$fn', '$sn', '$e', SHA2('$p',256))";
        $r = @mysqli_query($link, $q);
        if ($r) {
            # Store success message in session and redirect to avoid resubmission.
            $_SESSION['success'] = 'You are now registered. <a class="alert-link" href="login.php">Login</a>';
            header('Location: register.php');
            exit();
        } else {
            $_SESSION['error'] = 'Something went wrong. Please try again.';
        }
    } else {
        # Store error messages in session.
        $_SESSION['error'] = 'The following error(s) occurred:<br>' . implode('<br>', $errors);
    }

    # Close database connection.
    mysqli_close($link);
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

                <!-- Registration form -->
                <form action="register.php" method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            placeholder="Enter First Name" value="<?php if (isset($_POST['firstname']))
                                echo $_POST['firstname']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter Surname"
                            value="<?php if (isset($_POST['surname']))
                                echo $_POST['surname']; ?>" required>
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