<?php
include 'connect.php';
include 'modal_account.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account List</title>
  <!-- Link to Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Link to Custom CSS -->
  <link rel="stylesheet" href="css/voters.css">
</head>
<body>
  <div class="container mt-4">
    <div class="content-wrapper">
      <a href="index.php" class="btn btn-primary mt-2 ml-1 ">Back</a> 
      <section class="content-header">
        <center><h2>Accounts List</h2></center>
      </section>
      
      
        
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <button class="btn-success btn-sm addAcc" data-toggle="modal" data-target="#addAcc">
                  <i class="fa fa-plus"></i> Add New Account
                </button>
              </div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Password</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                      $sql = "SELECT * FROM accounts";
                      $query = $conn->query($sql);
                      while ($row = $query->fetch_assoc()) {
                          echo "<tr>
                                  <td>" . $row['username'] . "</td>
                                  <td>" . $row['password'] . "</td>
                                  <td>
                                    <button 
                                        class='btn btn-success btn-sm edit' 
                                        data-id='" . $row['id'] . "' 
                                        data-username='" . $row['username'] . "' 
                                        data-password='" . $row['password'] . "'>
                                        <i class='fa fa-edit'></i> Edit
                                    </button>
                                     <button class='btn btn-danger btn-sm delete' data-id='" . $row['id'] . "'>
                                        <i class='fa fa-trash'></i> Delete
                                    </button>
                                  </td>
                                </tr>";
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

  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Updated to the full version -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
  $(document).on('click', '.addAcc', function(e){
    e.preventDefault();
    $('#addAcc').modal('show');
  });


  $(document).on('click', '.edit', function() {
    var id = $(this).data('id');
    var username = $(this).data('username');
    var password = $(this).data('password');

    
    $('.id').val(id); 
    $('#username').val(username); 
    $('#password').val(password);

    $('#edit').modal('show');  
});


  $(document).on('click', '.delete', function() {
    var id = $(this).data('id');
    if (confirm("Are you sure you want to delete this account?")) {
      $.ajax({
        type: 'POST',
        url: 'account_delete.php',
        data: { id: id },
        success: function(response) {
          alert('Delete successful');
          location.reload(); 
        },
        error: function() {
          alert('Error deleting the account');
        }
      });
    }
  });
  </script>
</body>
</html>
