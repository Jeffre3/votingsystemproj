<?php
include "connect.php";

// Fetch data
$query = "SELECT * FROM voters ORDER BY id DESC LIMIT 1"; // Adjust query according to your table structure
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result); // Fetch the row
} else {
    echo "No data found!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Result</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="result.css"> <!-- Link to your custom CSS file -->
</head>
<body>

<div class="tab-content">
    <div class="tab-pane fade show active" id="patientInfo">
        <div class="row justify-content-center">
            <div class="card col-md-6 mt-5">
                <h2 class="my-2 card bg-danger text-light text-center">Voting</h2>

                    <div class="form-group">
                        <label for="department">Department:</label>
                        <input type="text" class="form-control" name="department" value="<?php echo htmlspecialchars($row['department']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Stuid">Student ID:</label>
                        <input type="text" class="form-control" name="Stuid" value="<?php echo htmlspecialchars($row['Stuid']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <input type="text" class="form-control" name="gender" value="<?php echo htmlspecialchars($row['gender']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" name="age" value="<?php echo htmlspecialchars($row['age']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="president">For President:</label>
                        <input type="text" class="form-control" name="president" value="<?php echo htmlspecialchars($row['president']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="Vpresident">For Vice President:</label>
                        <input type="text" class="form-control" name="Vpresident" value="<?php echo htmlspecialchars($row['Vpresident']); ?>" disabled> 
                    </div>
                    <div class="form-group">
                        <label for="secretary">For Treasurer:</label>
                        <input type="text" class="form-control" name="treasurer" value="<?php echo htmlspecialchars($row['treasurer']); ?>" disabled> 
                    </div>
                    <div class="form-group">
                        <label for="auditor">For Auditor:</label>
                        <input type="text" class="form-control" name="auditor" value="<?php echo htmlspecialchars($row['auditor']); ?>" disabled> 
                    </div>
                    <div class="form-group">
                        <label for="treasurer">For secretary:</label>
                        <input type="text" class="form-control" name="secretary" value="<?php echo htmlspecialchars($row['secretary']); ?>" disabled> 
                    </div>    
                    <a href="home.php" class="btn btn-warning mb-2">Back</a> 
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
