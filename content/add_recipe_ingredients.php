<?php
session_start();
include("config.php");
include("functions.php");

// Connect to database...
$dbconnect=mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$number = count($_POST["recipe_ingredient"]);

if ($number > 0)
{
    for($i=0; $i<$number; $i++)  
    {  
         if(trim($_POST["recipe_ingredient"][$i] != ''))  
         {  
              $sql = "INSERT INTO `test_ingredients` (`testID`, `Ingredient_Name`) VALUES('".mysqli_real_escape_string($connect, $_POST["recipe_ingredient"][$i])."')";  
              mysqli_query($connect, $sql);  
         }  
    }  
    echo "Data Inserted";  
}

else {
    echo "Enter at least one ingredient";
}

?>