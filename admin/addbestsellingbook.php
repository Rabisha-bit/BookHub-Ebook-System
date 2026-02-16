<?php
include "includes/header.php";

if (isset($_POST['save'])) {

    $book_id = $_POST['book_id'];
    $ranking = $_POST['ranking'];

    $query = "INSERT INTO bestselling_books (book_id, ranking)
            VALUES ('$book_id', '$ranking')";

        $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Book added successfully');
        window.location.href='allbestsellingbook.php';
        </script>";
    } else {
        echo "<script>alert('Failed to add book');</script>";
    }
}
?>

<div class="container mt-5" >
    <div class="card shadow-sm">
        <div class="card-header ">
            <h5 class="mb-0">Add Best Selling Book</h5>
        </div>

        <div class="card-body">

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Book ID</label>
                    <input type="number" name="book_id" class="form-control" placeholder="Enter Book ID">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ranking</label>
                    <input type="number" name="ranking" class="form-control" placeholder="Enter Ranking">
                </div>

                <button name="save" class="btn btn-primary w-100">Save</button>
            </form>

        </div>
    </div>
</div>

<?php include "includes/footer.php"?>