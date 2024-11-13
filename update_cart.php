<?php
session_start();

if (isset($_POST['id'], $_POST['quantity'], $_POST['price'])) {
    $id = (int) $_POST['id'];
    $quantity = (int) $_POST['quantity'];
    $price = (float) $_POST['price'];

    // Update the session cart quantity
    if ($quantity > 0) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    } else {
        unset($_SESSION['cart'][$id]);
    }

    // Recalculate the total
    $total = 0;
    foreach ($_SESSION['cart'] as $item_id => $item) {
        $total += $item['quantity'] * $item['price'];
    }

    // Return the total as response
    echo number_format($total, 2);
}
?>