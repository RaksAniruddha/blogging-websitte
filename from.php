<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="from.php" method="post">
        <label for="name">name</label><br>
        <input type="text" id="name" name="name"placeholder="enter your name"required ><br>
        <label for="emailId">email id</label><br>
        <input type="email" id="emailId"name="emailId" placeholder="enter your mailid" required ><br>
        <label for="male">male</label>
        <input type="radio"id="male" name="gender"value="male">
        <label for="female">female</label>
        <input type="radio"id="female"name="gender" value="female"> 
        <label for="others">others</label>
        <input type="radio"id="others"name="gender"value="others">
        <input type="submit" name="submit"id="submit" value="submit" onclick="valid()">
    </form>
    <script>
        let name=document.querySelector("#name");
        let emailId=document.querySelector("#emailId");
        function valid(){
            if(name.require===true&&emailId.require===true)
            {
               document.querySelector("#submit").disable=false;
            }else{
                document.querySelector("#submit").disable=true;
            }
        }
    </script>
</body>
</html>

<?php
  // define variables and set to empty values
  $name = $email = $gender =  "";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["emailId"]);
    // $website = test_input($_POST["website"]);
    // $comment = test_input($_POST["comment"]);
    if(isset($_POST["gender"])){
        $gender = test_input($_POST["gender"]);
    }
  }
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>
  