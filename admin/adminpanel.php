<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// Initialise variables
$fn = "";

// get teacher names / codes  for form dropdowns...
$teacher_sql="SELECT * FROM `teacher` ORDER BY `teacher`.`Teacher` ASC ";
$teacher_query=mysqli_query($dbconnect, $teacher_sql);
$teacher_rs=mysqli_fetch_assoc($teacher_query);

$old_prac = "";
$prac_date = "";
$period = "";
$teacher = "";

$has_errors = "no";

// figure out which form has been submitted and process it...
if(isset($_REQUEST["fn"]))
    $fn=$_REQUEST["fn"];

if ($fn=="class_order")

{
    $prac_date = ($_POST['prac_date']);
    $period = ($_POST['period']);
    $teacherID = ($_POST['teacher']);

    if ($teacherID != "")

    {
        $teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
        $teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
        $teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);

        $teacher = $teacher_name_rs["Teacher"];
    }

    // if date is not chosen...
    if ($prac_date == "") {
        $has_errors = "yes";
        $co_date_field = "form-error";
    }

    // if date is not chosen...
    if ($period == "") {
        $has_errors = "yes";
        $co_period_field = "form-error";
    }

    if ($teacherID == "") {
        $has_errors = "yes";
        $teacher_error = "error-text";
        $co_teacher_field = "form-error";
    }

    if($has_errors=="no")
    {
        // go to class orders
        $to_class_page = "index.php?page=../admin/period_details&date=<?php echo $prac_date; ?>&teacherID=<?php echo $teacherID ?>&period=<?php echo $period ?>";
        header('Location: '.$to_class_page);
    }


} // end checking class order


// Checking / processing for delete old orders form
if ($fn=="old_prac")

{
    $old_prac_date = ($_POST['old_prac']);

    // if date is not chosen...
    if ($old_prac_date == "") {
        $has_errors = "yes";
        $old_prac_field = "form-error";
    }

    if($has_errors=="no") {
        // go to delete old orders page
        $to_delete_orders = "index.php?page=../admin/deleteold&date=<?php echo $old_prac_date; ?>";
        header('Location: '.$to_delete_orders);
    }

}

?>

<div class="nice-middle">

<h1>Welcome to the admin panel</h1>

<p>
Please choose an option below...
</p>



<hr />

  <h2><a href="index.php?page=teacher_orders">Add an Order</a> </h2>

<hr />

</div>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/shopping");?>" enctype="multipart/form-data" name="shopping" id="shopping">
    <input type="hidden" name = "fn" value="shopping">

    <h2>Shopping Order</h2>

<p><i>See what needs to be ordered for the practicals in given date range.</i></p>

    Start Date: <input class="<?php echo $date_field; ?>" type="date" name="start_date" value="<?php echo $date; ?>" />

    End Date: <input class="<?php echo $date_field; ?>" type="date" name="end_date" value="<?php $date; ?>" />

    <p>
        <input class="submit-size" type="submit" value="Submit" />
</p>

</form>

<hr />

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/todays_orders");?>" enctype="multipart/form-data" name="todays_orders" id="todays_orders">
    <input type="hidden" name = "today" value="todays_orders">

<h2>Day Orders</h2>

<p><i>See which classes have practicals for a given day.  You can click the 'submit' button without entering a date to see today's practicals.</i></p>

Date: <input class="<?php echo $date_field; ?>" type="date" name="prac_date" value="" /> &emsp;

<p>
        <input class="submit-size" type="submit" value="Submit" />
</p>

</form>

<hr />

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/adminpanel");?>" enctype="multipart/form-data" name="class_order" id="class_order">
    <input type="hidden" name = "class" value="class_order">

    <!-- Hidden field so that when form is submitted, we can error check -->
    <input type="hidden" name="fn" value="class_order">

    <h2>Class Order</h2>

    <p><i>See what needs to be taken out for a given practical session.</i></p>

    Date: <input class="<?php echo $co_date_field; ?>" type="date" name="prac_date" value="<?php echo $prac_date ?>" /> &emsp;
    Period: <input class="<?php echo $co_period_field; ?>" name="period" value="<?php echo $period ?>" />

    &emsp;

    <!-- Teacher dropdown -->
    <select class="<?php echo $co_teacher_field; ?>" name="teacher">

    <?php 
        if ($teacherID=="") {
    ?>
        <option value="" selected>Teacher...</option>

        <?php
        }

        else {

            ?>
        <option value="<?php echo $teacherID; ?>" selected><?php echo $teacher; ?></option>
            <?php
        }

        ?>

        <!--- get options from database -->
        <?php 

        do {
            ?>
        <option value="<?php echo $teacher_rs['TeacherID']; ?>"><?php echo $teacher_rs['Teacher']; ?></option>

        <?php
            
        }   // end teacher  do loop

        while ($teacher_rs=mysqli_fetch_assoc($teacher_query))

        ?>

    </select>


    <p>
        <input class="submit-size" type="submit" value="Submit" />
</p>

</form>

<hr />

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/adminpanel");?>" enctype="multipart/form-data" name="old_prac" id="old_prac">

    <!-- Hidden field so that when form is submitted, we can error check -->
    <input type="hidden" name="fn" value="old_prac">

<h2>Delete Old Orders</h2>

<p><i>Delete old orders.</i></p>

Date: <input class="<?php echo $old_prac_field; ?>" type="date" name="old_prac" value="" /> &emsp;

<p>
        <input class="submit-size" type="submit" value="Submit" />
</p>

</form>


