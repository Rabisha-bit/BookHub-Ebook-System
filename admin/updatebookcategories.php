<?php include("includes/header.php");

$idtobeupdated = $_GET['id'];
$query = "
SELECT * FROM `bookcategory` WHERE category_id = $idtobeupdated";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if(isset($_POST["btncategory"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    
    $categoryname = $_POST["category_name"];
    
    
     $query = "UPDATE `bookcategory` SET `category_name`= '$categoryname' WHERE `category_id` = $idtobeupdated";
     $result = mysqli_query($conn, $query);
     if($result){
        echo "<script>alert('Category updated successfully');
        window.location.href='allbookcategories.php';
        </script>";
     } else {
        echo "<script>alert('Error');</script>";
     }
}


?>


<div class="container-fluid">

<!-- Category Form -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add / Manage Book Categories</h6>
    </div>

    <div class="card-body">

        <!-- Add Category Form -->
        <form  method="POST" class="mb-4">
            
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" required value="<?php echo $data['category_name']?>">
            </div>

            <button type="submit" class="btn btn-primary btn-block" name="btncategory">Update Category</button>
        </form>

</div>

<?php include("includes/footer.php"); ?>