<?php
// Check if form is submitted
if(isset($_FILES['imagesToUpload'])) {
    // Extract form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $message = $_POST['message'];

    // Create folder name based on filler's name
    $folderName = "response/forms_" . $name;

    // Check if the folder exists
    if (file_exists($folderName)) {
        // Delete old information and images
        $files = glob($folderName . '/*'); // Get all files in the folder
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete file
            }
        }
    } else {
        // If the folder doesn't exist, create it
        mkdir($folderName, 0777, true);
    }

    // Loop through each uploaded image file
    foreach ($_FILES['imagesToUpload']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['imagesToUpload']['name'][$key];
        $file_tmp = $_FILES['imagesToUpload']['tmp_name'][$key];
        $file_type = $_FILES['imagesToUpload']['type'][$key];

        // Destination directory
        $uploadDirectory = $folderName . '/';

        // Upload image
        $imagePath = $uploadDirectory . $file_name;
        if(move_uploaded_file($file_tmp, $imagePath)) {
            echo "Image '{$file_name}' uploaded successfully.<br>";
        } else {
            echo "Error uploading image '{$file_name}'.<br>";
        }
    }

    // Store text data in JSON file
    $jsonData = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'location' => $location,
        'message' => $message,
        'images' => array_map('basename', $_FILES['imagesToUpload']['name']) // Store only file names
    ];

    $jsonFilePath = $folderName . '/data.json';
    file_put_contents($jsonFilePath, json_encode($jsonData));

    // Redirect back to registration.html with success message
    header("Location: registration.html?success=true");
    exit();
} else {
    // If form data is not found, display error message
    echo "Form data not found!";
}
?>
