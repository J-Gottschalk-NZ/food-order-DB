<?php

// Initialise variables
$classID = $_SESSION['Order_Session'];

$fn = "";

$ingredient = "";
$ingredient_name = "";

$amount = "";
$next_item = "yes";

$ing_amount_error = "";

$has_errors = "no";


// Code below excutes when the form is submitted...
    $fn=$_REQUEST["fn"]; 

    if ($fn == "add_order") {
     // Get data from form...

     $next_item = "no";

     $ingredient = ($_POST['ingredient']);

     if($ingredient != "") {
        $ingredient_name_sql = "SELECT * FROM `ingredients` WHERE `IngredientID` = $ingredient ";
        $ingredient_name_query = mysqli_query($dbconnect, $ingredient_name_sql);
        $ingredient_name_rs = mysqli_fetch_assoc($ingredient_name_query);

        $ingredient_name = $ingredient_name_rs["Ingredient"];
     }

        if (is_numeric($ingredient) == FALSE OR 
           $ingredient == "")
           {
            $has_errors = "yes";
            $ing_amount_error = "error-text";
            $ingredient_field = "form-error";
           }


        $amount = ($_POST['amount']);

        if (is_numeric($amount)== FALSE OR 
            $amount == "") 
        
            {
                $has_errors = "yes";
                $ing_amount_error = "error-text";
                $amount_field = "form-error";
               }
        
        if ($has_errors == "no")

        {
        $q=mysqli_query($dbconnect,
            "insert into recipe_ingredients 
                (OrderID, IngredientID,Quantity)
            values
                ($classID,$ingredient,$amount)");

                // reset ingredient and amount
                $ingredient = "";
                $amount = "";
                $next_item = "yes";
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

<h2>Order your Ingredients</h2>
            
<p>
    Please order your ingredients.  Note the UNITS (mostly g / mL)!!
</p>

     
    <p><b>Please enter your ingredients / specific equipment followed by the amount needed</b></p>

    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=add_ingredients");?>" enctype="multipart/form-data" name="add_order" id="add_order">
    <input type="hidden" name="fn" value="add_order">
    
    <!-- Start of ingredient row -->
    <div>  

    <div class="<?php echo $ing_amount_error ?>">

    <?php 
        if($ingredient == "" and $amount == "") {
            ?>
            Please choose an ingredient AND an amount
            <?php
        }

        elseif ($ingredient == "") {
            ?>
            Please choose an ingredient
            <?php
        }

        elseif ($amount == "") {

            ?> 
            Please choose an amount 
            <?php
        }

        elseif (is_numeric($amount) == FALSE)
        {
            ?>
            Your amount MUST be a number only (no text)
            <?php
        }

    ?>

    </div>
    <!-- ingredient dropdown -->
    <select name="ingredient" class="<?php echo $ingredient_field ?>">

    <?php
        if($ingredient="" OR $next_item="yes") {
    ?>

    <option value="" selected>Choose...</option>

    <?php } 
    
    else { ?>

        <option value="<?php echo $ingredient; ?>" selected> <?php echo $ingredient_name; ?></option>

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

