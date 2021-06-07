
<?php
  include "includes/header.php";
?>
      <div class="content">
        <div class="container-fluid">

          
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">All Categories List:</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            <i class="material-icons">bug_report</i> Category
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table table-hover">
                    <thead class="text-warning">
                      <th>Serial</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Action</th>
                    </thead>
                    <tbody>

                    <!-- read all category -->
                    <?php
                    $query = "SELECT * FROM wp_category";
                    $result = mysqli_query($db,$query);
                    $count = 0;
                    while($row = mysqli_fetch_assoc($result)){
                      $c_id     = $row['c_id'];
                      $c_name   = $row['c_name'];
                      $c_desc   = $row['c_desc'];
                      $count++;
                    ?>
                      <tr>
                        <td><?php echo $count;?></td>
                        <td><?php echo $c_name;?></td>
                        <td><?php echo $c_desc;?></td>
                        <td class="td-actions text-right">
                              <a href="category.php?editId=<?php echo $c_id;?>" type="button" rel="tooltip"       title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">edit</i>
                              </a>
                              <a href="category.php?deleteId=<?php echo $c_id;?>" type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                <i class="material-icons">close</i>
                              </a>
                            </td>
                      </tr>
                    <?php
                    }

                    ?>
                    </tbody>
                  </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Add New Category</h4>
                  <p class="card-category">New employees on 15th September, 2016</p>
                </div>
                <div class="card-body table-responsive">
                <form method="POST">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category Name</label>
                          <input type="text" class="form-control" name="cat_name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Category Description</label>
                          <div class="form-group">
                            <label class="bmd-label-floating"> Don't add duplicate category. Please check before adding!</label>
                            <textarea class="form-control" rows="5" name="cat_description"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-primary " value="Add Category" name="add_cat">
                    <!-- <div class="clearfix"></div> -->
                  </form>

                  <!-- add new category -->
                  <?php
                  if (isset($_POST['add_cat'])) {
                    $cat_name         = $_POST['cat_name'];
                    $cat_description  = $_POST['cat_description'];

                    if (empty($cat_name) || empty($cat_description)) {
                      echo "<div class='alert alert-danger'>Please fill all the information!</div>";
                    }else{
                      $query = "INSERT INTO wp_category(c_name,c_desc) VALUES('$cat_name','$cat_description')";
                      $result = mysqli_query($db,$query);
  
                      if($result){
                        header('Location: category.php');
                      }else{
                        die("Add Category Error!".mysqli_error($db));
                      }
                    }

                    
                  }
                  ?>

                <!-- delete category -->
                <?php
                if (isset($_GET['deleteId'])) {
                  
                  $table = 'wp_category';
                  $table_id = 'c_id';
                  $delete_id = $_GET['deleteId'];
                  $page_url = 'category.php';

                  delete($table,$table_id,$delete_id,$page_url); 
                }
                
                
                
                ?>

                </div>
              </div>
            </div>
            <!-- edit -->
            <div class="col-lg-6 col-md-12"></div>
            <div class="col-lg-6 col-md-12">
              <?php
              if(isset($_GET['editId'])){
                $edit_cat = $_GET['editId'];

                $query = "SELECT * FROM wp_category WHERE c_id = '$edit_cat'";
                $result = mysqli_query($db,$query);
                while ($row = mysqli_fetch_assoc($result)) {
                  $c_name = $row['c_name'];
                  $c_desc = $row['c_desc'];
                }
                
                ?>
                <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Edit Category</h4>
                  <p class="card-category">Edit your category information.</p>
                </div>
                <div class="card-body table-responsive">
                <form method="POST">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Category Name</label>
                          <input type="text" value="<?php echo $c_name;?>" class="form-control" name="cat_name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Category Description</label>
                          <div class="form-group">
                            <textarea class="form-control" rows="5" name="cat_description" value="<?php echo $c_desc;?>"><?php echo $c_desc;?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-primary " value="Edit Category" name="edit_cat">
                    <!-- <div class="clearfix"></div> -->
                  </form>
                </div>
              </div>
                <?php
              }
              ?>


              <!-- update information -->
              <?php
              if(isset($_POST['edit_cat'])){
                $cat_name         = $_POST['cat_name'];
                $cat_description  = $_POST['cat_description'];

                //update
                $query = "UPDATE wp_category SET c_name='$cat_name', c_desc='$cat_description' WHERE c_id='$edit_cat'";
                $result = mysqli_query($db,$query);
                if($result){
                header('Location: category.php');
                }else{
                die("Edit Category Error!".mysqli_error($db));
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>


      <?php
      
      include "includes/footer.php";
      
      ?>