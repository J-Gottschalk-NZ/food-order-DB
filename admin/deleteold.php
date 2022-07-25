<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// Get today's date for checking we are not trying to delete things in the future...
// Also, put it in format which can beb compared with date from form
$current_date = date('Ymd');

// Get item ID...
$date=preg_replace('/[^0-9.]/','',$_REQUEST['date']);

$nice_date = date("D j M", strtotime($date));

// Get Class Sessions
$order_sql = "SELECT * FROM `classsession` WHERE `Date` <= '$date'";
$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_assoc($order_query);

$count = mysqli_num_rows($order_query);

?>

<div class="nice-middle">

<h1>Delete Orders</h1>



<?php 

if($count > 0) {

    if($date > $current_date)

    {

        ?>
    <div class="error">

    <p><b>WARNING</b></p>

    <p>The date you have specified is in the future.  Proceeding may result in the deletion of orders that have not yet been filled for practicals that have not yet been completed.</p>

    <p>You probably don't want to do that!!</p>

    </div>

        <?php

    }

    ?>



<p>
Proceeding will delete all orders up to and including <?php echo $nice_date; ?>. 
</p>

<p>
    <button><a href = "index.php?page=../admin/adminpanel">Go back!</a></button>    &nbsp;
    <button><a href="index.php?page=../admin/deleteold_sure&date=<?php echo $date; ?>">Delete <?php echo $count ?> orders</a></button>
</p>

    <?php
}   // end count warning


else {

    ?>
   <div class="error">

        There are no orders in the database that were made on / before <?php echo $nice_date; ?> so there is nothing to be deleted.

    </div>
    <?php

}

?>

<br />
</div>

