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

// Function to validate phone
function validate_phone($phone) {
    return preg_match('/^[0-9]{10,15}$/', $phone);
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
    $required_fields = ['firstName', 'lastName', 'email', 'phone', 'serviceType', 'startDate', 'endDate'];
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
    
    // Validate phone format
    if (!empty($input['phone']) && !validate_phone($input['phone'])) {
        $errors['phone'] = 'Invalid phone number format';
    }
    
    // Validate date range
    if (!empty($input['startDate']) && !empty($input['endDate'])) {
        $startDate = new DateTime($input['startDate']);
        $endDate = new DateTime($input['endDate']);
        
        if ($startDate > $endDate) {
            $errors['dateRange'] = 'End date must be after start date';
        }
    }
    
    // If validation errors exist
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit();
    }
    
    // Sanitize input data
    $firstName = sanitize_input($input['firstName']);
    $lastName = sanitize_input($input['lastName']);
    $email = sanitize_input($input['email']);
    $phone = sanitize_input($input['phone']);
    $serviceType = sanitize_input($input['serviceType']);
    $startDate = sanitize_input($input['startDate']);
    $endDate = sanitize_input($input['endDate']);
    $requirements = isset($input['requirements']) ? sanitize_input($input['requirements']) : '';
    
    // Email configuration
    $to = "info1ggrevents@gmail.com"; // Change this to your email
    $subject = "New Service Request - GGR Events";
    
    // Email message
    $message = "Dear GGR Events Team,\n\n";
    $message .= "You have received a new service request. Here are the details:\n\n";
    $message .= "Client Information:\n";
    $message .= "Name: " . $firstName . " " . $lastName . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Phone: " . $phone . "\n\n";
    $message .= "Service Details:\n";
    $message .= "Service Type: " . strtoupper(str_replace('_', ' ', $serviceType)) . "\n";
    $message .= "Start Date: " . $startDate . "\n";
    $message .= "End Date: " . $endDate . "\n";
    
    if (!empty($requirements)) {
        $message .= "Additional Requirements: " . $requirements . "\n";
    }
    
    $message .= "\nPlease contact the client within 24 hours to discuss their requirements.\n\n";
    $message .= "Best regards,\nGGR Events Website";
    
    // Email headers
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (send_email($to, $subject, $message, $headers)) {
        // Send confirmation email to client
        $client_subject = "Thank you for your request - GGR Events";
        $client_message = "Dear " . $firstName . ",\n\n";
        $client_message .= "Thank you for reaching out to GGR Events! We have received your service request and our team will contact you within 24 hours to discuss your requirements.\n\n";
        $client_message .= "Service Requested: " . strtoupper(str_replace('_', ' ', $serviceType)) . "\n";
        $client_message .= "Date Range: " . $startDate . " to " . $endDate . "\n\n";
        $client_message .= "If you have any urgent questions, please feel free to contact us at:\n";
        $client_message .= "Phone: +91 8309948909 / +91 9381022079\n";
        $client_message .= "Email: info@ggrevents.com\n\n";
        $client_message .= "We look forward to making your event unforgettable!\n\n";
        $client_message .= "Best regards,\nGGR Events Team";
        
        $client_headers = "From: info@ggrevents.com\r\n";
        $client_headers .= "Reply-To: info@ggrevents.com\r\n";
        
        send_email($email, $client_subject, $client_message, $client_headers);
        
        echo json_encode(['success' => true, 'message' => 'Request submitted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }
    
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
?>
