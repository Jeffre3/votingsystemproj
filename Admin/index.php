<?php
session_start();
include 'connect.php';

$user = $conn->query("SELECT * FROM admin WHERE id = 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voting Dashboard</title>

  <!-- Foundation CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.6.3/css/foundation.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css">

  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

  <style>
    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background-color: black;
      padding: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
    }

    .sidebar h5 {
      font-size: 1.2rem;
      margin-top: 10px;
    }

    .sidebar p {
      font-size: 1rem;
      color: #888;
    }

    .sidebar a {
      display: block;
      padding: 10px;
      margin: 10px 0;
      background-color: #007bff;
      color: white;
      border-radius: 4px;
      text-decoration: none;
      text-align: center;
    }

    .sidebar a:hover {
      background-color: #0056b3;
    }

    .sidebar select {
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    /* Main content section */
    .main {
      margin-left: 260px; /* Allow space for the sidebar */
      padding: 20px;
    }

    .main-header h1 {
      font-size: 2rem;
      color: #333;
    }

    .main-header button {
      font-size: 1rem;
      padding: 10px;
    }

    .stats-cards {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      margin-top: 20px;
      padding: 20px;
    }

    .stats-card {
      background-color: #fff;
      border-radius: 8px;
      padding: 15px;
      width: 30%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .stats-card h3 {
      font-size: 2rem;
      margin: 0;
      color: #333;
    }

    .stats-card p {
      font-size: 1rem;
      color: #666;
    }

    /* Charts section */
    .charts-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 20px;
      margin-top: 30px;
    }

    .chart-container {
      width: 48%;
      background-color: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .chart-container h3 {
      margin-bottom: 15px;
      font-size: 1.2rem;
      color: #333;
    }

    canvas {
      max-width: 100%;
      height: auto;
    }

    @media (max-width: 768px) {
      .stats-cards {
        flex-direction: column;
        align-items: center;
      }

      .stats-card {
        width: 100%;
      }

      .charts-wrapper {
        flex-direction: column;
      }

      .chart-container {
        width: 100%;
      }

      .main {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="https://via.placeholder.com/100" alt="Profile Picture" class="rounded-circle img-fluid mb-3">
    <h5>Carl Johnwesley Chavez</h5>
    <p>Online</p>
    <a href="index.php" class="button primary expanded">Dashboard</a>
    <hr>
    <a href="accounts.php" class="button primary expanded">Accounts</a>
    <a href="voters.php" class="button primary expanded">Voters</a>
    <a href="candidates.php" class="button primary expanded">Candidates</a>
    <hr>
    <form method="GET" action="">
        <select id="departmentFilter" name="department" class="form-control mb-3" onchange="this.form.submit()">
            <option value="">tang ina</option>
            <option value="">All Department</option>
            <option value="IT">Information Technology</option>
            <option value="IS">Information Systems</option>
            <option value="COMSCI">Computer Science</option>
            <option value="EMC">EMC</option>
        </select>
    </form>
</div>

<!-- Main Content -->
<div class="main">
  <div class="main-header">
    <h1>Dashboard</h1>
    <a href="../home.php"><button class="button alert">Logout</button></a>
  </div>

  <!-- Stats Cards -->
  <div class="stats-cards">
    <?php 
    $positions = $conn->query("SELECT COUNT(*) AS count FROM positions")->fetch_assoc()['count'];
    $candidates = $conn->query("SELECT COUNT(*) AS count FROM candidates")->fetch_assoc()['count'];
    $voters = $conn->query("SELECT COUNT(*) AS count FROM voters")->fetch_assoc()['count'];
    ?>
    
    <div class="stats-card">
      <h3><?= $positions ?></h3>
      <p>No. of Positions</p>
    </div>
    
    <div class="stats-card">
      <h3><?= $candidates ?></h3>
      <p>No. of Candidates</p>
    </div>
    
    <div class="stats-card">
      <h3><?= $voters ?></h3>
      <p>Total Voters</p>
    </div>
  </div>

  <!-- Votes Tally -->
  <div class="tally">
    <h2>Votes Tally</h2><br>
    <div class="charts-wrapper">
      <?php 
      $selected_department = isset($_GET['department']) ? $_GET['department'] : null;
      $positions = ['president', 'Vpresident', 'treasurer', 'auditor', 'secretary'];

      foreach ($positions as $position) {
          $query = "SELECT $position AS candidate_name, COUNT($position) AS votes 
                    FROM voters";

          // Add department filter if one is selected
          if ($selected_department) {
              $query .= " WHERE department = '$selected_department'";
          }

          $query .= " GROUP BY $position";

          $result = $conn->query($query);

          $candidate_names = [];
          $candidate_votes = [];
          while ($row = $result->fetch_assoc()) {
              $candidate_names[] = $row['candidate_name'];
              $candidate_votes[] = $row['votes'];
          }

          echo "<div class='chart-container'><h3>" . ucfirst($position) . "</h3>";
          echo "<canvas id='chart-$position'></canvas>";
          echo "<script>
                  new Chart(document.getElementById('chart-$position'), {
                      type: 'bar',
                      data: {
                          labels: " . json_encode($candidate_names) . ",
                          datasets: [{
                              label: 'Votes',
                              data: " . json_encode($candidate_votes) . ",
                              backgroundColor: [
                                  'rgba(54, 162, 235, 0.6)',
                                  'rgba(75, 192, 192, 0.6)',
                                  'rgba(255, 206, 86, 0.6)',
                                  'rgba(153, 102, 255, 0.6)'
                              ],
                              borderColor: [
                                  'rgba(54, 162, 235, 1)',
                                  'rgba(75, 192, 192, 1)',
                                  'rgba(255, 206, 86, 1)',
                                  'rgba(153, 102, 255, 1)'
                              ],
                              borderWidth: 2
                          }]
                      },
                      options: {
                          responsive: true,
                          plugins: {
                              legend: { position: 'top' }
                          },
                          scales: {
                              x: { grid: { display: false } },
                              y: { grid: { color: '#ddd' } }
                          }
                      }
                  });
                </script>";
          echo "</div>";
          
      }
      ?>
    </div>


    
  </div>
</div>

</body>
</html>
