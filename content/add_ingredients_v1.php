<?php

// Initialise variables
$classID = $_SESSION['Order_Session'];
//echo $classID;

$get_all_sql = "SELECT * FROM recipe_ingredients JOIN ingredients ON (`ingredients`.`IngredientID` = `recipe_ingredients`.`IngredientID`) WHERE OrderID = $classID";
$get_all_query = mysqli_query($dbconnect, $get_all_sql);
$get_all_rs = mysqli_fetch_all($get_all_query, MYSQLI_ASSOC);

// echo "<pre>";
// print_r ($get_all_rs);
// echo "</pre>";

// Code below excutes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") { 

        if (is_numeric($_POST['ingredient'])) 
            $ingredient=$_POST['ingredient'];
        else 
            die("Nasty Hacker....");
        

        if (is_numeric($_POST['amount'])) 
            $amount=$_POST['amount']; 
        else 
            die("Nasty Hacker...");
        
        $q=mysqli_query($dbconnect,
            "insert into recipe_ingredients 
                (OrderID, IngredientID,Quantity)
            values
                ($classID,$ingredient,$amount)");

} // end code that executes when 'submit' button pressed

// get ingredients from database for form dropdowns...

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
    
    <!-- Start of ingredient row -->
    <div>  
    <!-- ingredient dropdown -->
    <select name="ingredient">

    <option value="" selected>Choose...</option>

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

    <input class="amount-field" type="text" value="" name="amount" placeholder="amount" />

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
            "</td></tr>";
    }
    echo "</table>";

    ?>
    


    <form autocomplete="off" method="post" action="order_complete">
    
                <!-- Submit Button -->
    <p>
        <input class="submit-size" type="submit" value="I'm Done!" />
    </p>

</div>  <!-- / ingredient row -->


</form>

