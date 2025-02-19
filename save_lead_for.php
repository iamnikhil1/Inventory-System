<?php

$x = $_POST['name'];
$y = $_POST['status'];


$conn = mysqli_connect("localhost" ,
"root",
"" ,
"leads_details") or die("Connection failed");

$query ="INSERT INTO for_lead (name , status ) VALUES('{$x}' , '{$y}')";

$data = mysqli_query($conn , $query);

if(!$conn){
    die("Connection failed");
}
header("Location: http://localhost/Log/lead_for.php");
// After the lead is successfully added
header("Location: lead_for.php?message=New lead added successfully");
exit();

?>
