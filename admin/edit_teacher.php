<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$teacherID=preg_replace('/[^0-9.]/','',$_REQUEST['teacherID']);

// Get details to populate form...
$find_sql="SELECT * FROM `teacher` WHERE `TeacherID` = $teacherID";
$find_query=mysqli_query($dbconnect, $find_sql);
$find_rs=mysqli_fetch_assoc($find_query);

$code = $find_rs['Teacher'];
$username = $find_rs['username'];

$code_error = $username_error = $password_error = "no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    $code = mysqli_real_escape_string($dbconnect, $_POST['code']);
    $username = mysqli_real_escape_string($dbconnect, $_POST['username']);
    $password = mysqli_real_escape_string($dbconnect, $_POST['password']);

    // error checking goes here

    if ($code == "") {
        $has_errors = "yes";
        $code_error = "error-text";
        $code_error_field = "form-error";
        }

    if ($username == "") {
        $has_errors = "yes";
        $username_error = "error-text";
        $username_error_field = "form-error";
        }


    // if there are no errors, add ingredient!!
    if($has_errors != "yes") {
        

    // hash password if it has been changed and set up sql to include new password
    if ($password!= "")
    {

        $hashed = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);
        
        $edit_sql = "UPDATE `teacher` SET `Teacher` = '$code', `username` = '$username', `password` = '$hashed' WHERE `teacher`.`TeacherID` = $teacherID; ";


    } // end edit if password changed

    else {
        // sql does not reset password!!
        $edit_sql = "UPDATE `teacher` SET `Teacher` = '$code', `username` = '$username' WHERE `teacher`.`TeacherID` = $teacherID";

    }


    // run sql to update database
    $edit_query = mysqli_query($dbconnect, $edit_sql);

    // Go back to manage teacher page
    header('Location: index.php?page=../admin/manage_courses');
    }

} // end code that executes when submit button is pressed


    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/edit_teacher&teacherID=$teacherID");?>" enctype="multipart/form-data" name="edit_teacher" id="edit_teacher">

<h2>Edit Teachers</h2>

    <p>
    <input class="width-70 <?php echo $code_field ?>" type = "text" name="code" value="<?php echo $code; ?>" />
    </p>

    <p>
    <input class="width-70 <?php echo $username_field ?>" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" />

    </p>

    <p>
    
    <input class="width-70 <?php echo $password_field ?>" type = "password" name="password" value="" placeholder="Change Password or leave blank to keep existing password"/>
    </p>

    <!-- Submit Button -->
    <p>
        <input class="width-70" type="submit" value="Edit Teacher" />
    </p>

</form>