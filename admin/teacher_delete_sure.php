<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

// Get item ID...
$teacherID=preg_replace('/[^0-9.]/','',$_REQUEST['teacherID']);

// Find all class sessions associated with the teacher...
$session_sql = "SELECT * FROM `classsession` WHERE `TeacherID` = $teacherID";
$session_query = mysqli_query($dbconnect, $session_sql);
$session_rs = mysqli_fetch_assoc($session_query);

$session_count = mysqli_num_rows($session_query);

if ($session_count > 0) {

// get sessionID and remove ingredients
do {

$var_session = $session_rs['ClassSessionID'];

$ing_find_sql = "SELECT * FROM `recipe_ingredients` WHERE `OrderID` = $var_session";
$ing_find_query = mysqli_query($dbconnect, $ing_find_sql);
$ing_find_rs = mysqli_fetch_assoc($ing_find_query);

$var_order = $ing_find_rs['OrderID'];
$ing_del = "DELETE FROM `recipe_ingredients` WHERE OrderID = $var_order";
$ing_del_query = mysqli_query($dbconnect, $ing_del);

}

while ($session_rs=mysqli_fetch_assoc($session_query));

// delete session / order
$var_session_delete = $session_rs['ClassSessionID'];
$session_delete = "DELETE FROM `classsession` WHERE `classsession`.`ClassSessionID` = $var_session_delete";
$session_delete_query = mysqli_query($dbconnect, $session_delete);

}

// delete course from teachers / codes
$tc_delete_sql = "DELETE FROM `courses` WHERE `courses`.`TeacherID` = $teacherID";
$tc_delete_query = mysqli_query($dbconnect, $tc_delete_sql);

// delete from teacher table
$teacher_delete = "DELETE FROM `teacher` WHERE `teacher`.`TeacherID` = $teacherID";
$teacher_delete_query = mysqli_query($dbconnect, $teacher_delete);

?>

<h1>Teacher Deleted</h1>

<p>Success.  You have deleted selected teacher.</p>
