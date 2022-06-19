<?php

// Initialise variables
$classID = $_SESSION['Order_Session'];

$ingredient = "";
$amount = "";

$ingredient_error = $amount_error = "";

$has_errors = "no";

// Code below excutes when the form is submitted...
    $fn=$_REQUEST["fn"]; 
    if ($fn == "add_order") {
     // Get data from form...

     $ingredient = ($_POST['ingredient']);

        if (is_numeric($ingredient) == FALSE OR 
           $ingredient == "")
           {
            $has_errors = "yes";
            $ingredient_error = "error-text";
            $ingredient_field = "form-error";
           }


        $amount = ($_POST['amount']);

        if (is_numeric($amount)== FALSE OR 
            $amount == "") 
        
            {
                $has_errors = "yes";
                $amount_error = "error-text";
                $amount_field = "form-error";
               }
        
        if ($has_errors == "no")

        {
        $q=mysqli_query($dbconnect,
            "insert into recipe_ingredients 
                (OrderID, IngredientID,Quantity)
            values
                ($classID,$ingredient,$amount)");
        }
    }  

    elseif ($fn=="finalise_order")
    {
        $q=mysqli_query($dbconnect,
            "UPDATE `food_order` SET `Food_Order_Status` = 'closed' WHERE `food_order`.`ClassSessionID` = $classID; ");

            header('Location: index.php?page=order_complete');
    }
    elseif ($fn=="delingredient")
    {
            if  (is_numeric($_REQUEST["recipeingredientID"]))
            {
                $recipeingredient=$_REQUEST["recipeingredientID"];
                $q=mysqli_query($dbconnect,"delete from recipe_ingredients where OrderID=$classID and Recipe_IngredientsID=$recipeingredient");
                            }
            else {
                echo "Hacker Attempt....";
                die();
            }
    }

// } // end code that executes when 'submit' button pressed

// get ingredients from database for form dropdowns...
$get_all_sql = "SELECT * FROM recipe_ingredients JOIN ingredients ON (`ingredients`.`IngredientID` = `recipe_ingredients`.`IngredientID`) WHERE OrderID = $classID";
$get_all_query = mysqli_query($dbconnect, $get_all_sql);
$get_all_rs = mysqli_fetch_all($get_all_query, MYSQLI_ASSOC);


$ingredient_sql="SELECT * FROM `ingredients` ORDER BY `ingredients`.`Ingredient` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

?>

<h2>Order your Ingredients and Equpiment</h2>
            
<p>
    Please order your ingredients.  Remember to add in any special equipment that you will need.  Note the UNITS!!
</p>

     
    <p><b>Please enter your ingredients / specific equipment followed by the amount needed</b></p>

    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=add_ingredients");?>" enctype="multipart/form-data" name="add_order" id="add_order">
    <input type="hidden" name="fn" value="add_order">
    
    <!-- Start of ingredient row -->
    <div>  

    <div class="<?php echo $ingredient_error ?>">

    <?php 
        if($ingredient == "") {
            ?>
            Please choose an ingredient
            <?php
        }
    ?>

    </div>
    <!-- ingredient dropdown -->
    <select name="ingredient" class="<?php $ingredient_field ?>">

    <?php
        if($ingredient="") {
    ?>

    <option value="" selected>Choose...</option>

    <?php } 
    
    else { ?>

        <option value="<?php echo $ingredient; ?>" selected> <?php echo $ingredient; ?></option>

    <?php 

    }?>

    <!--- get options from database -->
    <?php 
    do {
        ?>
    <option value="<?php echo $ingredient_rs['IngredientID']; ?>"><?php echo $ingredient_rs['Ingredient']." (".$ingredient_rs['Units'].")"; ?></option>

    <?php
        
    }   // end genre do loop

    while ($ingredient_rs=mysqli_fetch_assoc($ingredient_query))

    ?>

    </select>

    <div class="<?php echo $amount_error; ?>">
    Please enter an amount
    </div>

    <input class="amount-field <?php echo $amount_field?>" type="text" value="<?php $amount ?>" name="amount" placeholder="amount" />

    <button  type="submit" name="add" id="add">Add More</button>
    
    </form>

    <!--  End recipe / ingredients section-->

    <!-- Loop through ingredients in order so far... -->

    <?php
    
   echo "<table>";

   foreach ($get_all_rs as $row) {
        echo "<tr><td>".
            $row["Ingredient"].
            "</td><td>".
            $row["Quantity"]." ".
            $row["Units"].
            "</td><td>".
            "<a href=".htmlspecialchars($_SERVER["PHP_SELF"]).
            "?page=add_ingredients&fn=delingredient&recipeingredientID=".$row["Recipe_IngredientsID"].">Delete</a>".
            "</td></tr>";
    }
    echo "</table>";

    ?>
    


    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=add_ingredients");?>" enctype="multipart/form-data" name="finalise_order" id="add_order">

    <input type="hidden" name="fn" value="finalise_order">
   
    <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="I'm Done!" />
    </p>

</div>  <!-- / ingredient row -->


</form>

