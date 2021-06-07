<?php
  include "includes/header.php";
?>

      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          
        <?php
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // view user
        if($do == 'Manage'){
            
        }
        //add user
        else if($do == 'add'){
            
        }
        //edit user
        else if($do == 'edit'){

        }
        //update user
        else if($do == 'update'){

        }
        //delete user
        else if($do == 'delete'){

        }

        ?>


        </div>
      </div>


<?php    
include "includes/footer.php";     
?>