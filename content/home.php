<?php
// unset session any old order sessions

if(isset($_SESSION['Order_session']))
    $_SESSION['Order_session'] = "";
	unset($_SESSION['Order_Session']);
?>

<br />

<div class = "login-wrapper">

<div class="student-login">

<h1>Student Login</h2>

<p><i>Not sure of the course code / teacher code?  Please look on your timetable (or ask your teacher).</i></p>

<form action="index.php?page=../content/student_login" method="post">

<p><input class="submit-size" name="ccode" placeholder="Course Code"/></p>
<p><input class="submit-size" name="teacherID" placeholder="Teacher Code" /></p>

<?php
if(isset($_GET['student_error'])) {
    
    ?>
	<span class="error"><?php echo $_GET['student_error'] ?></span>
    
	<?php
}
?>

<p><input class="submit-size" type="submit" name="student_login" value="Log In" /></p>

</form>

</div>

<div class="teacher-login">
<h1>Teacher Login</h1>

<form action="index.php?page=../admin/adminlogin" method="post">
    
    <p><input class="submit-size" name="username" placeholder="Username" /></p>
    <p><input class="submit-size" name="password" type="password" placeholder="Password" /></p>
    
<?php
if(isset($_GET['error'])) {
    
    ?>
	<span class="error"><?php echo $_GET['error'] ?></span>
    
	<?php
}
?>
    
    <p><input class="submit-size" type="submit" name="login" value="Log In" /></p>
    
</form>
</div>      <!-- / end teacher login div -->

</div>      <!-- / end login wrapper div -->

<br />