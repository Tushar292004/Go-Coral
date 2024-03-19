<?php
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

//input sanitized fiels
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $subject = sanitizeInput($_POST["subject"]);
    $message = sanitizeInput($_POST["message"]);


    if (!is_dir('responses')) {
        mkdir('responses');
    }
    $filename = 'responses/' . str_replace(' ', '_', $name) . '.json';


    if (file_exists($filename)) {
        unlink($filename);
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'subject' => $subject,
        'message' => $message
    ];

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filename, $jsonData);


//complition status handling
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent. Thank you!']);
} else {
    
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

?>
