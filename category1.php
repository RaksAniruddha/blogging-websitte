<?php include("header.php")?>
<?php
  $servername="localhost";
  $username="root";
  $password="";
  $dbname="aniBlog";
  $conn=new mysqli($servername,$username,$password,$dbname);
  if($conn->connect_error)
  {
    die("connection failed: ".$conn->connect_error);
  }
  if(isset($_POST['createCategorySubmit'])){
    $createCategoryName=$_POST['createCategoryName'];
    $createCategoryStatus=$_POST['createCategoryStatue'];
  $sql="INSERT INTO blogdata1(category_name,category_status)VALUES(' $createCategoryName',' $createCategoryStatus');";
   $execute=$conn->query($sql);
   if($execute)
   {
     echo "<script>alert('data inserted');location.reload();</script>";
   }else{
    echo "<script>alert('opps....sorry');location.reload();</script>";
   }
  }

  if(isset($_POST['editCategorySubmit'])){
    $editCategoryID=$_POST['editCategoryID']; 
    $editCategoryName=$_POST['editCategoryName'];
    $editCategoryStatue=$_POST['editCategoryStatue'];
  //update start
    $sql="UPDATE blogdata1 
          SET category_name='$editCategoryName', category_status='$editCategoryStatue' 
          WHERE id='$editCategoryID'";

    if($conn->query($sql)){
      echo "<script>alert('update sucessfully');loaction.reload();</script>";
    }else{
      echo "<script>alert('opps.....');loaction.reload();</script>";
    }
  }
  //update end
  //delete start
  if(isset($_POST['deleteCategory']))
  {
    $delCategoryId=$_POST['deleteCategoryId'];
    $sql="DELETE FROM blogdata1 WHERE id='$delCategoryId'";
    if($conn->query($sql)){
      echo "<script>alert('complete delete data');location.reload();</script>";
    }else{
      echo "<script>alert('opps....');location.reload();</script>";
    }
  }
  //delete end
?>
<div class="row"style="min-height:350px;margin:50px auto;">
  <div class="col-md-12">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"style="float:right">
    create
    </button>
  </div>
  <table class="table table-success table-striped">
    <thead>
      <tr>
        <th scope="col">SL NO</th>
        <th scope="col">category</th>
        <th scope="col">category status</th>
        <th scope="col">Update</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $sql="SELECT * FROM blogdata1";
        $result=$conn->query($sql);
        $count=0;
        if($result->num_rows>0){
        // if($result->$num_rows>0){
          while($row=$result->fetch_assoc()){
            $ExIdData = $row['id'];
            $ExCategoryName = $row['category_name'];
            $ExStatus = $row['category_status'];
            $count++;
      ?>
      <tr>
        <th scope="row"><?php echo"$count";?></th>
        <td><?php echo"$ExCategoryName";?></td>
        <td><?php echo" $ExStatus";?></td>
        <td>
              <!-- Button trigger modal -->
          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $ExIdData;?>">
          Update
          </button>
        </td>
        <td>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $ExIdData;?>">
          delete
        </button> 
        </td>
      </tr>
      <!-- create update modal -->
        <div class="modal fade" id="updateModal<?php echo $ExIdData;?>" tabindex="-1"  aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="category1.php"method="post"> 
                <input type="hidden" value="<?php echo $ExIdData;?>"id="editCategoryID<?php echo $ExIdData;?>"name="editCategoryID" style="hidden;">          
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editCategoryName<?php echo $ExIdData;?>" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editCategoryName<?php echo $ExIdData;?>"name="editCategoryName" >
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryStatue<?php echo $ExIdData;?>"class="form-label">Category Status</label>
                            <select class="form-control"id="editCategoryStatue<?php echo $ExIdData;?>"name="editCategoryStatue"required>
                                <option value="ON">ON</option>
                                <option value="OFF">OFF</option>
                            </select>
                      </div>
                    </div> 
                    <div class="modal-footer">
                        <button type="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit"id="editCategorySubmit<?php echo $ExIdData;?>" name="editCategorySubmit"class="btn btn-primary">update</button>
                    </div>
                </form>    
            </div>
          </div>
        </div>
      <!-- end of update modal -->
       <!-- create delete modal -->
        <div class="modal fade" id="deleteModal<?php echo $ExIdData;?>" tabindex="-1"  aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="category1.php"method="post">           
                    <div class="modal-body">
                        <div class="mb-3">
                          <p>are you sure?</p>
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <input type="hidden"name="deleteCategoryId" value="<?php echo $ExIdData;?>" id="deleteCategoryId<?php echo $ExIdData;?>"style="display:none"required>
                        <button type="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="deleteCategory"class="btn btn-danger">delete</button>
                    </div>
                </form>    
            </div>
          </div>
        </div>
      <!-- end of delete modal -->
      <?php }}?>
    </tbody>
  </table>
</div>
<!-- create create model -->
<div class="modal fade" id="createModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">create </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category1.php"method="post">           
            <div class="modal-body">
                <div class="mb-3">
                    <label for="createCategoryName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="createCategoryName"name="createCategoryName" >
                </div>
                <div class="mb-3">
                    <label for="createCategoryStatue"class="form-label">Category Status</label>
                    <select class="form-control"id="createCategoryStatue"name="createCategoryStatue">
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
               </div>
            </div> 
            <div class="modal-footer">
                <button type="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit"id="createCategorySubmit" name="createCategorySubmit"class="btn btn-primary">create</button>
            </div>
        </form>    
    </div>
  </div>
</div>
<!-- finish of create model -->
<!-- create update modal -->
<!-- <div class="modal fade" id="updateModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category1.php"method="post"> 
        <input type="hidden" vallue=""name="editCategoryID" style="hidden;">          
            <div class="modal-body">
                <div class="mb-3">
                    <label for="editCategoryName" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="editCategoryName"name="editCategoryName" >
                </div>
                <div class="mb-3">
                    <label for="editCategoryStatue"class="form-label">Category Status</label>
                    <select class="form-control"id="editCategoryStatue"name="editCategoryStatue">
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
               </div>
            </div> 
            <div class="modal-footer">
                <button type="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit"id="editCategorySubmit" name="editCategorySubmit"class="btn btn-primary">update</button>
            </div>
        </form>    
    </div>
  </div>
</div> -->
  <!-- end of update modal -->
  <!-- create delete modal
<div class="modal fade" id="deleteModal" tabindex="-1"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="category1.php"method="post">           
            <div class="modal-body">
                <div class="mb-3">
                   <p>are you sure?</p>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit"id="deleteCategory" name="deleteCategory"class="btn btn-danger">delete</button>
            </div>
        </form>    
    </div>
  </div>
</div> -->
  <!-- end of delete modal -->

<?php include("footer.php")?>