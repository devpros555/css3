<?php
// forms/quote.php

// Ensure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo "Invalid request.";
  exit;
}

// === SENDS TO LARRY'S REAL EMAIL ===
$to = "larryparks1969@gmail.com";

// === GET FORM FIELDS ===
$name         = isset($_POST['name']) ? trim($_POST['name']) : '';
$email        = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone        = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$service_area = isset($_POST['service_area']) ? trim($_POST['service_area']) : '';
$type         = isset($_POST['type']) ? trim($_POST['type']) : '';
$timeline     = isset($_POST['timeline']) ? trim($_POST['timeline']) : '';
$address      = isset($_POST['address']) ? trim($_POST['address']) : '';
$message      = isset($_POST['message']) ? trim($_POST['message']) : '';

// === BASIC REQUIRED FIELDS CHECK ===
if ($name === '' || $email === '' || $phone === '' || $service_area === '' || $type === '' || $timeline === '' || $message === '') {
  echo "Please fill out all required fields.";
  exit;
}

// === BUILD EMAIL ===
$subject = "New Concrete Quote Request from {$name}";

$body  = "A new concrete quote request was submitted:\n\n";
$body .= "Name: {$name}\n";
$body .= "Email: {$email}\n";
$body .= "Phone: {$phone}\n";
$body .= "Service Area: {$service_area}\n";
$body .= "Project Type: {$type}\n";
$body .= "Timeline: {$timeline}\n";
$body .= "Address: {$address}\n\n";
$body .= "Project Details:\n{$message}\n";

// Use a domain-based no-reply for deliverability
$from_email = "no-reply@" . $_SERVER['SERVER_NAME'];

$headers  = "From: Concrete Website <{$from_email}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// === SEND EMAIL ===
if (mail($to, $subject, $body, $headers)) {
  echo "OK"; // Required for php-email-form.js
} else {
  echo "Error sending email. Please try again or call us.";
}
