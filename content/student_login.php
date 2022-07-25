<?php

// get course and teacher code from form
$ccode = mysqli_real_escape_string($dbconnect, $_POST['ccode']);
$teacher = mysqli_real_escape_string($dbconnect, $_POST['teacherID']);

// Attempt to find course and teacher in database...
$login_sql="SELECT * FROM `courses` 
INNER JOIN subjects ON (`courses`.`SubjectID` = `subjects`.`SubjectID`) 
INNER JOIN teacher ON ( `teacher`.`TeacherID` = `courses`.`TeacherID`)
WHERE Teacher = '$teacher' AND Code = '$ccode'
";
$login_query=mysqli_query($dbconnect,$login_sql);
$login_rs = mysqli_fetch_assoc($login_query);

$login_count = mysqli_num_rows($login_query);

$teacherID = $login_rs['TeacherID'];
$yearlevel = $login_rs['YearLevel'];
    
// if code and teacher found, log in!
if($login_count == 1) {
    
    // password matches
    echo 'Password is valid!';
    $_SESSION['student']=$login_rs['username'];
    header("Location: index.php?page=place_order&teacherID=$teacherID&yearlevel=$yearlevel");
    
}   // end valid password if

// invalid password
else {
     echo 'Invalid course / teacher code.';
    unset($_SESSION);
    $login_error = "Invalid course / teacher code";
    header("Location: index.php?page=home&student_error=$login_error");
    
}   // end invalid password else



?>

<p> Helooo</p>