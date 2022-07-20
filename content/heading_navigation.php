
        
        <div class="box banner">
            
    
            <h1><a class="heading" href="index.php?page=home">Food Ordering System</a></h1>
        </div>    <!-- / banner -->

        <!-- Navigation goes here.  Edit BOTH the file name and the link name -->
        <div class="box nav">
              
                   
                    <?php  
                    
                    if(isset($_SESSION['admin'])) {
                        
                    ?>
                    
                    <a href="index.php?page=../admin/adminpanel" title="Admin Panel">Orders</a> | 
                    <a href="index.php?page=../admin/manage_ingredients" title="Manage Ingredients">Ingredients</a> | 
                    <a href="index.php?page=../admin/manage_courses" title="Manage Courses">Teachers &amp; Courses</a> | 
                    <a href="index.php?page=../admin/logout" title="Log Out">Log Out</a> | 
                   
                    
                    <!-- <a href="index.php?page=../admin/logout" title="Log out"><i class="fa fa-sign-out fa-2x"></i></a> -->
                    
                    &nbsp; &nbsp;
                                        
                    <?php
                        
                    } // end user is logged in if
                    
                    else {
                        ?>
                    
                    <!-- <a href="index.php?page=../admin/login" title="Login">
                        <i class="fa fa-sign-in fa-2x"></i> -->
                        <a href="index.php?page=../admin/login" title="Login">
                        Teacher Login
                    </a>
                    
                    <?php
                    }   // end of login else
                    
                    ?>
                    
            
        </div>    <!-- / nav -->    











