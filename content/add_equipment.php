<?php

// send user to home page if they are trying to hack in.
if (!isset($_SESSION['Order_Session'])) {
    header("Location: index.php");
}

// Initialise variables
$classID = $_SESSION['Order_Session'];

$fn = "";

$ingredient = "start";
$ingredient_name = "";
$ingredient_unit = "";
$name_unit = "";

$amount = 0;
$next_item = "yes";

$ing_amount_error = "";
$ing_amount_error_text = "";
$ingredient_field = "form-error";

$has_errors = "no";

if (isset($_REQUEST["fn"]))
    $fn=$_REQUEST["fn"]; 

    if ($fn == "add_order") {
     // Get data from form...

     $next_item = "no";

     $ingredient = ($_POST['ingredient']);

     if(is_numeric($ingredient) == TRUE) {
        $ingredient_name_sql = "SELECT * FROM `ingredients` WHERE `IngredientID` = $ingredient ";
        $ingredient_name_query = mysqli_query($dbconnect, $ingredient_name_sql);
        $ingredient_name_rs = mysqli_fetch_assoc($ingredient_name_query);

        $ingredient_name = $ingredient_name_rs["Ingredient"];
        $ingredient_unit = $ingredient_name_rs["Units"];

        $name_unit = $ingredient_name." (".$ingredient_unit.")";
     }

        if (is_numeric($ingredient) == FALSE OR 
           $ingredient_name == "start" OR $ingredient_name == "")
           {
            $has_errors = "yes";
            $ing_amount_error = "error-text";
            $ingredient_field = "red";
            $ing_amount_error_text = "Please choose an ingredient!!";
           }


        $amount = ($_POST['amount']);

        if (is_numeric($amount)== FALSE OR $amount <= 0) 
        
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
                $ingredient_name="";
                $name_unit = "";
                $amount = "";
                $has_errors = "no";
                
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


$ingredient_sql="SELECT * FROM category JOIN ingredients ON (`ingredients`.`CategoryID` = `category`.`CategoryID`) WHERE `ingredients`.`CategoryID` = 14 ORDER BY `ingredients`.`Ingredient` ASC ";
$ingredient_query=mysqli_query($dbconnect, $ingredient_sql);
$ingredient_rs=mysqli_fetch_assoc($ingredient_query);

// css to change ingredient box to red if there is a problem with it...

if($ingredient_field == "red" AND $has_errors=="yes")

{

?>

<style>
.select2-container--default .select2-selection--single{
    background-color: #ff9e9e;
;
}

</style>


<?php } ?>


<div class="block-center">

<div class="nice-middle">

<h2>Order your Equipment</h2>
            
<p>
    Please order any special equipment.  If you don't need to order anything, you can just push the I'm Done button.
</p>
<p>
    <!-- Link to go back to ingredients page if necessary -->
Need to go back and order more ingredients?  <a href="index.php?page=add_ingredients">Add them here </a>
</p>

</div>  <!-- / nice middle for start of page -->

    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=add_equipment");?>" enctype="multipart/form-data" name="add_order" id="add_order">
    <input type="hidden" name="fn" value="add_order">
    
    <!-- Start of ingredient row -->
    <div>  


    <?php if($has_errors=="yes") {?>

    <div class="<?php echo $ing_amount_error?>">
        Please enter the equipment needed and a valid amount (eg: 1)
    </div>

    <?php
    }
    ?>

    <!-- ingredient dropdown -->
    

    <select name="ingredient" class="js-example-basic-single" id="ingredient">

    <?php
        if($ingredient_name="") 
        
        {
    ?>

    <option value="" selected>Choose equipment ...</option>

    <?php } 
    
    else { 
        ?>


    <option value="<?php echo $ingredient; ?>" selected><?php echo $name_unit ?></option>

    <?php 

    }

    do {

        if ($ingredient_rs['Units'] == "")
        {
            $display_units = "";
        }
        
        else {
            $display_units = "(".$ingredient_rs['Units'].")";
        }


        ?>
    <option value="<?php echo $ingredient_rs['IngredientID']; ?>"><?php echo $ingredient_rs['Ingredient']." ".$display_units; ?></option>ion>

    <?php
        
    }   // end genre do loop

    while ($ingredient_rs=mysqli_fetch_assoc($ingredient_query))

    ?>

    </select>

    <input class="amount-field <?php echo $amount_field?>" type="text" value="<?php echo $amount ?>" name="amount" placeholder="amount" />

    <button  type="submit" name="add" id="add">Add to Order</button>
    
    </form>

    <!--  End recipe / ingredients section-->

    <!-- Loop through ingredients in order so far... -->

    <h3>Your Order So Far...</h3>

    <?php
    
   echo "<table>";

   foreach ($get_all_rs as $row) {
        echo "<tr><td>".
            $row["Ingredient"].
            "</td><td>".
            round($row["Quantity"], 1)." ".
            $row["Units"].
            "</td><td>".
            "<a href=".htmlspecialchars($_SERVER["PHP_SELF"]).
            "?page=add_ingredients&fn=delingredient&recipeingredientID=".$row["Recipe_IngredientsID"].">Delete</a>".
            "</td></tr>";
    }
    echo "</table>";

    ?>
    


    <form autocomplete="off" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?page=add_equipment");?>" enctype="multipart/form-data" name="finalise_order" id="add_order">

    <input type="hidden" name="fn" value="finalise_order">
   
    <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="Finish &amp; Confirm..." />
    </p>

</div>  <!-- / ingredient row -->


</form>

</div> <!-- / block-center div -->
