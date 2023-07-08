<!DOCTYPE html>
<html>
<head>
    <title>Upload and Store Video</title>
    <style>
        /* CSS styles for the page layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 20px;

        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .navbar li {
            display: inline;
            margin-right: 10px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
        }

        .content {
            text-align: center;
            margin-top: 50px;
        }

        .video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;

            border: 1px solid black;
        }

        .video-card {
            float: left;
            margin: 5px;
            border: 1px solid black;
        }

        .video-card video {
            width: 300px;
            height: 200px;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        span{
          color: black;
          font-weight: bold;
          cursor: pointer;
    
         
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
          
        </ul>
    </div>

    <div class="content">
        <h1>Watch your favourite classes</h1>

        <div class="video-container">
            <?php
            include("db.php");

            $fetchVideos = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($fetchVideos)) {
                $location = $row['location'];
                $name = $row['name'];
                echo "<div class='video-card'>
                          <video src='" . $location . "' controls></video>
                          <br>
                          <span>" . $name . "</span>
                      </div>";
            }
            ?>
        </div>
    </div>

    <div class="footer">
        &copy; <?php echo date('Y'); ?> Your Website | All rights reserved.
    </div>
</body>
</html>
