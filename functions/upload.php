<?php
// session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: functions/login.php');
//     exit();
// }
// $user_id = $_SESSION['user_id'];

// include 'functions/db.php';

// // Handle file upload
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
//     $file = $_FILES['data_file'];
//     $allowedExtensions = ['csv', 'tsv'];
//     $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

//     // Validate file extension
//     if (!in_array($fileExtension, $allowedExtensions)) {
//         echo '<div class="alert alert-danger">Invalid file type. Only CSV and TSV files are allowed.</div>';
//     } else {
//         // Read and clean the file
//         $fileContent = file_get_contents($file['tmp_name']);
//         $fileContent = preg_replace('/^\xEF\xBB\xBF/', '', $fileContent); // Remove BOM if present

//         // Normalize line breaks
//         $fileContent = str_replace(["\r\n", "\r"], "\n", $fileContent);

//         // Split into rows
//         $rows = explode("\n", trim($fileContent));

//         // Debugging: Output the number of rows and first few rows
//         echo '<pre>Number of rows: ' . count($rows) . '</pre>';
//         echo '<pre>';
//         print_r(array_slice($rows, 0, 5)); // Display first 5 rows for inspection
//         echo '</pre>';

//         $stmt = $connect->prepare("
//             INSERT INTO frederick_data_table (
//                 reporting_date,
//                 sale_month,
//                 store,
//                 artist,
//                 title,
//                 isrc,
//                 upc,
//                 quantity,
//                 team_percent,
//                 song_or_album,
//                 country_of_sale,
//                 songwriter_royalties_withheld,
//                 earnings_usd,
//                 user_id
//             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, $user_id)
//         ");

//         // Check for SQL preparation errors
//         if (!$stmt) {
//             die('SQL prepare error: ' . $connect->error);
//         }

//         // Process each row
//         $headerProcessed = false; // Flag to skip the header row
//         foreach ($rows as $row) {
//             // Skip empty lines
//             if (trim($row) === '') {
//                 continue;
//             }

//             // Parse the row
//             $data = str_getcsv($row, $delimiter); // Use delimiter for CSV/TSV

//             // Skip the header row
//             if (!$headerProcessed) {
//                 $headerProcessed = true;
//                 continue;
//             }

//             // Ensure the row has the expected number of columns
//             if (count($data) === 13) { // Based on your CSV/TSV file structure
//                 // Convert and bind parameters
//                 $reporting_date = date('Y-m-d', strtotime($data[0])); // Convert to YYYY-MM-DD
//                 $sale_month = date('Y-m', strtotime($data[1])); // Convert to YYYY-MM
//                 $store = $data[2];
//                 $artist = $data[3];
//                 $title = $data[4];
//                 $isrc = $data[5];
//                 $upc = !empty($data[6]) ? $data[6] : null;
//                 $quantity = (int)$data[7];
//                 $team_percent = (int)$data[8];
//                 $song_or_album = $data[9];
//                 $country_of_sale = $data[10];
//                 $songwriter_royalties_withheld = (float)$data[11];
//                 $earnings_usd = (float)$data[12];

//                 // Bind parameters and execute
//                 $stmt->bind_param(
//                     "sssssississdd", // Define types: s = string, i = integer, d = double
//                     $reporting_date,
//                     $sale_month,
//                     $store,
//                     $artist,
//                     $title,
//                     $isrc,
//                     $upc,
//                     $quantity,
//                     $team_percent,
//                     $song_or_album,
//                     $country_of_sale,
//                     $songwriter_royalties_withheld,
//                     $earnings_usd
                    
//                 );

//                 if (!$stmt->execute()) {
//                     echo '<div class="alert alert-danger">Error inserting data: ' . $stmt->error . '</div>';
//                 }
//             } else {
//                 echo '<div class="alert alert-warning">Skipping row with incorrect number of columns: ' . htmlspecialchars($row) . '</div>';
//             }
//         }

//         $stmt->close();
//         echo '<div class="alert alert-success">File uploaded and data imported successfully!</div>';
//         // Use header redirection after sending all content
//         // header('Location: index.php');
//     }
// }

session_start();

// check user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];

include 'db.php';

// handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];
    $allowedExtensions = ['csv', 'tsv'];
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    // validate file size (2 MB now, change first number for MB size):
    $maxFileSize = 2 * 1024 * 1024; 
    if ($file['size'] > $maxFileSize) {
        echo '<div class="alert alert-danger">File size exceeds the maximum limit of 2 MB.</div>';
        exit();
    }

    // validate file extension
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo '<div class="alert alert-danger">Invalid file type. Only CSV and TSV files are allowed.</div>';
    } else {
        // read and clean file
        // this should remove BOM from string that may be affecting import...
        $fileContent = file_get_contents($file['tmp_name']);
        $fileContent = preg_replace('/^\xEF\xBB\xBF/', '', $fileContent);

        // normalize line breaks. consider mac, windows...
        $fileContent = str_replace(["\r\n", "\r"], "\n", $fileContent);

        // split into rows (now that it's normalized)
        $rows = explode("\n", trim($fileContent));

        // debugging... output the number of rows and first few rows
        // echo '<pre>Number of rows: ' . count($rows) . '</pre>';
        // echo '<pre>';
        // print_r(array_slice($rows, 0, 5)); // Display first 5 rows for inspection
        // echo '</pre>';

        //  if issues occur for now, add $user_id manually here, insrtead of placeholder
        $stmt = $connect->prepare("
            INSERT INTO frederick_data_table (
                reporting_date,
                sale_month,
                store,
                artist,
                title,
                isrc,
                upc,
                quantity,
                team_percent,
                song_or_album,
                country_of_sale,
                songwriter_royalties_withheld,
                earnings_usd,
                user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        // check for SQL preparation errors
        if (!$stmt) {
            die('SQL prepare error: ' . $connect->error);
        }

        // find delimiter based on file extension
        $delimiter = ($fileExtension === 'tsv') ? "\t" : ",";

        // process $rows
        $headerProcessed = false;
        foreach ($rows as $row) {
            // Skip empty lines
            if (trim($row) === '') {
                continue;
            }

            // parse row
            $data = str_getcsv($row, $delimiter);

            // skip header, may need to change this if files lack a header
            if (!$headerProcessed) {
                $headerProcessed = true;
                continue;
            }

            // check each row has the expected number of columns
            if (count($data) === 13) {
                // Convert and bind parameters
                // TODO: retry this raw to see if DB will auto-convert again..
                $reporting_date = date('Y-m-d', strtotime($data[0])); // convert to YYYY-MM-DD
                $sale_month = date('Y-m', strtotime($data[1])); // convert to YYYY-MM

                $store = $data[2];
                $artist = $data[3];
                $title = $data[4];
                $isrc = $data[5];
                $upc = !empty($data[6]) ? $data[6] : null;
                $quantity = (int)$data[7];
                $team_percent = (int)$data[8];
                $song_or_album = $data[9];
                $country_of_sale = $data[10];
                $songwriter_royalties_withheld = (float)$data[11];
                $earnings_usd = (float)$data[12];

                // bind parameters and execute
                $stmt->bind_param(
                    "sssssississddi",
                    $reporting_date,
                    $sale_month,
                    $store,
                    $artist,
                    $title,
                    $isrc,
                    $upc,
                    $quantity,
                    $team_percent,
                    $song_or_album,
                    $country_of_sale,
                    $songwriter_royalties_withheld,
                    $earnings_usd,
                    $user_id,
                );

                if (!$stmt->execute()) {
                    echo '<div class="alert alert-danger">Error inserting data: ' . $stmt->error . '</div>';
                }
            } else {
                echo '<div class="alert alert-warning">Skipping row with incorrect number of columns: ' . htmlspecialchars($row) . '</div>';
            }
        }

        $stmt->close();
        $_SESSION['message'] = 'data imported successfully!';

        header('Location: ../public/index.php');
        exit();
    }
}
?>

<?php
include '../includes/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Upload CSV/TSV File:</h1>
        <br><br>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="data_file">Select file:</label>
                <input type="file" name="data_file" id="data_file" class="" required>
            </div>
            <button type="submit" class="btn btn-primary">Import</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
