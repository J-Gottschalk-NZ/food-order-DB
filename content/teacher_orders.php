<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// Initialise variables
$first = "";
$last = "";
$year_level = "";
$teacher = "";
$teacherID = "";
$period = "";
$product = "";
$comment = "";
$current_date = date('Y-m-d');
$date = "";

$first_error = $last_error = $product_error = $year_level_error = $teacher_error = $period_error = $date_error ="no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Get data from form...
    $first = mysqli_real_escape_string($dbconnect, $_POST['first']);
    $last = mysqli_real_escape_string($dbconnect, $_POST['last']);

    $year_level = mysqli_real_escape_string($dbconnect, $_POST['year_level']);

    $teacherID = mysqli_real_escape_string($dbconnect, $_POST['teacher']);

    if ($teacherID != "")

    {
        $teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
        $teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
        $teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);

        $teacher = $teacher_name_rs["Teacher"];
    }

    $date = mysqli_real_escape_string($dbconnect, $_POST['prac_date']);


    $period = mysqli_real_escape_string($dbconnect, $_POST['period']);
    $product = mysqli_real_escape_string($dbconnect, $_POST['product']);
    $comment = mysqli_real_escape_string($dbconnect, $_POST['comment']);

        // Error checking goes here
    
        // check last name is not blank
        if ($last == "") {
            $has_errors = "yes";
            $last_error = "error-text";
            $last_field = "form-error";
            }

        // check lfirstast name is not blank
        if ($first == "") {
            $has_errors = "yes";
            $first_error = "error-text";
            $first_field = "form-error";
            }

        // if year level is not chosen...
        if ($year_level == "") {
            $has_errors = "yes";
            $year_level_error = "error-text";
            $year_level_field = "form-error";
        }

        // if teacher  is not chosen...
        if ($teacherID == "") {
            $has_errors = "yes";
            $teacher_error = "error-text";
            $teacher_field = "form-error";
        }

        // if date is not chosen...
        if ($date == "") {
            $has_errors = "yes";
            $date_field = "form-error";
        }

        if($date <= $current_date) {
            $has_errors = "yes";
            $period_error = "error-text";
            $date_field = "form-error";
        }

        // if period is not chosen...
        if ($period == "") {
            $has_errors = "yes";
            $period_error = "error-text";
            $period_field = "form-error";
        }

        if ($date=="") {
            $has_errors = "yes";
            $date_error = "error-text";
            $date_field = "form-error";
        }

        // if product is not chosen...
        if ($product =="") {
            $has_errors = "yes";
            $product_error = "error-text";
            $product_field = "form-error";
        }
       
        // **** If we don't have errors, update the DB and move on... ****
        if($has_errors != "yes") {
               
            $recordID_query = mysqli_query($dbconnect, 
                    "INSERT INTO `classsession` (`ClassSessionID`,`TeacherID`, `YearLevel`, `Date`, `Period`) VALUES (NULL,$teacherID, $year_level, '$date', $period);");
            
            $classID=$dbconnect->insert_id;
            

            // Get ClassID
            $add_food_order = mysqli_query($dbconnect, "INSERT INTO `food_order` (`OrderID`, `LastName`, `FirstName`, `Product`, `Comment`, `ClassSessionID`) VALUES (NULL, '$last', '$first', '$product', '$comment', $classID); ");

            // Go to order_ingredients page 
            $_SESSION['Order_Session'] = $classID;
            
            header('Location: index.php?page=add_ingredients');

        }

} // end code that executes when 'submit' button pressed

?>



<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=teacher_orders");?>" enctype="multipart/form-data" name="add_order" id="add_order">

<?php

// get options from database for form dropdowns...
$teacher_sql="SELECT * FROM `teacher` ORDER BY `teacher`.`Teacher` ASC ";
$teacher_query=mysqli_query($dbconnect, $teacher_sql);
$teacher_rs=mysqli_fetch_assoc($teacher_query);

$ingredient_sql="SELECT * FROM `ingredients` ORDER BY `ingredients`.`Ingredient` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

?>

<h2>Food Order Form</h2>
            
<p>
    Please fill in the form below to order food for an upcoming practical.
</p>
    <!-- Extra field with fn defined so we don't get an error message when users go from this form to the ordering form -->
    <input type="hidden" name="fn" value = "">

    <div class="<?php echo $first_error; ?>">
        Please type in your first name
    </div>

    <input class="add-field <?php echo $first_field?>" type="text" name="first" value="<?php echo $first; ?>" placeholder="First Name" />

    <br /><br />

    <div class="<?php echo $last_error; ?>">
        Please type in your last name
    </div>

    <input class="add-field <?php echo $last_field?>" type="text" name="last" value="<?php echo $last; ?>" placeholder="Last Name" />

    <br /><br />

    <div class="<?php echo $year_level_error?>">
    <?php
        if($year_level =="" and $teacherID == "") {
            ?>
            Please choose a year level AND teacher...
            <?php
        }

        elseif ($year_level == "") {
            ?>
            Please choose a year level
            <?php
        }

        elseif ($teacherID == "")
        {
    ?>
        Please choose a teacher
    <?php
        }
        ?>
    </div>

    <!-- Year Level dropdown -->
    <select class="<?php echo $year_level_field; ?>" name="year_level">

    <?php
        if($year_level=="") {

            ?>
            <option value="" selected>Year Level</option>
            <?php
        }

        else {

            ?>
            <option value="<?php echo $year_level; ?>" selected><?php echo $year_level; ?></option>

            <?php
        }

    ?>

        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
    </select>

    <!-- Teacher dropdown -->
    <select class="<?php echo $teacher_field; ?>" name="teacher">

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

    <br /><br >
    
    <!-- Date AND Period errors... -->
    <div class="<?php echo $period_error; ?>">

    <?php if($date == "" && $period == "") {
        ?>
        Please choose a <b>Date</b> and a <b>Period</b>...
        <?php
    }

    elseif ($date <= $current_date && $period == "")
    {
        ?>
        Choose a date <b>that is AFTER today AND choose a period</b>
        <?php
    }

    elseif ($date <= $current_date)

    {
        ?>
        Choose a date <b>that is AFTER today</b>.
        <?php
    }

    elseif ($period=="") {
    ?> 
          Please choose a <b>period</b>...
    <?php    
    }
   ?>

    </div>


    <!-- ***** Date Field is here ****** -->
    Date of Practical: <input class="<?php echo $date_field; ?>" type="date" name="prac_date" value="<?php echo $date; ?>" />


    <select class="<?php echo $period_field; ?>" name="period">

    <?php if ($period=="") {
        ?>
            <option value="" selected>Period</option>
        <?php
    }

    else { ?>  
    
    <option value="<?php echo $period; ?>" selected><?php echo $period; ?></option>
    
    <?php } ?>
        
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>

    <br /><br />

    <div class="<?php echo $product_error; ?>">
        Please type in the product / item you are making
    </div>

    <input class="add-field <?php echo $product_field; ?>" type="text" name="product" value="<?php echo $product; ?>" placeholder="Product Name" />

    <br /><br />
    <p><b>Comment</b> - Use the space below for any special instructions.  For example, if everyone in the class is making the same product and will need the same ingredients, you can specify the quantity to go on each tray below.  Then on the following page, you can simply order in bulk.  For example, for 10 groups, each student might need 100 g of flour (which you would specify below), the bulk order (on the next page) would be for 1,000 g of flour).</p>

    <textarea class="comment-text" name="comment" value="<?php echo $comment ?>">
        <?php echo $comment; ?>
    </textarea>

    <br /><br />                
    
                <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="Continue..." />
    </p>



</form>

