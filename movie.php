<?php

// Start session for accessing session variables if needed
session_start();

include 'includes/navbar.php'; ?>

<head>
	<title>Movie</title>
</head>

<?php

# Get passed movie id and assign it to a variable.
if (isset($_GET['movie_id']))
	$movie_id = $_GET['movie_id'];

# Open database connection.
require('includes/connect_db.php');

# Retrieve selective movie data from 'movie_listings' database table. 
$q = "SELECT * FROM movie_listings WHERE movie_id = $movie_id";
$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) == 1) {
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

	# Update or add movie booking in cart.
	if (isset($_SESSION['cart'][$movie_id])) {
		$_SESSION['cart'][$movie_id]['quantity']++;
	} else {
		$_SESSION['cart'][$movie_id] = array('quantity' => 1, 'price' => $row['mov_price']);
	}

	echo '

	<div class="container mt-5 mb-5">
		<div class="row">
			<!-- Movie Video Preview -->
			<div class="col-md-6">
				<div class="embed-responsive embed-responsive-16by9 mb-4">
					<iframe class="embed-responsive-item" src="' . $row['preview'] . '" 
						frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
					</iframe>
				</div>
			</div>

			<!-- Movie Details Section -->
			<div class="col-md-6">
				<h1 class="display-4">' . $row['movie_title'] . '</h1>
				<p class="lead">Release Date: ' . $row['release'] . '</p>
				<p><strong>Genre:</strong> ' . $row['genre'] . '</p>
				<img src="' . $row['age_rating'] . '" alt="Age Rating" width="50px" class="mb-3">
				<p>' . $row['further_info'] . '</p>
			</div>
		</div>

		<!-- Show Times Section -->
		<div class="row mt-5">
			<div class="col-md-12">
				<h4>Show Times at <strong>' . $row['theatre'] . '</strong></h4>
				<hr>
				<div class="d-flex justify-content-start flex-wrap">
					<a href="show1.php" class="btn btn-secondary mr-2 mb-2">Book > ' . $row['show1'] . '</a>
					<a href="show2.php" class="btn btn-secondary mr-2 mb-2">Book > ' . $row['show2'] . '</a>
					<a href="show3.php" class="btn btn-secondary mr-2 mb-2">Book > ' . $row['show3'] . '</a>
				</div>
			</div>
		</div>
	</div>
	';
}

# Close database connection.
mysqli_close($link);
?>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>