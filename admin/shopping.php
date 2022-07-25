<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

$start_date = ($_POST['start_date']);
$end_date = ($_POST['end_date']);

$nice_start = date("D j M", strtotime($_POST['start_date']));
$nice_end = date("D j M", strtotime($_POST['end_date']));

// echo $start_date."&nbsp; &nbsp;".$end_date;

$order_sql = "SELECT SUM(Quantity), `ingredients`.`Ingredient`, `ingredients`.`Units` FROM classsession 
INNER JOIN food_order ON (`food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`) 
INNER JOIN recipe_ingredients ON ( `food_order`.`OrderID` = `recipe_ingredients`.`OrderID`)
INNER JOIN ingredients ON ( `recipe_ingredients`.`IngredientID` = `ingredients`.`IngredientID`)
WHERE `Date` BETWEEN '$start_date' AND '$end_date' AND `ingredients`.`CategoryID` != 14
GROUP BY `recipe_ingredients`.`IngredientID` 
ORDER BY `ingredients`.`Ingredient` ASC
";

$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_all($order_query, MYSQLI_ASSOC);

$order_count = mysqli_num_rows($order_query);



?>

<div class="nice-middle">

<h2>Shopping Order (<?php echo $nice_start ?> - <?php echo $nice_end ?>)</h2>

<?php

// error if there are no orders for the dates specified 
if ($order_count < 1) {

    ?>

    <div class="error">
        Sorry - there are no food orders for the specified date range.
    </div>

    <br />

    <?php
}

?>

<table>

<?php

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

    ?>
    </td></tr>  <!-- / single cell row -->
    <?php
    
}


?>

</table>

</div>