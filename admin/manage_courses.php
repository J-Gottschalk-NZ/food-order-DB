<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

// Get Teacher information
$find_teacher_sql="SELECT * FROM `teacher` ORDER BY `teacher`.`Teacher` ASC ";
$find_teacher_query=mysqli_query($dbconnect, $find_teacher_sql);
$find_teacher_rs=mysqli_fetch_assoc($find_teacher_query);

// Get Course information
$find_sql="SELECT * FROM `subjects` ORDER BY `subjects`.`Code` ASC ";
$find_query=mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);

$find_count = mysqli_num_rows($find_query);

// Get Course and Teacher Information (needed for student logins)
$ctinfo_sql = "SELECT * FROM `courses` 
INNER JOIN subjects ON (`courses`.`SubjectID` = `subjects`.`SubjectID`) 
INNER JOIN teacher ON ( `teacher`.`TeacherID` = `courses`.`TeacherID`)
";
$ctinfo_query = mysqli_query($dbconnect, $ctinfo_sql);
$ctinfo_rs = mysqli_fetch_assoc($ctinfo_query);

$ctinfo_count = mysqli_num_rows($ctinfo_query);

?>

<div class = "nice-middle">

<h1>Manage Teachers &amp; Courses</h1>
<p>
    At the start of the year you'll want to...
</p>

<ul>
<li>Add / Delete teachers depending on staff changes</li>
<li>Add any new course codes</li>
<li>Associate Teachers with courses on their timetables</li>
</ul>

<br />
<hr />

<h1>Teachers </h1>

<h3><a href="index.php?page=../admin/add_teacher" title="Manage Ingredients">Add a Teacher</a></h3>


<table>

<?php do { ?>

<tr>
    <td><?php echo $find_teacher_rs['username']?> (<?php echo $find_teacher_rs['Teacher']?>)</td>
    <td><a href="index.php?page=../admin/edit_teacher&teacherID=<?php echo $find_teacher_rs['TeacherID']?>">Edit</a></td>
    <td><a href="index.php?page=../admin/delete_teacher&teacherID=<?php echo $find_teacher_rs['TeacherID']?>">Delete</a></td>
</tr>

<?php } 
    while ($find_teacher_rs=mysqli_fetch_assoc($find_teacher_query))
?>

</table>

<br />
<hr />

<h2>Course Codes</h2>

<h3><a href="index.php?page=../admin/add_course" title="Add Course">Add a New Course</a></h3>

<?php

    // only display table if courses exit
    if($find_count > 0) {

?>

<table>

<?php do { ?>

<tr>
    <td><?php echo $find_rs['Code']?> (<?php echo $find_rs['YearLevel']?>)</td>
    <td><a href="index.php?page=../admin/edit_course&SubjectID=<?php echo $find_rs['SubjectID']?>">Edit</a></td>
    <td><a href="index.php?page=../admin/delete_course&SubjectID=<?php echo $find_rs['SubjectID']?>">Delete</a></td>
</tr>

<?php } 
    while ($find_rs=mysqli_fetch_assoc($find_query))
?>

</table>

<?php 
    }  // end course count if
?>

<br />

<hr />

<h2>Teachers &amp; Courses</h2>

<div class="error">
If a new teacher has joined the team, please <a href="index.php?page=../admin/add_teacher">add them here</a> before you go any further.
</div>

<h3><a href ="index.php?page=../admin/add_tc">Add Teacher to a Course</a></h3>


<?php
    // only display table if results exist
    if($ctinfo_count > 0) {

?>

<p><i>
Remove teachers from a course by using the 'delete' option below.
</i></p>

<table>

<?php do { ?>

    <tr>
        <td><?php echo $ctinfo_rs['Code']." (".$ctinfo_rs['Teacher'].")" ?></td>
        <td><a href="index.php?page=../admin/delete_tc&courseID=<?php echo $ctinfo_rs['CourseID']?>">Delete</a></td>
    </tr>

    <?php } 
    while ($ctinfo_rs=mysqli_fetch_assoc($ctinfo_query))
?>


</table>

<?php
    } // end show course / teacher table if
?>

</div>

<br />


