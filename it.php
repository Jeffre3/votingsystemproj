<?php
include "connect.php";
$current_page = basename($_SERVER['PHP_SELF'], "it.php");

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
                        <a href="home.php" class="nav__link">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__text">Home</span>
                        </a>
                        <a href="it.php" class="nav__link <?php echo ($current_page == 'it.php') ? 'active' : ''; ?>">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__text">Candidates</span>
                        </a>
                        
                        <a href="home.php" class="nav__link">
                            <i class='bx bx-heart nav__icon'></i>
                            <span class="nav__text">About</span>
                        </a>
                        <a href="LR.php" class="nav__link">
                            <i class='bx bx-bookmark nav__icon'></i>
                            <span class="nav__text">Login</span>
                        </a>
                        <a href="register.php" class="nav__link">
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
            <a href="#IT1-Partylist">
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
            <a href="#IT2-Partylist">
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
            <a href="#IT3-Partylist">
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
            <a href="#IndependentIT">
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
                <h1 class="Title" id="IT1-Partylist">IT Department</h1>
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
                        <option value="Liam Thompson">Liam Thompson</option>
                        <option value="Abby Johnson">Abby Johnson</option>
                        <option value="Liam Torres">Liam Torres</option>
                        <option value="Alex Rivera">Alex Rivera</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="Vpresident">Vote for Vice President:</label>
                    <select id="Vpresident" name="Vpresident" required>
                        <option value="" disabled selected>Select Vice President</option>
                        <option value="Ava Martinez">Ava Martinez</option>
                        <option value="Maya Patel">Maya Patel</option>
                        <option value="Aria Mendoza">Aria Mendoza</option>
                        <option value="Maya Ortiz">Maya Ortiz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="secretary">Vote for Secretary:</label>
                    <select id="secretary" name="secretary" required>
                        <option value="" disabled selected>Select Secretary</option>
                        <option value="Alliyah Kim">Alliyah Kim</option>
                        <option value="Samira Lee">Samira Lee</option>
                        <option value="Jayden Lim">Jayden Lim</option>
                        <option value="Rohan Patel">Rohan Patel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="auditor">Vote for Auditor:</label>
                    <select id="auditor" name="auditor" required>
                        <option value="" disabled selected>Select Auditor</option>
                        <option value="Sophia Chen">Sophia Chen</option>
                        <option value="David Kim">David Kim</option>
                        <option value="Mia Chen">Mia Chen</option>
                        <option value="Sarah Lee">Sarah Lee</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="treasurer">Vote for Treasurer:</label>
                    <select id="treasurer" name="treasurer" required>
                        <option value="" disabled selected>Select Treasurer</option>
                        <option value="Aiah Arceta">Aiah Arceta</option>
                        <option value="Joey Robinson">Joey Robinson</option>
                        <option value="Kim Jong Un">Kim Jong Un</option>
                        <option value="Ethan Nguyen">Ethan Nguyen</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn" name="button">Submit Ballot</button>
            </form>
        </div>
    </div>



  <div class="wrapper">
    
    <div class="title-container">
      <h1 class="Title" id="IT1-Partylist">IT1 Partylist</h1>
    </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/236x/b4/cb/d6/b4cbd639a71db86edfdfbbc57a85961a.jpg">
        <p>Name: Liam Thompson</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Code for Change, Lead for Tomorrow!"</p>
    </div>
    
    <div class="column">
        <h2>Vice President</h2>
        <img src="https://raketcontent.com/1/2x2_pic_74eb4eeef0.jpg">
        <p>Name: Ava Martinez</p>
        <p>Age: 20</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Empowering Voices, Elevating Ideas!"</p>
    </div>
    
    <div class="column">
        <h2>Secretary</h2>
        <img src="https://i.pinimg.com/736x/1d/f9/d4/1df9d49191b554fd08b35bc0164dae98.jpg">
        <p>Name: Alliyah Kim</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Organizing Bytes for a Better Future!"</p>
    </div>
    
    <div class="column">
        <h2>Auditor</h2>
        <img src="https://i.pinimg.com/736x/82/a3/24/82a324cdd6b6059003744f7d1980e9da.jpg">
        <p>Name: Sophia Chen</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Integrity in Code, Transparency in Leadership!"</p>
    </div>
    
    <div class="column">
        <h2>Treasurer</h2>
        <img src="https://i.pinimg.com/736x/fb/a4/fe/fba4fe822deb0f7d23992554104f3d15.jpg">
        <p>Name: Aiah Arceta</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Smart Budgeting, Stronger Community!"</p>
    </div>
    

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IT2-Partylist">IT2 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://i.pinimg.com/564x/f5/67/53/f5675354c60bcf2f879ebf7131c3803b.jpg">
        <p>Name: Abby Johnson</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Innovate, Inspire, Implement!"</p>
      </div>
      
      <div class="column">
        <h2>Vice President</h2>
        <img src="https://i.pinimg.com/736x/83/5e/0f/835e0f0b83da64eb3ec31fd9944ef00d.jpg">
        <p>Name: Maya Patel</p>
        <p>Age: 20</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Together We Achieve More!"</p>
      </div>
      
      <div class="column">
        <h2>Secretary</h2>
        <img src="https://i.pinimg.com/550x/a1/d2/67/a1d2672da9101ac1419e87ee7f31927e.jpg">
        <p>Name: Samira Lee</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Efficiency is Key!"</p>
      </div>
      
      <div class="column">
        <h2>Auditor</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-SGcYaEH4-GKUJ-MiVIWB31FPONbz-89EfEkVNRX0PO4i3VaRGvOe4SjChCV2vHSBcKs&usqp=CAU">
        <p>Name: David Kim</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Transparency Builds Trust!"</p>
      </div>
      
      <div class="column">
        <h2>Treasurer</h2>
        <img src="https://scontent.fmnl9-2.fna.fbcdn.net/v/t39.30808-6/243508612_390489275974104_6405368642272446802_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeG5vKU-4_VwJoYarps1KT_5ZUb8AkMIHjNlRvwCQwgeM8YFXoBMSNZocQ_ATYLON1oRUbc0yaUO7Jml53FU1IAR&_nc_ohc=sjAVwFKD854Q7kNvgE9ZUTB&_nc_zt=23&_nc_ht=scontent.fmnl9-2.fna&_nc_gid=AayA_YjLD32TEa_Uvkd0c5t&oh=00_AYCMNoiWC4zQFQbvoLWh0G5vNJBqmOtOrZCnhjJ90DRE_A&oe=671FE617">
        <p>Name: Joey Robinson</p>
        <p>Age: 18</p>
        <p>Year: 1st Year</p>
        <p>Motto: "Smart Spending for a Bright Future!"</p>
      </div>
      

</section>	

</div>

<div class="wrapper">
    
  <div class="title-container">
    <h1 class="Title" id="IT3-Partylist">IT3 Partylist</h1>
  </div>


<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://pbs.twimg.com/media/DFf9oTrVoAAhMXk.jpg">
        <p>Name: Liam Torres</p>
        <p>Age: 20</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Code for a Better Tomorrow!"</p>
      </div>
      
      <div class="column">
        <h2>Vice President</h2>
        <img src="https://passport-photo.online/_optimized/prepare2.0498e1e2-opt-1920.WEBP">
        <p>Name: Aria Mendoza</p>
        <p>Age: 19</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Empowering Innovation Together!"</p>
      </div>
      
      <div class="column">
        <h2>Secretary</h2>
        <img src="https://cdn.prod.website-files.com/5fa2d4c3db5df80796a33819/5ffba7f46669292e728d50d8_DSC_0808.jpeg">
        <p>Name: Jayden Lim</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Your Voice, Our Mission!"</p>
      </div>
      
      <div class="column">
        <h2>Auditor</h2>
        <img src="https://live.staticflickr.com/7404/9570220270_b2caaa87b5_b.jpg">
        <p>Name: Mia Chen</p>
        <p>Age: 18</p>
        <p>Year: 1st Year</p>
        <p>Motto: "Integrity in Every Byte!"</p>
      </div>
      
      <div class="column">
        <h2>Treasurer</h2>
        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e9/Kim_Jong-un_2019.png">
        <p>Name: Kim Jong Un</p>
        <p>Age: 22</p>
        <p>Year: 4th Year</p>
        <p>Motto: "Smart Solutions for Our Future!"</p>
      </div>
      

</section>	

</div>

<div class="wrapper_gray">
    
  <div class="title-container">
    <h1 class="Title" id="IndependentIT">Independent (IT)</h1>
  </div>

<section class="columns">
    <div class="column">
        <h2>President</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2dHLC073XsS100ABTZmmN_Fa6kPqiMpgKH3lUTznHcgiv0n396rhA57GUhuqTrJuWuxo&usqp=CAU">
        <p>Name: Alex Rivera</p>
        <p>Age: 21</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Code, Connect, Create!"</p>
      </div>
      
      <div class="column">
        <h2>Vice President</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSOJpV2fZ0eKpo-4nNLsAOA_88m3u_OWc6zeC8CphyG3ijUEqxsX43qiOTziydDe4B88Sc&usqp=CAU">
        <p>Name: Maya Ortiz</p>
        <p>Age: 22</p>
        <p>Year: 3rd Year</p>
        <p>Motto: "Innovate for Tomorrow!"</p>
      </div>
      
      <div class="column">
        <h2>Secretary</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2X18bewD0_uwfcKpHp0k8-5yj-7wJXyBue25XNu5eEZ5r_S9ENyOUJ2TXq_J4H3nVGvM&usqp=CAU">
        <p>Name: Rohan Patel</p>
        <p>Age: 20</p>
        <p>Year: 2nd Year</p>
        <p>Motto: "Your Ideas Matter!"</p>
      </div>
      
      <div class="column">
        <h2>Auditor</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRunFejIZHq6ZyPcD_hA965n6QWT0kltkdwuh7LRL_zhyL0yYbil231iDX-fqmTYb4sThE&usqp=CAU">
        <p>Name: Sarah Lee</p>
        <p>Age: 19</p>
        <p>Year: 1st Year</p>
        <p>Motto: "Integrity in Every Line!"</p>
      </div>
      
      <div class="column">
        <h2>Treasurer</h2>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRdmThnI815tDkiKMZuXIWT1FDg85ky7KlazXCwQJj6dTnxLldCzk4iRvQ6-08_aIoaHX4&usqp=CAU">
        <p>Name: Ethan Nguyen</p>
        <p>Age: 23</p>
        <p>Year: 4th Year</p>
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