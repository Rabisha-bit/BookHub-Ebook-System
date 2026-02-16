<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
include_once "../database/config.php";

if (isset($_POST["btnregister"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $userimage = $_FILES['userimage']['name'];
    $userimagePath = $_FILES['userimage']['tmp_name'];
    $extension = pathinfo($userimage, PATHINFO_EXTENSION);
    $username = $_POST["username"];
    $useremail = $_POST["useremail"];
    $userpassword = $_POST["userpassword"];
    $userconfirmpassword = $_POST["userconfirmpassword"];


    $checkEmailQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_email='$useremail'");
    if (mysqli_num_rows($checkEmailQuery) > 0) {
        echo "<script>alert('Email already registered. Please use a different email.');</script>";
    } else if ($userpassword !== $userconfirmpassword) {
        echo "<script>alert('Passwords do not match. Please try again.');
        window.location.href='register.php';
        </script>";
    } else {
        try {
            //Server settings
            $mail->isSMTP();
            //Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   //Enable SMTP authentication
            $mail->Username = 'rabisha2698@gmail.com';                     //SMTP username
            $mail->Password = 'yoov gjcz uglc noxb';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('rabisha2698@gmail.com');
            $mail->addAddress($_POST['useremail']);     //Add a recipient



            $mail->isHTML(true);
            $mail->Subject = 'Welcome To BookHub';


            $mail->Body = '<html><body>Welcome to BookHub, ' . $username . '!<br>Your account has been created successfully.<br>Registered Email: ' . $useremail . '<br><br>Stay curious,<br>Team BookHub</body></html>';



            $isMailed = $mail->send();
            if (isset($isMailed)) {

                $newimagename = $useremail . "." . $extension;
                $newimagepath = "userprofileimage/" . $newimagename;
                move_uploaded_file($userimagePath, $newimagepath);
                $hashedPassword = password_hash($userpassword, PASSWORD_DEFAULT);
                $insertUserQuery = "INSERT INTO users (user_name, user_email, user_password,user_image, role_id ) VALUES ('$username', '$useremail', '$hashedPassword','$newimagename',2)";

                if (mysqli_query($conn, $insertUserQuery)) {
                    echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.php';</script>";
                } else {
                    echo "<script>alert('Registration failed. Please try again later.');
            window.location.href='register.php';
            </script>";
                }

            }
            ;

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Auth Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        :root {
            --body-font: "Inter", sans-serif;
            --heading-font: "Boldonse", system-ui;
            --primary-color: #531f96ff;
            --text-dark: #252525ff;
            --text-light: #ffffff;
            --light: #d1d1d1a4;
        }

        body {
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
        }

        .auth-wrapper {
            max-width: 900px;
            margin: 60px auto;
        }

        .card-custom {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .left-panel {
            background: linear-gradient(to right, #E0C3FC 0%, #8EC5FC 100%);
            color: white;
            padding: 40px;
            border-radius: 20px 0 0 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .left-panel i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .left-panel h2 {
            color: var(--text-dark);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .left-panel p {
            color: var(--text-dark);
            opacity: 0.9;
        }

        .form-panel {
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 12px;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
        }

        .btn {
            border-radius: 10px;
            padding: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        /* Custom styling for file input to make it look consistent */
        .form-control[type="file"] {
            padding: 10px;
        }

        .form-control[type="file"]::file-selector-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-control[type="file"]::file-selector-button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .left-panel {
                border-radius: 20px 20px 0 0;
            }

            .form-panel {
                border-radius: 0 0 20px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <div class="row g-0 card-custom overflow-hidden">

            <!-- LEFT PANEL -->
            <div class="col-md-5 left-panel d-flex flex-column justify-content-center align-items-start">
                <i class="bi bi-shield-lock-fill fs-1 mb-3"></i>
                <h2>Join Us</h2>
                <p class="mt-2">Create a new account to get started securely.</p>
            </div>

            <!-- RIGHT PANEL (REGISTER FORM) -->
            <div class="col-md-7 bg-white form-panel">
                <h3 class="mb-3"><i class="bi bi-person-badge me-2"></i>Register</h3>
                <form id="registerForm" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person me-1"></i>Full Name</label>
                        <input type="text" name="username" class="form-control" id="registerName"
                            placeholder="Enter your full name" required />
                        <div class="error-message" id="registerNameError">Full name is required.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                        <input type="email" name="useremail" class="form-control" id="registerEmail"
                            placeholder="Enter your email" required />
                        <div class="error-message" id="registerEmailError">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-image me-1"></i>Profile Image</label>
                        <input type="file" name="userimage" class="form-control" id="registerImage" accept="image/*" />
                        <div class="error-message" id="registerImageError">Please select a valid image file (e.g., JPG,
                            PNG).</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
                        <input type="password" name="userpassword" class="form-control" id="registerPassword"
                            placeholder="Create a strong password" required />
                        <div class="error-message" id="registerPasswordError">Password must be at least 8 characters
                            with numbers and symbols.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lock me-1"></i>Confirm Password</label>
                        <input type="password" name="userconfirmpassword" class="form-control" id="confirmPassword"
                            placeholder="Confirm your password" required />
                        <div class="error-message" id="confirmPasswordError">Passwords do not match.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100" name="btnregister"><i
                            class="bi bi-check-circle me-2"></i>Register</button>
                    <div class="mt-3 text-center">
                        <p>Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>