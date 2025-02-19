<?php
$conn = new mysqli("localhost", "root", "", "items_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Retrieve and sanitize form data
$location_code = trim($_POST['location_code']);
$location_name = trim($_POST['location_name']);
$address = trim($_POST['address']);
$pincode = trim($_POST['pincode']);
$company_name = trim($_POST['company_name']);
$city = trim($_POST['city']);
$state = trim($_POST['state']);
$country = trim($_POST['country']);
$contact_no = trim($_POST['contact_no']);
$whatsapp_no = trim($_POST['whatsapp_no']);
$email_id = trim($_POST['email_id']);
$gst_no = trim($_POST['gst_no']);
// Database connection
if (empty($location_code) || empty($location_name) || empty($address) || empty($pincode) || empty($city) || empty($state) || empty($country) || empty($contact_no)) {
    die("Error: All required fields must be filled!");
}


// Prepare and bind
$stmt = $conn->prepare("INSERT INTO location_details(location_code,company_name,location_name, address, pincode, city, state, country, contact_no, whatsapp_no, email_id, gst_no) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $location_code,$company_name, $location_name, $address, $pincode, $city, $state, $country, $contact_no, $whatsapp_no, $email_id, $gst_no);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to location.php after successful submission
        header("Location: http://localhost/Log/location.php");
        exit(); // Ensure script stops execution after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();

// Redirect to contact display page

exit;


// Close database connection
$conn->close();
?>