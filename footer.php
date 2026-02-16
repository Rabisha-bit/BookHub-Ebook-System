<!-- CSS -->
<style>
  .social-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #e9ecef;
    /* light background */
    color: #4b2c7a;
    /* your theme primary color */
    transition: all 0.3s ease;
    font-size: 16px;
    text-decoration: none;
  }

  .social-icon:hover {
    background-color: #4b2c7a;
    /* primary color on hover */
    color: #fff;
    /* icon turns white */
    transform: translateY(-3px);
  }
</style>
<!-- Footer Start -->
<footer class="bg-light text-dark pt-5 pb-3 mt-5 border-top" style="font-family: var(--body-font);">
  <div class="container">
    <div class="row">

      <!-- About Section -->
      <div class="col-md-4 mb-4">
        <h5 class="navbar-brand ">BookHub</h5>
        <p>Your one-stop destination for books — from kids’ tales to adult fiction, competitions, and more.</p>
        <div class="d-flex gap-3 mt-2">
          <a href="https://facebook.com" target="_blank" class="social-icon">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="https://instagram.com" target="_blank" class="social-icon">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://linkedin.com" target="_blank" class="social-icon">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="https://youtube.com" target="_blank" class="social-icon">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-md-2 mb-4">
        <h6 class="fw-bold" style="font-family: var(--body-font);">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-dark text-decoration-none">Home</a></li>
          <li><a href="booklist.php" class="text-dark text-decoration-none">Books</a></li>
          <li><a href="competition.php" class="text-dark text-decoration-none">Competitions</a></li>
          <li><a href="contact.php" class="text-dark text-decoration-none">Contact Us</a></li>
        </ul>
      </div>

      <!-- Customer Service -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold" style="font-family: var(--body-font);">Customer Service</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-dark text-decoration-none">FAQs</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Shipping & Returns</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Privacy Policy</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Terms & Conditions</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-bold" style="font-family: var(--body-font);">Contact Us</h6>
        <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>123 Book Street, City, Country</p>
        <p class="mb-1"><i class="fas fa-phone-alt me-2"></i>+123 456 7890</p>
        <p class="mb-0"><i class="fas fa-envelope me-2"></i>support@bookhub.com</p>
      </div>

    </div>

    <hr class="border-secondary">

    <!-- Footer Bottom -->
    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> BookHub. All Rights Reserved.</p>
      <p class="mb-0">Designed with ❤️ by Rabisha Nadeem</p>
    </div>
  </div>
</footer>
<!-- Footer End -->





<!-- <script src="assests/js/cart.js"></script> -->
<script src="assests/js/script.js"></script>
<script src="assests/js/custom.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>