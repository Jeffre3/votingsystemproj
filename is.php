<?php
include "connect.php";
$current_page = basename($_SERVER['PHP_SELF'], "is.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['button'])) {
    $department = $_POST['department'] ?? null;
    $Stuid = $_POST['Stuid'] ?? null;
    $email = $_POST['email'] ?? null;
    $name = $_POST['name'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $age = $_POST['age'] ?? null;
    $president = $_POST['president'] ?? null;
    $Vpresident = $_POST['Vpresident'] ?? null;
    $secretary = $_POST['secretary'] ?? null;
    $auditor = $_POST['auditor'] ?? null;
    $treasurer = $_POST['treasurer'] ?? null;

    if (isset($department, $email, $Stuid, $name, $gender, $age, $president, $Vpresident, $secretary, $auditor, $treasurer)) {
        // Prepare statement for database insertion
        $stmt = $conn->prepare("INSERT INTO voters (department, email, Stuid, name, gender, age, president, Vpresident, secretary, auditor, treasurer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissssssss", $department, $email, $Stuid, $name, $gender, $age, $president, $Vpresident, $secretary, $auditor, $treasurer);

        if ($stmt->execute()) {
            // Prepare email
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'systemvotinggg@gmail.com';
                $mail->Password = 'hfzl gacx lzni tbgr'; // Sensitive information should be stored securely
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('systemvotinggg@gmail.com', 'Voting System');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Voting Confirmation';
                $mail->Body = "Dear $name,<br><br>Thank you for voting. Here are the details of your votes:<br>
                               <b>President:</b> $president<br>
                               <b>Vice President:</b> $Vpresident<br>
                               <b>Secretary:</b> $secretary<br>
                               <b>Auditor:</b> $auditor<br>
                               <b>Treasurer:</b> $treasurer<br>
                               Best regards,<br>Voting Committee";

                $mail->send();
                echo '<script>alert("Email sent successfully.");</script>';
            } catch (Exception $e) {
                echo '<script>alert("Email sending failed. Error: ' . $mail->ErrorInfo . '");</script>';
            }

            $_SESSION['notification'] = 'Vote Successful';
            header("Location: result.php");
            exit();
        } else {
            echo '<script>alert("Error: ' . $stmt->error . '");</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("All fields are required!");</script>';
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="assets\css\info.css">
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>VotingIna Mo</title>
  <style>
  button {
    border: none;
    font-family: inherit;
    font-size: inherit;
    color: white;
    background: none;
    cursor: pointer;
    padding: 25px 80px;
    display: inline-block;
    margin: 15px 30px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    outline: none;
    position: relative;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
      background-color: #000000;
      border-radius: 2rem;
}
  </style>

</head>
<body id="body">
        <div class="l-navbar" id="navbar">
            <nav class="nav">
                <div>
                    <a href="home.php" class="nav__logo">
                        <img src="assets/icons/logo.svg" alt="" class="nav__logo-icon">
                        <span class="nav__logo-text">VotingInaMo</span>
                    </a>
    
                    <div class="nav__toggle" id="nav-toggle">
                        <i class='bx bx-chevron-right'></i>
                    </div>
    
                    <ul class="nav__list">
                        <a href="home.php" class="nav__link <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__text">Home</span>
                        </a>
                        <a href="is.php" class="nav__link <?php echo ($current_page == 'is.php') ? 'active' : ''; ?>">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__text">Candidates</span>
                        </a>
                        <a href="notification.php" class="nav__link <?php echo ($current_page == 'notification') ? 'active' : ''; ?>">
                            <i class='bx bx-bell nav__icon'></i>
                            <span class="nav__text">Notification</span>
                        </a>
                        <a href="home.php" class="nav__link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">
                            <i class='bx bx-heart nav__icon'></i>
                            <span class="nav__text">About</span>
                        </a>
                        <a href="LR.php" class="nav__link <?php echo ($current_page == 'login') ? 'active' : ''; ?>">
                            <i class='bx bx-bookmark nav__icon'></i>
                            <span class="nav__text">Login</span>
                        </a>
                        <a href="register.php" class="nav__link <?php echo ($current_page == 'signup') ? 'active' : ''; ?>">
                            <i class='bx bx-message-rounded nav__icon'></i>
                            <span class="nav__text">Signup</span>
                        </a>                 
                    </ul>
                </div>
            </nav>
        </div>

  <div class="wrapper_yellow">
    <div class="title-container">
      <h1 class="Title">Partylist</h1>
    </div>
    <div class="title-container">
      <h2 class="Lists">
        <span class="list-item" data-carousel="it">IT</span>
        <span class="list-item" data-carousel="cs">IS</span>
        <span class="list-item" data-carousel="ems">CS</span>
        <span class="list-item" data-carousel="cpe">EMC</span>
      </h2>
    </div>

    <!--Carousel Gallery-->
    <div class="carousel-gallery">
      <div class="swiper-container" id="carousel-it">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="it.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IT1 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="it.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IT2 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="it.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IT3 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="it.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>Independent (IT)</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg" data-fancybox="gallery">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-vector/crowded-people-face-vector-silhouette-10_1119689-3774.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>



      <!-- Other Carousels -->
      <div class="swiper-container" id="carousel-cs" style="display:none;">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="#IS1-Partylist">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IS1 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="#IS2-Partylist">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IS2 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="#IS3-Partylist">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>IS3 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="#IndependentIS">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>Independent (IS)</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=" data-fancybox="gallery">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>



      <div class="swiper-container" id="carousel-ems" style="display:none;">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="cs.php">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1205518142/vector/artists-on-stage.jpg?s=612x612&w=0&k=20&c=6zBR8WC1LQNo_EZ6FKoQa4Wl7-VN3Q6PAUfqC4myUsc=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>CS1 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="cs.php">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1205518142/vector/artists-on-stage.jpg?s=612x612&w=0&k=20&c=6zBR8WC1LQNo_EZ6FKoQa4Wl7-VN3Q6PAUfqC4myUsc=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>CS2 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="cs.php">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1205518142/vector/artists-on-stage.jpg?s=612x612&w=0&k=20&c=6zBR8WC1LQNo_EZ6FKoQa4Wl7-VN3Q6PAUfqC4myUsc=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>CS3 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="cs.php">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1205518142/vector/artists-on-stage.jpg?s=612x612&w=0&k=20&c=6zBR8WC1LQNo_EZ6FKoQa4Wl7-VN3Q6PAUfqC4myUsc=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>Independent (CS)</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=" data-fancybox="gallery">
              <div class="image" style="background-image: url(https://media.istockphoto.com/id/1205518142/vector/artists-on-stage.jpg?s=612x612&w=0&k=20&c=6zBR8WC1LQNo_EZ6FKoQa4Wl7-VN3Q6PAUfqC4myUsc=)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

      <div class="swiper-container" id="carousel-cpe" style="display:none;">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <a href="emc.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-photo/silhouette-group-people-isolated-white-background_359013-5273.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>EMC1 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="emc.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-photo/silhouette-group-people-isolated-white-background_359013-5273.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>EMC2 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="emc.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-photo/silhouette-group-people-isolated-white-background_359013-5273.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>EMC3 Partylist</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="emc.php">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-photo/silhouette-group-people-isolated-white-background_359013-5273.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
                <div class="text-overlay">
                  <h3>Independent (EMC)</h3>
                </div>
              </div>
            </a>
          </div>
          <div class="swiper-slide">
            <a href="https://media.istockphoto.com/id/1127377693/vector/group-of-people-crowd-of-people-silhouettes.jpg?s=612x612&w=0&k=20&c=b9EI5beoAATGaxkkAweHzdFEnQVxLMuSurTxiwPzVLM=" data-fancybox="gallery">
              <div class="image" style="background-image: url(https://img.freepik.com/premium-photo/silhouette-group-people-isolated-white-background_359013-5273.jpg)">
                <div class="overlay">
                  <em class="mdi mdi-magnify-plus"></em>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
  <!--#Carousel Gallery-->

  <div class="wrapper_gray">         
    <section class="columns">
        <div class="column">
            <section class="color-1">
			
            <button id="openModal">Vote Now</button>
			</section>
        </div>

    </section>	
    </div>

    <div class="modal" id="votingModal">
        <div class="modal-card">
            <button class="close-btn" id="closeModal">&times;</button>
            <div class="title-container">
                <h1 class="Title" id="IT1-Partylist">IS Department</h1>
             </div>
            <hr>
            <h4>Personal Info</h4>
            <form method="post" action="it.php">
                <div class="form-group">
                    <label for="Stuid">Student ID:</label>
                    <input type="text" id="Stuid" name="Stuid" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select id="department" name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="COMSCI">Computer Science</option>
                        <option value="IS">Information System</option>
                        <option value="IT">Information Technology</option>
                        <option value="EMC">EMC</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <hr>
                <h4>Candidates</h4>
                <div class="form-group">
                    <label for="president">Vote for President:</label>
                    <select id="president" name="president" required>
                        <option value="" disabled selected>Select President</option>
                        <option value="Lucas Delgado">Lucas Delgado</option>
                        <option value="Maya Alonzo">Maya Alonzo</option>
                        <option value="Lexi Torres">Lexi Torres</option>
                        <option value="Lily Morales">Lily Morales</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Vpresident">Vote for Vice President:</label>
                    <select id="Vpresident" name="Vpresident" required>
                        <option value="" disabled selected>Select Vice President</option>
                        <option value="Zara Kim">Zara Kim</option>
                        <option value="Raj Patel">Raj Patel</option>
                        <option value="Aiden Li">Aiden Li</option>
                        <option value="Ravi Patel">Ravi Patel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="secretary">Vote for Secretary:</label>
                    <select id="secretary" name="secretary" required>
                        <option value="" disabled selected>Select Secretary</option>
                        <option value="Ravi Singh">Ravi Singh</option>
                        <option value="Elena Kim">Elena Kim</option>
                        <option value="Mia Santos">Mia Santos</option>
                        <option value="Emily Chen">Emily Chen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auditor">Vote for Auditor:</label>
                    <select id="auditor" name="auditor" required>
                        <option value="" disabled selected>Select Auditor</option>
                        <option value="Priya Patel">Priya Patel</option>
                        <option value="Liam Torres">Liam Torres</option>
                        <option value="Noah Ramirez">Noah Ramirez</option>
                        <option value="Mikha Johnson">Mikha Johnson</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="treasurer">Vote for Treasurer:</label>
                    <select id="treasurer" name="treasurer" required>
                        <option value="" disabled selected>Select Treasurer</option>
                        <option value="Noah Brooks">Noah Brooks</option>
                        <option value="Sofia Reyes">Sofia Reyes</option>
                        <option value="Aaron Gramonte">Aaron Gramonte</option>
                        <option value="Sofia Garcia">Sofia Garcia</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="button">Submit Ballot</button>
            </form>
        </div>
    </div>

  <div class="wrapper">
    
    <div class="title-container">
      <h1 class="Title" id="IS1-Partylist">IS1 Partylist</h1>
    </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://www.shutterstock.com/image-photo/id-photo-portrait-handsome-mature-260nw-1592137060.jpg">
        <p>Name: Lucas Delgado</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Together We Rise!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXgGadvvLHcq_nDcFxB0KgYiQBDZNM2zMTZ5yDP_vrzgLiQl7UeuS6WJx9rB8GccKvzXY&usqp=CAU">
        <p>Name: Zara Kim</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Empower Each Other!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://pbs.twimg.com/media/F4xcqSTaUAExkuh.jpg:large">
        <p>Name: Ravi Singh</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Voices of Change!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://www.bcc-phil.com/wp-content/uploads/2020/07/Galorport-Dawn-Shella-May-Acctng-Clerk-and-Asst-Cashier.jpg">
        <p>Name: Priya Patel</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Transparency Matters!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i1.rgstatic.net/ii/profile.image/1083195718148109-1635265392662_Q512/Ian-Cary-Prado.jpg">
        <p>Name: Noah Brooks</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Counting on You!"</p>
    </div>
    

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IS2-Partylist">IS2 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/236x/94/1b/5d/941b5dddc38129e0d241281e4d3d7637.jpg">
        <p>Name: Maya Alonzo</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Empower, Inspire, Achieve!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://www.xu.edu.ph/images/2021/img/may/1x1.PNG">
        <p>Name: Raj Patel</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Your Voice Matters!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://toplist.info/images/800px/nayeon-777920.jpg">
        <p>Name: Elena Kim</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Together, We Can!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://amchamfoundation.com/wp-content/uploads/2021/09/Louise-Auren-B.-Alte.jpg">
        <p>Name: Liam Torres</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Integrity in Action!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/474x/20/c5/51/20c551f6d0966f90d6fe91fe0e19f2c9.jpg">
        <p>Name: Sofia Reyes</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Count on Me!"</p>
    </div>
    
</section>	

</div>

<div class="wrapper">
    
  <div class="title-container">
    <h1 class="Title" id="IS3-Partylist">IS3 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/736x/f3/6e/af/f36eaf418aef5d7b7f3cf76e6bf60ec3.jpg">
        <p>Name: Lexi Torres</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Unity in Diversity"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://cdn.kenzap.com/600/a5706_1.jpeg">
        <p>Name: Aiden Li</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Together We Rise"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://i.pinimg.com/236x/97/01/9c/97019c92570b0846632e3bcedacee0b7.jpg">
        <p>Name: Mia Santos</p>
        <p>Age: 20</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Your Ideas Matter!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://lidlidda.gov.ph/wp-content/uploads/2021/07/HON.-JAMES-S.-SACAYANAN.jpg">
        <p>Name: Noah Ramirez</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Transparency is Key!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://mir-s3-cdn-cf.behance.net/user/276/21a65a1164519163.61dd2875daaa3.jpg">
        <p>Name: Aaron Gramonte</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Counting on You!"</p>
    </div>
    

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IndependentIS">Independent (IS)</h1>
  </div>

<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/736x/29/c0/34/29c03453d21532502b6f31a64de3b0c5.jpg">
        <p>Name: Lily Morales</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Empower, Inspire, Lead!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://www.bcc-phil.com/wp-content/uploads/2020/08/Jhonny-Aquilino.jpg">
        <p>Name: Ravi Patel</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Together We Achieve!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://i.pinimg.com/236x/30/59/de/3059def6aaa5eba65ac68c26731821ca.jpg">
        <p>Name: Emily Chen</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Your Voice, Our Vision!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://preview.redd.it/kpop-idol-zoa-v0-2r3dcj1ls3mb1.jpg?width=640&crop=smart&auto=webp&s=c89bee3b65f794e6121d5145e86458e9a61b884f">
        <p>Name: Mikha Johnson</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Integrity in Action!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/63/97/fb/6397fb93b7d395f5f0c210dfcc505aac.jpg">
        <p>Name: Sofia Garcia</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Count on Me!"</p>
    </div>
    

</section>	

</div>

  <footer id="footer">
    <nav class="footer-container container">
      <ul class="footer-links">
        <li class="footer-item"><a class="footer-link" href="/privacy">Privacy Policy</a></li>
        <li class="footer-item"><a class="footer-link" href="/terms">Terms of Service</a></li>
        <li class="footer-item"><a class="footer-link" href="/contact">Contact</a></li>
      </ul>
    </nav>
    <div class="footer-info">
      <p>&copy; 2024 VotingIna Mo. All rights reserved.</p>
    </div>
  </footer>


</body>
<script src="assets/js/main.js"></script>
<script>
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const modal = document.getElementById('votingModal');

        openModal.addEventListener('click', () => {
            modal.classList.add('active');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.remove('active');
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
<script>
  $(document).ready(function () {
    var swiperIT = new Swiper('#carousel-it', {
      effect: 'slide',
      speed: 1900,
      slidesPerView: 5,
      spaceBetween: 20,
      simulateTouch: true,
      autoplay: {
        delay: 5000,
        stopOnLastSlide: false,
        disableOnInteraction: false
      },
      pagination: {
        el: '#carousel-it .swiper-pagination',
        clickable: true
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 5
        },
        425: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20
        }
      }
    });

    // Initialize other carousels similarly if they have content
  });

  function showCarousel(selected) {
    // Hide all carousels
    const carousels = document.querySelectorAll('.swiper-container');
    carousels.forEach(carousel => {
      carousel.style.display = 'none';
    });

    // Show the selected carousel
    document.getElementById(`carousel-${selected}`).style.display = 'block';

    // Reinitialize Swiper for the selected carousel
    new Swiper(`#carousel-${selected}`, {
      effect: 'slide',
      speed: 1900,
      slidesPerView: 5,
      spaceBetween: 20,
      simulateTouch: true,
      autoplay: {
        delay: 5000,
        stopOnLastSlide: false,
        disableOnInteraction: false
      },
      pagination: {
        el: `#carousel-${selected} .swiper-pagination`,
        clickable: true
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 5
        },
        425: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 20
        }
      }
    });
  }

  // Event listener for list items to toggle carousels
  const listItems = document.querySelectorAll('.list-item');
  listItems.forEach(item => {
    item.addEventListener('click', function () {
      // Remove active class from all items
      listItems.forEach(i => i.classList.remove('active'));

      // Add active class to the clicked item
      this.classList.add('active');

      // Show the corresponding carousel
      showCarousel(this.getAttribute('data-carousel'));
    });
  });

  // Initialize the first carousel (IT) by default
  document.addEventListener('DOMContentLoaded', () => {
    showCarousel('it');
  });
</script>

<script>
  function toggleMobileMenu(menu) {
      menu.classList.toggle('open');
  }
</script>

</html>