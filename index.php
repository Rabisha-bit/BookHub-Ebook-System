<?php
$title = "Home Page | BOOKHUB";
include 'header.php';
$booksDataQuery = mysqli_query($conn, "SELECT * FROM `book` INNER JOIN `bookcategory` ON book.category_id = bookcategory.category_id");
// Fetch active (live) competitions
$activeQuery = mysqli_query($conn, "SELECT * FROM `competitions` WHERE status = 'active'");
$activeCompetitions = [];
while ($row = mysqli_fetch_assoc($activeQuery)) {
  $activeCompetitions[] = $row;
}
// Fetch upcoming competitions
$upcomingQuery = mysqli_query($conn, "SELECT * FROM `competitions` WHERE status = 'upcoming'");
$upcomingCompetitions = [];
while ($row = mysqli_fetch_assoc($upcomingQuery)) {
  $upcomingCompetitions[] = $row;
}
// Fetch latest winners
$latestWinners = mysqli_query($conn, "
    SELECT cw.position, cw.announced_at,
           cs.submission_type, c.comp_title, u.user_name
    FROM competition_winners cw
    INNER JOIN competition_submissions cs ON cw.submission_id = cs.submission_id
    INNER JOIN competitions c ON cw.competition_id = c.comp_id
    INNER JOIN users u ON cs.user_id = u.user_id
    ORDER BY cw.announced_at DESC
    LIMIT 5
");

$calendar = mysqli_query($conn, "SELECT * FROM `kids_books_calendar`");

$bestselling = mysqli_query($conn, "SELECT * FROM `bestselling_books` INNER JOIN book ON bestselling_books.book_id = book.book_id  INNER JOIN bookcategory ON book.category_id = bookcategory.category_id");



?>

<!-- Single Hero Banner -->
<section id="heroBanner" class="bg-gray-100">
  <div class="hero-content d-flex flex-row  align-items-center justify-content-center p-5 gap-5">

    <!-- LEFT SIDE PREMIUM SOCIAL ICONS -->
    <div class="social-sidebar position-absolute start-0 top-50 translate-middle-y d-flex flex-column ms-3">
      <a href="https://www.facebook.com/" class="social-item"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/tec_hgirl99/?hl=en" class="social-item"><i class="fab fa-instagram"></i></a>
      <a href="https://www.linkedin.com/in/rabisha-nadeem99/" class="social-item"><i class="fab fa-linkedin"></i></a>
      <a href="https://www.youtube.com/@tayyabbits" class="social-item"><i class="fab fa-youtube"></i></a>
    </div>
    <div class="slide-text text-center  ps-5">
      <h1>Unlock a World of Books</h1>
      <p class="pt-2">From fiction to education — find every book that matches your passion.</p>
      <div class="herobtn d-flex gap-3 justify-content-center pt-2">
        <a href="booklist.php" class="explorebtn">Explore Now</a>

        <a href="./competition.php" class="compbtn">See Competition</a>



      </div>


    </div>


    <!-- FLOATING CONTACT ICON -->
    <a href="contact.php" class="floating-contact">
      <i class="fa-solid fa-envelope"></i>
    </a>
  </div>
</section>
<section id="company-services" class="padding-large pb-0">
  <div class="container mb-5">
    <div class="row  my-1">

      <!-- Fast Delivery -->
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <i class="fa-solid fa-truck-fast fa-2x text-primary"></i>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Fast Delivery</h4>
            <p>Get your books delivered quickly and safely to your doorstep.</p>
          </div>
        </div>
      </div>

      <!-- Quality Books -->
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <i class="fa-solid fa-book-open-reader fa-2x text-primary"></i>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Premium Quality</h4>
            <p>Original, high-quality books with perfect printing & binding.</p>
          </div>
        </div>
      </div>

      <!-- Best Prices -->
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <i class="fa-solid fa-tags fa-2x text-primary"></i>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Best Prices</h4>
            <p>Daily offers & special discounts on top-selling books.</p>
          </div>
        </div>
      </div>

      <!-- Secure Payment -->
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <i class="fa-solid fa-shield fa-2x text-primary"></i>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">100% Secure Payment</h4>
            <p>Your transactions are protected with advanced security.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- //Best Selling Books -->

<!-- Best Selling Books Section -->
<section>
  <div class="container-fluid best-selling-books my-5"
    style="padding: 40px 20px; background: #fdf8ff; border-radius: 20px;">
    <h2 class="text-center my-4" style="font-family: var(--heading-font);  font-size: 2.5rem; color: var(--text-dark);">
      Best Selling Books
    </h2>
    <p class="text-center mb-5" style="font-family: var(--body-font); font-size: 1.1rem; color: #6b6b6b;">
      Explore the most loved books by our readers — stories that everyone is talking about!
    </p>

    <div class="row">
      <?php foreach ($bestselling as $book): ?>
        <div class="col-md-4 book-item" data-book-id="<?php echo $book['book_id']; ?>"
          data-title="<?php echo strtolower($book['book_title']); ?>"
          data-author="<?php echo strtolower($book['book_author']); ?>"
          data-category="<?php echo strtolower($book['category_name']); ?>" data-price="<?php echo $book['pdf_price']; ?>"
          data-type="<?php echo strtolower($book['pdf_type']); ?>">


          <div class="book-card2 mb-4">
            <div class="book-left my-5">
              <img src="./admin/bookimages/<?php echo $book['book_cover'] ?>" alt="Book Cover">
            </div>

            <div class="book-right mt-3">
              <h2 class="book-title2"><?php echo $book['book_title']; ?></h2>

              <p class="book-desc">
                <?php echo $book['short_description']; ?>
              </p>

              <div class="cat-rating">
                <p class="book-author2 my-2">
                  <span><?php echo $book['book_author']; ?></span>
                </p>
                <span class="category me-1"><?php echo $book['category_name']; ?></span>
              </div>

              <hr>
              <?php if (isset($_SESSION["username"])): ?>

                <div class="format-price d-flex gap-1">
                  <div class="price d-flex gap-2">
                    <span><i class="fa-regular fa-file-pdf"></i></span>
                    <?php if ($book['pdf_type'] == "free"): ?>
                      <p class="text-success">Free</p>
                    <?php else: ?>
                      <p>Rs.<?php echo $book['pdf_price']; ?></p>
                    <?php endif; ?>
                  </div>

                  <div class="price d-flex gap-2">
                    <span><i class="fa-solid fa-book"></i></span>
                    <p>Rs.<?php echo $book['hardcopy_price']; ?></p>
                  </div>

                  <div class="price d-flex gap-2">
                    <span><i class="fa-solid fa-compact-disc"></i></span>
                    <p>Rs.<?php echo $book['cd_price']; ?></p>
                  </div>
                </div>

                <div class="book-buttons">
                  <button class="btn-cart">
                    <span><i class="fa-solid fa-eye"></i></span>
                    <a href="booksdetailpages.php?id=<?php echo $book['book_id']; ?>">View Detail</a>
                  </button>

                  <div id="toast" class="custom-toast">This format is currently unavailable.</div>
                <?php else: ?>
                  <div class="format-price d-flex gap-1">
                    <div class="price d-flex gap-2">
                      <span><i class="fa-regular fa-file-pdf"></i></span>
                      <?php if ($book['pdf_type'] == "free"): ?>
                        <p class="text-success">Free</p>
                      <?php else: ?>
                        <p>Rs.<?php echo $book['pdf_price']; ?></p>
                      <?php endif; ?>
                    </div>

                    <div class="price d-flex gap-2">
                      <span><i class="fa-solid fa-book"></i></span>
                      <p>Rs.<?php echo $book['hardcopy_price']; ?></p>
                    </div>

                    <div class="price d-flex gap-2">
                      <span><i class="fa-solid fa-compact-disc"></i></span>
                      <p>Rs.<?php echo $book['cd_price']; ?></p>
                    </div>
                  </div>
                  <div class="book-buttons">
                    <button class="btn-cart">
                      <span><i class="fa-solid fa-eye"></i></span>
                      <a href="./auth/login.php">View Detail</a>
                    </button>


                  <?php endif; ?>
                </div>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- View All Books Button -->
    <div class="text-center mt-4 bestselling-btn">
      <a href="booklist.php" class="explorebtn">View All Books</a>
    </div>
  </div>
</section>




<!-- //Winners Section -->
<div class="container livecomp my-3">
  <div class="row">
    <!-- Winners Section -->
    <h2 class="mt-5 text-center"> Latest Winners</h2>

    <div class="row">
      <?php
      if (mysqli_num_rows($latestWinners) > 0) {
        while ($winner = mysqli_fetch_assoc($latestWinners)) { ?>
          <div class="col-md-6 mb-3">
            <div class="card comp-card my-5 shadow-lg">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="winner-icon me-3">
                  <!-- Trophy Icon -->
                  <i class="fa-solid fa-trophy" style="font-size: 2.5rem;"></i>
                </div>
                <div>
                  <h5 class="mb-2">
                    <span class=" fw-bold"><?php echo ucfirst($winner['position']); ?> Position</span>:
                    <span><?php echo $winner['user_name']; ?></span>
                  </h5>
                  <p class="mb-1">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <?php echo $winner['submission_type']; ?> -<?php echo $winner['comp_title']; ?>
                  </p>
                  <small class="text-muted">
                    <i class="bi bi-calendar-event me-1"></i>
                    Announced on <?php echo date('M d, Y', strtotime($winner['announced_at'])); ?>
                  </small>
                </div>
              </div>
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="col-md-12 text-center my-5">
          <p class="text-muted"><i class="bi bi-emoji-frown me-2"></i>No winners announced yet.</p>
        </div>
      <?php } ?>

    </div>

  </div>
</div>
<!-- Upcoming Kids Books Banner -->
<section>
  <div class="kidsbanner my-5" style="
    background: linear-gradient(135deg, #ffdee9 0%, #b5fffc 100%);
    padding: 50px 20px;
    text-align: center;
    position: relative;
    overflow: hidden;
">

    <!-- Floating Mascot -->
    <img src="https://cdn-icons-png.flaticon.com/512/742/742751.png" alt="Kids Mascot" style="
            width: 110px;
            position: absolute;
            top: -20px;
            left: -20px;
            opacity: 0.8;
            animation: float 3s ease-in-out infinite;
         ">

    <img src="https://cdn-icons-png.flaticon.com/512/742/742774.png" alt="Kids Mascot" style="
            width: 120px;
            position: absolute;
            bottom: -10px;
            right: -10px;
            opacity: 0.8;
            animation: float 3s ease-in-out infinite reverse;
         ">

    <!-- Heading -->
    <h2 style="
        font-size: 2.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    ">
      Tiny Tales : Next Drop
    </h2>

    <!-- Tagline -->
    <p style="
        font-size: 1.2rem;
        color: #444;
        max-width: 650px;
        margin: 0 auto 20px auto;
    ">
      Wholesome new kids’ books arriving soon — packed with imagination, color, and adventure.
      Stay tuned for story magic!
    </p>

    <!-- CTA Button -->
    <a href="#newarrivalscalendar" style="
          display: inline-block;
          padding: 12px 28px;
          background: var(--primary-color);
          color: #fff;
          font-weight: 600;
          border-radius: 30px;
          text-decoration: none;
          transition: 0.3s ease;
       ">
      Stay Tuned 🚀
    </a>
  </div>
  <!-- Floating Animation -->
  <style>
    @keyframes float {
      0% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-12px);
      }

      100% {
        transform: translateY(0px);
      }
    }
  </style>
</section>
<!-- //livecomp -->
<div class="container livecomp my-5" id="live-comp">
  <?php if (!empty($activeCompetitions)): ?>
    <h2 class="text-center mt-5">Live Competitions</h2>

    <?php foreach ($activeCompetitions as $comp): ?>

      <?php

      if (!isset($_SESSION['user_id'])) {
        $already = false; // logged-out users cannot be "already participated"
      } else {
        $user_id = $_SESSION['user_id'];
        $compId = $comp['comp_id'];
        $user_id = $_SESSION['user_id'];
        $compId = $comp['comp_id'];
        $sql = "SELECT submission_id FROM competition_submissions WHERE user_id = $user_id AND comp_id = $compId";
        $result = mysqli_query($conn, $sql);
        $already = mysqli_num_rows($result) > 0;
      }
      ?>

      <div class="col-md-12 my-5">
        <div class="card comp-card h-100">
          <div class="card-body d-flex flex-column">

            <!-- Status Badge -->
            <div class="mb-2">
              <?php
              $statusClass = strtolower($comp['status']);
              echo "<span class='status-badge status-$statusClass'>" .
                ucfirst($comp['status'])
                . "</span>";
              ?>
            </div>

            <h5 class="comp-title mb-2">
              <?php echo htmlspecialchars($comp['comp_title']); ?>
            </h5>

            <p><span class="comp-label">Type:</span>
              <span class="comp-value"><?php echo htmlspecialchars($comp['comp_type']); ?></span>
            </p>

            <p><span class="comp-label">Start:</span>
              <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['start_date'])); ?></span>
            </p>

            <p><span class="comp-label">End:</span>
              <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['end_date'])); ?></span>
            </p>

            <p><span class="comp-label">Prize:</span>
              <span class="comp-value"><?php echo htmlspecialchars($comp['prize_details']); ?></span>
            </p>


            <?php if ($already): ?>
              <!-- Already Participated Button -->
              <button onclick="showToast()" class="explorebtn mt-auto text-center"
                style="border-radius: 10px; font-weight:600; background:#888;">
                Already Participated
              </button>

            <?php else: ?>
              <!-- Normal Button -->
              <a href="timer.php?comp_id=<?php echo $comp['comp_id']; ?>" class="explorebtn mt-auto text-center"
                style="border-radius: 10px; font-weight:600;">
                Submit Your Entry
              </a>
            <?php endif; ?>

          </div>
        </div>
      </div>

    <?php endforeach; ?>
  <?php else: ?>
    <p>No live competitions at the moment.</p>
  <?php endif; ?>
</div>


<section>
  <!-- New Arrivals Calendar Section -->
  <div id="newarrivalscalendar" class="new-arrivals-container  my-5"
    style="padding: 40px 20px; background: #fdf8ff; border-radius: 20px;">

    <h2 class="text-center">
      New Arrivals Calendar
    </h2>

    <p class="text-center my-4" style="font-size: 1.1rem; color: #6b6b6b; margin-top: -10px;">
      Fresh kids books dropping soon — mark your reading plans!
    </p>

    <div class="calendar-grid">
      <?php if (mysqli_num_rows($calendar) > 0): ?>
        <?php foreach ($calendar as $cal): ?>
          <div class="calendar-card">
            <div class="date-box">
              <span class="month"><?php echo date('M', strtotime($cal['release_date'])); ?></span>
              <span class="day"><?php echo date('d', strtotime($cal['release_date'])); ?></span>
            </div>
            <img src="./admin/calendaricons/<?php echo $cal['book_icon'] ?>" class="book-icon">
            <h4 class="title"><?php echo $cal['title'] ?></h4>
            <p class="desc"><?php echo $cal['description'] ?></p>
            <button class="notify-btn" onclick="notifyToast('<?php echo addslashes($cal['title']); ?>')">Notify Me</button>

          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">No upcoming books yet. Stay tuned!</p>
      <?php endif; ?>


    </div>
  </div>


</section>


<!-- //upcomingCompetitions -->
<div class="container livecomp my-5">
  <div class="row">
    <?php if (!empty($activeCompetitions)): ?>
      <h2 class="text-center">Upcoming Competitions</h2>
      <?php foreach ($upcomingCompetitions as $comp): ?>
        <div class="col-md-6 my-5">
          <div class="card comp-card h-100">

            <div class="card-body d-flex flex-column">

              <!-- Status Badge -->
              <div class="mb-2">
                <?php
                $statusClass = strtolower($comp['status']);
                echo "<span class='status-badge status-$statusClass'>" .
                  ucfirst($comp['status'])
                  . "</span>";
                ?>
              </div>

              <h5 class="comp-title mb-2">
                <?php echo htmlspecialchars($comp['comp_title']); ?>
              </h5>

              <p><span class="comp-label">Type:</span>
                <span class="comp-value"><?php echo htmlspecialchars($comp['comp_type']); ?></span>
              </p>

              <p><span class="comp-label">Start:</span>
                <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['start_date'])); ?></span>
              </p>

              <p><span class="comp-label">End:</span>
                <span class="comp-value"><?php echo date('M d, Y', strtotime($comp['end_date'])); ?></span>
              </p>

              <p><span class="comp-label">Prize:</span>
                <span class="comp-value"><?php echo htmlspecialchars($comp['prize_details']); ?></span>
              </p>




            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No live competitions at the moment.</p>
    <?php endif; ?>
  </div>
</div>





<!-- Toast container -->
<div id="notifyToast" style="display:none; 
            position:fixed; 
            bottom:20px; 
            right:20px; 
            background:#333; 
            color:#fff; 
            padding:12px 20px; 
            border-radius:8px;
            z-index:9999;
            font-weight:500;">
</div>

<script>
  function notifyToast(bookTitle) {
    const toast = document.getElementById("notifyToast");
    toast.textContent = `"${bookTitle}" added to your notifications!`;
    toast.style.display = "block";

    setTimeout(() => {
      toast.style.display = "none";
    }, 3000);
  }
</script>


<div id="toast" style="display:none; 
            position:fixed; 
            bottom:20px; 
            right:20px; 
            background:#333; 
            color:#fff; 
            padding:10px 20px; 
            border-radius:8px;
            z-index:9999;">
</div>

<script>
  function showToast(message = "You already participated in this competition.") {
    const t = document.getElementById("toast");
    t.textContent = message;
    t.style.display = "block";
    setTimeout(() => { t.style.display = "none"; }, 3000);
  }
</script>






<?php include 'footer.php'; ?>