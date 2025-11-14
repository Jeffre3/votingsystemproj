<?php
include "connect.php";
$current_page = basename($_SERVER['PHP_SELF'], "cs.php");

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
                        <a href="it.php" class="nav__link <?php echo ($current_page == 'cs.php') ? 'active' : ''; ?>">
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
            <a href="is.php">
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
            <a href="is.php">
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
            <a href="is.php">
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
            <a href="is.php">
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
            <a href="#CS1-Partylist">
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
            <a href="#CS2-Partylist">
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
            <a href="#CS3-Partylist">
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
            <a href="#IndependentCS">
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
                <h1 class="Title" id="IT1-Partylist">CS Department</h1>
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
                        <option value="Miguel Rivera">Miguel Rivera</option>
                        <option value="Aria Santos">Aria Santos</option>
                        <option value="Harold Legazpi">Harold Legazpi</option>
                        <option value="Justin Rivera">Justin Rivera</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Vpresident">Vote for Vice President:</label>
                    <select id="Vpresident" name="Vpresident" required>
                        <option value="" disabled selected>Select Vice President</option>
                        <option value="Leo Kim">Leo Kim</option>
                        <option value="Mia Garcia">Mia Garcia</option>
                        <option value="Robert Martinez">Robert Martinez</option>
                        <option value="Jamie Lee">Jamie Lee</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="secretary">Vote for Secretary:</label>
                    <select id="secretary" name="secretary" required>
                        <option value="" disabled selected>Select Secretary</option>
                        <option value="Sofia Martinez">Sofia Martinez</option>
                        <option value="Lilia Dela Cruz">Lilia Dela Cruz</option>
                        <option value="Aisha Garcia">Aisha Garcia</option>
                        <option value="Jordan Kim">Jordan Kim</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auditor">Vote for Auditor:</label>
                    <select id="auditor" name="auditor" required>
                        <option value="" disabled selected>Select Auditor</option>
                        <option value="Mia Thompson">Mia Thompson</option>
                        <option value="Marie Ramos">Marie Ramos</option>
                        <option value="Ryan Kim">Ryan Kim</option>
                        <option value="Taylor Nguyen">Taylor Nguyen</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="treasurer">Vote for Treasurer:</label>
                    <select id="treasurer" name="treasurer" required>
                        <option value="" disabled selected>Select Treasurer</option>
                        <option value="Emma Lee">Emma Lee</option>
                        <option value="Zoe Reyes">Zoe Reyes</option>
                        <option value="Sophia Lee">Sophia Lee</option>
                        <option value="Casey Brooks">Casey Brooks</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="button">Submit Ballot</button>
            </form>
        </div>
    </div>

  <div class="wrapper">
    
    <div class="title-container">
      <h1 class="Title" id="CS1-Partylist">CS1 Partylist</h1>
    </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://cens.ph/assets/images/members/franz.jpg">
        <p>Name: Miguel Rivera</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Together We Rise!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://i.pinimg.com/originals/59/d2/81/59d28109f2458256b5702db20af0c655.jpg">
        <p>Name: Leo Kim</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Your Voice Matters!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://image.civitai.com/xG1nkqKTMzGDvpLrqFT7WA/4b490d17-3b77-41c7-8f9f-3791eacf0386/width=450/1712615.jpeg">
        <p>Name: Sofia Martinez</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organized for You!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9yo2BQAyaxozqY_-keqVmUlQUPkEErL9p9g&s">
        <p>Name: Mia Thompson</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Transparency is Key!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/e4/d8/72/e4d87286adc6db4ff8bebcfb3c3ed5af.jpg">
        <p>Name: Emma Lee</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Count on Me!"</p>
    </div>
    
</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="CS2-Partylist">CS2 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/550x/a1/d2/67/a1d2672da9101ac1419e87ee7f31927e.jpg">
        <p>Name: Aria Santos</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Lead with Purpose!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://i.pinimg.com/736x/5c/65/58/5c6558a17be2e41b4f0d6605194be853.jpg">
        <p>Name: Mia Garcia</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Together We Thrive!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://www.pier.or.th/static/fa7198c6e9caf4e135c6b88f67a410e5/a89ca/profile.jpg">
        <p>Name: Lilia Dela Cruz</p>
        <p>Age: 20</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organize for Success!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://www.federislaw.com.ph/wp-content/uploads/2024/09/1x1.jpg">
        <p>Name: Marie Ramos</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Integrity in Numbers!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/e9/22/82/e92282a661555afb1c20edb9a6bc4c7c.jpg">
        <p>Name: Zoe Reyes</p>
        <p>Age: 19</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Your Funds, Our Future!"</p>
    </div>
    
</section>	

</div>

<div class="wrapper">
    
  <div class="title-container">
    <h1 class="Title" id="CS3-Partylist">CS3 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://cens.ph/assets/images/members/mark.jpg">
        <p>Name: Harold Legazpi</p>
        <p>Age: 28</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Empower Your Voice!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://cens.ph/assets/images/members/ryan.jpg">
        <p>Name: Robert Martinez</p>
        <p>Age: 26</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Together We Can!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://cens.ph/assets/images/members/precious.jpg">
        <p>Name: Aisha Garcia</p>
        <p>Age: 22</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organizing for Progress!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://www.mastersflyingschool.com/files/students/74.jpg">
        <p>Name: Ryan Kim</p>
        <p>Age: 25</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Integrity Above All!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://pbs.twimg.com/media/F4s5HMgboAAoLOF.jpg">
        <p>Name: Sophia Lee</p>
        <p>Age: 24</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Securing Our Future!"</p>
    </div>
    

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IndependentCS">Independent (CS)</h1>
  </div>

<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://www.mastersflyingschool.com/files/students/53.jpg">
        <p>Name: Justin Rivera</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Lead with Purpose!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://img.lazcdn.com/g/p/9684b451b46332c18ac6df736c3f8d61.png_720x720q80.png">
        <p>Name: Jamie Lee</p>
        <p>Age: 18</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Unity in Diversity!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://i.pinimg.com/736x/7d/32/b6/7d32b635740f9d8eb4326d24e730fcd4.jpg">
        <p>Name: Jordan Kim</p>
        <p>Age: 22</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organize to Mobilize!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://i.pinimg.com/736x/84/0c/26/840c2672a1db2b2268531e12f8b024ed.jpg">
        <p>Name: Taylor Nguyen</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Transparency is Key!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/236x/97/01/9c/97019c92570b0846632e3bcedacee0b7.jpg">
        <p>Name: Casey Brooks</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Your Funds, Our Future!"</p>
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