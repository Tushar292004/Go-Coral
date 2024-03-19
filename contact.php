<?php

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $subject = sanitizeInput($_POST["subject"]);
    $message = sanitizeInput($_POST["message"]);

    // Create a folder named 'responses' if it doesn't exist
    if (!is_dir('responses')) {
        mkdir('responses');
    }

    // Generate JSON filename from the username (replace spaces with underscores)
    $filename = 'responses/' . str_replace(' ', '_', $name) . '.json';

    // Check if the file already exists
    if (file_exists($filename)) {
        // Delete the old response file
        unlink($filename);
    }

    // Prepare data to be saved in JSON format
    $data = [
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ];

    // Encode data to JSON format
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // Save data to the JSON file
    file_put_contents($filename, $jsonData);

    // Respond with success message
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
} else {
    // If the request method is not POST, respond with an error message
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
