<?php

$title = "Essay Submission";
include "header.php";

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comp_id = $_POST['comp_id'] ?? 0;
    $essay = $_POST['essay'] ?? '';

    if ($comp_id == 0 || empty($essay)) {
        die("Invalid submission.");
    }

    $checkQuery = mysqli_query($conn, 
        "SELECT * FROM competition_submissions 
         WHERE user_id='$user_id' AND comp_id='$comp_id'"
    );

    if (mysqli_num_rows($checkQuery) > 0) {
        die("<p class='warning'>You have already submitted for this competition.</p>
             <a class='btn' href='index.php'>Back to Home</a>");
    }

    $essay_safe = mysqli_real_escape_string($conn, $essay);

    $insertQuery = "INSERT INTO competition_submissions 
                    (comp_id, user_id, submission_type, essay_text, timer_start, timer_end, status)
                    VALUES ('$comp_id', '$user_id', 'text', '$essay_safe', NOW(), NOW(), 'submitted')";

    if (mysqli_query($conn, $insertQuery)) {
        echo "<p class='success'>Your essay has been submitted successfully!</p>
              <a class='btn' href='index.php'>Back to Home</a>";
        exit;
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
        exit;
    }
}
?>

<style>
/* --- FLAT UI DASHBOARD LOOK --- */

:root {
  --body-font: "Inter", sans-serif;
  --heading-font: "Boldonse", system-ui;
  --primary-color: #531f96ff;
  --text-dark: #252525ff;
  --text-light: #ffffff;
  --light: #d1d1d1a4;
}

.container-flat {
    max-width: 900px;
    margin: 50px auto;
    background: #ffffff;
    padding: 40px;
}

h1 {
    font-size: 3rem;
    font-family: var(--heading-font);
    /* font-weight: 600; */
    margin-bottom: 10px;
    color: #333;
}

#timer {
    font-size: 70px;
    font-weight: 700;
    color: #222;
    margin-bottom: 30px;
}

/* Textarea: flat UI, clean, professional */
textarea {
    width: 100%;
    height: 500px !important;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 18px;
    font-size: 16px;
    line-height: 1.6;
    background: #fafafa;
    resize: vertical;
    outline: none;
}

textarea:focus {
    border-color: var(--primary-color);
    background: #fff;
}

/* Flat button */
.btn-submit {
    background: var(--primary-color);
    border: none;
    padding: 12px 30px;
    color: #fff;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-submit:disabled {
    background: #9bbcff;
    cursor: not-allowed;
}

/* Alerts */
.success { color: #2e7d32; font-size: 18px; }
.error { color: #c62828; font-size: 18px; }
.warning { color: #ff8f00; font-size: 18px; }

a.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #2979ff;
    color: #fff;
    border-radius: 4px;
    text-decoration: none;
}
</style>

<div class="container-flat text-center">

    <h1>Essay Submission</h1>
    <h2 id="timer"></h2>

    <form action="" method="POST">
        <input type="hidden" name="comp_id" value="<?php echo $_GET['comp_id'] ?? 0; ?>">

        <textarea name="essay" placeholder="Write your essay here..." required></textarea>

        <br><br>

        <button type="submit" class="btn-submit">Submit</button>
    </form>
</div>

<script>
let time = 3 * 60 * 60; // 3 hours

setInterval(() => {
    let hrs = Math.floor(time / 3600);
    let mins = Math.floor((time % 3600) / 60);
    let secs = time % 60;

    document.getElementById("timer").innerHTML =
        `${hrs.toString().padStart(2,'0')}:${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;

    if (time === 0) {
        alert("Time is over!");
        document.querySelector(".btn-submit").disabled = true;
    }

    time--;
}, 1000);
</script>

<?php include "footer.php"; ?>
