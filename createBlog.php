<?php include('conectDbBlog.php');
$pageTitle="create a Blog ";
?>
<?php include('header.php')?>
<?php
    if(isset($_POST['submitAction'])){
        $titleBlog=$_POST['titleBlog'];
        $selectCategory=$_POST['selectCategory'];
        // $inputImage=$_FILES['inputImage'];   
        $textForBlog=$_POST['textForBlog'];
        $metaTag=$_POST['metaTag'];
        $status=$_POST['selectStatus'];
              
        $filenameTemp=$_FILES["inputImage"]["name"];
        $filename= date("mjYHis").$filenameTemp;
        $tempname=$_FILES["inputImage"]["tmp_name"];

        $folder="upload/".$filename;
        move_uploaded_file($tempname,$folder);
        

        $sql="INSERT INTO blog(blogtitle,blogimage,statusblog,metaTag,blogtext,blogcategory)
              VALUES  ('$titleBlog', '$filename','$status', '$metaTag', '$textForBlog', '$selectCategory')";
 
        $exequte = $conn->query($sql);

        if($exequte) {
        echo "<script>alert('data inserted sucessfully'); loaction.reload();</script>";
        } else {
        echo "<script>alert('Oops...! Try Again...'".$conn->error."); loaction.reload();</script>";
        }
    }
?>
<div class="row"style="min-height:350px; margin:50px auto;display:flex; justify-content:center; align-item:center;background-color:rgba(0,0,0,0.1);">
   <!-- staring of main form -->
    <div class="col-md-6 lg-6">
            <form class="row g-3" action="createBlog.php" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="titleBlog" class="form-label">Blog Title <span style="color:red;"> *</span></label>
                    <input type="text" class="form-control" id="titleBlog" name="titleBlog"placeholder="blog-title" oninput="setMetatagValue()" required>
                </div>
                <div class="col-md-3">
                    <label for="metaTag" class="form-label">Blog Tag <span style="color:red;"> *</span></label>
                    <input type="meta" class="form-control" name="metaTag" id="metaTag"placeholder="auto-upload" oninput="blockSpecialChar()"required>
                </div>
                <div class="col-md-3">
                    <label for="selctStatus" class="form-label">Blog Tag <span style="color:red;"> *</span></label>
                    <select class="form-select"name="selectStatus" id="selectStatus"required>
                        <option value="">Choose.....</option>
                        <option value="ON">ON</option>
                        <option value="OFF">OFF</option>
                    </select>
                </div>    
                <div class="col-md-4">
                    <label for="selectCategory" class="form-label">Select Catagory <span style="color:red;">*</span></label>
                    <select id="selectCategory" class="form-select" name="selectCategory" required>
                        <option value="">Choose...</option>
                        <?php
                            $sql="SELECT * FROM blogdata";
                            $result=$conn->query($sql);
                            if($result->num_rows>0){
                                while($row=$result->fetch_assoc()){
                                    $ExIdData = $row['id'];
                                    $ExCategoryName = $row['catagory_name'];
                        ?> 
                            <option value="<?php echo $ExIdData; ?>"><?php echo $ExCategoryName; ?></option>
                        <?php } }?>
                    </select>
                   
                </div>
                <div class="col-md-6">
                    <label for="inputImage" class="form-label">image</label>
                    <input type="file" class="form-control" id="inputImage"name="inputImage"accept=".jpg, .png">
                </div>
                <div class="col-md-2">
                    <img id="photoPreview" src="https://d38b044pevnwc9.cloudfront.net/cutout-nuxt/passport/1-change1.jpg" alt="Demo photo" style="max-width:100%; max-height:100%; object-fit:contain" >
                </div>
                <!-- <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div> -->
                <div class="col-12">
                    <label for="textForBlog" class="form-label">Blog Content <span style="color:red;"> *</span></label>
                    <textarea class="form-control" id="textForBlog" placeholder="Text for blog details"name="textForBlog" rows="7"required ></textarea>
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
<!-- <div class="container">
        <h1>Scan QR Codes</h1>
        <div class="section">
            <div id="my-qr-reader">
            </div>
        </div>
    </div> -->
<?php include('footer.php')?>
<!-- <style>
        body {
        display: flex;
        justify-content: center;
        margin: 0;
        padding: 0;
        height: 100vh;
        box-sizing: border-box;
        text-align: center;
        background: rgb(128 0 0 / 66%);
    }
    .container {
        width: 100%;
        max-width: 500px;
        margin: 5px;
    }
    
    .container h1 {
        color: #ffffff;
    }
    
    .section {
        background-color: #ffffff;
        padding: 50px 30px;
        border: 1.5px solid #b2b2b2;
        border-radius: 0.25em;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
    }
</style> -->
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
    let e=document.getElemntById("selectStatus");
    function checkRequire(){
      if(a.require===true&&b.require==true&&c.require==true&&d.require==true&&e==true)
      {
        document.querySelector("#submitAction").disable=false;
      }
    }

// function domReady(fn) {
//     if (
//         document.readyState === "complete" ||
//         document.readyState === "interactive"
//     ) {
//         setTimeout(fn, 1000);
//     } else {
//         document.addEventListener("DOMContentLoaded", fn);
//     }
// }
 
// domReady(function () {
 
//     // If found you qr code
//     function onScanSuccess(decodeText, decodeResult) {
//         alert("You Qr is : " + decodeText, decodeResult);
//     }
 
//     let htmlscanner = new Html5QrcodeScanner(
//         "my-qr-reader",
//         { fps: 10, qrbos: 250 }
//     );
//     htmlscanner.render(onScanSuccess);
// });
</script>