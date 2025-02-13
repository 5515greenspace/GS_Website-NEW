<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
    
    $to = "joelu@greenspacegroup.net"; // Replace with your email address
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $email_body = "You have received a new message from your website contact form.\r\n\r\n" .
                  "Name: $name\r\n" .
                  "Email: $email\r\n" .
                  "Subject: $subject\r\n" .
                  "Message:\r\n$message";
    
    if (mail($to, $subject, $email_body, $headers)) {
        echo "Thank you for your message. We'll get back to you soon.";
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    echo "This script can only be accessed through a form submission.";
}
?>