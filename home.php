<?php include('conectDbBlog.php');
      $pageTitle="HOME PAGE";
?>
<?php include('header.php')?>
<div class="row">
    <?php
    $sql="SELECT * FROM blog";
    $result=$conn->query($sql);
    if($result->num_rows>0){
            while($row=$result->fetch_assoc()){ 
                $blogTitle=$row['blogtitle'];
                $blogImage=$row['blogimage'];
                $blogText=$row['blogtext'];
                $blogId=$row['blogid'];
                if(!empty($blogImage)){
                    $destination="upload/".$blogImage;
                }else{ 
                    $destination="";
                }
    ?>
        <div class="col-md-4">
            <div style="display:block; margin:10px auto; padding:10px; border:1px solid rgba(0,0,0,0.4); border-radius:10px; box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.35);">
                <center>
                    <img src="<?php echo $destination;?>" alt="blog image" style="height:50px;">
                </center>
                <h4><?php echo $blogTitle;?></h4>
                <p><?php if(strlen($blogText)>150){echo substr($blogText,0,20)."  [...]";}else{echo $blogText;}?></p>
                <a href="view.php?b=<?php echo $blogId; ?>">View Details</a>
            </div>
            
        </div>
    <?php } }?>
</div>
<?php include('footer.php')?>