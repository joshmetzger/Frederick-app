<?php
session_start();

$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Test Form</title>
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>Submit Test Form</h1>
    <form id="createForm" action="functions/create.php" method="POST">
        <input type="text" name="reporting_date" placeholder="Reporting Date (YYYY-MM-DD)" required>
        <input type="text" name="sale_month" placeholder="Sale Month" required>
        <input type="text" name="store" placeholder="Store" required>
        <input type="text" name="artist" placeholder="Artist" required>
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="isrc" placeholder="ISRC" required>
        <input type="text" name="upc" placeholder="UPC">
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="number" name="team_percent" placeholder="Team Percent" required>
        <input type="text" name="song_or_album" placeholder="Song/Album" required>
        <input type="text" name="country_of_sale" placeholder="Country of Sale" required>
        <input type="number" name="songwriter_royalties_withheld" step="0.01" placeholder="Songwriter Royalties Withheld" required>
        <input type="number" name="earnings_usd" step="0.01" placeholder="Earnings USD" required>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <button type="submit">Save</button>
    </form>
    
    <script>
        $(document).ready(function() {
            $('#createForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: 'functions/create.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log("Response:", response);
                        alert('Record added successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('An error occurred: ' + status);
                    }
                });
            });
        });
    </script>
</body>
</html>
