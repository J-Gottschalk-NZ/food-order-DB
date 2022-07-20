<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

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
WHERE `Date` BETWEEN '$start_date' AND '$end_date' 
GROUP BY `recipe_ingredients`.`IngredientID`
ORDER BY `ingredients`.`Ingredient` ASC
";

$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_all($order_query, MYSQLI_ASSOC);



?>

<div class="nice-middle">

<h2>Shopping Order (<?php echo $nice_start ?> - <?php echo $nice_end ?>)</h2>

<table>

<?php

foreach ($order_rs as $row) {

    ?>
    <tr><td>    <!-- Single cell row -->
    <?php
    // echo $row["OrderID"]."&nbsp; &nbsp;";
    // echo $row["YearLevel"]."&nbsp;";
    // echo $row["Date"]."&nbsp; &nbsp;";
    // echo $row["Product"]."&nbsp; &nbsp;";
    $arr = $row;
    echo array_values($arr)[0]."&nbsp; &nbsp;";
    echo $row["Units"]."&nbsp; &nbsp;";
    echo $row["Ingredient"]."&nbsp; &nbsp;";
    // echo $row["Quantity"]."&nbsp; &nbsp;";
    // echo $row["Quantity"]."&nbsp; &nbsp;";
    // echo "<br />";
    // echo print_r($row, true)."<br />";
    // $ingredient_totals = implode(", ", $row);
    // echo $ingredient_totals."<br />";
    echo "<br />";

    ?>
    </td></tr>  <!-- / single cell row -->
    <?php
    
}


?>

</table>

</div>