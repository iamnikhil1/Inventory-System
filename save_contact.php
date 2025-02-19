<?php
// Retrieve and sanitize form data
$source_lead = isset($_POST['source_lead']) ? htmlspecialchars(trim($_POST['source_lead'])) : null;
$for_lead = isset($_POST['for_lead']) ? htmlspecialchars(trim($_POST['for_lead'])) : null;
$lead_priority = isset($_POST['lead-priority']) ? htmlspecialchars(trim($_POST['lead-priority'])) : null;
$contact_person = isset($_POST['contact-person']) ? htmlspecialchars(trim($_POST['contact-person'])) : null;
$company_name = isset($_POST['company-name']) ? htmlspecialchars(trim($_POST['company-name'])) : null;
$mobile_no = isset($_POST['mobile-no']) ? htmlspecialchars(trim($_POST['mobile-no'])) : null;
$whatsapp_no = isset($_POST['whatsapp-no']) ? htmlspecialchars(trim($_POST['whatsapp-no'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$address = isset($_POST['address']) ? htmlspecialchars(trim($_POST['address'])) : null;
$country = isset($_POST['country']) ? htmlspecialchars(trim($_POST['country'])) : null;
$state = isset($_POST['state']) ? htmlspecialchars(trim($_POST['state'])) : null;
$city = isset($_POST['city']) ? htmlspecialchars(trim($_POST['city'])) : null;
$pincode = isset($_POST['pincode']) ? htmlspecialchars(trim($_POST['pincode'])) : null;
$reference_person_name = isset($_POST['reference-person-name']) ? htmlspecialchars(trim($_POST['reference-person-name'])) : null;
$reference_person_mobile = isset($_POST['reference-person-mobile']) ? htmlspecialchars(trim($_POST['reference-person-mobile'])) : null;
$estimate_amount = isset($_POST['estimate-amount']) ? htmlspecialchars(trim($_POST['estimate-amount'])) : null;
$next_follow_up_date = isset($_POST['next-follow-up-date']) ? htmlspecialchars(trim($_POST['next-follow-up-date'])) : null;
$employee_name = isset($_POST['employee_name']) ? htmlspecialchars(trim($_POST['employee_name'])) : null;
$remarks = isset($_POST['remarks']) ? htmlspecialchars(trim($_POST['remarks'])) : null;

$gst_no = isset($_POST['gst_no']) ? htmlspecialchars(trim($_POST['gst_no'])) : null;

// Database connection
$conn = new mysqli("localhost", "root", "", "leads_details");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$sql_contact = "INSERT INTO contact(lead_source, lead_for,lead_priority,contact_person, company_name, mobile_no, whatsapp_no, email, address, country, state, city, pincode, reference_person_name, reference_person_mobile_no, estimate_amount, next_follow_up_date, employee_name, remarks,gst_no)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_contact = $conn->prepare($sql_contact);
$stmt_contact->bind_param("ssssssssssssssssssss", 
    $source_lead, 
    $for_lead, 
    $lead_priority, 
    $contact_person, 
    $company_name, 
    $mobile_no, 
    $whatsapp_no, 
    $email, 
    $address, 
    $country, 
    $state, 
    $city, 
    $pincode, 
    $reference_person_name, 
    $reference_person_mobile, 
    $estimate_amount, 
    $next_follow_up_date, 
    $employee_name, 
    $remarks,
    $gst_no
);

// Execute statement
if ($stmt_contact->execute()) {
    echo "<p>Contact details saved successfully!</p>";
} else {
    echo "<p>Error: " . $stmt_contact->error . "</p>";
    $conn->close();
    exit;
}

$stmt_contact->close();
$conn->close();

// Redirect to contact display page
header("Location: http://localhost/Log/contact.php");
exit;
