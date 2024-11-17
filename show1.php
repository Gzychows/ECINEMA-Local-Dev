<?php
session_start();
require('login_tools.php');

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
  load();
  exit();
} ?>

<head>
  <title>Booking</title>
</head>

<?php


include 'includes/navbar.php'; // Only include navbar after header() checks


// Get passed product id and assign it to a variable.
if (isset($_GET['id']))
  $id = $_GET['id'];

// Check if form has been submitted for update.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  foreach ($_POST['qty'] as $id => $mov_qty) {
    $id = (int) $id;
    $qty = (int) $mov_qty;
    if ($qty == 0) {
      unset($_SESSION['cart'][$id]);
    } elseif ($qty > 0) {
      $_SESSION['cart'][$id]['quantity'] = $qty;
    }
  }
}

// Initialize grand total variable.
$total = 0;

// Display the cart if not empty.
if (!empty($_SESSION['cart'])) {
  require('includes/connect_db.php');

  // Retrieve all items in the cart from the 'movie' database table.
  $q = "SELECT * FROM movie_listings WHERE movie_id IN (" . implode(',', array_keys($_SESSION['cart'])) . ") ORDER BY
movie_id ASC";
  $r = mysqli_query($link, $q);

  echo '
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card bg-light mb-3">
        <div class="card-header">
          <h5 class="card-title">Booking Summary</h5>
        </div>
        <div class="card-body">
          <form action="cart.php" method="post">
            ';

  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    $movie_id = $row['movie_id'];
    $quantity = $_SESSION['cart'][$movie_id]['quantity'];
    $price = $_SESSION['cart'][$movie_id]['price'];
    $subtotal = $quantity * $price;
    $total += $subtotal;

    echo "
            <ul class=\"list-group list-group-flush\">
              <li class=\"list-group-item\">
                <h4>{$row['theatre']}</h4>
                <p>Movie Title: {$row['movie_title']}</p>
                <p>Starting @ {$row['show1']}</p>
                <div class=\"input-group mb-3\">
                  <div class=\"input-group-prepend\">
                    <button type=\"button\" class=\"btn btn-dark\" onclick=\"updateQuantity($movie_id, -1,
                      $price)\">-</button>
                  </div>
                  <input type=\"text\" class=\"form-control text-center\" id=\"quantity_$movie_id\"
                    name=\"qty[$movie_id]\" value=\"$quantity\" readonly>
                  <div class=\"input-group-append\">
                    <button type=\"button\" class=\"btn btn-dark\" onclick=\"updateQuantity($movie_id, 1,
                      $price)\">+</button>
                  </div>
                </div>
              </li>
            </ul>
            <br>
            ";
  }

  echo '
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <p id="total">To Pay: &pound' . number_format($total, 2) . '</p>
              </li>
              <li class="list-group-item">
                <!-- Book Now and Add to Cart Options -->
                <a href="checkout.php?total=' . $total . '" class="btn btn-secondary btn-block mb-2">Book Now</a>
                <a href="movie_listing.php" class="btn btn-primary btn-block">Add More Movies to Cart</a>
              </li>
            </ul>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
';
} else {
  // If the cart is empty, display a message.
  echo '
<div class="container">
  <div class="alert alert-secondary" role="alert">
    <h2>No reservations have been made.</h2>
    <a href="movie_listing.php" class="alert-link">View What\'s On Now</a>
  </div>
</div>
';
}
?>

<script>
  // JavaScript function to update quantity with AJAX
  function updateQuantity(movie_id, change, price) {
    const quantityInput = document.getElementById("quantity_" + movie_id);
    let quantity = parseInt(quantityInput.value) + change;

    if (quantity < 1) quantity = 1;

    quantityInput.value = quantity;

    // AJAX request to update quantity and total in the session
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        document.getElementById("total").innerHTML = "To Pay: &pound" + xhr.responseText;
      }
    };
    xhr.send("id=" + movie_id + "&quantity=" + quantity + "&price=" + price);
  }
</script>

<?php include 'includes/footer.php'; ?>