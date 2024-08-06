<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<?php include '../includes/navbar.php'; ?>
<body>
    <div class="container">
        <h1>Register</h1>

        <?php
        include 'db.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $connect->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $password);
                $success = $stmt->execute();

                if ($success) {
                    echo '<div class="alert alert-success">Registration successful!</div>';
                } else {
                    echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
                }

                $stmt->close();
            } else {
                echo '<div class="alert alert-danger">Error preparing statement: ' . $connect->error . '</div>';
            }
        }
        ?>

        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        
    </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script> -->

</body>
</html>
