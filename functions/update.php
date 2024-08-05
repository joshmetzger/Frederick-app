<?php
include 'db.php';

$id = $_POST['id'];
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

$stmt = $connect->prepare("
    UPDATE frederick_data_table
    SET
        reporting_date = '$reporting_date',
        sale_month = '$sale_month',
        store = '$store',
        artist = '$artist',
        title = '$title',
        isrc = '$isrc',
        upc = '$upc',
        quantity = '$quantity',
        team_percent = '$team_percent',
        song_or_album = '$song_or_album',
        country_of_sale = '$country_of_sale',
        songwriter_royalties_withheld = '$songwriter_royalties_withheld',
        earnings_usd = '$earnings_usd',
        user_id = '$user_id'
    WHERE id = '$id'
");

$stmt->bind_param(
    "sssssississdii",
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
    $id
);

if ($stmt->execute()) {
    echo 'Record updated successfully';
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
$connect->close();
?>
