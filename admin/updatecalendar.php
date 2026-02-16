<?php 
include "includes/header.php";

$idtobeupdated = $_GET["id"];

$calendarresult = mysqli_query($conn,"SELECT * FROM `kids_books_calendar` WHERE id = $idtobeupdated") ;
$calendar =  mysqli_fetch_assoc($calendarresult) ;


if (isset($_POST['updateCalendarbtn'])){

$title = $_POST['title'];
$description = $_POST['description'];
$release_date = $_POST['release_date'];

$iconname = $_FILES['bookicon']['name'];
$icontmppath = $_FILES['bookicon']['tmp_name'];
move_uploaded_file($icontmppath, "calendaricons/". $iconname);

$result = mysqli_query($conn,"UPDATE `kids_books_calendar` SET `title`='$title',`description`='$description',`release_date`='$release_date',`book_icon`='$iconname' WHERE id = $idtobeupdated") ;

if ($result) {
        echo "<script>alert('Calendar Updated Successfully');
        window.location.href='managecalendars.php';
        </script>";
    } else {
        echo "<script>alert('Failed to Update Calendar');</script>";
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
          <input type="text" class="form-control" value="<?php echo $calendar['title']; ?>"  id="title" name="title" placeholder="Enter book title" required>
        </div>
        
        <div class="mb-3">
          <label for="description" class="form-label">Short Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a short description" required><?php echo $calendar['description']; ?></textarea>
        </div>
        
        <div class="mb-3">
          <label for="release_date" class="form-label">Release Date</label>
          <input type="date" class="form-control" value="<?php echo $calendar['release_date']; ?>" id="release_date" name="release_date" required>
        </div>
        
        <div class="mb-3">
          <label for="book_icon" class="form-label">Book Icon</label>
          <img width="50" src="calendaricons/<?php echo $calendar['book_icon']; ?>" alt="">
          <input type="file" class="form-control" id="book_icon" name="bookicon" accept="image/*" required>
        </div>
        
        <button type="submit" name="updateCalendarbtn" class="btn btn-primary w-100">Update Calendar</button>
      </form>
    </div>
  </div>
</div>

<?php include "includes/footer.php";?>