<?php
session_start();
include "./database/config.php";
// Cart count aur total calculate karein
$cartCount = 0;
$cartTotal = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
        $cartTotal += $item['price'] * $item['quantity'];
    }
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Boldonse&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assests/css/global.css">
    <link rel="stylesheet" href="assests/css/home.css">
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <!-- Left: BookHub Logo -->
            <a class="navbar-brand ms-3" href="index.php">

                BOOKHUB
            </a>
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Center: Nav Links -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item pt-1">
                        <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>"
                            href="index.php">Home</a>
                    </li>
                    <li class="nav-item pt-1">
                        <a class="nav-link <?php echo ($currentPage == 'booklist.php') ? 'active' : ''; ?>"
                            href="booklist.php">Books</a>
                    </li>
                    <li class="nav-item pt-1">
                        <a class="nav-link <?php echo ($currentPage == 'competition.php') ? 'active' : ''; ?>"
                            href="competition.php">Competitions</a>
                    </li>
                    <li class="nav-item pt-1">
                        <a class="nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"
                            href="contact.php">Contact Us</a>
                    </li>

                    <?php if (isset($_SESSION["user_id"])): ?>
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="cart.php" title="Cart">
                                <img src="./assests/icons/bag (2).png" alt="Cart Icon">
                                <?php if ($cartCount > 0): ?>
                                    <span id="cart-count"><?php echo $cartCount; ?></span>
                                    <span id="cart-total">Rs. <?php echo number_format($cartTotal, 0); ?></span>
                                <?php else: ?>
                                    <span id="cart-count">0</span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="./auth/login.php" title="Cart">
                                <img src="./assests/icons/bag (2).png" alt="Cart Icon">
                                <span id="cart-count">0</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Right: User Icon and Add to Cart Icon -->
                <ul class="navbar-nav me-4">
                    <?php if (isset($_SESSION["username"])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <img src="./auth/userprofileimage/<?php echo $_SESSION['userimage']; ?>" alt="User"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">

                                <span class="ms-2" style="font-size: 14px;">
                                    <?php echo $_SESSION['username']; ?>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end p-3" aria-labelledby="userMenu"
                                style="width: 260px;">

                                <!-- User Profile Display -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <img src="./auth/userprofileimage/<?php echo $_SESSION['userimage']; ?>" alt="User"
                                            style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?php echo $_SESSION['username']; ?></h6>
                                        <small class="text-muted"><?php echo $_SESSION['useremail']; ?></small>
                                    </div>
                                </div>

                                <li>
                                    <a class="dropdown-item" href="useraccount.php">View Account</a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item text-danger" href="./auth/logout.php">Logout</a>
                                </li>

                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./auth/login.php" title="Add to Cart">
                                <img src="./assests/icons/user-.png" alt="">
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>

    <script>
        function updateCartCount(newCount) {
            const cartCountSpan = document.getElementById('cart-count');
            if (cartCountSpan) {
                cartCountSpan.innerText = newCount;
            }
        }
    </script>