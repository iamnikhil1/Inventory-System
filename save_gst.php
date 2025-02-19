<?php

$x = $_POST['name'];
$y = $_POST['percentage'];


$conn = mysqli_connect("localhost" ,
"root",
"" ,
"items_info") or die("Connection failed");

$query ="INSERT INTO gst (code ,percentage ) VALUES('{$x}' , '{$y}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
// After the lead is successfully added
header("Location: gst.php?message=New lead added successfully");
exit();

?>
