    <?php
    session_start();
    include 'connect.php';
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Candidates List</title>

        <!-- Include Bootstrap CSS and JS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/candidates.css">


        <style>
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0); /* Remove dark overlay */
            }

            .modal {
                z-index: 1050; /* Ensure modal is above all elements */
            }

            .modal-backdrop {
                z-index: 1040; /* Backdrop is just below the modal */
            }
        </style>
    </head>
    <body>  
    <div class="container mt-4">
        <div class="content-wrapper">
        <a href="index.php" class="btn btn-primary mt-2 ml-1 ">Back</a> 
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Candidates List</h1>
            
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addc">
                                    <i class="fa fa-plus"></i> Add New
                                </button>
                            </div>
                            <div class="box-body">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Platform</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM candidates ORDER BY id ASC";
                                        $query = $conn->query($sql);

                                        while ($row = $query->fetch_assoc()) {
                                            echo "
                                                <tr>
                                                    <td><img src='" . htmlspecialchars($row['image']) . "' width='50' height='50'></td>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['position']) . "</td>
                                                    <td>" . htmlspecialchars($row['platform']) . "</td>
                                                    <td>
                                                    <button 
                                                        class='btn btn-success btn-sm edit' 
                                                        data-id='" . $row['id'] . "' 
                                                        data-name='" . htmlspecialchars($row['name']) . "'
                                                        data-position='" . htmlspecialchars($row['position']) . "' 
                                                        data-platform='" . htmlspecialchars($row['platform']) . "'>
                                                        <i class='fa fa-edit'></i> Edit
                                                    </button>
                                                        <button class='btn btn-danger btn-sm delete' data-id='" . $row['id'] . "'><i class='fa fa-trash'></i> Delete</button>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Add New Candidate Modal -->
    <div class="modal fade" id="addc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Candidate</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addc_form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position" class="col-sm-3 control-label">Position</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="platform" class="col-sm-3 control-label">Platform</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="platform" name="platform" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-sm-3 control-label">Photo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="button" id="saveCandidateBtn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Candidate Modal -->
    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit Candidate</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_form" class="form-horizontal">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_position" class="col-sm-3 control-label">Position</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_position" name="position" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_platform" class="col-sm-3 control-label">Platform</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="edit_platform" name="platform" required></textarea>
                            </div>

                            <div class="form-group">
                            <label for="image" class="col-sm-3 control-label">Photo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="button" id="editCandidateBtn" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Candidate Modal -->
    <div class="modal fade" id="delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Delete Candidate</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_form">
                        <input type="hidden" id="delete_id" name="id">
                        <p>Are you sure you want to delete <span id="delete_name"></span>?</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    <button type="button" id="deleteCandidateBtn" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Add new candidate
        $('#saveCandidateBtn').on('click', function(e) {
            e.preventDefault();

            var formData = new FormData($('#addc_form')[0]);

            $.ajax({
                url: 'candidates_add.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('Candidate added successfully!');
                    location.reload();
                },
                error: function(error) {
                    alert('Error occurred while adding the candidate.');
                    console.error(error);
                }
            });
        });

        // Show edit modal
        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var position = $(this).data('position');
            var platform = $(this).data('platform');

            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_position').val(position);
            $('#edit_platform').val(platform);

            $('#edit').modal('show');
        });

        // Save edit changes
        $('#editCandidateBtn').on('click', function(e) {
        e.preventDefault();

        var formData = new FormData($('#edit_form')[0]); // Include the image file

        $.ajax({
            url: 'candidates_edit.php',
            type: 'POST',
            data: formData,
            processData: false,  // Prevent jQuery from automatically transforming the data into a query string
            contentType: false,  // Let the browser set the content type with the correct boundary
            success: function(response) {
                alert('Candidate updated successfully!');
                location.reload();
            },
            error: function(error) {
                alert('Error occurred while updating the candidate.');
                console.error(error);
            }
        });
    });


        // Show delete modal
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            var name = $(this).closest('tr').find('td:nth-child(2)').text();

            $('#delete_id').val(id);
            $('#delete_name').text(name);

            $('#delete').modal('show');
        });

        // Confirm deletion
        $('#deleteCandidateBtn').on('click', function(e) {
            e.preventDefault();

            var formData = $('#delete_form').serialize();

            $.ajax({
                url: 'candidates_delete.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Candidate deleted successfully!');
                    location.reload();
                },
                error: function(error) {
                    alert('Error occurred while deleting the candidate.');
                    console.error(error);
                }
            });
        });
    });
    </script>

    </body>
    </html>
