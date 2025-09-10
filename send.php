<?php
// Hide errors from the user
error_reporting(0);

// === CONFIG ===
$to = "admin@graffeducationrecruitment.co.uk"; 
$subject = "New Student Application - Graff Education Recruitment";
$from_email = "admin@graffeducationrecruitment.co.uk"; 
$headers = "From: Graff Education <$from_email>\r\n";
$headers .= "Reply-To: $from_email\r\n";

// === Collect Form Data (match names from form) ===
$first_name  = $_POST['first_name'] ?? '';
$surname     = $_POST['surname'] ?? '';
$email       = $_POST['email'] ?? '';
$phone       = $_POST['phone'] ?? '';
$nationality = $_POST['nationality'] ?? '';
$city        = $_POST['city'] ?? '';
$program     = $_POST['program'] ?? '';
$financial_support = $_POST['financial_support'] ?? '';
$referral_source   = $_POST['referral_source'] ?? '';
$agent_name        = $_POST['agent_name'] ?? '';
$agent_company     = $_POST['agent_company'] ?? '';

// Add to message

$message .= "Disability: $disability\n";
if ($disability === "Yes" && !empty($disability_details)) {
    $message .= "Disability Details: $disability_details\n";
}
$consent     = isset($_POST['consent']) ? "Yes" : "No";

// === Build Message ===
$message  = "New Application Received:\n\n";
$message .= "First Name: $first_name\n";
$message .= "Surname: $surname\n";
$message .= "Email: $email\n";
$message .= "Phone (WhatsApp): $phone\n";
$message .= "Nationality: $nationality\n";
$message .= "Current City in UK: $city\n";
$message .= "Chosen Program: $program\n";
$message .= "Financial Support: $financial_support\n";
$message .= "Referral Source: $referral_source\n";
if ($referral_source === "Agent") {
    $message .= "Agent Name: $agent_name\n";
    $message .= "Agent Company: $agent_company\n";
}

$message .= "Disability: $disability\n";
$message .= "Disability Details: $disability_details\n";
$message .= "Consent Given: $consent\n";

// === Handle File Uploads ===
$uploads = [];
$upload_dir = __DIR__ . "/uploads/"; 
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Function to save file securely
function saveFile($fileField, $upload_dir, &$uploads) {
    if (isset($_FILES[$fileField]) && $_FILES[$fileField]['error'] === UPLOAD_ERR_OK) {
        $filename = preg_replace("/[^A-Z0-9._-]/i", "_", basename($_FILES[$fileField]['name']));
        $target = $upload_dir . time() . "_" . $filename;
        if (move_uploaded_file($_FILES[$fileField]['tmp_name'], $target)) {
            $uploads[] = $target;
        }
    }
}
