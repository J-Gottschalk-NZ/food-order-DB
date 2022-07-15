<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

// Initialise variables
$fn = "";


// figure out which form has been submitted and process it...
if(isset($_REQUEST["fn"]))
    $fn=$_REQUEST["fn"];

if ($fn=="shopping")

{
    // process shopping order
} // end processing shopper order

?>

<div class="nice-middle">

<h1>Welcome to the admin panel</h1>

<p>
Please choose an option below...
</p>

</div>

<hr />


<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/shopping");?>" enctype="multipart/form-data" name="shopping" id="shopping">
    <input type="hidden" name = "fn" value="shopping">

    <h2>Shopping Order</h2>

<p><i>See what needs to be ordered for the practicals in given date range.</i></p>

    Start Date: <input class="<?php echo $date_field; ?>" type="date" name="start_date" value="<?php echo $date; ?>" />

    End Date: <input class="<?php echo $date_field; ?>" type="date" name="end_date" value="<?php echo $date; ?>" />

    <p>
        <input class="submit-size" type="submit" value="Submit" />
</p>

</form>

<hr />



