<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

$date=preg_replace('/[^0-9.]/','',$_REQUEST['date']);
$teacherID=preg_replace('/[^0-9.]/','',$_REQUEST['teacherID']);
$period=preg_replace('/[^0-9.]/','',$_REQUEST['period']);

$nice_date = date("D j M", strtotime($date));

// Get teacher name based on ID
$teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
$teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
$teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);


// Find orders matching date, period and teacher
$order_sql = "SELECT SUM(Quantity), `ingredients`.`Ingredient`, `ingredients`.`Units` FROM classsession 
INNER JOIN food_order ON (`food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`) 
INNER JOIN recipe_ingredients ON ( `food_order`.`ClassSessionID` = `recipe_ingredients`.`OrderID`)
INNER JOIN ingredients ON ( `recipe_ingredients`.`IngredientID` = `ingredients`.`IngredientID`)
WHERE `Date` = '$date' AND TeacherID = $teacherID AND `Period` = $period
GROUP BY `recipe_ingredients`.`IngredientID`
ORDER BY `ingredients`.`Ingredient` ASC
";

$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_all($order_query, MYSQLI_ASSOC);

$count = mysqli_num_rows($order_query);

// if orders exist, retrieve order details
if($count > 0) {

$tray_sql = "SELECT * FROM classsession 
INNER JOIN food_order ON (`food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`) 
INNER JOIN recipe_ingredients ON ( `food_order`.`ClassSessionID` = `recipe_ingredients`.`OrderID`)
INNER JOIN ingredients ON ( `recipe_ingredients`.`IngredientID` = `ingredients`.`IngredientID`)
WHERE `Date` = '$date' AND TeacherID = $teacherID AND `Period` = $period
GROUP BY `food_order`.`LastName`
-- ORDER BY `ingredients`.`Ingredient` ASC
";

$tray_query = mysqli_query($dbconnect, $tray_sql);
$tray_rs = mysqli_fetch_assoc($tray_query);
}



?>

<div class="nice-middle">

<h2>Class Order - <?php echo $nice_date ?>, Period <?php echo $period ?> (<?php echo $teacher_name_rs['Teacher']?>)</h2>

<table>

<?php

if ($count < 1)
{

?>

<div class="error">
    Sorry - there are no orders for the requested class.
</div>

<br />

<?php

}

else {
foreach ($order_rs as $row) {

    ?>
    <tr><td>    <!-- Single cell row -->
    <?php

    $arr = $row;
    $sum_quantity = array_values($arr)[0];
    // echo array_values($arr)[0]."&nbsp; &nbsp;";
    echo round($sum_quantity, 1);
    echo $row["Units"]."&nbsp; &nbsp;";
    echo $row["Ingredient"]."&nbsp; &nbsp;";
    echo "<br />";

    } // end else bracket if we have a result

    ?>
    </td></tr>  <!-- / single cell row -->
    <?php
    
}


?>

</table>

<?php 

if($count > 0)

{

?>

<h1>Order Details / Trays</h1>

<p>Here are the orders for each student / group in the class.</p>

<?php

do {


?>

<div class ="results">

<!-- Display name and product -->
<b><?php echo $tray_rs['FirstName']." ".$tray_rs['LastName']; ?> - <?php echo $tray_rs['Product']?></b>&emsp; 

<a href="index.php?page=../admin/delete_order&ID=<?php echo $tray_rs['OrderID']; ?>" title="Delete order"><i class="fa fa-trash"></i></a>

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
?>


<?php
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
    <?php echo $ing_ordered_rs['Ingredient']?>: <?php echo round($ing_ordered_rs['Quantity'], 1).$ing_ordered_rs['Units'];?>
</td></tr>

<?php

}

while ($ing_ordered_rs=mysqli_fetch_assoc($ing_ordered_query));

?>

</table>

</div>

<br />

<?php

}

while ($tray_rs=mysqli_fetch_assoc($tray_query));

}   // end count if for showing tray orders
?>

</div>