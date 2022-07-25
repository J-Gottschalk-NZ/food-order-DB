<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}

// Get item ID...
$ingredientID=preg_replace('/[^0-9.]/','',$_REQUEST['ingredientID']);

// Get ingredient name
$ing_name_sql = "SELECT * FROM `ingredients` WHERE `IngredientID` = $ingredientID";
$ing_name_query = mysqli_query($dbconnect, $ing_name_sql);
$ing_name_rs = mysqli_fetch_assoc($ing_name_query);

// delete ingredients from student orders
$order_delete_sql = "DELETE FROM recipe_ingredients WHERE IngredientID = $ingredientID";
$order_delete_query = mysqli_query($dbconnect, $order_delete_sql);

// delete from list of ingredients
$ingredient_delete_sql = "DELETE FROM ingredients WHERE IngredientID = $ingredientID";
$ingredient_delete_query = mysqli_query($dbconnect, $ingredient_delete_sql);

?>

<h1><?php echo $ing_name_rs['Ingredient']; ?> Deleted</h1>

<p>Success.  You have deleted <?php echo $ing_name_rs['Ingredient']; ?> from the list of available ingredients.</p>
