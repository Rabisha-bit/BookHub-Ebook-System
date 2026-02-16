<?php
include "includes/header.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM bestselling_books WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $book_id = $_POST['book_id'];
    $ranking = $_POST['ranking'];

    $query = "UPDATE bestselling_books 
            SET book_id='$book_id', ranking='$ranking' 
            WHERE id=$id";

        $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Book Updated successfully');
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
                    <input type="number" name="book_id"  value="<?php echo $row['book_id']; ?>" class="form-control" placeholder="Enter Book ID">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ranking</label>
                    <input type="number" name="ranking" value="<?php echo $row['ranking']; ?>" class="form-control" placeholder="Enter Ranking">
                </div>

                <button name="update" class="btn btn-primary w-100">Update book</button>
            </form>

        </div>
    </div>
</div>

<?php include "includes/footer.php"?>