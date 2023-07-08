<?php

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mysql";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if (isset($_POST['upload'])) {
    $video_name = $_POST['video_name'];
    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    // Specify the directory to store the uploaded videos
    $upload_directory = "uploads/";

    // Move the uploaded video to the specified directory
    $file_destination = $upload_directory . $file_name;
    move_uploaded_file($file_tmp, $file_destination);

    // Check if the file_name column already exists
    $checkQuery = "SELECT * FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = 'videos' AND column_name = 'file_name'";

    $result = $conn->query($checkQuery);

    if ($result->num_rows == 0) {
        // The file_name column does not exist, so we can add it
        $alterQuery = "ALTER TABLE videos ADD COLUMN file_name VARCHAR(255)";

        if ($conn->query($alterQuery) === TRUE) {
            echo "Column 'file_name' added successfully.";
        } else {
            echo "Error adding column 'file_name': " . $conn->error;
        }
    }

    // Check if the file_type column already exists
    $checkQuery = "SELECT * FROM information_schema.columns WHERE table_schema = '$dbname' AND table_name = 'videos' AND column_name = 'file_type'";

    $result = $conn->query($checkQuery);

    if ($result->num_rows == 0) {
        // The file_type column does not exist, so we can add it
        $alterQuery = "ALTER TABLE videos ADD COLUMN file_type VARCHAR(800)";

        if ($conn->query($alterQuery) === TRUE) {
            echo "Column 'file_type' added successfully.";
        } else {
            echo "Error adding column 'file_type': " . $conn->error;
        }
    }
    

    // Insert the video details into the database
    $sql = "INSERT INTO videos (name, file_name, file_type)
            VALUES ('$video_name', '$file_name', '$file_type')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Video uploaded successfully.";
    } else {
        $error_message = "Error uploading video: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Video</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Video</h1> <h4>(below 40mb)</h4> 
        <?php if (isset($success_message)) { ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="post" enctype="multipart/form-data">
            <label for="video_name">Video Name:</label>
            <input type="text" name="video_name" id="video_name" required><br>
            <label for="file">Select a video:</label>
            <input type="file" name="file" id="file" required><br>
            <input type="submit" name="upload" value="Upload">
        </form>
    </div>
</body>
</html>
