<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}


$subjectID = preg_replace('/[^0-9.]/','',$_REQUEST['SubjectID']);

$find_sql = "SELECT * FROM `subjects` WHERE `SubjectID` = $subjectID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$code = $find_rs['Code'];
$yearlevel = $find_rs['YearLevel'];

$code_error = $yearlevel_error = "no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    $code = mysqli_real_escape_string($dbconnect, $_POST['code']);
    $yearlevel = mysqli_real_escape_string($dbconnect, $_POST['yearlevel']);

    // error checking goes here

    if ($code == "") {
        $has_errors = "yes";
        $code_error = "error-text";
        $code_error_field = "form-error";
        }

    if ($yearlevel == "") {
        $has_errors = "yes";
        $yearlevel_error = "error-text";
        $yearlevel_error_field = "form-error";
        }


    // if there are no errors, add ingredient!!
    if($has_errors != "yes") {

    // add course to database...
    $edit_sql = "UPDATE `subjects` SET `Code` = '$code', `YearLevel` = '$yearlevel' WHERE `subjects`.`SubjectID` = $subjectID";
    $edit_query = mysqli_query($dbconnect, $edit_sql);


        

    // Go back to manage teacher page
    header('Location: index.php?page=../admin/manage_courses');
    }

} // end code that executes when submit button is pressed


    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/edit_course&SubjectID=$subjectID");?>" enctype="multipart/form-data" name="edit-course" id="edit_course">

<h2>Edit a Course</h2>
<i>All fields are required!</i><br />

    <p>
    <input class="width-70 <?php echo $code_error_field ?>" type = "text" name="code" value="<?php echo $code; ?>" 
    placeholder = "Course code" />
    </p>

    <p>
    <input class="width-70 <?php echo $yearlevel_error_field ?>" type="text" name="yearlevel" value="<?php echo $yearlevel; ?>" placeholder="Year Level" />

    </p>

    <!-- Submit Button -->
    <p>
        <input class="width-70" type="submit" value="Edit Course" />
    </p>

</form>