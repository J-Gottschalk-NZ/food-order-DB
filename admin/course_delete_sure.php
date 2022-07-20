<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

// Get item ID...
$subjectID=preg_replace('/[^0-9.]/','',$_REQUEST['subjectID']);

// delete subject from Teachers and Courses
$tcfind_sql = "SELECT * FROM `courses` WHERE `SubjectID` = $subjectID";
$tcfind_query = mysqli_query($dbconnect, $tcfind_sql);
$tcfind_rs = mysqli_fetch_assoc($tcfind_query);

// delete course from teachers / codes
$tc_delete_sql = "DELETE FROM `courses` WHERE `courses`.`SubjectID` = $subjectID";
$tc_delete_query = mysqli_query($dbconnect, $tc_delete_sql);

// delete from course list
$cdel_sql = "DELETE FROM `subjects` WHERE `subjects`.`SubjectID` = $subjectID";
$cdel_query = mysqli_query($dbconnect, $cdel_sql);

?>

<h1>Course Deleted</h1>

<p>Success.  You have deleted the course.</p>
