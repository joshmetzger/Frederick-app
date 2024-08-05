<?php session_start(); ?>
<?php include '../includes/navbar.php'; ?>
<?php include '../functions/config.php'; ?>

<?php  $user_id = $_SESSION['user_id']; ?>

<?php
    $response = file_get_contents('https://restcountries.com/v3.1/all');
    $countriesData = json_decode($response, true);

    // Extract country codes and names
    $countries = [];
    foreach ($countriesData as $country) {
        $code = $country['cca2']; // alpha code
        $name = $country['name']['common']; //  country name
        $countries[$code] = $name;
    }
?>

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

        <?php
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }
            if (isset($_SESSION['all_deleted_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['all_deleted_message'] . '</div>';
                unset($_SESSION['all_deleted_message']);
            }
        ?>
    
        <h1>My Records</h1>
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#createModal">Add New Record</button>
       
        <button class="btn btn-danger mb-4" data-toggle="modal" data-target="#deleteAllModal" style="float: right;">Delete ALL Records!</button>
        
        <br><br>
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
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables Data -->
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="form-group">
                            <label for="reporting_date">Reporting Date:</label>
                            <input type="date" class="form-control" id="reporting_date" name="reporting_date" required>
                        </div>
                        <div class="form-group">
                            <label for="sale_month">Sale Month:</label>
                            <input type="text" class="form-control" id="sale_month" name="sale_month" placeholder="format: YYYY-MM" pattern="\d{4}-\d{2}" title="Format: YYYY-MM" required>
                        </div>
                        <div class="form-group">
                            <label for="store">Store:</label>
                            <input type="text" class="form-control" id="store" name="store" required>
                        </div>
                        <div class="form-group">
                            <label for="artist">Artist:</label>
                            <input type="text" class="form-control" id="artist" name="artist" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="isrc">ISRC:</label>
                            <input type="text" class="form-control" id="isrc" name="isrc" required>
                        </div>
                        <div class="form-group">
                            <label for="upc">UPC:</label>
                            <input type="text" class="form-control" id="upc" name="upc">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="team_percent">Team Percent:</label>
                            <input type="number" step="0.00000001" class="form-control" id="team_percent" name="team_percent" required>
                        </div>
                        <div class="form-group">
                            <label for="song_or_album">Song/Album:</label>
                            <select class="form-control" id="song_or_album" name="song_or_album" required>
                                <option value="" disabled selected>Select...</option>
                                <option value="Song">Song</option>
                                <option value="Album">Album</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="country_of_sale">Country of Sale:</label>
                            <!-- <input type="text" class="form-control" id="country_of_sale" name="country_of_sale" required> -->
                            <select class="form-control" id="country_of_sale" name="country_of_sale" required>
                                <option value="" disabled>Select a country...</option>
                                <?php foreach ($countries as $code => $name): ?>
                                    <option value="<?php echo htmlspecialchars($code); ?>" <?php if ($country_of_sale == $code) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="songwriter_royalties_withheld">Songwriter Royalties Withheld:</label>
                            <input type="number" step="0.00000001" class="form-control" id="songwriter_royalties_withheld" name="songwriter_royalties_withheld" required>
                        </div>
                        <div class="form-group">
                            <label for="earnings_usd">Earnings USD:</label>
                            <input type="number" step="0.00000001" class="form-control" id="earnings_usd" name="earnings_usd" required>
                        </div>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_id" name="id">
                        
                        <div class="form-group">
                            <label for="edit_reporting_date">Reporting Date:</label>
                            <input type="date" class="form-control" id="edit_reporting_date" name="reporting_date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_sale_month">Sale Month:</label>
                            <input type="text" class="form-control" id="edit_sale_month" name="sale_month" placeholder="format: YYYY-MM" pattern="\d{4}-\d{2}" title="Format: YYYY-MM" required>
                            <!-- <input type="text" class="form-control" id="edit_sale_month" name="sale_month" placeholder="formar: 2023-04" required> -->
                        </div>
                        <div class="form-group">
                            <label for="edit_store">Store:</label>
                            <input type="text" class="form-control" id="edit_store" name="store" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_artist">Artist:</label>
                            <input type="text" class="form-control" id="edit_artist" name="artist" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Title:</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_isrc">ISRC:</label>
                            <input type="text" class="form-control" id="edit_isrc" name="isrc" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_upc">UPC:</label>
                            <input type="text" class="form-control" id="edit_upc" name="upc">
                        </div>
                        <div class="form-group">
                            <label for="edit_quantity">Quantity:</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_team_percent">Team Percent:</label>
                            <input type="number" step="0.00000001" class="form-control" id="edit_team_percent" name="team_percent" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_song_or_album">Song/Album:</label>
                            <select class="form-control" id="edit_song_or_album" name="song_or_album" required>
                                <option value="" disabled>Select...</option>
                                <option value="Song" <?php if ($song_or_album == 'Song') echo 'selected'; ?>>Song</option>
                                <option value="Album" <?php if ($song_or_album == 'Album') echo 'selected'; ?>>Album</option>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="edit_country_of_sale">Country of Sale:</label>
                            <input type="text" class="form-control" id="edit_country_of_sale" name="country_of_sale" required>
                        </div> -->
                        <div class="form-group">
                            <label for="country_of_sale">Country of Sale:</label>
                            <!-- <input type="text" class="form-control" id="country_of_sale" name="country_of_sale" required> -->
                            <select class="form-control" id="country_of_sale" name="country_of_sale" required>
                                <option value="" disabled>Select a country...</option>
                                <?php foreach ($countries as $code => $name): ?>
                                    <option value="<?php echo htmlspecialchars($code); ?>" <?php if ($country_of_sale == $code) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_songwriter_royalties_withheld">Songwriter Royalties Withheld:</label>
                            <input type="number" step="0.00000001" class="form-control" id="edit_songwriter_royalties_withheld" name="songwriter_royalties_withheld" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_earnings_usd">Earnings USD:</label>
                            <input type="number" step="0.00000001" class="form-control" id="edit_earnings_usd" name="earnings_usd" required>
                        </div>
                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                    <button id="confirmDelete" class="btn btn-danger">Delete</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete ALL Confirmation Modal -->
    <div id="deleteAllModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete ALL Records</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete ALL records?</p>
                    <button id="confirmDeleteAll" class="btn btn-danger">Delete</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": "../functions/fetch_data.php",
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
                    { 
                        "data": null,
                        "defaultContent": "<button class='btn btn-warning btn-edit'>Edit</button>"
                    },
                    { 
                        "data": null,
                        "defaultContent": "<button class='btn btn-danger btn-delete'>Delete</button>"
                    }
                ]
            });

            // vaidate Inputs
            document.getElementById('createForm').addEventListener('submit', function(event) {
                let valid = true;

                // Sale Month
                const saleMonth = document.getElementById('sale_month').value;
                const saleMonthPattern = /^\d{4}-\d{2}$/;
                if (!saleMonthPattern.test(saleMonth)) {
                    valid = false;
                    alert('Sale Month format is invalid. Please use YYYY-MM.');
                }

                if (!valid) {
                    // Prevent submission for fail
                    event.preventDefault(); 
                }
            });

            // Handle Add New Record
            $(document).ready(function() {
                $('#createForm').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '../functions/create.php',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#createForm').modal('hide');
                            // success message
                            window.location.href = window.location.href + '?success=Record added successfully!';
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                            alert('An error occurred: ' + status);
                        }
                    });
                });
            });

            // VALIDATE INPUTS!!
            document.getElementById('editForm').addEventListener('submit', function(event) {
                let valid = true;

                // Sale Month
                const saleMonth = document.getElementById('edit_sale_month').value;
                const saleMonthPattern = /^\d{4}-\d{2}$/;
                if (!saleMonthPattern.test(saleMonth)) {
                    valid = false;
                    alert('Sale Month format is invalid. Please use YYYY-MM.');
                }

                if (!valid) {
                    // Prevent submission for fail
                    event.preventDefault(); 
                }
            });

            // Handle Edit Record
            $('#dataTable').on('click', '.btn-edit', function() {
                var data = table.row($(this).parents('tr')).data();
                $('#edit_id').val(data.id);
                $('#edit_reporting_date').val(data.reporting_date);
                $('#edit_sale_month').val(data.sale_month);
                $('#edit_store').val(data.store);
                $('#edit_artist').val(data.artist);
                $('#edit_title').val(data.title);
                $('#edit_isrc').val(data.isrc);
                $('#edit_upc').val(data.upc);
                $('#edit_quantity').val(data.quantity);
                $('#edit_team_percent').val(data.team_percent);
                $('#edit_song_or_album').val(data.song_or_album);
                $('#edit_country_of_sale').val(data.country_of_sale);
                $('#edit_songwriter_royalties_withheld').val(data.songwriter_royalties_withheld);
                $('#edit_earnings_usd').val(data.earnings_usd);
                $('#user_id').val(data.user_id);
                
                $('#editModal').modal('show');
            });

            $('#editForm').on('submit', function(e) {
                e.preventDefault();
                // console.log(e);
                $.ajax({
                    url: '../functions/update.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            // Handle Delete Record
            var deleteId;
            $('#dataTable').on('click', '.btn-delete', function() {
                deleteId = table.row($(this).parents('tr')).data().id;
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '../functions/delete.php',
                    type: 'POST',
                    data: { id: deleteId },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            $(document).ready(function() {
                $('#confirmDeleteAll').on('click', function() {
                    $.ajax({
                        url: '../functions/delete_all.php',
                        type: 'POST',
                        success: function(response) {
                            $('#deleteAllModal').modal('hide');
                            alert('Records deleted successfully!');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('An error occurred:', error);
                            alert('An error occurred: ' + error);
                        }
                    });
                });
            });


        });
    </script>
</body>
</html>
