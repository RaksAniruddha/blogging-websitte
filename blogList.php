<?php 
    include('conectDbBlog.php');
    $pageTitle = "List of Blog";
?>
<?php include('header.php');?>
<?php
   if(isset($_POST['deleteAction'])){
      $deleteBlogId=$_POST['deleteId'];
      $DelImgFile=$_POST['blogImgFile'];
      $sql="DELETE FROM blog WHERE blogid='$deleteBlogId'";
      $exequte=$conn->query($sql);
      if($exequte){
          if(!empty($DelImgFile)){
            unlink("upload/".$DelImgFile);
          }
      }
    }
?>
<table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">image</th>
        <th scope="col">Blog Title</th>
        <th scope="col">Category Title</th>
        <th scope="col">Status</th>
        <th scope="col">Update</th>
        <th scope="col">View Blog</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql="SELECT * FROM blog";
        $result=$conn->query($sql);
        if($result->num_rows>0){
          while($row=$result->fetch_assoc()){
            $image=$row['blogimage'];
            $blogTitle=$row['blogtitle'];
            $blogId=$row['blogid'];
            $categoryId=$row['blogcategory'];
            $status=$row['statusblog']; 
      ?>
        <tr>
          <th scope="row">
            <?php if(empty($image)){ echo "empty"; }else{ ?>  
              <img src="upload/<?php echo $image;?>" style="max-height:50px;">
            <?php } ?>
            </th>
          <td><?php echo $blogTitle;?></td>
          <td>
            <?php  
              $sql1="SELECT * FROM blogdata WHERE id='$categoryId'";
              $result1=$conn->query($sql1);
              if($result1->num_rows>0){
                while($row1=$result1->fetch_assoc()){
                  $categoryName=$row1['catagory_name'];
                  echo $categoryName;
                }
              }
            ?>
          </td>
          <td><?php echo $status;?></td>
          <td>
          <a href="editBlog.php?b=<?php echo $blogId; ?>"><button type="button" class="btn btn-outline-success">Update</button></a>
          </td>
          <td>
          <a href="view.php?b=<?php echo $blogId; ?>"><button type="button" class="btn btn-outline-secondary">View</button></a>
          </td>
          <td><button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModelView<?php echo $blogId; ?>">
                          Delete
              </button>
          </td>
        </tr>     
          <!--delete model view-->
          <div class="modal fade" id="deleteModelView<?php echo $blogId; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Delete Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="blogList.php" method="post">
                    <div class="modal-body">
                      <p>Are you sure to delete data?</p>
                    </div>
                    <div class="modal-footer"> 
                      <input type="hidden" value="<?php echo $image;?>"name="blogImgFile" style="display:none;">
                      <input type="hidden" value="<?php  echo $blogId;?>" name="deleteId" style="display:none;">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" name="deleteAction" class="btn btn-danger">Delete</button>
                    </div>
                  </form>
                </div>
              </div>
          </div>
          <!--delete model view-->
        <?php }}else{ ?>
          <tr><td colspan="10" style="text-align:center;">No Data Found...</td></tr>
        <?php } ?>
    </tbody>
</table>
<?php include('footer.php');?>