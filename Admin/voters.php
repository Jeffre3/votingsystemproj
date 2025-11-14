<?php
include 'connect.php';
include 'modal_voters.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voters List</title>
  
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
 
  <link rel="stylesheet" href="css/voters.css">
</head>
<body>
  <div class="container mt-4">
    <div class="content-wrapper">
      <a href="index.php" class="btn btn-primary mt-2 ml-1">Back</a> 
      <section class="content-header">
        <center><h2>Voters List</h2></center>
      </section>
      
      <section class="content">
        <?php
        
        if (isset($_SESSION['error'])) {
          echo "<div class='alert alert-danger alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  <h4><i class='icon fa fa-warning'></i> Error!</h4>" . $_SESSION['error'] . "</div>";
          unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
          echo "<div class='alert alert-success alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                  <h4><i class='icon fa fa-check'></i> Success!</h4>" . $_SESSION['success'] . "</div>";
          unset($_SESSION['success']);
        }
        ?>
        
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"></div>
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Email</th>
                      <th>Name</th>
                      <th>Department</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM voters";
                    $query = $conn->query($sql);
                    while ($row = $query->fetch_assoc()) {
                      echo "<tr>
                              <td>" . $row['Stuid'] . "</td>
                              <td>" . $row['email'] . "</td>
                              <td>" . $row['name'] . "</td>
                              <td>" . $row['department'] . "</td>
                              <td>
                                <button class='btn btn-success btn-sm edit-btn' 
                                  data-id='" . $row['id'] . "' 
                                  data-name='" . $row['name'] . "' 
                                  data-email='" . $row['email'] . "' 
                                  data-Stuid='" . $row['Stuid'] . "' 
                                  data-department='" . $row['department'] . "'>
                                  <i class='fa fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm delete-btn' data-id='" . $row['id'] . "'>
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

  
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    
    $(document).on('click', '.edit-btn', function() {
      var id = $(this).data('id');
      var name = $(this).data('name');
      var email = $(this).data('email');
      var Stuid = $(this).data('Stuid');
      var department = $(this).data('department');

      $('.modal .id').val(id);
      $('#name').val(name);
      $('#email').val(email);
      $('#Stuid').val(Stuid);
      $('#department').val(department);

      $('#edit').modal('show');
    });

  
    $(document).on('click', '.delete-btn', function() {
      var id = $(this).data('id');
      if (confirm("Are you sure you want to delete this voter?")) {
        $.ajax({
          type: 'POST',
          url: 'voters_delete.php',
          data: { id: id },
          success: function(response) {
            alert('Delete successful');
            location.reload(); 
          },
          error: function() {
            alert('Error deleting the voter');
          }
        });
      }
    });
  </script>
</body>
</html>
