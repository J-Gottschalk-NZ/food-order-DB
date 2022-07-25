<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

$to_find = ($_POST['quick_search']);
$current_date = date('Y-m-d');


$tray_sql = "SELECT * FROM classsession 
INNER JOIN food_order ON (`food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`) 
INNER JOIN recipe_ingredients ON ( `food_order`.`ClassSessionID` = `recipe_ingredients`.`OrderID`)
INNER JOIN ingredients ON ( `recipe_ingredients`.`IngredientID` = `ingredients`.`IngredientID`)
WHERE `Date` > $current_date AND `FirstName` LIKE '%$to_find%' OR `LastName` LIKE '%$to_find%'
GROUP BY `food_order`.`LastName`
-- ORDER BY `ingredients`.`Ingredient` ASC
";

$tray_query = mysqli_query($dbconnect, $tray_sql);
$tray_rs = mysqli_fetch_assoc($tray_query);

$count = mysqli_num_rows($tray_query);

?>

<div class="nice-middle">

<h2>Search Results for <?php echo $to_find; ?></h2>

<?php

// if we have results, display them...

if ($count > 0) {

    do {

        $prac_date = $tray_rs['Date'];
        $nice_date = date("D j M", strtotime($prac_date));


    // Get teacher name based on ID

    $teacherID = $tray_rs['TeacherID'];

    $teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
    $teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
    $teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);

?>
<div class="results">
<!-- Display name and product -->
<b><?php echo $tray_rs['FirstName']." ".$tray_rs['LastName']; ?> - <?php echo $tray_rs['Product']?></b>&emsp; 

<a href="index.php?page=../admin/delete_order&ID=<?php echo $tray_rs['OrderID']; ?>" title="Delete order"><i class="fa fa-trash"></i></a>

<br /><br />

<p><b class="error-text"><?php echo $nice_date?> , Period <?php echo $tray_rs['Period']?> (<?php echo $teacher_name_rs['Teacher']; ?>)</b></p>

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

</div>  <!-- / results -->

<br />

<?php
    }

    while ($tray_rs=mysqli_fetch_assoc($tray_query));

} // end if we have results

else {
// if no results, say the search had no results

?>

<div class="error">

Sorry there were not results for your search.

</div>

<?php

}

?>



</div>

<br />



