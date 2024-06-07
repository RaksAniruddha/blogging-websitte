<?php include('conectDbBlog.php');
  $pageTitle="view Page";
?>
<?php include('header.php')?>
<?php
    $id=$_GET['b'];
    $sql="SELECT * FROM blog where blogid='$id'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
           $blogTitle=$row['blogtitle'];
           $blogImage=$row['blogimage'];
           $blogText=$row['blogtext'];
        } 
    }  
?>
<div class="row"style="min-height:100px; margin:50px auto;background-color:rgba(0,0,0,0.1);">
    <div class="col-lg-6 md-6">
        <div class="row g-3">
            <div class="col-lg-6 md-6">
                <figure class="figure">
                    <?php
                    if(!empty($blogImage)){
                        $destination="upload/".$blogImage;
                    }  
                    ?>
                    <img src="<?php echo $destination;?>"class="img-thumbnail" alt="uploaded image">
                    <figcaption class="figure-caption"style="font-size:30px;"><?php echo $blogTitle; ?></figcaption>
                </figure>
            </div>
            <div class="col-lg-6 md-6">
                <p><?php echo $blogText;?></p>
            </div>    
        </div>
    </div>
</div>
<?php include('footer.php')?>