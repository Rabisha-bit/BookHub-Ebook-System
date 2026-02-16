<?php
$title = "Contact Us | BOOKHUB";
include("header.php");

$showToast = false; // flag to trigger toast

if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    $query = "INSERT INTO contact_messages (name, email, subject, message)
              VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $query)) {
        $showToast = true; // show toast if insert succeeds
    } else {
        echo "<div class='alert alert-danger'>Database Error: " . mysqli_error($conn) . "</div>";
    }
}





?>

<style>
    :root {
  --body-font: "Inter", sans-serif;
  --heading-font: "Boldonse", system-ui;
  --primary-color: #531f96ff;
  --text-dark: #252525ff;
  --text-light: #ffffff;
  --light: #d1d1d1a4;
}
    .contact-wrapper {
        max-width: 850px;
        margin: 50px auto;
    }

    .contact-card {
        background: #fff;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.12);
    }

    .contact-title {
        font-size: 32px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 10px;
    }

    .contact-subtitle {
        font-size: 15px;
        text-align: center;
        color: #777;
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-control {
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ddd;
        transition: 0.2s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 6px var(--primary-color);
    }

    /* Submit Button */
    .btn-submit {
        background: var(--primary-color);
        color: white;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        width: 100%;
        transition: 0.2s;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: var(--primary-color);
        transform: translateY(-1px);
    }

    .btn-submit i {
        font-size: 18px;
    }
</style>

<div class="contact-wrapper">
    <div class="contact-card">

        <h2 class="contact-title"><i class="fa-solid fa-envelope-circle-check"></i> Contact Us</h2>
        <p class="contact-subtitle">We’re always here to support your reading journey — let’s talk.</p>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Your message has been successfully sent!</div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Message subject" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Your Message</label>
                <textarea name="message" class="form-control" rows="5" placeholder="Write your message..." required></textarea>
            </div>

            <button type="submit" name="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Send Message
            </button>

        </form>

    </div>
</div>
<div id="toast" style="display:none; position:fixed; top:20px; right:20px; background:#28a745; color:#fff; padding:15px 25px; border-radius:8px; z-index:9999;">
    Message sent successfully!
</div>

<script>
<?php if($showToast): ?>
    const toast = document.getElementById("toast");
    toast.style.display = "block";

    // Optional fade out after 2 seconds
    setTimeout(() => {
        toast.style.display = "none";
        // Redirect to homepage after toast
        window.location.href = "index.php";
    }, 2000);
<?php endif; ?>
</script>

<script>
    document.getElementById("contactForm").addEventListener("submit", function (e) {
    const email = document.querySelector("input[name='email']").value;

    if (!email.includes("@") || !email.includes(".")) {
        e.preventDefault();
        alert("Kindly drop a valid email — our support elves require accuracy 🧙‍♂️✨");
    }
});

</script>

<?php include("footer.php"); ?>
