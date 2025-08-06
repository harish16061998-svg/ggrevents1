<?php
// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header for response
header('Content-Type: application/json');

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to send email
function send_email($to, $subject, $message, $headers) {
    return mail($to, $subject, $message, $headers);
}

// Main processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        // Fallback to POST data
        $input = $_POST;
    }
    
    // Validate required fields
    $required_fields = ['name', 'email', 'message'];
    $errors = [];
    
    foreach ($required_fields as $field) {
        if (empty($input[$field])) {
            $errors[$field] = ucfirst($field) . ' is required';
        }
    }
    
    // Validate email format
    if (!empty($input['email']) && !validate_email($input['email'])) {
        $errors['email'] = 'Invalid email format';
    }
    
    // If validation errors exist
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }
    
    // Sanitize input data
    $name = sanitize_input($input['name']);
    $email = sanitize_input($input['email']);
    $message = sanitize_input($input['message']);
    
    // Email configuration
    $to = "info@ggrevents.com"; // Change this to your email
    $subject = "New Feedback - GGR Events";
    
    // Email message
    $email_message = "Dear GGR Events Team,\n\n";
    $email_message .= "You have received new feedback from your website:\n\n";
    $email_message .= "From: " . $name . "\n";
    $email_message .= "Email: " . $email . "\n\n";
    $email_message .= "Feedback:\n" . $message . "\n\n";
    $email_message .= "Best regards,\nGGR Events Website";
    
    // Email headers
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (send_email($to, $subject, $email_message, $headers)) {
        // Send confirmation email to client
        $client_subject = "Thank you for your feedback - GGR Events";
        $client_message = "Dear " . $name . ",\n\n";
        $client_message .= "Thank you for taking the time to share your feedback with GGR Events! We truly value your input and will review your comments carefully.\n\n";
        $client_message .= "Your feedback helps us improve our services and provide better experiences for all our clients.\n\n";
        $client_message .= "If you have any additional questions or concerns, please don't hesitate to contact us at:\n";
        $client_message .= "Phone: +91 8309948909 / +91 9381022079\n";
        $client_message .= "Email: info@ggrevents.com\n\n";
        $client_message .= "Best regards,\nGGR Events Team";
        
        $client_headers = "From: info@ggrevents.com\r\n";
        $client_headers .= "Reply-To: info@ggrevents.com\r\n";
        
        send_email($email, $client_subject, $client_message, $client_headers);
        
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
