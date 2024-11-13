<?php
# Start session to access session variables.
session_start();
include 'includes/navbar.php';

# Redirect if not logged in.
if (!isset($_SESSION['id'])) {
	require('login_tools.php');
	load();
}

# Check for passed total and cart.
if (isset($_GET['total']) && ($_GET['total'] > 0) && (!empty($_SESSION['cart']))) {
	# Open database connection.
	require('includes/connect_db.php');

	# Insert ticket reservation and total into 'movie_booking' database table.
	$q = "INSERT INTO movie_booking (id, total, booking_date) VALUES ({$_SESSION['id']}, {$_GET['total']}, NOW())";
	$r = mysqli_query($link, $q);

	# Retrieve the current booking number.
	$booking_id = mysqli_insert_id($link);

	# Retrieve cart items from 'movie_listings' database table.
	$q = "SELECT * FROM movie_listings WHERE movie_id IN (" . implode(',', array_keys($_SESSION['cart'])) . ") ORDER BY movie_id ASC";
	$r = mysqli_query($link, $q);

	# Store order contents in 'booking_content' database table.
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		$query = "INSERT INTO booking_content (booking_id, movie_id, quantity, price) VALUES ($booking_id, " . $row['movie_id'] . "," . $_SESSION['cart'][$row['movie_id']]['quantity'] . "," . $_SESSION['cart'][$row['movie_id']]['price'] . ")";
		$result = mysqli_query($link, $query);
	}

	# Clear the cart.
	$_SESSION['cart'] = NULL;

	# Generate QR Code URL (using Google Charts API)
	$qr_data = "Booking Reference: #EC1000" . $booking_id . ", Total: £" . $_GET['total'];
	$qr_code_url = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . urlencode($qr_data) . "&choe=UTF-8";

	# Display confirmation with QR code.
	echo '
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h4>Booking Confirmation</h4>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Thank You for booking with ECinema!</h5>
                        <p class="card-text">Your booking has been successfully processed. Please save the QR code below, which you can scan at the cinema entrance.</p>
                        <hr>
                        <img src="' . $qr_code_url . '" alt="Booking QR Code" class="img-fluid my-3" width="200">
                        <p><strong>Booking Reference:</strong> #EC1000' . $booking_id . '</p>
                        <p><strong>Total Paid:</strong> &pound;' . number_format($_GET['total'], 2) . '</p>
                        <hr>
                        <a href="index.php" class="btn btn-secondary mt-3">Go back to Home Page</a>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <small>Booking Date: ' . date('Y-m-d H:i:s') . '</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';

} else {
	echo '
    <div class="container mt-5">
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">No Reservations Made</h4>
            <p>Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
            <hr>
            <a href="movie_listing.php" class="btn btn-dark">Browse Movies</a>
        </div>
    </div>
    ';
}

# Close the database connection.
mysqli_close($link);

include 'includes/footer.php';
?>