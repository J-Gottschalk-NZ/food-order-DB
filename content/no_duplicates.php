<?php

// Get Error
$first=$_REQUEST['firstname'];
$last=$_REQUEST['lastname'];
$date=preg_replace('/[^0-9.]/','',$_REQUEST['date']);

$nice_date = date("D j M", strtotime($date));

?>

<div class="nice-middle">

<br />

<div class="error">
    
    <h1>Oops!</h1>

    <p>We already have an order for <?php echo $first; ?> <?php echo $last ?> for <?php echo $nice_date ?>.</p>

    <p><a href="index.php">Click here</a> to try again.</p>

</div>

</br />

</div>
