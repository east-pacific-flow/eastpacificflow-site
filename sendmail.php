<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form input values to prevent XSS (Cross-site Scripting) attacks
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Validate that the message is not empty
    if (empty($message)) {
        echo "Message cannot be empty.";
        exit;
    }

    // Define the recipient email address
    $to = "sales@eastpacificflow.com.au";  // Change this to your email address
    $subject = "New Message from Contact Form";

    // Prepare the email body
    $body = "You have received a new message from your contact form:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Message: $message\n";

    // Set the headers
    $headers = "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        // Redirect user to a thank you page or show a success message
        header("Location: thank_you.html");  // Redirect to a thank you page
        exit;
    } else {
        echo "Message could not be sent. Please try again later.";
    }
} else {
    echo "Invalid request method.";
}
?>
