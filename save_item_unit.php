<?php

$x = $_POST['name'];
$y = $_POST['value'];


$conn = mysqli_connect("localhost" ,
"root",
"" ,
"items_info") or die("Connection failed");

$query ="INSERT INTO item_unit (unit,value ) VALUES('{$x}' , '{$y}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
// After the lead is successfully added
header("Location: item_unit.php?message=New lead added successfully");
exit();

?>
