<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$courseID=preg_replace('/[^0-9.]/','',$_REQUEST['courseID']);

echo "Course ID".$courseID;

$cdel_sql = "DELETE FROM `courses` WHERE CourseID = $courseID";
$cdel_query = mysqli_query($dbconnect, $cdel_sql);

header('Location: index.php?page=../admin/manage_courses');


?>