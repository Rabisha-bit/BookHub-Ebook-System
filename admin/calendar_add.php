<?php 
include "includes/header.php";

if (isset($_POST['addCalendarbtn'])){

$title = $_POST['title'];
$description = $_POST['description'];
$release_date = $_POST['release_date'];

$iconname = $_FILES['bookicon']['name'];
$icontmppath = $_FILES['bookicon']['tmp_name'];

move_uploaded_file($icontmppath, "calendaricons/". $iconname);

$result = mysqli_query($conn,"INSERT INTO `kids_books_calendar`( `title`, `description`, `release_date`, `book_icon`) VALUES ( '$title' , '$description','$release_date','$iconname')") ;

if ($result) {
        echo "<script>alert('Calendar added successfully');
        window.location.href='managecalendars.php';
        </script>";
    } else {
        echo "<script>alert('Failed to add Calendar');</script>";
    }

};

?>


<div class="container my-5">
  <div class="card shadow-sm">
    <div class="card-header ">
      <h1 class="mb-0 font-weight-bold text-gray">Add New Kids Book</h1>
    </div>
    <div class="card-body">
      <form  method="POST" enctype="multipart/form-data">
        
        <div class="mb-3">
          <label for="title" class="form-label">Book Title</label>
          <input type="text" class="form-control" id="title" name="title" placeholder="Enter book title" required>
        </div>
        
        <div class="mb-3">
          <label for="description" class="form-label">Short Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a short description" required></textarea>
        </div>
        
        <div class="mb-3">
          <label for="release_date" class="form-label">Release Date</label>
          <input type="date" class="form-control" id="release_date" name="release_date" required>
        </div>
        
        <div class="mb-3">
          <label for="book_icon" class="form-label">Book Icon</label>
          <input type="file" class="form-control" id="book_icon" name="bookicon" accept="image/*" required>
        </div>
        
        <button type="submit" name="addCalendarbtn" class="btn btn-primary w-100">Add Book</button>
      </form>
    </div>
  </div>
</div>

<?php include "includes/footer.php";?>