<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}


$code = "";
$yearlevel = "";

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
    $add_sql = "INSERT INTO `subjects` (`SubjectID`, `Code`, `YearLevel`) VALUES (NULL, '$code', '$yearlevel'); ";
    $add_query = mysqli_query($dbconnect, $add_sql);


        

    // Go back to manage teacher page
    header('Location: index.php?page=../admin/manage_courses');
    }

} // end code that executes when submit button is pressed


    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_course");?>" enctype="multipart/form-data" name="add-course" id="add_course">

<h2>Add a New Course</h2>
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
        <input class="width-70" type="submit" value="Add New Course" />
    </p>

</form>