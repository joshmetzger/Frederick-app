<?php
include 'db.php';

// Collect POST data
$reporting_date = $_POST['reporting_date'];
$sale_month = $_POST['sale_month'];
$store = $_POST['store'];
$artist = $_POST['artist'];
$title = $_POST['title'];
$isrc = $_POST['isrc'];
$upc = $_POST['upc'];
$quantity = $_POST['quantity'];
$team_percent = $_POST['team_percent'];
$song_or_album = $_POST['song_or_album'];
$country_of_sale = $_POST['country_of_sale'];
$songwriter_royalties_withheld = $_POST['songwriter_royalties_withheld'];
$earnings_usd = $_POST['earnings_usd'];
$user_id = $_POST['user_id'];

// Prepare SQL statement
$sql = "
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
    ) VALUES (
        '$reporting_date',
        '$sale_month',
        '$store',
        '$artist',
        '$title',
        '$isrc',
        '$upc',
        '$quantity',
        '$team_percent',
        '$song_or_album',
        '$country_of_sale',
        '$songwriter_royalties_withheld',
        '$earnings_usd',
        '$user_id'
    )
";

// Execute the query
if ($connect->query($sql) === TRUE) {
    echo 'Record added successfully';
} else {
    echo 'Error: ' . $connect->error;
}

$connect->close();
?>
