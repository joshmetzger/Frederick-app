<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fredrerick Import App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/Frederick/public/public_index.php">All Records</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="/Frederick/public/index.php">MY Records</a></li>
                    <li><a href="/Frederick/functions/upload.php">Upload</a></li>
                    <?php 
                        if(!isset($_SESSION['user_id'])){
                    ?>
                        <li><a href="/Frederick/functions/login.php">Login</a></li>
                        <li><a href="/Frederick/functions/register.php">Register</a></li>
                    <?php      
                        } else {
                    ?>
                            <li></li>
                    <?php
                        }
                    ?>
                    <!-- <li><a href="/Frederick/functions/register.php">Register</a></li> -->
                    <?php 
                        if(isset($_SESSION['user_id'])){
                    ?>
                        <li><a href="/Frederick/functions/logout.php">Logout</a></li>
                    <?php      
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
