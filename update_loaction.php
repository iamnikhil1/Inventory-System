<?php
 $id = $_POST['id']; // Hidden field for location ID
 $location_code = trim($_POST['location_code']);
 $company_name = trim($_POST['company_name']);
 $location_name = trim($_POST['location_name']);
 $address = trim($_POST['address']);
 $pincode = trim($_POST['pincode']);
 $city = trim($_POST['city']);
 $state = trim($_POST['state']);
 $country = trim($_POST['country']);
 $contact_no = trim($_POST['contact_no']);
 $whatsapp_no = trim($_POST['whatsapp_no']);
 $email_id = trim($_POST['email_id']);
 $gst_no = trim($_POST['gst_no']);

 // Validate required fields
 if (empty($id) || empty($location_code) || empty($location_name) || empty($address) || empty($pincode) || empty($city) || empty($state) || empty($country) || empty($contact_no)) {
     die("Error: All required fields must be filled!");
 }

$conn = mysqli_connect("localhost", "root", "", "items_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = $conn->prepare("UPDATE location_details  SET location_code=?,company_name=?,location_name=?, address=?, pincode=?, city=?, state=?, country=?, contact_no=?, whatsapp_no=?, email_id=?, gst_no=? WHERE id=?");
$stmt->bind_param("ssssssssssssi", $location_code, $company_name,$location_name, $address, $pincode, $city, $state, $country, $contact_no, $whatsapp_no, $email_id, $gst_no, $id);

 // Execute the statement
 if ($stmt->execute()) {
    // Redirect to location.php after successful update
    header("Location: location.php?update=success");
    exit();
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement
$stmt->close();


// Close database connection
$conn->close();
?>