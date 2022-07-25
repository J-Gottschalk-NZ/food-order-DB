<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$subjectID=preg_replace('/[^0-9.]/','',$_REQUEST['SubjectID']);

// Check that subject is not associated with a teacher
$find_sql = "SELECT * FROM `courses` WHERE `SubjectID` = subjectID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$ccode_sql = "SELECT * FROM `subjects` ORDER BY `subjects`.`Code` ASC ";
$ccode_query = mysqli_query($dbconnect, $ccode_sql);
$ccode_rs = mysqli_fetch_assoc($ccode_query);

$count = mysqli_num_rows($find_query);

?>

<div class="nice-middle">

<h1>Delete <?php echo $ccode_rs['Code']; ?></h1>

<?php 

if($count == 1) {

    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $count?> teacher associated with this course.
    </div>

    <?php
}   // end count warning

elseif ($count > 1) {
    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $count?> teachers associated with this course.

    </div>

    <?php
}

else {

    ?>
    Are you sure you want to do this?
    <?php

}

?>

<br />

<p>
    <button><a href = "index.php?page=../admin/manage_courses">Go back!</a></button>    &nbsp;
    <button><a href="index.php?page=../admin/course_delete_sure&subjectID=<?php echo $subjectID; ?>">I'm sure.  Delete it.</a></button>
</p>

</div>
