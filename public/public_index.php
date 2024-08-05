<?php include '../includes/navbar.php'; ?>
<?php include '../functions/config.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .modal-lg {
            max-width: 90%;
        }
    </style>
</head>
<body>
    <div class="container">

        <h1>All Records</h1>
        
        <table id="dataTable" class="display mt-3" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reporting Date</th>
                    <th>Sale Month</th>
                    <th>Store</th>
                    <th>Artist</th>
                    <th>Title</th>
                    <th>ISRC</th>
                    <th>UPC</th>
                    <th>Quantity</th>
                    <th>Team Percent</th>
                    <th>Song/Album</th>
                    <th>Country of Sale</th>
                    <th>Songwriter Royalties Withheld</th>
                    <th>Earnings USD</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables Data -->
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": "../functions/fetch_data_public.php",
                "columns": [
                    { "data": "id" },
                    { "data": "reporting_date" },
                    { "data": "sale_month" },
                    { "data": "store" },
                    { "data": "artist" },
                    { "data": "title" },
                    { "data": "isrc" },
                    { "data": "upc" },
                    { "data": "quantity" },
                    { "data": "team_percent" },
                    { "data": "song_or_album" },
                    { "data": "country_of_sale" },
                    { "data": "songwriter_royalties_withheld" },
                    { "data": "earnings_usd" },
                ]
            });
        });

    </script>
</body>
</html>
