<?php

// check user is logged in, if they are not go back to login page
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');

}


// Get item ID...
$ingredientID=preg_replace('/[^0-9.]/','',$_REQUEST['ingredientID']);

// Get all existing ingredients to populate ingredient checker
$ingredient_sql="SELECT * FROM ingredients JOIN category ON (`ingredients`.`CategoryID` = `category`.`CategoryID`) 
WHERE `IngredientID` = $ingredientID ORDER BY `IngredientID` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

// Get categories
$categories_sql = "SELECT * FROM `category` ORDER BY `category`.`Category` ASC ";
$categories_query = mysqli_query($dbconnect, $categories_sql);
$categories_rs = mysqli_fetch_assoc($categories_query);


$new_ing_name = $ingredient_rs['Ingredient'];
$new_ing_unit = $ingredient_rs['Units'];
$category = $ingredient_rs['Category'];
$category_ID = $ingredient_rs['CategoryID'];


$new_cat_error = $new_ing_name_error = $new_ing_unit_error = "no-error";

$has_errors = "no";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    // Get data from form...
    $category_ID = mysqli_real_escape_string($dbconnect, $_POST['new_cat']);

    if($category_ID != "")

    {
        $category_name_sql = "SELECT * FROM `category` WHERE `CategoryID` = $category_ID";
        $category_name_query = mysqli_query($dbconnect, $category_name_sql);
        $category_rs = mysqli_fetch_assoc($category_name_query);

        $category = $category_rs["Category"];
    }


    $new_ing_name = mysqli_real_escape_string($dbconnect, $_POST['new_ing_name']);
    $new_ing_unit = mysqli_real_escape_string($dbconnect, $_POST['new_ing_unit']);

    // error checking goes here

    // check ingredient name is not blank
    if ($new_ing_name == "") {
        $has_errors = "yes";
        $new_ing_name_error = "error-text";
        $new_ing_name_field = "form-error";
        }

    if ($category_ID=="") {
        $has_errors = "yes";
        $new_cat_error = "error-text";
        $new_cat_field = "form-error";
    }


    // if there are no errors, add ingredient!!
    if($has_errors != "yes") {
        $add_ingredient_sql = "UPDATE `ingredients` SET `CategoryID` = '$category_ID', `Ingredient` = '$new_ing_name', `Units` = '$new_ing_unit' WHERE `ingredients`.`IngredientID` = $ingredientID; ";
        $add_ingrdient_query = mysqli_query($dbconnect, $add_ingredient_sql);

            // Go to success page
    $_SESSION['Add_Ingredients'] = $new_ing_name;
    header('Location: index.php?page=../admin/edit_ing_success');
    }

} // end code that executes when submit button is pressed


// Get all existing ingredients to populate ingredient checker
$ingredient_sql="SELECT * FROM `ingredients` ORDER BY `ingredients`.`Ingredient` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

// Get categories
$categories_sql = "SELECT * FROM `category` ORDER BY `category`.`Category` ASC ";
$categories_query = mysqli_query($dbconnect, $categories_sql);
$categories_rs = mysqli_fetch_assoc($categories_query);

    ?>

<form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=../admin/edit_ingredient&ingredientID=$ingredientID");?>" enctype="multipart/form-data" name="new_ingrdient" id="new_ingrdient">

<h2>Edit Ingredient</h2>


    <div class="<?php echo $new_cat_error; ?>">
        Please choose a category
    </div>

    <select class = "add-field <?php echo $new_cat_field; ?>" name="new_cat">

    <?php
        if($category_ID=="") {
            ?>
        <option value="" selected>Choose a category...</option>
            <?php
        }

        else {
            ?>
        <option value="<?php echo $category_ID?>;" selected><?php echo $category; ?></option>
            <?php
        }

    // Get Categories from database
    do{

?>
    <option value="<?php echo $categories_rs['CategoryID']?>"><?php echo $categories_rs['Category']?></option>
<?php
    }

    while ($categories_rs=mysqli_fetch_assoc($categories_query))

    ?>

    </select>

    <br /><br />

    
    <div class="<?php echo $new_ing_name_error ?>">

    <?php

    if($new_ing_name == "" and $new_ing_unit == "")

    {?> Please enter an ingredient name AND choose a unit<?php } 
    
    elseif ($new_ing_name == "")
    {?> Please enter an ingredient name <?php } 

    elseif ($new_ing_unit == "")
    {?> Please choose a unit <?php } 
    ?>


    </div>

    <input class="width-70 <?php echo $new_ing_name_field?>" type="text" name="new_ing_name" value="<?php echo $new_ing_name; ?>" placeholder="New Ingredient Name" />

    <select class="width-18 <?php echo $new_unit_field?>" name="new_ing_unit">

    <?php
    if($new_ing_unit=="") {

        ?>
        <option value="" selected>Choose a unit</option>
        <?php

    }

    else {

        ?>
        <option value="<?php echo $new_ing_unit; ?>" selected><?php echo $new_ing_unit; ?></option>
        <?php
    }

    ?>


        <!-- <option value="">Choose a unit</option> -->
        <option value="g">g</option>
        <option value="mL">mL</option>
        <option value="sheet/s">Sheet/s</option>
        <option value="">None (-)</option>
    </select>

    <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="Edit Ingredient" />
    </p>

</form>