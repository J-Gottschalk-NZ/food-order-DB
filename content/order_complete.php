<?php

// send user to home page if they are trying to hack in.
if (!isset($_SESSION['Order_Session'])) {
   header("Location: index.php");
}

$classID = $_SESSION['Order_Session'];
$int_classID = intval( $classID );

$dtp = "SELECT * FROM `classsession` WHERE `ClassSessionID` = $classID";
$dtp_query = mysqli_query($dbconnect, $dtp);
$dtp_rs = mysqli_fetch_assoc($dtp_query);

$date = $dtp_rs['Date'];
$nice_date = date("D j M", strtotime($date));
$teacherID = $dtp_rs['TeacherID'];
$period = $dtp_rs['Period'];

$food_details_sql = "SELECT * FROM `food_order` WHERE `ClassSessionID` = $classID";
$food_details_query = mysqli_query($dbconnect, $food_details_sql);
$food_details_rs = mysqli_fetch_assoc($food_details_query);

$first = $food_details_rs['FirstName'];
$last = $food_details_rs['LastName'];
$product =$food_details_rs['Product'];

$tray_sql = "SELECT * FROM food_order WHERE ClassSessionID = $int_classID";
$tray_query = mysqli_query($dbconnect, $tray_sql);
$tray_rs = mysqli_fetch_assoc($tray_query);

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // send students to home page when done
    if (!isset($_SESSION['admin'])) {
        header('Location: index.php');
    
    }

    // send teachers to admin panel when done
    else {
        $_SESSION['Order_session'] = "";
        unset($_SESSION['Order_Session']);
        header('Location: index.php?page=../admin/adminpanel');
    }
    
}

?>

<div class="nice-middle">

<h2>Food Order Confirmation</h2>
            
<p>
   Please double check your order for <b class="error-text"> <?php echo $nice_date; ?>, Period <?php echo $period; ?></b>.  If there are ingredients missing, <a href="index.php?page=add_ingredients">go back and add them</a>.
</p>

<div class ="results">

<!-- Display name and product -->
<b><?php echo $tray_rs['FirstName']." ".$tray_rs['LastName']; ?> - <?php echo $tray_rs['Product']?></b>&emsp; 


<br /><br />

<?php
if ($tray_rs['Comment'] != "") {


    $show_comment = str_replace("\n", "<br />", $tray_rs['Comment']);

    ?>

    <div class="blue">

    <?php echo $show_comment; ?>

</div>

    <?php
}

    $orderID = $tray_rs['OrderID'];

    // get ingredients for each order...
    $ing_ordered_sql = "SELECT * FROM `recipe_ingredients` 
    JOIN ingredients ON (`ingredients`.`IngredientID`=`recipe_ingredients`.`IngredientID`)
    WHERE `OrderID` = $orderID ORDER BY `ingredients`.`Ingredient` ASC";
    $ing_ordered_query = mysqli_query($dbconnect, $ing_ordered_sql);
    $ing_ordered_rs = mysqli_fetch_assoc($ing_ordered_query);

?>

<table>

<?php

// List ingredients
do {

    ?>

<tr><td>
    <?php echo $ing_ordered_rs['Ingredient']?>: <?php echo round($ing_ordered_rs['Quantity'],1).$ing_ordered_rs['Units'];?>
</td></tr>

<?php

}

while ($ing_ordered_rs=mysqli_fetch_assoc($ing_ordered_query));

?>

</table>

<br />

</div>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=order_complete");?>" enctype="multipart/form-data" name="order_complete" id="order_complete">

<p><input class="submit-size" type="submit" name="all done" value="All Done!" /></p>


</form>


    
</div>
