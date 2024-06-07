<?php include('conectDbBlog.php');?>
<?php

// insert data into table begin
  if(isset($_POST['createAction'])){
    $categoryName=$_POST['categoryName'];
    $categoryStatue=$_POST['categoryStatue'];
    
    $sql="INSERT INTO blogdata(catagory_name, catagory_status)";
    $sql.="VALUES('$categoryName', '$categoryStatue')";
    $exequte = $conn->query($sql);

    if($exequte) {
      echo "<script>alert('data inserted sucessfully'); loaction.reload();</script>";
    } else {
      echo "<script>alert('Oops...! Try Again...'".$conn->error."); loaction.reload();</script>";
    }
  }
// insert data into table end

// update data into table begin
if(isset($_POST['updateAction'])){
  $editCategoryId=$_POST['editCategoryId'];
  $editCategoryName=$_POST['editCategoryName'];
  $editCategoryStatue=$_POST['editCategoryStatue'];

  $sql="UPDATE blogdata 
        SET catagory_name='$editCategoryName', catagory_status='$editCategoryStatue'
        WHERE id ='$editCategoryId'";
  $exequte = $conn->query($sql);

  if($exequte) {
    echo "<script>alert('data update sucessfully'); loaction.reload();</script>";
  } else {
    echo "<script>alert('Oops...! Try Again...'".$conn->error."); loaction.reload();</script>";
  }
}
// update data into table end

// delete data into table begin
if(isset($_POST['deleteAction'])){
  $delCategoryId=$_POST['deleteCategoryId'];

  $sql="DELETE FROM blogdata WHERE id ='$delCategoryId'";
  $exequte = $conn->query($sql);

  if($exequte) {
    echo "<script>alert('data deleted sucessfully'); loaction.reload();</script>";
  } else {
    echo "<script>alert('Oops...! Try Again...'".$conn->error."); loaction.reload();</script>";
  }
}
// delete data into table end
  
     
?>
<?php include ("header.php"); ?>
    <div class="row" style="min-height:350px; margin:50px auto;">
        <div class="col-md-12">
          <!-- create new model button begin -->
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewModelView" style="float:right;">
            Create New
          </button>
          <!-- create new model button end -->
          <br>
          <!-- <button type="button" class="btn btn-primary btn-lg" style="margin-left:92%;font-size:2vmin;background-color:#f5b642;"><a href="create.php"style="text-decoration:none;color:#ffff;">create</a></button> -->
          <table class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Sl no</th>
                <th scope="col">Category</th>
                <th scope="col">Satus</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $sql="SELECT * FROM blogdata";
                $result=$conn->query($sql);
                $count= 0;
                if($result->num_rows>0){
                  while($row=$result->fetch_assoc()){
                    $ExIdData = $row['id'];
                    $ExCategoryName = $row['catagory_name'];
                    $ExStatus = $row['catagory_status'];
                    $count++;
              ?>
                  <tr>
                    <th scope="row"><?php echo $count;?></th>
                    <td><?php echo $ExCategoryName; ?></td>
                    <td><?php  echo $ExStatus;?></td>
                    <td>
                      <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModelView<?php echo $ExIdData;?>">
                        Update
                      </button>
                    </td>
                    <td>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModelView<?php echo $ExIdData;?>">
                        Delete
                      </button>
                    </td>
                  </tr>
                  <!-- update model popup view section begin -->
                  <div class="modal fade" id="updateModelView<?php echo $ExIdData;?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Update</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="category.php" method="post">
                          <div class="modal-body">
                            <input type="hidden" value="<?php echo $ExIdData;?>" name="editCategoryId" style="display:none;">
                            <div class="mb-3">
                              <label for="editCategoryName<?php echo $ExIdData;?>" class="form-label">Category Name</label>
                              <input type="text" class="form-control" id="editCategoryName<?php echo $ExIdData;?>" name="editCategoryName" value="<?php echo $ExCategoryName; ?>" placeholder="Category Name" required>
                            </div>
                            <div class="mb-3">
                              <label for="editCategoryStatue<?php echo $ExIdData;?>" class="form-label">Category Status</label>
                              <select class="form-control" id="editCategoryStatue<?php echo $ExIdData;?>" name="editCategoryStatue" required>
                                <option value="ON" <?php if($ExStatus=='ON'){echo"selected";} ?>>ON</option>
                                <option value="OFF" <?php if($ExStatus=='OFF'){echo"selected";} ?>>OFF</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="updateAction" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- update model popup view section end -->
                  <!--delete model view-->
                  <div class="modal fade" id="deleteModelView<?php echo $ExIdData;?>"tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Delete Data</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="category.php" method="post">
                          <div class="modal-body">
                            <p>Are you sure to delete data?</p>
                          </div>
                          <div class="modal-footer"> 
                            <input type="hidden" value="<?php echo $ExIdData;?>" name="deleteCategoryId" style="display:none;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="deleteAction" class="btn btn-danger">Delete</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!--delete model view-->
              <?php } } ?>
            </tbody>
          </table>
        </div>
    </div>

<!-- create new model popup view section begin -->
<div class="modal fade" id="createNewModelView" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category.php" method="post">
        <div class="modal-body">
        <div class="mb-3">
          <label for="categoryName" class="form-label">Category Name</label>
          <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" required>
        </div>
        <div class="mb-3">
          <label for="categoryStatue" class="form-label">Category Status</label>
          <select class="form-control" id="categoryStatue" name="categoryStatue" required>
            <option value="">--Select One--</option>
            <option value="ON">ON</option>
            <option value="OFF">OFF</option>
          </select>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="createAction" class="btn btn-primary">Add New</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- create new model popup view section end -->
  <?php include ("footer.php"); ?>
