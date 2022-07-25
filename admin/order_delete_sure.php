<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// Get order ID...
$orderID=preg_replace('/[^0-9.]/','',$_REQUEST['orderID']);

// delete ingredients from student orders
$order_delete_sql = "DELETE FROM recipe_ingredients WHERE OrderID = $orderID";
$order_delete_query = mysqli_query($dbconnect, $order_delete_sql);

// delete food order
$food_order_delete_sql = "DELETE FROM food_order WHERE OrderID = $orderID";
$food_order_delete_query = mysqli_query($dbconnect, $food_order_delete_sql);

// delete class session
$class_session_delete_sql = "DELETE FROM classsession WHERE ClassSessionID = $orderID";
$class_session_delete_query = mysqli_query($dbconnect, $class_session_delete_sql);

?>

<div class="nice-middle">

<h1>Deletion Success</h1>

<p>Success.  The requested food order/s have been deleted.</p>

</div>
