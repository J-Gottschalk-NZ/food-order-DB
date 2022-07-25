<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// get options from database for form dropdowns...
$teacher_sql="SELECT * FROM `teacher` ORDER BY `teacher`.`Teacher` ASC ";
$teacher_query=mysqli_query($dbconnect, $teacher_sql);
$teacher_rs=mysqli_fetch_assoc($teacher_query);

$code_sql = "SELECT * FROM `subjects` ORDER BY `Code`";
$code_query = mysqli_query($dbconnect, $code_sql);
$code_rs = mysqli_fetch_assoc($code_query);

// initialise values
$subjectID = "";
$teacherID = "";

$subjectID_error = $teacherID_error = "no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    $subjectID = mysqli_real_escape_string($dbconnect, $_POST['subjectID']);
    $teacherID = mysqli_real_escape_string($dbconnect, $_POST['teacherID']);

    // error checking goes here

    if ($subjectID == "") {
        $has_errors = "yes";
        $subjectID_error = "error-text";
        $subjectID_field = "form-error";
        }

    if ($teacherID == "") {
        $has_errors = "yes";
        $teacherID_error = "error-text";
        $teacherID_field = "form-error";
        }

    // Get Teacher name to hold value in form if code not entered
    if ($teacherID != "")

    {
        $teacher_name_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID ";
        $teacher_name_query = mysqli_query($dbconnect, $teacher_name_sql);
        $teacher_name_rs = mysqli_fetch_assoc($teacher_name_query);

        $teacher = $teacher_name_rs["Teacher"];
    }

    if ($subjectID != "")

    {
        $ccode_sql = "SELECT * FROM `subjects` WHERE `SubjectID` = $subjectID";
        $ccode_query = mysqli_query($dbconnect, $ccode_sql);
        $ccode_rs = mysqli_fetch_assoc($ccode_query);

        $ccode = $ccode_rs["Code"];
    }


    // if there are no errors, add ingredient!!
    if($has_errors != "yes") {

    // add course to database...
    $add_sql = "INSERT INTO `courses` (`CourseID`, `SubjectID`, `TeacherID`) VALUES (NULL, $subjectID, $teacherID); ";
    $add_query = mysqli_query($dbconnect, $add_sql);


    // Go back to manage teacher page
    header('Location: index.php?page=../admin/manage_courses');
    }

} // end code that executes when submit button is pressed


    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_tc");?>" enctype="multipart/form-data" name="add-tc" id="add_tc">

<h2>Add a Teacher to a Course</h2>
<i>All fields are required!</i><br />

    <!-- Teacher dropdown -->
    <select class="<?php echo $teacherID_field; ?>" name="teacherID">

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

&emsp;

    <!-- Subject / Course Code drop down -->
    <select class="<?php echo $subjectID_field; ?>" name="subjectID">

    <?php 
        if ($subjectID=="") {
    ?>
        <option value="" selected>Course Code...</option>

        <?php
        }

        else {

            ?>
        <option value="<?php echo $subjectID; ?>" selected><?php echo $ccode; ?></option>
            <?php
        }

        ?>

        <!--- get options from database -->
        <?php 

        do {
            ?>
        <option value="<?php echo $code_rs['SubjectID']; ?>"><?php echo $code_rs['Code']; ?></option>

        <?php
            
        }   // end teacher  do loop

        while ($code_rs=mysqli_fetch_assoc($code_query))

        ?>

    </select>


    <!-- Submit Button -->
    <p>
        <input class="width-70" type="submit" value="Add Teacher to Course" />
    </p>

</form>