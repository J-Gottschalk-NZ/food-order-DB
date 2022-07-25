<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$teacherID=preg_replace('/[^0-9.]/','',$_REQUEST['teacherID']);

// get teacher
$teachfind_sql = "SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID";
$teachfind_query = mysqli_query($dbconnect, $teachfind_sql);
$teachfind_rs = mysqli_fetch_assoc($teachfind_query);

// Check that subject is not associated with a teacher
$find_sql = "SELECT * FROM `courses` WHERE `TeacherID` = $teacherID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$session_sql = "SELECT * FROM `classsession` WHERE `TeacherID` = $teacherID ";
$session_query = mysqli_query($dbconnect, $session_sql);
$session_rs = mysqli_fetch_assoc($session_query);

$session_count = mysqli_num_rows($session_query);

?>

<div class="nice-middle">

<h1>Delete <?php echo $teachfind_rs['Teacher']; ?></h1>

<?php 

if($session_count == 1) {

    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $session_count ?> food order associated with this teacher and that will be deleted when the teacher is removed.
    </div>

    <?php
}   // end count warning

elseif ($session_count > 1) {
    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $session_count ?> food orders associated with this teacher and they will be deleted when the teacher is removed.
    </div>

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
    <button><a href="index.php?page=../admin/teacher_delete_sure&teacherID=<?php echo $teacherID; ?>">I'm sure.  Delete it.</a></button>
</p>

</div>