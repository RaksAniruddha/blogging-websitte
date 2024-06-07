<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbName="myDB";
 $conn =new mysqli($servername,$username,$password,$dbName);
 if($conn->connect_error)
 {
    die("coonection failed:".$conn->connect_error);
 }

//  $sql = "CREATE TABLE MyGuests (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     firstname VARCHAR(30) NOT NULL,
//     lastname VARCHAR(30) NOT NULL,
//     email VARCHAR(50),
//     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//     )";
    
//     if ($conn->query($sql) === TRUE) {
//       echo "Table MyGuests created successfully";
//     } else {
//       echo "Error creating table: " . $conn->error;
//     }


//   $sql="CREATE TABLE table1 ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//                     firstname VARCHAR(30) NOT NULL,
//                     lastname VARCHAR(30) NOT NULL,
//                     email VARCHAR(50),
//                     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";
  
//   if($conn->query($sql)===TRUE){
//     echo"table my guest is created";
//   }else{
//     echo "error create table: ".$conn->error;
//   } 
/*$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com');";
$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Mary', 'Moe', 'mary@example.com');";
$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('Julie', 'Dooley', 'julie@example.com')";*/

// $sql="INSERT INTO myguests (firstname, lastname, email)
//         VALUES ('John', 'Doe', 'john@example.com');";
// $sql.="INSERT INTO myguests (firstname, lastname, email) 
//         VALUES ('avipriya','paul','paulavipriya@gmail.com');";
// $sql.="INSERT INTO myguests (firstname,lastname,email)
//         VALUES('pallav','paul','paulpallav@gmail.com');";


    // if($conn->multi_query($sql)===true)
    // {
    //     echo "insertion occred";
    // }else{
    //     echo "failed".$conn->error;
    // }
    // $conn->close();
    // $sql="INSERT INTO table1(firstname,lastname,email)VALUES('aniruddha','rakshit','rakshitaniruddha1999@gmail.com');";
    // $sql.="INSERT INTO table1(firstname,lastname,email)VALUES('navanita','dutta','duttanavanita54@gmail.com');";
    // $sql.="INSERT INTO table1(firstname,lastname,email)VALUES('ribhujyoti','saha','saharibhu1999@gmail.com');";
    // if($conn->multi_query($sql))
    // {
    //     echo "insertion occerd";
    // }else{
    //     echo $conn->error;
    // }
//     $sql = "SELECT id, firstname, lastname FROM table1";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }

//    $sql="SELECT id, firstname ,lastname from table1 ORDER BY lastname";
//    $result=$conn->query($sql);
//    if($result->num_rows>0)
//    {
//     while($row=$result->fetch_assoc())
//     {
//         echo "id:".$row['id']." -name ".$row['firstname']." ".$row['lastname']."<br>";
//     }
//    }else{
//     echo "0 result";
//    }
//    $sql="UPDATE table1 SET lastname='bhattacharjee'WHERE id=36";
//    if($conn->query($sql))
//    {
//      $sql1="SELECT firstname,lastname FROM table1 WHERE id=36";
//      $result=$conn->query($sql1);
//      if($result->num_rows>0)
//      {
//         while($row=$result->fetch_assoc())
//         {
//             echo $row['firstname']." ".$row['lastname'];  
//         }
//      }
//    }
   $sql="DELETE FROM table1 WHERE id=36";
    if($conn->query($sql))
    {
       $sql1="SELECT id, firstname,lastname FROM table1";
       $result=$conn->query($sql1);;
       while($row=$result->fetch_assoc())
       {
        echo $row['id']." ".$row['firstname']." ".$row['lastname']."<br>";
       }
    }
    $conn->close();
?>