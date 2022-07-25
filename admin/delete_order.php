<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$orderID=preg_replace('/[^0-9.]/','',$_REQUEST['ID']);

// Get Class Session
$order_sql = "SELECT * FROM `food_order` WHERE `ClassSessionID` = $orderID";
$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_assoc($order_query);


// Check that ingredient is not in an existing order
$find_sql = "SELECT * FROM `recipe_ingredients` WHERE `OrderID` = $orderID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$count = mysqli_num_rows($find_query);

?>

<div class="nice-middle">

<h1>Delete Order</h1>

<p>
Proceeding will delete <?php echo $order_rs['FirstName']; ?> <?php echo $order_rs['LastName'] ?>'s order for <?php echo $order_rs['Product'] ?> ingredients.
</p>

<?php 

if($count > 0) {

    ?>


    <p>This order has <?php echo $count?> ingredients associated with it.</p>

    <?php
}   // end count warning


else {

    ?>
    Are you sure you want to do this?
    <?php

}

?>

<br />

<p>
    <button><a href = "index.php?page=../admin/adminpanel">Go back!</a></button>    &nbsp;
    <button><a href="index.php?page=../admin/order_delete_sure&orderID=<?php echo $orderID; ?>">Proceed &amp; delete.</a></button>
</p>

</div>