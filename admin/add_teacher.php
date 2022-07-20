<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}


$code = "";
$username = "";
$password = "";

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

    if ($password == "") {
        $has_errors = "yes";
        $password_error = "error-text";
        $password_error_field = "form-error";
        }

    // if there are no errors, add ingredient!!
    if($has_errors != "yes") {

    // hash password
    $hashed = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);

    // add teacher to database...
    $add_sql = "INSERT INTO `teacher` (`TeacherID`, `Teacher`, `username`, `password`) VALUES (NULL, '$code', '$username', '$hashed'); ";
    $add_query = mysqli_query($dbconnect, $add_sql);
        

    // Go back to manage teacher page
    header('Location: index.php?page=../admin/manage_courses');
    }

} // end code that executes when submit button is pressed


    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/add_teacher");?>" enctype="multipart/form-data" name="edit_teacher" id="edit_teacher">

<h2>Add a Teacher</h2>
<i>All fields are required!</i><br />

    <p>
    <input class="width-70 <?php echo $code_error_field ?>" type = "text" name="code" value="<?php echo $code; ?>" 
    placeholder = "Teacher Code" />
    </p>

    <p>
    <input class="width-70 <?php echo $username_error_field ?>" type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" />

    </p>

    <p>
    
    <input class="width-70 <?php echo $password_error_field ?>" type = "password" name="password" value="" placeholder="Password"/>
    </p>

    <!-- Submit Button -->
    <p>
        <input class="width-70" type="submit" value="Add Teacher" />
    </p>

</form>