<?php

$x = $_POST['name'];


$conn = mysqli_connect("localhost" ,
"root",
"" ,
"employee_info") or die("Connection failed");

$query ="INSERT INTO designation (name) VALUES('{$x}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
header("Location: http://localhost/Log/designation.php");
// After the lead is successfully added
header("Location: designation.php?message=New lead added successfully");
exit();

?>
