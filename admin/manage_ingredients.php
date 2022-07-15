<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php?page=../admin/login');

}

// initialise ingredient to search

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $to_search = mysqli_real_escape_string($dbconnect, $_POST['to_search']);
}

else {

$to_search = "";
}


// Filter all existing ingredients
$ingredient_sql="SELECT * FROM `ingredients` WHERE `Ingredient` LIKE '%$to_search%' ORDER BY `ingredients`.`Ingredient` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

$count = mysqli_num_rows($ingredient_query);

?>

<div class = "nice-middle">

<h1>Manage Ingredients </h1>

<h3><a href="index.php?page=../admin/new_ingredients" title="Manage Ingredients">Add Ingredients</a></h3>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/manage_ingredients");?>" enctype="multipart/form-data" name="filter_ingredient" id="filter_ingredient">

<input class="width-250" type="text" name="to_search" value="" placeholder="Type here to filter / search" />


        <input class="width-93px" type="submit" value="Search" />


</form>

<br />

<?php 

    if($count==0)
    {
        
    ?>

<div class="error">
    <p>Sorry there are no ingredients that match your search</p>
</div>

<?php
    } // end no items if

else {
?>

<table>

<?php do { ?>

<tr>
    <td><?php echo $ingredient_rs['Ingredient']?> (<?php echo $ingredient_rs['Units']?>)</td>
    <td><a href="index.php?page=../admin/edit_ingredient&ingredientID=<?php echo $ingredient_rs['IngredientID']?>">Edit</a></td>
    <td><a href="index.php?page=../admin/delete_ingredient&ingredientID=<?php echo $ingredient_rs['IngredientID']?>">Delete</a></td>
</tr>

<?php } 
    while ($ingredient_rs=mysqli_fetch_assoc($ingredient_query))
?>

</table>

</div>

<?php

}
?>

<br />


