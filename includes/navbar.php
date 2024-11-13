<?php
// session_start();
// # Redirect if not logged in.
// if (!isset($_SESSION['id'])) {
//     require('login_tools.php');
//     load();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />

    <!-- CSS STYLE -->
    <link rel="stylesheet" type="text/css" href="styles/style.css" />


    <!-- jQuery and Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome (for icons) -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:900" rel="stylesheet" />
</head>

<body>
    <!-- START Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <!-- Navbar Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="images/index/logo2.png" alt="Logo" class="logo" />
        </a>

        <!-- Collapsible button (burger menu) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links (collapsible on mobile) -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link stroke" href="index.php">eCinema</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link stroke" href="movie_listing.php">What's On</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link stroke" href="contactUs.php">Contact Us</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if (isset($_SESSION['username'])): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2" style="width: 1.2rem; height: 1.2rem;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="mr-2">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <?php else: ?>
                            <!-- SVG Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 mr-2" style="width: 1.2rem; height: 1.2rem;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            My Account
                        <?php endif; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if (isset($_SESSION['username'])): ?>
                            <a class="dropdown-item" href="#">My Bookings</a>
                            <a class="dropdown-item" href="user_account.php">Account Details</a>
                            <a class="dropdown-item" href="logout.php">Log Out</a>
                        <?php else: ?>
                            <a class="dropdown-item" href="login.php">Log In</a>
                            <a class="dropdown-item" href="register.php">Register</a>
                        <?php endif; ?>
                    </div>
                </li>

                <!-- Cart Icon for Logged-In Users -->
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-cart" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zm3.14 4L4.89 13h7.924l1.2-6H3.14z" />
                                <path
                                    d="M5.5 16a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm7-1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                            </svg>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <!-- END Navbar -->

    <!-- Page Content -->
    <!-- Your page content goes here -->