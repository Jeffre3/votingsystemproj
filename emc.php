<?php
include "connect.php";
$current_page = basename($_SERVER['PHP_SELF'], "emc.php");
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
                        <a href="it.php" class="nav__link <?php echo ($current_page == 'emc.php') ? 'active' : ''; ?>">
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
            <a href="#CPE1-Partylist">
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
            <a href="#CPE2-Partylist">
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
            <a href="#CPE3-Partylist">
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
            <a href="#IndependentCPE">
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
                <h1 class="Title" id="IT1-Partylist">EMC Department</h1>
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
                        <option value="CJ Chavez">CJ Chavez</option>
                        <option value="Alex Rivera">Alex Rivera</option>
                        <option value="Daniel Reyes">Daniel Reyes</option>
                        <option value="Ethan Garcia">Ethan Garcia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Vpresident">Vote for Vice President:</label>
                    <select id="Vpresident" name="Vpresident" required>
                        <option value="" disabled selected>Select Vice President</option>
                        <option value="Jeffrey Lagunero">Jeffrey Lagunero</option>
                        <option value="Jamie Santos">Jamie Santos</option>
                        <option value="Ashley Gomez">Ashley Gomez</option>
                        <option value="Isabella Cruz">Isabella Cruz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="secretary">Vote for Secretary:</label>
                    <select id="secretary" name="secretary" required>
                        <option value="" disabled selected>Select Secretary</option>
                        <option value="Abel Gramonte">Abel Gramonte</option>
                        <option value="Sarah Cruz">Sarah Cruz</option>
                        <option value="Jenna Cruz">Jenna Cruz</option>
                        <option value="Alyssa Mendoza">Alyssa Mendoza</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auditor">Vote for Auditor:</label>
                    <select id="auditor" name="auditor" required>
                        <option value="" disabled selected>Select Auditor</option>
                        <option value="Staney Dominador">Staney Dominador</option>
                        <option value="Chris Dela Cruz">Chris Dela Cruz</option>
                        <option value="Marco Fernandez">Marco Fernandez</option>
                        <option value="Joshua Reyes">Joshua Reyes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="treasurer">Vote for Treasurer:</label>
                    <select id="treasurer" name="treasurer" required>
                        <option value="" disabled selected>Select Treasurer</option>
                        <option value="Carl Layson">Carl Layson</option>
                        <option value="Mia Lopez">Mia Lopez</option>
                        <option value="Mia Torres">Mia Torres</option>
                        <option value="Chloe Santos">Chloe Santos</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="button">Submit Ballot</button>
            </form>
        </div>
    </div>

  <div class="wrapper">
    
    <div class="title-container">
      <h1 class="Title" id="CPE1-Partylist">EMC1 Partylist</h1>
    </div>


<section class="columns">
<div class="column">
    <h2>President</h2>
    <img src="https://static.vecteezy.com/system/resources/previews/032/176/017/non_2x/business-avatar-profile-black-icon-man-of-user-symbol-in-trendy-flat-style-isolated-on-male-profile-people-diverse-face-for-social-network-or-web-vector.jpg">
    <p>Name: CJ Chavez</p>
    <p>Age: 20</p>
    <p>Year: 3rd Year</p>
    <p>Motto: Innovating Today, Leading Tomorrow!</p>
</div>

<div class="column">
    <h2>Vice President</h2>
    <img src="https://static.vecteezy.com/system/resources/previews/032/176/017/non_2x/business-avatar-profile-black-icon-man-of-user-symbol-in-trendy-flat-style-isolated-on-male-profile-people-diverse-face-for-social-network-or-web-vector.jpg">
    <p>Name: Jeffrey Lagunero</p>
    <p>Age: 21</p>
    <p>Year: 2nd Year</p>
    <p>Motto: Empowering Technology, Empowering You.</p>
</div>

<div class="column">
    <h2>Secretary</h2>
    <img src="https://static.vecteezy.com/system/resources/previews/032/176/017/non_2x/business-avatar-profile-black-icon-man-of-user-symbol-in-trendy-flat-style-isolated-on-male-profile-people-diverse-face-for-social-network-or-web-vector.jpg">
    <p>Name: Abel Gramonte</p>
    <p>Age: 20</p>
    <p>Year: 3rd Year</p>
    <p>Motto: Code Today, Lead Tomorrow!</p>
</div>

<div class="column">
  <h2>Auditor</h2>
  <img src="https://static.vecteezy.com/system/resources/previews/032/176/017/non_2x/business-avatar-profile-black-icon-man-of-user-symbol-in-trendy-flat-style-isolated-on-male-profile-people-diverse-face-for-social-network-or-web-vector.jpg">
  <p>Name: Staney Dominador</p>
  <p>Age: 21</p>
  <p>Year: 3rd Year</p>
  <p>Motto: Connect, Create, Conquer!</p>
</div>

<div class="column">
  <h2>Treasurer</h2>
  <img src="https://static.vecteezy.com/system/resources/previews/032/176/017/non_2x/business-avatar-profile-black-icon-man-of-user-symbol-in-trendy-flat-style-isolated-on-male-profile-people-diverse-face-for-social-network-or-web-vector.jpg">
  <p>Name: Carl Layson</p>
  <p>Age: 21</p>
  <p>Year: 3rd Year</p>
  <p>Motto: When there's a hole, There's a way</p>
</div>

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="CPE2-Partylist">EMC2 Partylist</h1>
  </div>


  <section class="columns">
    <div class="column">
      <h2>President</h2>
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2dHLC073XsS100ABTZmmN_Fa6kPqiMpgKH3lUTznHcgiv0n396rhA57GUhuqTrJuWuxo&usqp=CAU">
      <p>Name: Alex Rivera</p>
      <p>Age: 20</p>
      <p>Year: 3rd Year</p>
      <p>Motto: "Leading with Vision, Driven by Tech!"</p>
    </div>
  
    <div class="column">
      <h2>Vice President</h2>
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu_O_V_Fse20_SEReZTtYBEqWXHMYjbHTAryrWCxsCwvpjDw6GZyATcX_6zPTv0LCa-I4&usqp=CAU">
      <p>Name: Jamie Santos</p>
      <p>Age: 19</p>
      <p>Year: 2nd Year</p>
      <p>Motto: "Together, We Code the Future!"</p>
    </div>
  
    <div class="column">
      <h2>Secretary</h2>
      <img src="https://i.pinimg.com/236x/d9/c3/24/d9c324c7802a59b269f12cf22a14f529.jpg">
      <p>Name: Sarah Cruz</p>
      <p>Age: 21</p>
      <p>Year: 4th Year</p>
      <p>Motto: "Organize, Optimize, Innovate!"</p>
    </div>
  
    <div class="column">
      <h2>Auditor</h2>
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVdL_eqm9Jvcr3M5dfB06CXxOzmY3T5cn8dC5amUWKy1nnPnDBG79egOmb-vKuT5BuZzA&usqp=CAU">
      <p>Name: Chris Dela Cruz</p>
      <p>Age: 20</p>
      <p>Year: 3rd Year</p>
      <p>Motto: "Numbers Matter, Transparency Always!"</p>
    </div>
  
    <div class="column">
      <h2>Treasurer</h2>
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUpXBsZsfrZ5MHCMPmhi5nyau7Dp5yIOK9xg&s">
      <p>Name: Mia Lopez</p>
      <p>Age: 18</p>
      <p>Year: 1st Year</p>
      <p>Motto: "Saving Smart, Leading Strong!"</p>
    </div>
  </section>
  

</div>

<div class="wrapper">
    
  <div class="title-container">
    <h1 class="Title" id="CPE3-Partylist">EMC3 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwSo01DHZXzurU0arOkVGMsfwYFXFfIVw73CgdfwXJQ8369MZW-xeHIfdzx-p3WUMFek0&usqp=CAUg">
        <p>Name: Daniel Reyes</p>
        <p>Age: 21</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Innovation in Action, Leadership in Progress!"</p>
      </div>
      
      <div class="column">
        <h2>Vice President</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJtqjYSPA-KFTUYbkLepwPqdza1IRbxbDzPJn_MQqUlguTzkt1eIuIIA1umQ9MJ6MOwbw&usqp=CAU">
        <p>Name: Ashley Gomez</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Your Voice, Our Priority!"</p>
      </div>
      
      <div class="column">
        <h2>Secretary</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5w2P2-wR_rNbbdc1pAvX70k-QUSzms5-zsg&s">
        <p>Name: Jenna Cruz</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organizing for a Better Tomorrow!"</p>
      </div>
      
      <div class="column">
        <h2>Auditor</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxYF01WqVRoqN25GjOm8K-JRU5c3m125FT1kqjO2ximRnZJdvkB2C2vLFlc4xMwuJX7OA&usqp=CAU">
        <p>Name: Marco Fernandez</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Trust in Transparency, Trust in Me!"</p>
      </div>
      
      <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/a7/8c/eb/a78ceb29c87f39161e7d78825bb17186.jpg">
        <p>Name: Mia Torres</p>
        <p>Age: 18</p>
        <p>Year: 1st Year</p>
        <p>Motto: "Smart with Funds, Strong in Leadership!"</p>
      </div>
      

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IndependentCPE">Independent (EMC)</h1>
  </div>

<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://fulbright.org.ph/images/cwgallery/2-alumni/thumb_2_11a0d66520dcb7cb237e2d82223d2163.jpg">
        <p>Name: Ethan Garcia</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Leading with Passion, Innovating with Purpose!"</p>
      </div>
      
      <div class="column">
        <h2>Vice President</h2>
        <img src="https://100percentrenewables.com.au/wp-content/uploads/2022/08/Regine-Baltazar.png">
        <p>Name: Isabella Cruz</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Your Voice, Our Strength!"</p>
      </div>
      
      <div class="column">
        <h2>Secretary</h2>
        <img src="https://intramuros.gov.ph/wp-content/uploads/2021/09/Screen-Shot-2021-09-14-at-7.49.58-PM.png">
        <p>Name: Alyssa Mendoza</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Organizing for Progress!"</p>
      </div>
      
      <div class="column">
        <h2>Auditor</h2>
        <img src="https://i.pinimg.com/236x/b4/cb/d6/b4cbd639a71db86edfdfbbc57a85961a.jpg">
        <p>Name: Joshua Reyes</p>
        <p>Age: 21</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Keeping it Clear, Keeping it Fair!"</p>
      </div>
      
      <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/9c/7f/f9/9c7ff92f60f204c903f3166a20f8edb3.jpg">
        <p>Name: Chloe Santos</p>
        <p>Age: 18</p>
        <p>Year: 1st Year</p>
        <p>Motto: "Budgeting for a Better Future!"</p>
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