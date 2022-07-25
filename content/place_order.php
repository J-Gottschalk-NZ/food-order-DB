<?php

// Initialise variables
$first = "";
$last = "";

// check to see if year level and teacher have been set
// ie: prevent users from trying to circumvent student login

if (!isset($_GET['yearlevel']) or !isset($_GET['teacherID']))
{
    header("Location: index.php");
}

$year_level=preg_replace('/[^0-9.]/','',$_REQUEST['yearlevel']);
$teacherID=preg_replace('/[^0-9.]/','',$_REQUEST['teacherID']);

// get teacher name
$teacher_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID";
$teacher_query = mysqli_query($dbconnect, $teacher_sql);
$teacher_rs = mysqli_fetch_assoc($teacher_query);

$teacher = $teacher_rs['Teacher'];
$period = "";
$product = "";

$current_date = date('Y-m-d');
$date = "";

$first_error = $last_error = $product_error = $year_level_error = $teacher_error = $period_error = $date_error ="no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Get data from form...
    $first = mysqli_real_escape_string($dbconnect, $_POST['first']);
    $last = mysqli_real_escape_string($dbconnect, $_POST['last']);

    $date = mysqli_real_escape_string($dbconnect, $_POST['prac_date']);


    $period = mysqli_real_escape_string($dbconnect, $_POST['period']);
    $product = mysqli_real_escape_string($dbconnect, $_POST['product']);

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

        // if date is not chosen...
        if ($date == "") {
            $has_errors = "yes";
            $date_field = "form-error";
        }

        // if period is not chosen...
        if ($period == "") {
            $has_errors = "yes";
            $period_error = "error-text";
            $period_field = "form-error";
        }

        // use period error because text for date / period in the same place
        if ($date=="") {
            $has_errors = "yes";
            $period_error = "error-text";
            $date_field = "form-error";
        }

        // check practical date is in the future (ie: tomorrow or later)
        // use period error because text for date / period in the same place
        if($date <= $current_date) {
            $has_errors = "yes";
            $period_error = "error-text";
            $date_field = "form-error";
        }

        // if product is not chosen...
        if ($product =="") {
            $has_errors = "yes";
            $product_error = "error-text";
            $product_field = "form-error";
        }

        // check for duplicates based on date, firstname and lastname   
        $isduplicate = "SELECT * FROM `food_order` 
        INNER JOIN classsession ON ( `food_order`.`ClassSessionID` = `classsession`.`ClassSessionID`)
        WHERE `LastName` = '$last' AND `FirstName` = '$first' AND `Date` = '$date'";
        $isduplicate_query = mysqli_query($dbconnect, $isduplicate);
        $isduplicate_rs = mysqli_fetch_assoc($isduplicate_query);

        $isduplicate_count = mysqli_num_rows($isduplicate_query);
        
        if ($isduplicate_count > 0) {
            $has_errors = "yes";

                header("Location: index.php?page=no_duplicates&firstname=$first&lastname=$last&date=$date");
        }
      
        // **** If we don't have errors, update the DB and move on... ****
        if($has_errors != "yes") {
              
            $recordID_query = mysqli_query($dbconnect, 
                    "INSERT INTO `classsession` (`ClassSessionID`,`TeacherID`, `YearLevel`, `Date`, `Period`) VALUES (NULL,$teacherID, $year_level, '$date', $period);");
            
            $classID=$dbconnect->insert_id;
            

            // Get ClassID
            $add_food_order = mysqli_query($dbconnect, "INSERT INTO `food_order` (`OrderID`, `LastName`, `FirstName`, `Product`, `ClassSessionID`) VALUES (NULL, '$last', '$first', '$product', $classID); ");

            // Go to order_ingredients page 
            $_SESSION['Order_Session'] = $classID;
            
            header('Location: index.php?page=add_ingredients');

        }

} // end code that executes when 'submit' button pressed

?>



<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=place_order&teacherID=$teacherID&yearlevel=$year_level");?>" enctype="multipart/form-data" name="add_order" id="add_order">

<h2>Food Order Form - Year <?php echo $year_level ?> (<?php echo $teacher ?>)</h2>

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


                 
    
                <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="Continue..." />
    </p>



</form>

