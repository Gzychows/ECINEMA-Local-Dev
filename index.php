<?php
// Start session for accessing session variables if needed
session_start();

include 'includes/navbar.php';
?>

<head>
    <title>ECINEMA Home Page</title>
</head>

<!-- START MAIN-->
<main class="container px-3">
    <!-- START of ECinema text effect -->
    <div class="text-container">
        <h1>ECINEMA</h1>
    </div>
    <!-- END of ECinema text effect -->

    <!-- START Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <!-- Carousel Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <!-- Carousel Inner -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/index/carousel_img1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/index/carousel_img2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/index/carousel_img3.jpg" alt="Third slide">
            </div>
        </div>

        <!-- Carousel Controls -->
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- END Carousel -->

    <!-- START Containers-->
    <div class="container">
        <div class="row movie-windows d-flex justify-content-center">
            <?php
            require('includes/connect_db.php');

            $q = "SELECT * FROM movie_listings LIMIT 3";
            $r = mysqli_query($link, $q);

            if (mysqli_num_rows($r) > 0) {
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    echo '
                <div class="col-md-4 d-flex justify-content-center mb-4">
                    <div class="card" style="width: 18rem;">
                        <img src="' . $row['img'] . '" class="card-img-top" alt="Movie image" />
                        <div class="card-body">
                            <p class="card-text">' . $row['further_info'] . '</p>
                            <a href="movie.php?movie_id=' . $row['movie_id'] . '" class="btn btn-secondary btn-block" role="button">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                ';
                }
                mysqli_close($link);
            } else {
                echo '<p class="text-center">There are currently no movies available.</p>';
            }
            ?>
        </div>
    </div>

    <!-- END OF MAIN-->
</main>

<!-- FOOTER -->
<?php
include 'includes/footer.php';
?>