<?php

$x = $_POST['name'];
$y = $_POST['description'];

$conn = mysqli_connect("localhost" ,
"root",
"" ,
"items_info") or die("Connection failed");

$query ="INSERT INTO items_list(code ,description ) VALUES('{$x}' , '{$y}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
// After the lead is successfully added
header("Location: items_list.php?message=New lead added successfully");
exit();

?>
