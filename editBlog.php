<?php 
    include('conectDbBlog.php');
    $pageTitle = "Edit Blog";


    $id=$_GET['b'];
    $sql="SELECT * FROM blog WHERE blogid='$id'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $image=$row['blogimage'];
            $metaTag=$row['metaTag'];
            $blogTitle=$row['blogtitle'];
            $blogId=$row['blogid'];
            $categoryId=$row['blogcategory'];
            $status=$row['statusblog']; 
            $blogText=$row['blogtext'];
        }
    }else{
        echo "<script>window.location.href='blogList.php';</script>";
    }
?>
<?php include('header.php');?>
<div class="row"style="min-height:350px; margin:50px auto;display:flex; justify-content:center; align-item:center;background-color:rgba(0,0,0,0.1);">
   <!-- staring of main form -->
    <div class="col-md-6 lg-6">
            <form class="row g-3" action="editBlog.php?b=<?php echo $id;?>" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="titleBlog" class="form-label">Blog Title <span style="color:red;"> *</span></label>
                    <input type="text" class="form-control" id="titleBlog" name="titleBlog"value="<?php echo $blogTitle;?>"placeholder="blog-title" oninput="setMetatagValue()" required>
                </div>
                <div class="col-md-3">
                    <label for="metaTag" class="form-label">Blog Tag <span style="color:red;"> *</span></label>
                    <input type="meta" class="form-control" value="<?php echo $metaTag;?>" name="metaTag" id="metaTag"placeholder="auto-upload" oninput="blockSpecialChar()"required>
                </div>
                <div class="col-md-3">
                    <label for="selctStatus" class="form-label">Blog Tag <span style="color:red;"> *</span></label>
                    <select class="form-select"name="selectStatus" id="selectStatus"required>
                    <?php
                    if(isset($status)){
                        if($status=='ON'){
                            $selected="selected";
                            $selectedNew="";
                            $statusNew='OFF';
                            ?>
                        <option value="<?php echo $status;?>"<?php echo $selected;?>><?php echo $status;?></option>
                        <option value="<?php echo $statusNew;?>"<?php echo $selectedNew;?>><?php echo $statusNew;?></option>
                        <?php }else{
                            $selected="selected";
                            $selectedNew="";
                            $statusNew='ON';
                        ?>
                        <option value="<?php echo $status;?>"<?php echo $selected;?>><?php echo $status;?></option>
                        <option value="<?php echo $statusNew;?>"<?php echo $selectedNew;?>><?php echo $statusNew;?></option> 
                        <?php } }?>   
                    </select>
                </div>    
                <div class="col-md-4">
                    <label for="selectCategory" class="form-label">Select Catagory <span style="color:red;">*</span></label>
                    <select id="selectCategory" class="form-select" name="selectCategory" required>
                        <?php
                            $sql="SELECT * FROM blogdata";
                            $result=$conn->query($sql);
                            if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){
                                    $ExIdData = $row['id'];
                                    $ExCategoryName = $row['catagory_name'];

                                    if($categoryId==$ExIdData){$selectedData="selected";}else{$selectedData="";}
                        ?> 
                        <option value="<?php echo $ExIdData; ?>" <?php echo $selectedData; ?>><?php echo  $ExCategoryName;?></option>
                        <?php } }?>
                    </select>
                   
                </div>
                <div class="col-md-6">
                    <label for="inputImage" class="form-label">image</label>
                    <input type="file" class="form-control" id="inputImage"name="inputImage"accept=".jpg, .png">
                </div>
                <div class="col-md-2">
                    <?php if(!empty($image)){
                            $destination="upload/".$image;
                    ?>
                        <img id="photoPreview" src="<?php echo $destination; ?>" alt="Uploaded photo" style="max-width:100%; max-height:100%; object-fit:contain" >
                    <?php }else{ ?>
                        <img id="photoPreview" src="https://upload.wikimedia.org/wikipedia/commons/b/b6/Image_created_with_a_mobile_phone.png" alt="Demo photo" style="max-width:100%; max-height:100%; object-fit:contain" > 
                    <?php }?>   
                </div>
                <!-- <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div> -->
                <div class="col-12">
                    <label for="textForBlog" class="form-label">Blog Content <span style="color:red;"> *</span></label>
                    <textarea class="form-control" id="textForBlog" placeholder="Text for blog details"name="textForBlog" rows="7"required ><?php echo $blogText;?></textarea>
                </div>
                
                <!-- <div class="col-12">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                    </div>
                </div> -->
                <div class="col-12">
                    <button type="submit" name="submitAction" id="submitAction" class="btn btn-warning"style="float:right;"onclick="checkRequire();">SUBMIT</button>
                </div>
            </form>
    </div>
        <!-- ending of main form -->
</div>
<?php
    if(isset($_POST['submitAction'])){ 
        $titleBlog=$_POST['titleBlog'];
        $metaTag=$_POST['metaTag'];
        $statusBlog=$_POST['selectStatus'];
        $selectCategory=$_POST['selectCategory'];
        $textForBlog=$_POST['textForBlog'];

        $filenameTemp=$_FILES["inputImage"]["name"];
        if(empty($_FILES["inputImage"]["name"])){
                if(!empty($image)){
                $filename= $image;
            }
        }else{
                if(!empty($image)){
                    $filename= date("mjYHis").$filenameTemp;
                    unlink("upload/".$image);
                }else{
                $filename= date("mjYHis").$filenameTemp;
            }
        }
        $tempname=$_FILES["inputImage"]["tmp_name"];
        $folder="upload/".$filename;
        move_uploaded_file($tempname,$folder);

        $sql="UPDATE blog SET blogtitle='$titleBlog', metaTag='$metaTag', 
                        statusblog='$statusBlog', blogimage='$filename', 
                        blogtext='$textForBlog', blogcategory='$selectCategory'
        WHERE blogid='$id'";
        $result=$conn->query($sql);

        if($result){
            echo "<script>alert('data update sucessfully'); loaction.reload();</script>";
        }else {
            echo "<script>alert('Oops...! Try Again...'".$conn->error."); loaction.reload();</script>";
        }
   } 
?>
<?php include('footer.php');?>
<script>
   const input=document.getElementById('inputImage'); // input data
    const previewPhoto=()=>{
        const file=input.files;
        if(file){
            const fileReader=new FileReader();
            const preview=document.getElementById('photoPreview'); // img preview
            fileReader.onload=function(event){
             preview.setAttribute('src',event.target.result);
            }
            fileReader.readAsDataURL(file[0]);
        }
    }
    input.addEventListener("change",previewPhoto);
    
    let imageInput=document.getElementById('photoPreview');
    imageInput.addEventListener('change',function(e){
        if(e.target.files){
            let imageFile=e.target.files[0];
            var reader=new FileReader();
            reader.onload=function(e){
                var img=document.createElement("img");
                img.onload=function(event)
                {
                    var canvas=document.createElement("canvas");
                    var ctx=canvas.getContext("2d");
                    ctx.drawImage(img,0,0,400,400);


                    var dataurl=canvas.toDataUrl(imageFile.type);
                    document.getElementById('inputImage').src=dataurl;
                }
                img.src=e.target.result;
            }
            reader.readAsDataURL(imageFile);
        }
    });

    function setMetatagValue(){
        let blogTitle = $("#titleBlog").val();
        let extraChar=blogTitle.replace(/[&\/\\#,+()$~`^@|!%""*.?<>{}]/g,"").replace(/ /g,"_").toLowerCase();
        $("#metaTag").val(extraChar);}
    function blockSpecialChar(){
        
        $("#metaTag").val($("#metaTag").val().replace(/[&\/\\#,+()$~`^@|!%""*.?<>{}]/g,"").replace(/ /g,"_").toLowerCase());}

    let a=document.getElemntById("titleBlog");
    let b=document.getElemntById("metaTag");
    let c=document.getElemntById("textForBlog");
    let d=document.getElemntById("selectCategory");
    function checkRequire(){
      if(a.require===true&&b.require==true&&c.require==true&&d.require==true)
      {
        document.querySelector("#submitAction").disable=false;
      }
    }


</script>