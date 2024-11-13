<?php
session_start();

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    // Remove the item from the cart session
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    // Recalculate the total
    $total = 0;
    foreach ($_SESSION['cart'] as $item_id => $item) {
        $total += $item['quantity'] * $item['price'];
    }

    // Return the updated total as a JSON response
    echo json_encode(['total' => number_format($total, 2)]);
}
?>