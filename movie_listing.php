<?php
// Start session for accessing session variables if needed
session_start();

include 'includes/navbar.php';
?>

<head>
	<title>What's On</title>
</head>

<main class="py-4">
	<div class="container">
		<h1 class="text-center mb-4">Now Showing</h1>
		<div class="row">

			<?php
			# Open database connection.
			require('includes/connect_db.php');

			# Retrieve movies from 'movie_listing' database table.
			$q = "SELECT * FROM movie_listings";
			$r = mysqli_query($link, $q);
			if (mysqli_num_rows($r) > 0) {
				# Display body section.
				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '
                    <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
                        <div class="card" style="width: 18rem;">
                            <img src="' . $row['img'] . '" alt="Movie" class="card-img-top img-fluid">
                            <div class="card-body text-center">
                                <h6 class="card-title">' . $row['movie_title'] . '</h6>
                                <a href="movie.php?movie_id=' . $row['movie_id'] . '" class="btn btn-secondary btn-block" role="button">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                    ';
				}
				# Close database connection.
				mysqli_close($link);
			}
			# Or display message.
			else {
				echo '<p class="text-center">There are currently no movies showing.</p>';
			}
			?>
		</div>
	</div>
</main>

<!-- FOOTER -->
<?php
include 'includes/footer.php';
?>