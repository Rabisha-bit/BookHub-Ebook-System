<?php
include_once "../database/config.php";
session_start();
if (isset($_POST["btnlogin"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['user_id'] = $userData['user_id'];  // Add this line

    $userloginemail = $_POST["userloginemail"];
    $userloginpassword = $_POST["userloginpassword"];

    $checkUserRecordQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_email='$userloginemail'");
    if (mysqli_num_rows($checkUserRecordQuery) > 0) {
        $userData = mysqli_fetch_assoc($checkUserRecordQuery);
        $passVerification = password_verify($userloginpassword, $userData['user_password']);
        if ($passVerification) {

            $_SESSION['user_id'] = $userData['user_id']; // <--- add this
            $_SESSION['username'] = $userData['user_name'];
            $_SESSION['useremail'] = $userData['user_email'];
            $_SESSION['userimage'] = $userData['user_image'];
            $_SESSION['role'] = $userData['role_id'];
            if ($userData['role_id'] == 1) {

                echo "<script>alert('Login successful! Redirecting to admin dashboard.');
				window.location.href='../admin/index.php';
				</script>";
            } else {
                echo "<script>alert('Login successful! Redirecting to guest homepage.');
				window.location.href='../index.php';
				</script>";
            }
        } else {
            echo "<script>alert('Incorrect password. Please try again.');
			window.location.href='login.php';
			</script>";
        }

    } else {
        echo "<script>alert('No account found with this email. Please register first.');
		window.location.href='register.php';
		</script>";
    }

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Auth Panel</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .checkbox-custom {
            display: flex;
            align-items: center;
        }

        .checkbox-custom input {
            margin-right: 8px;
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
                <h2>Welcome Back</h2>
                <p class="mt-2">Sign in to your account to continue securely.</p>
            </div>

            <!-- RIGHT PANEL (LOGIN FORM) -->
            <div class="col-md-7 bg-white form-panel">
                <h3 class="mb-3"><i class="bi bi-key-fill me-2"></i>Login</h3>
                <form id="loginForm" method="post">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
                        <input type="email" name="userloginemail" class="form-control" id="loginEmail"
                            placeholder="Enter your email" required />
                        <div class="error-message" id="loginEmailError">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
                        <input type="password" name="userloginpassword" class="form-control" id="loginPassword"
                            placeholder="Enter your password" required />
                        <div class="error-message" id="loginPasswordError">Password must be at least 6 characters.</div>
                    </div>
                    <!-- <div class="mb-3 checkbox-custom">
                    <input type="checkbox" id="rememberMe" />
                    <label for="rememberMe">Remember Me</label>
                </div> -->
                    <button type="submit" name="btnlogin" class="btn btn-primary w-100"><i
                            class="bi bi-arrow-right-circle me-2"></i>Login</button>
                    <div class="mt-3 text-center">
                        <a href="#" class="text-decoration-none">Forgot Password?</a>
                    </div>
                    <div class="mt-3 text-center">
                        <p>Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a>
                        </p>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
    // Simple form validation
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePassword(password, minLength = 6) {
        return password.length >= minLength;
    }

    // Login form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;
        let valid = true;

        if (!validateEmail(email)) {
            document.getElementById('loginEmailError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('loginEmailError').style.display = 'none';
        }

        if (!validatePassword(password)) {
            document.getElementById('loginPasswordError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('loginPasswordError').style.display = 'none';
        }

        if (valid) {
            alert('Login successful! (Replace with actual logic)');
            // Add your login API call here
        }
    });
</script> -->
</body>

</html>