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

// Check that ingredient is not in an existing order
$find_sql = "SELECT * FROM `recipe_ingredients` WHERE `IngredientID` = $ingredientID";
$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

$count = mysqli_num_rows($find_query);

?>

<div class="nice-middle">

<h1>Delete <?php echo $ing_name_rs['Ingredient']; ?></h1>

<?php 

if($count == 1) {

    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $count?> student who has ordered this ingredient.  If you remove the ingredient from the list of available ingredients, it will also delete the ingredient from their order.</p>

    </div>

    <?php
}   // end count warning

elseif ($count > 1) {
    ?>

    <div class="error">

    <p>Are you sure?  You have <?php echo $count?> students who have ordered this ingredient.  If you remove the ingredient from the list of available ingredients, it will also delete the ingredient from their orders.</p>

    </div>

    <?php
}

else {

    ?>
    Are you sure you want to do this?
    <?php

}

?>

<br />

<p>
    <button><a href = "index.php?page=../admin/manage_ingredients">Go back!</a></button>    &nbsp;
    <button><a href="index.php?page=../admin/ing_delete_sure&ingredientID=<?php echo $ingredientID; ?>">I'm sure.  Delete it.</a></button>
</p>

</div>