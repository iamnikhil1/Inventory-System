<?php

$x = $_POST['name'];
$y = $_POST['description'];
$z = $_POST['type'];

$conn = mysqli_connect("localhost" ,
"root",
"" ,
"items_info") or die("Connection failed");

$query ="INSERT INTO hsn_sac(code ,description,type ) VALUES('{$x}' , '{$y}', '{$z}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
// After the lead is successfully added
header("Location: hsn.php?message=New lead added successfully");
exit();

?>
