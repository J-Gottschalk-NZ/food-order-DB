
        
        <div class="banner logo-text">            
    
            <div class="logo"><h1><a class="heading" href="index.php?page=home"><img src="theme\mhs_logo.png"/></a></h1></div>
            <div class="title-text"><h1>MHS Ingredient Ordering System</h1></div>
        </div>    <!-- / banner -->

        <!-- Navigation goes here.  Edit BOTH the file name and the link name -->
        <div class="nav">
              
                   
                    <?php  
                    // if teachers are logged in
                    if(isset($_SESSION['admin'])) {
                        
                    ?>

                    <div class="linkwrapper">

                    <div class="tools">
                    
                    <a href="index.php?page=../admin/adminpanel" title="Admin Panel">Orders</a> | 
                    <a href="index.php?page=../admin/manage_courses" title="Manage Courses">Teachers &amp; Courses</a> |
                    <a href="index.php?page=../admin/manage_ingredients" title="Manage Ingredients">Ingredients</a>

                    </div>

                    <div class="quicksearch">
                        <!-- Quick Search -->           
                        <form class="quick" method="post" action="index.php?page=../admin/quick_search" enctype="multipart/form-data">

                            <input type="text" name="quick_search" value="" required placeholder="Quick Search..." />

                            <input class="submit" type="submit" name="find_quick" value="&#xf002;" />

                        </form>     <!-- / quick search -->
                    </div>

                    <div class="logout">
                    <a href="index.php?page=../admin/logout" title="Log Out">Log Out</a>
                    </div>
                   
                    
                    </div>  <!-- / linkwrapper -->
                    
                                       
                    <?php
                        
                    } // end user is logged in if
                    
                    ?>
                    
            
        </div>    <!-- / nav -->    











