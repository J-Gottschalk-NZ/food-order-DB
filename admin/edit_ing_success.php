<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}


// Initialise variables
$new_ing_name = $_SESSION['Add_Ingredients'];

$new_ing_success_sql = "SELECT * FROM ingredients
JOIN category ON (`category`.`CategoryID` = `ingredients`.`CategoryID`)
WHERE `Ingredient` LIKE '$new_ing_name' 
";
$new_ing_success_query = mysqli_query($dbconnect, $new_ing_success_sql);
$new_ing_success_rs = mysqli_fetch_assoc($new_ing_success_query);

?>

<h2>Ingredient Successfully Edited</h2>

<p>
    Here are the details of the ingredient that has been added to the database.
</p>
<p>
Category: <b><?php echo $new_ing_success_rs['Category']?></b><br />
Ingredient: 
<b><?php echo $new_ing_success_rs['Ingredient']?> (<?php echo $new_ing_success_rs['Units'];?>)</b>
</p>