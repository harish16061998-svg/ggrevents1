<?php
// Email Configuration for GGR Events
// This file contains all email-related settings for the application

// Email Server Settings
define('EMAIL_HOST', 'smtp.gmail.com');           // SMTP server
define('EMAIL_PORT', 587);                        // SMTP port (587 for TLS, 465 for SSL)
define('EMAIL_USERNAME', 'info1ggrevents@gmail.com'); // Your Gmail address
define('EMAIL_PASSWORD', 'rimd cssn ttrz vugs');   // Your Gmail App Password (not regular password)
define('EMAIL_ENCRYPTION', 'tls');               // Encryption type: tls or ssl

// Email Addresses
define('ADMIN_EMAIL', 'info1ggrevents@gmail.com');      // Admin email for receiving notifications
define('SUPPORT_EMAIL', 'info1ggrevents@gmail.com'); // Alternative support email
define('FROM_EMAIL', 'info1ggrevents@gmail.com');    // Default from email address
define('FROM_NAME', 'GGR Events');                // Default from name

// Email Templates
define('EMAIL_SUBJECT_PREFIX', '[GGR Events]');  // Prefix for email subjects

// Email Settings
define('EMAIL_CHARSET', 'UTF-8');                 // Character encoding
define('EMAIL_CONTENT_TYPE', 'text/html');        // Content type: text/plain or text/html

// Debug Mode
define('EMAIL_DEBUG', false);                    // Set to true for debugging

// SMTP Authentication
define('SMTP_AUTH', true);                       // Enable SMTP authentication
define('SMTP_SECURE', 'tls');                     // Enable TLS encryption

// Email Limits
define('MAX_EMAILS_PER_HOUR', 100);              // Rate limiting
define('EMAIL_TIMEOUT', 30);                      // Connection timeout in seconds

// Reply-To Settings
define('REPLY_TO_EMAIL', 'info1ggrevents@gmail.com');   // Default reply-to email
define('REPLY_TO_NAME', 'GGR Events Support');    // Default reply-to name

// BCC Settings (for admin notifications)
define('BCC_EMAIL', 'harish16061998@gmail.com');      // BCC for admin notifications

// Error Handling
define('EMAIL_ERROR_LOG', 'logs/email_errors.log'); // Path to email error log
?>
