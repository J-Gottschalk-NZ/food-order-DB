<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

$date = mysqli_real_escape_string($dbconnect, $_POST['prac_date']);

if($date=="") {
    $date = date('Y-m-d');
    }

$nice_date = date("D j M", strtotime($date));

// Get teacher name based on ID
// $teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
// $teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
// $teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);


// Find orders matching date, period and teacher
$order_sql = "SELECT * FROM `classsession` 
INNER JOIN teacher ON (`classsession`.`TeacherID` = `teacher`.`TeacherID`)
INNER JOIN food_order ON (`food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`) 
INNER JOIN recipe_ingredients ON ( `food_order`.`OrderID` = `recipe_ingredients`.`OrderID`)
INNER JOIN ingredients ON ( `recipe_ingredients`.`IngredientID` = `ingredients`.`IngredientID`)

WHERE `Date` = '$date' 
GROUP BY `Period`, `Teacher`
ORDER BY `classsession`.`Period` ASC
";

$order_query = mysqli_query($dbconnect, $order_sql);
$order_rs = mysqli_fetch_assoc($order_query);

$count = mysqli_num_rows($order_query);

?>

<div class="nice-middle">

<h2><?php echo $nice_date ?> - Orders</h2>

<?php 

// if orders exist, retrieve order details
if($count > 0) {

    do {

        if ($order_rs['Period'] == 1) {
            $periodcolor = "period-1";
        }

        else if ($order_rs['Period'] == 2) {
            $periodcolor = "period-2";
        }

        else if ($order_rs['Period'] == 3) {
            $periodcolor = "period-3";
        }

        else if ($order_rs['Period'] == 4) {
            $periodcolor = "period-4";
        }

        else {
            $periodcolor = "period-5";
        }

        ?>
        <div class="period <?php echo $periodcolor ?>">
        P<?php echo $order_rs['Period']; ?>: 
        <a target=”_blank” href="index.php?page=../admin/period_details&date=<?php echo $date; ?>&teacherID=<?php echo $order_rs['TeacherID']; ?>&period=<?php echo $order_rs['Period']; ?>">
        <?php echo $order_rs['Teacher']; ?>
    </a>
        <!-- <br /> -->
    </div>
        <?php

    }

    while ($order_rs=mysqli_fetch_assoc($order_query));

}

else {

    ?>
    <div class = "error">
        There are no classes doing practicals today!
    </div>
    <?php
}

?>

</div>

<br />